<?php

namespace api\modules\v4\utilities;

use common\models\UserRoles;
use Yii;
use common\models\SelectedServices;
use common\models\UserAccessTokens;
use common\models\Users;
use common\models\UserTypes;

// this class is used to get user related data
class UserUtilities
{
    public function userData($user_id, $source = null)
    {
        $user = Users::find()
            ->alias('a')
            ->select([
                'a.user_enc_id', 'a.username', 'a.first_name', 'a.last_name', 'a.initials_color', 'a.phone', 'a.email', 'a.organization_enc_id',
                'b.name organization_name', 'b.slug organization_slug', 'a.username organization_username', 'b.email organization_email', 'b.phone organization_phone',
                '(CASE
                WHEN c.code IS NOT NULL THEN c.code
                WHEN b1.code IS NOT NULL THEN b1.code
                ELSE NULL
                END) as referral_code',
                'CASE WHEN b.logo IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . '",b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=true&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo',
                'CASE WHEN a.image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . '",a.image_location, "/", a.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(a.first_name," ",a.last_name), "&size=200&rounded=true&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END image',
            ])
            ->joinWith(['organizationEnc b' => function ($b) {
                $b->joinWith(['referrals b1']);
            }], false)
            ->joinWith(['referrals0 c'], false)
            ->where(['a.user_enc_id' => $user_id])
            ->asArray()
            ->one();

        $user['user_type'] = $this->getUserType($user_id);

        if ($source != null) {
            $token = $this->findToken($user_id, $source);
            $token = !empty($token) ? $this->getToken($token) : $this->generateNewToken($user_id, $source);
            $user['access_token'] = $token->access_token;
            $user['source'] = $token->source;
            $user['refresh_token'] = $token->refresh_token;
            $user['access_token_expiry_time'] = $token->access_token_expiration;
            $user['refresh_token_expiry_time'] = $token->refresh_token_expiration;
        }

        if($user['user_type'] == 'Employee'){
            $user_role = UserRoles::findOne(['user_enc_id' => $user->user_enc_id]);
        }

        return $user;
    }

    private function getUserType($user_id)
    {
        $user = Users::findOne(['user_enc_id' => $user_id]);

        $service = SelectedServices::find()
            ->alias('a')
            ->select(['b.name'])
            ->joinWith(['serviceEnc b'], false)
            ->where(['a.is_selected' => 1]);

        if ($user->organization_enc_id) {
            $service->andWhere(['or', ['a.organization_enc_id' => $user->organization_enc_id]]);
        } else {
            $service->andWhere(['or', ['a.created_by' => $user->user_enc_id]]);
        }

        $service = $service->asArray()->all();

        $serviceArr = array_column($service, 'name');

        if (in_array('Loans', $serviceArr)) {
            $user_type = "Financer";
        } else if (in_array('E-Partners', $serviceArr)) {
            $user_type = "DSA";
        } else if (in_array('Connector', $serviceArr)) {
            $user_type = "Connector";
        } else {
            $user_type = UserTypes::findOne(['user_type_enc_id' => $user->user_type_enc_id])->user_type;
        }

        return $user_type;
    }

    private function findToken($user_id, $source)
    {
        return UserAccessTokens::findOne([
            'user_enc_id' => $user_id,
            'source' => $source
        ]);
    }

    private function getToken($token)
    {
        $time_now = date('Y-m-d H:i:s', time());
        $token->access_token = \Yii::$app->security->generateRandomString(32);
        $token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
        $token->refresh_token = \Yii::$app->security->generateRandomString(32);
        $token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
        if ($token->save()) {
            return $token;
        }
        return $token->getErrors();
    }

    private function generateNewToken($user_id, $source)
    {
        $token = new UserAccessTokens();
        $time_now = date('Y-m-d H:i:s');
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $token->access_token_enc_id = $utilitiesModel->encrypt();
        $token->user_enc_id = $user_id;
        $token->access_token = \Yii::$app->security->generateRandomString(32);
        $token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
        $token->refresh_token = \Yii::$app->security->generateRandomString(32);
        $token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
        $token->source = $source;
        if ($token->save()) {
            return $token;
        }

        return false;
    }

}