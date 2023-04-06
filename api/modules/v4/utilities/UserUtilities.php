<?php

namespace api\modules\v4\utilities;

use common\models\AssignedSupervisor;
use common\models\Organizations;
use common\models\UserRoles;
use Yii;
use common\models\SelectedServices;
use common\models\UserAccessTokens;
use common\models\Users;
use common\models\UserTypes;

// this class is used to get user related data
class UserUtilities
{
    public function userData($user_id)
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

        if ($user['user_type'] == 'Employee') {

            $user_role = UserRoles::findOne(['user_enc_id' => $user_id, 'is_deleted' => 0]);

            if (!empty($user_role) && $user_role->organization_enc_id != null) {
                $employee_organization = $this->getOrganization($user_role->organization_enc_id);
                $user = array_merge($user, $employee_organization);
            }

        } elseif ($user['user_type'] == 'DSA') {

            $dsa = AssignedSupervisor::find()
                ->alias('a')
                ->select(['a.assigned_enc_id', 'a.supervisor_enc_id', 'b.organization_enc_id'])
                ->joinWith(['supervisorEnc b'], false);
            if ($user->organization_enc_id) {
                $dsa->where(['a.assigned_organization_enc_id' => $user->organization_enc_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);
            } else {
                $dsa->where(['a.assigned_user_enc_id' => $user->user_enc_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);
            }
            $dsa = $dsa->asArray()->one();

            if (!empty($dsa) && $dsa['organization_enc_id']) {
                $dsa_organization = $this->getOrganization($dsa['organization_enc_id']);
                $user = array_merge($user, $dsa_organization);
            }
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

    private function getOrganization($organization_id)
    {
        return Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name organization_name', 'a.slug organization_slug', 'b.username organization_username'])
            ->joinWith(['createdBy b'], false)
            ->where(['a.organization_enc_id' => $organization_id])
            ->asArray()
            ->one();
    }

    private static function findToken($user_id, $source)
    {
        return UserAccessTokens::findOne([
            'user_enc_id' => $user_id,
            'source' => $source
        ]);
    }

    private static function getToken($token)
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

    private static function generateNewToken($user_id, $source)
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