<?php

namespace api\modules\v4\controllers;

use api\modules\v3\models\widgets\Referral;
use api\modules\v4\models\ForgotPassword;
use api\modules\v4\models\ProfilePicture;
use api\modules\v4\models\Candidates;
use api\modules\v4\models\LoginForm;
use api\modules\v4\models\SignupForm;
use api\modules\v4\utilities\UserUtilities;
use common\models\Organizations;
use common\models\spaces\Spaces;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\Users;
use common\models\UserVerificationTokens;
use common\models\Utilities;
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

    // this action is used for signup
    public function actionSignup()
    {
        try {

            $params = Yii::$app->request->post();

            // creating signup form object. if its financer then it will make object with scenario Financer to require organization fields
            $model = !empty($params['user_type']) ? (($params['user_type'] == 'Financer') ? new SignupForm(['scenario' => 'Financer']) : new SignupForm()) : new SignupForm();

            // loading data from post request to model
            if ($model->load(Yii::$app->request->post(), '')) {

                // if source empty then assign user ip address
                $model->source = !empty($model->source) ? $model->source : Yii::$app->getRequest()->getUserIP();

                // if model validated then it will save data
                if ($model->validate()) {
                    // saving user data
                    $data = $model->save();

                    // if user saved successfully
                    if ($data['status'] == 201) {
                        // creating user utilities model to get user data
                        $user = new UserUtilities();
                        $user_data = $user->userData($data['user_id'], $model->source);

                        return $this->response(201, ['status' => 201, 'data' => $user_data]);
                    } else {
                        // if there is error while saving data
                        return $this->response(500, $data);
                    }
                }

                // if there is errors in model while validating then return errors
                return $this->response(409, ['status' => 409, 'error' => $model->getErrors()]);
            }

            // if there is no data in post request then send 400 bad request
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);

        } catch (\Exception $exception) {
            return ['status' => 500, 'message' => 'an error occurred', 'error' => json_decode($exception->getMessage(), true)];
        }
    }

    // this action is used to validate fields like username, email, phone etc.
    public function actionValidate()
    {
        $params = Yii::$app->request->post();

        // if field is username then checking in  usernames table
        if ($params['field'] == 'username') {
            $exists = Usernames::findOne(['username' => $params['value']]);
            if ($exists) {
                return $this->response(409, ['status' => 409, 'exists' => true]);
            }
        }

        // checking in users table
        $user_exists = Users::findOne([$params['field'] => $params['value']]);

        if ($user_exists) {
            return $this->response(409, ['status' => 409, 'exists' => true]);
        }

        return $this->response(200, ['status' => 200, 'exists' => false]);
    }

    // this action is used to log user in
    public function actionLogin()
    {
        try {
            // creating login form object
            $model = new LoginForm();

            // loading login request data into form
            if ($model->load(Yii::$app->request->post(), '')) {

                // logging in user
                if ($model->login()) {

                    // if source empty then assigning user if as source
                    $source = Yii::$app->request->post('source');
                    if (!$source) {
                        $source = Yii::$app->getRequest()->getUserIP();
                    }

                    // getting user object
                    $user = $this->findUser($model);

                    // updating user last_visit and last_visit_through
                    $user->last_visit = date('Y-m-d H:i:s');
                    $user->last_visit_through = 'EL';
                    if (!$user->update()) {
                        // if user not update then returning error
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $user->getErrors()]);
                    }

                    // creating user utilities model to get user data
                    $userData = new UserUtilities();
                    $user_data = $userData->userData($user->user_enc_id, $source);

                    return $this->response(200, ['status' => 200, 'data' => $user_data]);
                }

                // if form not validated then return 409 conflict and incorrect username and password
                return $this->response(409, ['status' => 409, 'data' => $model->getErrors()]);
            }

            // if there is no data in request then error 400 bad request
            return $this->response(400, ['status' => 400, 'message' => 'bad request']);
        } catch (\Exception $exception) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => json_decode($exception, true)]);
        }
    }

    // finding user with username or email
    private function findUser($model)
    {
        return Candidates::find()->where(['or', ['username' => $model->username], ['email' => $model->username]])->one();
    }

    // this action is used to upload profile picture
    public function actionUploadProfilePicture()
    {
        // only performed by logged-in user
        if ($user = $this->isAuthorized()) {

            // creating profile picture object
            $pictureModel = new ProfilePicture();

            // loading image into profile image get by instance name
            $pictureModel->profile_image = UploadedFile::getInstanceByName('profile_image');

            // if image loaded and validated
            if ($pictureModel->profile_image && $pictureModel->validate()) {

                // adding or updating profile image and returning it
                $image = $pictureModel->update($user->user_enc_id);

                if ($image['status'] == 200) {
                    return $this->response(200, $image);
                }

                return $this->response(500, $image);

            } else {

                // if not validated then returning conflict
                return $this->response(409, ['status' => 409, 'message' => 'conflict']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // this action is used to upload organization logo
    public function actionUploadLogo()
    {
        // checking user authorized
        if ($user = $this->isAuthorized()) {

            $utilitiesModel = new Utilities();

            // if user organization exists then upload its logo
            if ($user->organization_enc_id) {

                // getting logo instance by name
                $logo = UploadedFile::getInstanceByName('logo');

                // getting organization with this org id
                $orgModel = Organizations::findOne(['organization_enc_id' => $user->organization_enc_id]);

                // adding organization logo_location and base_path
                $orgModel->logo_location = \Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->organizations->logo . $orgModel->logo_location . '/';
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $orgModel->logo = $utilitiesModel->encrypt() . '.' . $logo->extension;
                $type = $logo->type;
                if ($orgModel->update()) {

                    // after updating location creating spaces object and uploading image to digital ocean
                    $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                    $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                    $result = $my_space->uploadFileSources($logo->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $orgModel->logo, "public", ['params' => ['ContentType' => $type]]);
                    if ($result) {
                        return $this->response(200, ['status' => 200, 'message' => 'Updated Successfully']);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred while uploading logo']);
                    }
                } else {
                    // if an error occurred while adding/updating oge logo
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $orgModel->getErrors()]);
                }

            } else {
                // 409 conflict must be organization login to upload logo
                return $this->response(409, ['status' => 409, 'message' => 'Must be an organization']);
            }
        } else {
            return $this->response(401, ['status' => 401, ['message' => 'unauthorized']]);
        }
    }

    // this action for otp login
    public function actionOtpLogin()
    {
        try {
            $params = Yii::$app->request->post();

            // if phone not found in params then return missing information
            if (empty($params['phone'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "phone"']);
            }

            // decoding phone number
            $phone = $this->decode($params['phone']);

            // finding user with this phone number
            $user = Users::find()->where(['or', ['phone' => [$phone, '+91' . $phone]], ['phone' => $phone]])->one();

            if ($user) {

                // updating last_visit and last_visit_through
                $user->last_visit = date('Y-m-d H:i:s');
                $user->last_visit_through = 'EL';
                if (!$user->update()) {
                    // if not update then return 500
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $user->getErrors()]);
                }

                // getting source from user ip
                $source = Yii::$app->getRequest()->getUserIP();

                // creating user utilities model to get user data
                $userData = new UserUtilities();
                $user_data = $userData->userData($user->user_enc_id, $source);

                return $this->response(200, ['status' => 200, 'data' => $user_data]);
            }

            // if user not found then return 404 not found
            return $this->response(404, ['status' => 404, 'message' => 'user not found']);
        } catch (\Exception $exception) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => json_decode($exception, true)]);
        }
    }

    // this function is used to get and return phone number from user id
    public function actionUserPhone()
    {
        $params = Yii::$app->request->post();

        // if id variable is empty then it will return 422 missing information
        if (empty($params['id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "id"']);
        }

        // getting user phone with user_enc_id
        $user = Users::find()
            ->select(['user_enc_id', 'phone'])
            ->where(['user_enc_id' => $params['id']])
            ->asArray()
            ->one();

        // if user exists then return phone without +91
        if ($user) {
            // removing +91 from phone number
            $phone = preg_replace('/^\+?91|\|1|\D/', '', ($user['phone']));
            return $this->response(200, ['status' => 200, 'phone' => $phone]);
        }

        // if user not found
        return $this->response(404, ['status' => 404, 'message' => 'user not found']);
    }

    // this function is used to decode phone number
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

    // this is action is used to forgot password
    public function actionForgotPassword()
    {
        $params = Yii::$app->request->post();

        // if username is empty return missing information username
        if (empty($params['username'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "username"']);
        }

        // finding user with username and email
        $user = Users::find()->where(['or', ['username' => $params['username']], ['email' => $params['username']]])->one();

        // if user found with this username
        if ($user) {

            // creating object for forgot password
            $form = new ForgotPassword();

            // method to forgot password
            $forgot_password = $form->forgotPassword($user);
            if ($forgot_password['status'] == 200) {
                return $this->response(200, $forgot_password);
            }

            return $this->response(500, $forgot_password);
        }

        // if user not found then return user not found
        return $this->response(404, ['status' => 404, 'message' => 'user not found']);
    }

    // this action is used to reset password from token
    public function actionResetPassword()
    {
        $params = Yii::$app->request->post();

        // if token empty return missing information token
        if (empty($params['token'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "token"']);
        }

        // if new_password empty return missing information new_password
        if (empty($params['new_password'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "new_password"']);
        }


        try {
            // if token verified then getting its user_id
            $user_id = Yii::$app->forgotPassword->verify($params['token']);
        } catch (InvalidParamException $e) {
            // if exception occurred
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $e->getMessage()]);
        }

        // changing to new password
        if (Yii::$app->forgotPassword->change($user_id, $params['new_password'])) {
            return $this->response(200, ['status' => 200, 'message' => 'password changed successfully']);
        }

        return $this->response(500, ['status' => 500, 'message' => 'something went wrong']);
    }

    // getting user detail with its access token
    public function actionFindUser()
    {
        try {
            // getting access token and source
            $access_token = Yii::$app->request->post('access_token');
            $source = Yii::$app->request->post('source');

            // getting token detail with this access_token and source
            $token = UserAccessTokens::findOne(['access_token' => $access_token, 'source' => $source]);

            // if token not found
            if (!$token) {
                return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
            }

            // creating today's date
            $today_date = new \DateTime();
            $today_date = $today_date->format('Y-m-d H:i:s');

            // if token expired then returning unauthorized
            if ($today_date > $token->access_token_expiration) {
                return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
            }

            // getting user detail from token user
            $user = Users::findOne(['user_enc_id' => $token->user_enc_id]);

            // creating user utilities model to get user data
            $userData = new UserUtilities();
            $data = $userData->userData($user->user_enc_id);

            // adding token detail to data
            $data['access_token'] = $token->access_token;
            $data['source'] = $token->source;
            $data['refresh_token'] = $token->refresh_token;
            $data['access_token_expiry_time'] = $token->access_token_expiration;
            $data['refresh_token_expiry_time'] = $token->refresh_token_expiration;

            // if password is user phone then it will send weak_password true else false
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['password'] = $user->phone;
            $pass = $utilitiesModel->encrypt_pass();
            $data['weak_password'] = $pass === $user['password'];

            return $this->response(200, ['status' => 200, 'data' => $data]);

        } catch (\Exception $exception) {
            return $this->response(500, ['status' => 200, 'message' => 'an error occurred', 'error' => json_decode($exception, true)]);
        }

    }

    // this action is used to change password
    public function actionChangePassword()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            // checking new_password empty return missing information
            if (empty($params['new_password'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "new_password"']);
            }

            // getting user object with user_enc_id
            $user = Users::findOne(['user_enc_id' => $user->user_enc_id]);

            // encrypting and updating new password
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['password'] = $params['new_password'];
            $user->password = $utilitiesModel->encrypt_pass();
            $user->last_updated_on = date('Y-m-d H:i:s');
            if (!$user->update()) {
                // if not update returning 500 error
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $user->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    // verifying phone
    public function actionVerifyPhone()
    {
        $params = Yii::$app->request->post();

        // if phone is empty in params then return phone missing information
        if (empty($params['phone'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "phone"']);
        }

        // decoding phone
        $phone = $this->decode($params['phone']);

        // getting user with this phone
        $user = Users::find()->where(['or', ['phone' => [$phone, '+91' . $phone]], ['phone' => $phone]])->one();

        // if user exists return true else false
        if ($user) {
            return $this->response(200, ['status' => 200, 'user_exists' => true]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'user not found', 'user_exists' => false]);
    }

    // this api is used to change password with otp verification
    public function actionOtpChangePassword()
    {
        $params = Yii::$app->request->post();

        // checking phone in params
        if (empty($params['phone'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "phone"']);
        }

        // decoding phone
        $phone = $this->decode($params['phone']);

        // getting user object with this phone number
        $user = Users::find()->where(['or', ['phone' => [$phone, '+91' . $phone]], ['phone' => $phone]])->one();

        if ($user) {

            // this query will delete old user verification tokens
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

            // creating new token
            $utilitiesModel = new Utilities();
            $userVerificationModel = new UserVerificationTokens();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $userVerificationModel->token_enc_id = $utilitiesModel->encrypt();
            $userVerificationModel->token = Yii::$app->security->generateRandomString();
            $userVerificationModel->verification_type = 1;
            $userVerificationModel->created_by = $user->user_enc_id;
            if (!$userVerificationModel->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $userVerificationModel->getErrors()]);
            }

            // returning verification token
            return $this->response(200, ['status' => 200, 'token' => $userVerificationModel->token]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'user not found']);
    }

    public function actionReferralLogo()
    {
        $params = Yii::$app->request->post();
        $ref = \common\models\Referral::find()
            ->alias('a')
            ->select([
                'a.referral_enc_id',
                'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo . '",b.logo_location, "/", b.logo) 
                    ELSE null
                    END AS logo'
            ])
            ->joinWith(['organizationEnc b' ])
            ->where(['a.code' => $params['code']])
            ->andWhere(['<>', 'a.organization_enc_id', 'null'])
            ->asArray()
            ->one();

        if ($ref) {
            return $this->response(200, ['status' => 200, 'data' => $ref]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }
}