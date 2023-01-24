<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\ForgotPassword;
use api\modules\v4\models\OrganizationSignup;
use api\modules\v4\models\ProfilePicture;
use api\modules\v4\models\Candidates;
use api\modules\v4\models\LoginForm;
use api\modules\v4\models\IndividualSignup;
use common\models\AssignedSupervisor;
use common\models\Organizations;
use common\models\Referral;
use common\models\SelectedServices;
use common\models\spaces\Spaces;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\UserRoles;
use common\models\Users;
use common\models\UserTypes;
use common\models\UserVerificationTokens;
use common\models\Utilities;
use frontend\models\accounts\ResetPasswordForm;
use yii\web\UploadedFile;
use Yii;
use yii\helpers\Url;
use yii\filters\Cors;
use yii\filters\auth\HttpBearerAuth;


class AuthController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'signup',
                'org-signup',
                'validate',
                'login',
                'upload-profile-picture',
                'upload-logo',
                'otp-login',
                'forgot-password',
                'reset-password',
                'user-phone',
                'find-user',
                'change-password',
                'otp-change-password',
                'verify-phone'
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'signup' => ['POST', 'OPTIONS'],
                'org-signup' => ['POST', 'OPTIONS'],
                'validate' => ['POST', 'OPTIONS'],
                'login' => ['POST', 'OPTIONS'],
                'upload-profile-picture' => ['POST', 'OPTIONS'],
                'upload-logo' => ['POST', 'OPTIONS'],
                'otp-login' => ['POST', 'OPTIONS'],
                'forgot-password' => ['POST', 'OPTIONS'],
                'reset-password' => ['POST', 'OPTIONS'],
                'user-phone' => ['POST', 'OPTIONS'],
                'find-user' => ['POST', 'OPTIONS'],
                'change-password' => ['POST', 'OPTIONS'],
                'otp-change-password' => ['POST', 'OPTIONS'],
            ]
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionSignup()
    {
        $model = new IndividualSignup();

        if ($model->load(Yii::$app->request->post(), '')) {

            if (!$model->source) {
                $model->source = Yii::$app->getRequest()->getUserIP();
            }

            if ($model->dsaRefId && !$model->is_connector && $model->user_type != 'Employee') {
                if (!$this->DsaOrgExist($model->dsaRefId)) {
                    return $this->response(404, ['status' => 404, 'message' => 'no organization found with this ref id']);
                }
            }

            if ($model->validate()) {
                if ($data = $model->saveUser()) {
                    return $this->response(201, ['status' => 201, 'data' => $data]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }
            return $this->response(409, ['status' => 409, 'error' => $model->getErrors()]);
        }
        return $this->response(400, ['status' => 400, 'message' => 'bad request']);
    }

    private function DsaOrgExist($dsaRefId)
    {
        return Organizations::find()
            ->alias('a')
            ->where(['a.organization_enc_id' => $dsaRefId])
            ->joinWith(['selectedServices b' => function ($x) {
                $x->andWhere(['b.is_selected' => 1]);
                $x->joinWith(['serviceEnc c' => function ($b) {
                    $b->andWhere(['c.name' => ['E-Partners', 'Loans']]);
                }], 'INNER JOIN');
            }], 'INNER JOIN')
            ->exists();
    }

    public function actionOrgSignup()
    {
        $model = new OrganizationSignup();
        if ($model->load(Yii::$app->request->post(), '')) {
            if (!$model->source) {
                $model->source = Yii::$app->getRequest()->getUserIP();
            }
            if ($model->validate()) {
                if ($data = $model->add()) {
                    return $this->response(201, ['status' => 201, 'data' => $data]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }
            return $this->response(409, ['status' => 409, 'error' => $model->getErrors()]);
        }
        return $this->response(400, ['status' => 400, 'message' => 'bad request']);
    }

    public function actionValidate()
    {
        $params = Yii::$app->request->post();

        if ($params['field'] == 'username') {
            $exists = Usernames::findOne(['username' => $params['value']]);
            if ($exists) {
                return $this->response(409, ['status' => 409, 'exists' => true]);
            }
        }

        $user_exists = Users::findOne([$params['field'] => $params['value']]);

        if ($user_exists) {
            return $this->response(409, ['status' => 409, 'exists' => true]);
        }

        return $this->response(200, ['status' => 200, 'exists' => false]);
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->login()) {
                $source = Yii::$app->request->post('source');
                if (!$source) {
                    $source = Yii::$app->getRequest()->getUserIP();
                }
                $user = $this->findUser($model);

//                if ($user->organization_enc_id) {
//                    if (!$this->isEPartner($user)) {
//                        return $this->response(409, ['status' => 409, 'message' => 'organization must be e-partner']);
//                    }
//                }

                $user->last_visit = date('Y-m-d H:i:s');
                $user->last_visit_through = 'EL';
                if (!$user->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }

                $token = $this->findToken($user, $source);
                if (empty($token)) {
                    if ($token = $this->newToken($user->user_enc_id, $source)) {
                        $data = $this->returnData($user, $token);
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    }
                } else {
                    if ($token = $this->onlyTokens($token)) {
                        $data = $this->returnData($user, $token);
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    }
                }
            }
            return $this->response(409, ['status' => 409, 'data' => $model->getErrors()]);
        }
        return $this->response(400, ['status' => 400, 'message' => 'bad request']);
    }

    private function isEPartner($user)
    {
        return SelectedServices::find()
            ->alias('a')
            ->joinWith(['serviceEnc b'])
            ->where(['a.organization_enc_id' => $user->organization_enc_id, 'a.is_selected' => 1, 'b.name' => 'E-Partners'])
            ->exists();
    }

    private function returnData($user, $token)
    {
        if ($user->organization_enc_id) {
            $ref = Referral::findOne(['organization_enc_id' => $user->organization_enc_id]);
            $data['referral_code'] = !empty($ref) ? $ref->code : '';

            $org = Organizations::findOne(['organization_enc_id' => $user->organization_enc_id]);
            $data['organization_name'] = $org->name;
            $data['organization_email'] = $org->email;
            $data['organization_phone'] = $org->phone;
            $data['organization_slug'] = $org->slug;
            $data['organization_enc_id'] = $org->organization_enc_id;
            $data['organization_username'] = Users::findOne(['organization_enc_id' => $org->organization_enc_id])->username;
            if ($org->logo != null) {
                $data['logo'] = Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . $org->logo_location . '/' . $org->logo;
            } else {
                $data['logo'] = "https://ui-avatars.com/api/?name=" . $org->name . "&size=200&rounded=false&background=" . str_replace("#", "", $org->initials_color) . "&color=ffffff";
            }
        } else {
            $ref = Referral::findOne(['user_enc_id' => $user->user_enc_id]);
            $data['referral_code'] = !empty($ref) ? $ref->code : '';
        }

        $service = SelectedServices::find()
            ->alias('a')
            ->select(['b.name'])
            ->joinWith(['serviceEnc b'], false)
            ->where(['a.is_selected' => 1]);
//            ->andWhere(['or', ['a.created_by' => $user->user_enc_id], ['organization_enc_id' => $user->organization_enc_id]]);
        if ($user->organization_enc_id) {
            $service->andWhere(['or', ['a.organization_enc_id' => $user->organization_enc_id]]);
        } else {
            $service->andWhere(['or', ['a.created_by' => $user->user_enc_id]]);
        }

        $service = $service->asArray()
            ->all();


        $serviceArr = array_column($service, 'name');


        if (in_array('Loans', $serviceArr)) {
            $data['user_type'] = "Financer";
        } else if (in_array('E-Partners', $serviceArr)) {
            $data['user_type'] = "DSA";
        } else if (in_array('Connector', $serviceArr)) {
            $data['user_type'] = "Connector";
        } else {
            $data['user_type'] = UserTypes::findOne(['user_type_enc_id' => $user->user_type_enc_id])->user_type;
        }

        $data['username'] = $user->username;
        $data['user_enc_id'] = $user->user_enc_id;
        $data['first_name'] = $user->first_name;
        $data['last_name'] = $user->last_name;
        $data['initials_color'] = $user->initials_color;
        $data['phone'] = $user->phone;
        $data['email'] = $user->email;
//        $data['user_type'] = UserTypes::findOne(['user_type_enc_id' => $user->user_type_enc_id])->user_type;
        $data['access_token'] = $token->access_token;
        $data['source'] = $token->source;
        $data['refresh_token'] = $token->refresh_token;
        $data['access_token_expiry_time'] = $token->access_token_expiration;
        $data['refresh_token_expiry_time'] = $token->refresh_token_expiration;

        if ($user->image) {
            $data['image'] = Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image . $user->image_location . DIRECTORY_SEPARATOR . $user->image, 'https');
        } else {
            $data['image'] = "https://ui-avatars.com/api/?name=" . $user->first_name . ' ' . $user->last_name . "&size=200&rounded=false&background=" . str_replace("#", "", $user->initials_color) . "&color=ffffff";
        }

        if ($data['user_type'] == 'Employee') {
            $org_id = UserRoles::findOne(['user_enc_id' => $user->user_enc_id])->organization_enc_id;
            if ($org_id) {
                $organization = Organizations::find()
                    ->alias('a')
                    ->select(['a.organization_enc_id', 'a.name', 'a.slug', 'b.username'])
                    ->joinWith(['createdBy b'], false)
                    ->where(['a.organization_enc_id' => $org_id])
                    ->asArray()
                    ->one();
                $data['organization_name'] = $organization['name'];
                $data['organization_slug'] = $organization['slug'];
                $data['organization_username'] = $organization['username'];
                $data['organization_enc_id'] = $organization['organization_enc_id'];
            }
        }

        if ($data['user_type'] == 'DSA') {

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
                $organization = Organizations::find()
                    ->alias('a')
                    ->select(['a.organization_enc_id', 'a.name', 'a.slug', 'b.username'])
                    ->joinWith(['createdBy b'], false)
                    ->where(['a.organization_enc_id' => $dsa['organization_enc_id']])
                    ->asArray()
                    ->one();
                $data['organization_name'] = $organization['name'];
                $data['organization_slug'] = $organization['slug'];
                $data['organization_username'] = $organization['username'];
                $data['organization_enc_id'] = $organization['organization_enc_id'];
            }
        }

        return $data;
    }

    private function findUser($model)
    {
        $user = Candidates::findOne([
            'username' => $model->username
        ]);
        if (!$user) {
            $user = Candidates::findOne([
                'email' => $model->username
            ]);
        }
        return $user;
    }

    private function onlyTokens($token)
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

    private function newToken($user_id, $source)
    {
        $token = new UserAccessTokens();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $time_now = date('Y-m-d H:i:s', time());
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
        return $token->getErrors();
    }

    private function findToken($user, $source)
    {
        return UserAccessTokens::findOne([
            'user_enc_id' => $user->user_enc_id,
            'source' => $source
        ]);
    }

    public function actionUploadProfilePicture()
    {
        if ($user = $this->isAuthorized()) {
            $pictureModel = new ProfilePicture();
            $pictureModel->profile_image = UploadedFile::getInstanceByName('profile_image');
            if ($pictureModel->profile_image && $pictureModel->validate()) {
                if ($user_id = $pictureModel->update($user->user_enc_id)) {
                    $user_image = Users::find()
                        ->select(['CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", image_location, "/", image) ELSE NULL END image'])
                        ->where(['user_enc_id' => $user_id])
                        ->asArray()
                        ->one();
                    return $this->response(200, ['status' => 200, 'image' => $user_image['image']]);
                }
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            } else {
                return $this->response(409, ['status' => 409, 'message' => 'conflict']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUploadLogo()
    {
        if ($user = $this->isAuthorized()) {
            $utilitiesModel = new Utilities();
            if ($user->organization_enc_id) {
                $logo = UploadedFile::getInstanceByName('logo');
                $orgModel = Organizations::findOne(['organization_enc_id' => $user->organization_enc_id]);

                if ($orgModel) {
                    $orgModel->logo_location = \Yii::$app->getSecurity()->generateRandomString();
                    $base_path = Yii::$app->params->upload_directories->organizations->logo . $orgModel->logo_location . '/';
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $orgModel->logo = $utilitiesModel->encrypt() . '.' . $logo->extension;
                    $type = $logo->type;
                    if ($orgModel->update()) {
                        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                        $result = $my_space->uploadFileSources($logo->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $orgModel->logo, "public", ['params' => ['ContentType' => $type]]);
                        if ($result) {
                            return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
                        } else {
                            return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred']);
                        }
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'An Error Occurred']);
                    }
                } else {
                    return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
                }

            } else {
                return $this->response(409, ['status' => 409, 'message' => 'Must be an organization']);
            };
        }
    }

    public function actionOtpLogin()
    {
        $params = Yii::$app->request->post();

        if (empty($params['phone'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "phone"']);
        }

        $phone = $this->decode($params['phone']);
//        $phone = $params['phone'];

        $user = Users::find()
            ->where([
                'or',
                ['phone' => [$phone, '+91' . $phone]],
                ['phone' => $phone],
            ])
            ->one();

        if ($user) {

            $user->last_visit = date('Y-m-d H:i:s');
            $user->last_visit_through = 'EL';
            if (!$user->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

            $source = Yii::$app->getRequest()->getUserIP();
            $token = $this->findToken($user, $source);

            if (empty($token)) {
                if ($token = $this->newToken($user->user_enc_id, $source)) {
                    $data = $this->returnData($user, $token);
                    return $this->response(200, ['status' => 200, 'data' => $data]);
                }
            } else {
                if ($token = $this->onlyTokens($token)) {
                    $data = $this->returnData($user, $token);
                    return $this->response(200, ['status' => 200, 'data' => $data]);
                }
            }
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionUserPhone()
    {
        $params = Yii::$app->request->post();

        if (empty($params['id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "id"']);
        }

        $user = Users::find()
            ->select(['user_enc_id', 'phone'])
            ->where(['user_enc_id' => $params['id']])
            ->asArray()
            ->one();

        if ($user) {
            $phone = preg_replace('/^\+?91|\|1|\D/', '', ($user['phone']));
            return $this->response(200, ['status' => 200, 'phone' => $phone]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    private function decode($encoded)
    {
        $encoded = base64_decode($encoded);
        $decoded = "";
        for ($i = 0; $i < strlen($encoded); $i++) {
            $b = ord($encoded[$i]);
            $a = $b ^ 10;
            $decoded .= chr($a);
        }
        return base64_decode(base64_decode($decoded));
    }

    public function actionForgotPassword()
    {
        $params = Yii::$app->request->post();

        if (empty($params['username'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "username"']);
        }

        $user = Users::find()
            ->where([
                'or',
                ['username' => $params['username']],
                ['email' => $params['username']],
            ])
            ->one();

        if ($user) {
            $form = new ForgotPassword();
            if ($form->forgotPassword($user)) {
                return $this->response(200, ['status' => 200, 'message' => 'reset password mail sent to your email please check.']);
            }
            return $this->response(500, ['status' => 500, 'message' => 'something went wrong']);
        }

        return $this->response(404, ['status' => 404, 'message' => 'user not found']);
    }

    public function actionResetPassword()
    {

        $params = Yii::$app->request->post();

        if (empty($params['token'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "token"']);
        }

        if (empty($params['new_password'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "new_password"']);
        }

        try {
            $user_id = Yii::$app->forgotPassword->verify($params['token']);
        } catch (InvalidParamException $e) {
            return $this->response(500, ['status' => 500, 'message' => $e->getMessage()]);
        }

        if (Yii::$app->forgotPassword->change($user_id, $params['new_password'])) {
            return $this->response(200, ['status' => 200, 'message' => 'password changed successfully']);
        }

        return $this->response(500, ['status' => 500, 'message' => 'something went wrong']);
    }

    public function actionFindUser()
    {
        $access_token = Yii::$app->request->post('access_token');
        $source = Yii::$app->request->post('source');

        $token = UserAccessTokens::findOne(['access_token' => $access_token, 'source' => $source]);

        $today_date = new \DateTime();
        $today_date = $today_date->format('Y-m-d H:i:s');

        if ($today_date > $token->access_token_expiration) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }

        $user = Users::findOne(['user_enc_id' => $token->user_enc_id]);

        $data = $this->returnData($user, $token);

        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['password'] = $user->phone;
        $pass = $utilitiesModel->encrypt_pass();
        if ($pass === $user['password']) {
            $data['weak_password'] = true;
        } else {
            $data['weak_password'] = false;
        }

        return $this->response(200, ['status' => 200, 'data' => $data]);

    }

    public function actionChangePassword()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (empty($params['new_password'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "new_password"']);
            }

            $user = Users::findOne(['user_enc_id' => $user->user_enc_id]);

            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['password'] = $params['new_password'];
            $user->password = $utilitiesModel->encrypt_pass();
            $user->last_updated_on = date('Y-m-d H:i:s');
            if (!$user->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionVerifyPhone()
    {
        $params = Yii::$app->request->post();

        if (empty($params['phone'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "phone"']);
        }

        $phone = $this->decode($params['phone']);
//        $phone = $params['phone'];

        $user = Users::find()
            ->where([
                'or',
                ['phone' => [$phone, '+91' . $phone]],
                ['phone' => $phone],
            ])
            ->one();

        if ($user) {
            return $this->response(200, ['status' => 200, 'user_exists' => true]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found', 'user_exists' => false]);
    }

    public function actionOtpChangePassword()
    {
        $params = Yii::$app->request->post();

        if (empty($params['phone'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "phone"']);
        }

        $phone = $this->decode($params['phone']);
//        $phone = $params['phone'];

        $user = Users::find()
            ->where([
                'or',
                ['phone' => [$phone, '+91' . $phone]],
                ['phone' => $phone],
            ])
            ->one();

        if ($user) {

            UserVerificationTokens::updateAll([
                'last_updated_on' => date('Y-m-d H:i:s'),
                'last_updated_by' => $user->user_enc_id,
                'is_deleted' => 1
            ], ['and',
                ['verification_type' => 1],
                ['created_by' => $user->user_enc_id],
                ['status' => 'Pending'],
                ['is_deleted' => 0]
            ]);

            $utilitiesModel = new Utilities();
            $userVerificationModel = new UserVerificationTokens();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $userVerificationModel->token_enc_id = $utilitiesModel->encrypt();
            $userVerificationModel->token = Yii::$app->security->generateRandomString();
            $userVerificationModel->verification_type = 1;
            $userVerificationModel->created_by = $user->user_enc_id;
            if (!$userVerificationModel->save()) {
                return $this->response(500, ['statud' => 500, 'message' => 'an error occurred', 'error' => $userVerificationModel->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'token' => $userVerificationModel->token]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }
}