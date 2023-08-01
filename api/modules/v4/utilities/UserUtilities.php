<?php

namespace api\modules\v4\utilities;

use common\models\AssignedSupervisor;
use common\models\Organizations;
use common\models\UserRoles;
use yii\helpers\Url;
use Yii;
use common\models\SelectedServices;
use common\models\UserAccessTokens;
use common\models\Users;
use common\models\UserTypes;

// this class is used to get user related data
class UserUtilities
{
    public $rolesArray = ['State Credit Head', 'Operations Manager', 'Product Manager'];
    // getting user data to return after signup/login
    public function userData($user_id, $source = null)
    {
        try {
            // query to get user data
            $user = Users::find()
                ->alias('a')
                ->select([
                    'a.user_enc_id', 'a.username', 'a.first_name', 'a.last_name', 'a.initials_color', 'a.phone', 'a.email', 'a.organization_enc_id',
                    'b.name organization_name', 'b.slug organization_slug', 'f.location_enc_id branch_id', 'f.location_name branch_name', 'a.username organization_username', 'b.email organization_email', 'b.phone organization_phone',
                    '(CASE
                    WHEN c.code IS NOT NULL THEN c.code
                    WHEN b1.code IS NOT NULL THEN b1.code
                    ELSE NULL
                    END) as referral_code',
                    'CASE WHEN a.image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . '",a.image_location, "/", a.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(a.first_name," ",a.last_name), "&size=200&rounded=true&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END image',
                    'CASE WHEN b.logo IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . '",b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=true&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo',
                    'd1.designation',
                    'd.employee_code', 'd.grade', 'CONCAT(g1.first_name," ",g1.last_name) reporting_person', 'f.location_name branch_name', 'CONCAT(f.location_name , ", ", f1.name) as branch_location'
                ])
                ->joinWith(['organizationEnc b' => function ($b) {
                    $b->joinWith(['referrals b1']);
                }], false)
                ->joinWith(['referrals0 c'], false)
                ->joinWith(['userRoles0 d' => function ($d) {
                    $d->joinWith(['reportingPerson g1'], false);
                    $d->joinWith(['designation d1'], false);
                    $d->joinWith(['branchEnc f' => function ($f) {
                        $f->joinWith(['cityEnc f1'], false);
                    }], false);
                }], false)
                ->joinWith(['userRoles1 g'], false)
                ->where(['a.user_enc_id' => $user_id])
                ->asArray()
                ->one();

            // getting user type
            $user['user_type'] = $this->getUserType($user_id);

            // if user_type is Employee then getting its organization data and merging it into user array
            if ($user['user_type'] == 'Employee' || $user['user_type'] == 'Dealer') {

                // getting user role data to get organization id the employee belongs to
                $user_role = UserRoles::findOne(['user_enc_id' => $user_id, 'is_deleted' => 0]);

                // user_role not empty and organization id not null then getting organization data and merging it into user array
                if (!empty($user_role) && $user_role->organization_enc_id != null) {
                    $employee_organization = $this->getOrganization($user_role->organization_enc_id);
                    $user = array_merge($user, $employee_organization);
                }

            } elseif ($user['user_type'] == 'DSA') {

                // if user_type is DSA then getting its organization id from assigned supervisor table
                $dsa = AssignedSupervisor::find()
                    ->alias('a')
                    ->select(['a.assigned_enc_id', 'a.supervisor_enc_id', 'b.organization_enc_id'])
                    ->joinWith(['supervisorEnc b'], false);
                // DSA can be organization or individual user so if it is organization then getting data with assigned_organization_enc_id
                if ($user['organization_enc_id']) {
                    $dsa->where(['a.assigned_organization_enc_id' => $user['organization_enc_id'], 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);
                } else {
                    // if it's individual user then getting data with assigned_user_enc_id
                    $dsa->where(['a.assigned_user_enc_id' => $user_id, 'a.supervisor_role' => 'Lead Source', 'a.is_supervising' => 1, 'b.is_deleted' => 0]);
                }
                $dsa = $dsa->asArray()->one();

                // if not empty DSA array then getting organization data and merging it into user array
                if (!empty($dsa) && $dsa['organization_enc_id']) {
                    $dsa_organization = $this->getOrganization($dsa['organization_enc_id']);
                    $user = array_merge($user, $dsa_organization);
                }
            }

            if ($source != null) {
                $token = $this->findToken($user_id, $source);
                $token = !empty($token) ? $this->getToken($token) : $this->generateNewToken($user_id, $source);
                $user['access_token'] = $token->access_token;
                $user['source'] = $token->source;
                $user['refresh_token'] = $token->refresh_token;
                $user['access_token_expiry_time'] = $token->access_token_expiration;
                $user['refresh_token_expiry_time'] = $token->refresh_token_expiration;
            }
            $userUtilities = new UserUtilities();
            $accessroles = $userUtilities->rolesArray;
            if (in_array($user['designation'], $accessroles)) {
                $user['specialAccessRole'] = true;
            } else {
                $user['specialAccessRole'] = false;
            }
            return $user;
        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }
    }

    // getting user type Financer, DSA, Connector, Employee, Dealer
    public static function getUserType($user_id)
    {
        // getting user object
        $user = Users::findOne(['user_enc_id' => $user_id]);

        // getting services data to user type Financer, DSA, Connector
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

        // Extracts the 'name' field from each element of the $service array
        $serviceArr = array_column($service, 'name');

        // getting user type of this user. user types can be Individual, Employee, Dealer
        $user_type = UserTypes::findOne(['user_type_enc_id' => $user->user_type_enc_id])->user_type;

        // if service is Loans then make user_type Financer
        if (in_array('Loans', $serviceArr)) {
            $user_type = "Financer";
        } else if (in_array('E-Partners', $serviceArr)) {
            // if service assigned to this user is e-partners then make user type to DSA
            $user_type = "DSA";
        } else if (in_array('Connector', $serviceArr)) {
            // if service assigned to this user is Connector then make user type to Connector
            $user_type = "Connector";
        }

        return $user_type;
    }

    // getting organization data
    private function getOrganization($organization_id)
    {
        return Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name organization_name', 'a.slug organization_slug', 'b.username organization_username', 'a.email organization_email', 'a.phone organization_phone',
                'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . '",a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=true&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logoOrg',
                'CASE WHEN b.image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . '",b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(b.first_name," ",b.last_name), "&size=200&rounded=true&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END imageOrg',
            ])
            ->joinWith(['createdBy b' => function ($b) {
                $b->joinWith(['userRoles b1'], false);
            }], false)
            ->where(['a.organization_enc_id' => $organization_id])
            ->asArray()
            ->one();
    }

    // finding user access token exists or not
    private function findToken($user_id, $source)
    {
        return UserAccessTokens::findOne([
            'user_enc_id' => $user_id,
            'source' => $source,
            'is_deleted' => 0
        ]);
    }

    // if token exists updating its token and expire time
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
        throw new \Exception(json_encode($token->getErrors()));
    }

    // generating new Token
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

        throw new \Exception(json_encode($token->getErrors()));
    }

    // to search key in a vast array
    public static function array_search_key($needle_key, $array)
    {
        foreach ($array as $key => $value) {
            if ($key === $needle_key) {
                return $value;
            }
            if (is_array($value)) {
                if (($result = self::array_search_key($needle_key, $value)) !== false) {
                    return $result;
                }
            }
        }
        return false;
    }

}