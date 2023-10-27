<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\ForgotPasswordForm;
use api\modules\v1\models\SocialLogin;
use common\components\AuthHandler;
use common\models\Auth;
use common\models\EmailLogs;
use common\models\User;
use common\models\Usernames;
use common\models\Users;
use common\models\UserTypes;
use http\Env\Response;
use yii\helpers\Url;
use Yii;
use api\modules\v1\models\IndividualSignup;
use api\modules\v1\models\LoginForm;
use api\modules\v1\models\Candidates;
use common\models\RandomColors;
use common\models\UserAccessTokens;
use common\models\Utilities;

class AuthController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'signup' => ['POST'],
                'login' => ['POST'],
                'refresh-access-token' => ['POST'],
                'forgot-password' => ['POST'],
                'social-authentication' => ['POST'],
                'social-login' => ['POST'],
                'check-source-id' => ['POST'],
                'user-data' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionCheckSourceId()
    {
        $params = Yii::$app->request->post();
        if (!isset($params['platform']) && empty($params['platform'])) {
            return $this->response(422, 'missing information');
        }

        if (!isset($params['source_id']) && empty($params['source_id'])) {
            return $this->response(422, 'missing information');
        }
        $auth = Auth::find()->where([
            'source' => $params['platform'],
            'source_id' => $params['source_id'],
        ])->one();

        if ($auth) {
            return $this->response(200, 'success');
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionSocialAuthentication()
    {
        $model = new SocialLogin();
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $result = $model->handle();
                if ($result['status'] == 203) {
                    $user = Candidates::findOne([
                        'user_enc_id' => $result['user_id'],
                    ]);
                    $token = $this->findToken($user, $model->source);
                    if (empty($token)) {
                        if ($token = $this->newToken($user->user_enc_id, $model->source)) {
                            $data = $this->returnData($user, $token);
                            return $this->response(200, $data);
                        }
                    } else {
                        if ($token = $this->onlyTokens($token)) {
                            $data = $this->returnData($user, $token);
                            return $this->response(200, $data);
                        }
                    }
                } else if ($result['status'] == 205) {
                    $user = Candidates::findOne([
                        'user_enc_id' => $result['user_id'],
                    ]);
                    return $this->response(200, ['user_id' => $user->user_enc_id, 'user_name' => $user->username]);
                } else {
                    return $this->response(500, 'An Error Occurred..');
                }
            }
            return $this->response(422, $model->getErrors());
        }
        return $this->response(422);
    }

    public function actionSocialLogin()
    {
        $id = Yii::$app->request->post('user_id');
        $username = Yii::$app->request->post('username');
        $platform = Yii::$app->request->post('platform');
        $source = Yii::$app->request->post('source');
        $user = Candidates::findOne([
            'user_enc_id' => $id,
        ]);
        if (!$user) {
            return $this->response(404, 'Not Found');
        }
        if ($user->username != $username) {
            $chkUsername = Usernames::findOne(['username' => $username]);
            if ($chkUsername) {
                return $this->response(409, 'Already Exist');
            } else {
                $save_user_name = new Usernames();
                if (strlen($username) >= 3 && strlen($username) <= 20) {
                    $save_user_name->username = $username;
                } else {
                    return $this->response(409, 'Already Exist');
                }
                $save_user_name->assigned_to = 1;
                if ($save_user_name->save()) {
                    $user->username = $username;
                    $user->last_updated_on = date('Y-m-d H:i:s');
                    $user->last_visit = date('Y-m-d H:i:s');
                    $user->last_visit_through = 'EYAPP';
                    if (!$user->update()) {
                        return $this->response(500, 'an error occurred');
                    }
                } else {
                    return $this->response(500, 'an error occurred');
                }
            }

        }
        $token = $this->findToken($user, $platform);
        if (empty($token)) {
            if ($token = $this->newToken($user->user_enc_id, $source)) {
                $data = $this->returnData($user, $token);
                return $this->response(200, $data);
            }
        } else {
            if ($token = $this->onlyTokens($token)) {
                $data = $this->returnData($user, $token);
                return $this->response(200, $data);
            }
        }
    }

    public function actionSignup()
    {
        $model = new IndividualSignup();
        $already_taken = [
            'username' => 'Username already taken'
        ];
        if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '')) {
            if ($model->validate()) {
                if (!$this->usernameValid($model)) {
                    return $this->response(409, $already_taken);
                }
                if ($user = $this->newUser($model)) {
                    if (!empty($user->user_enc_id)) {
                        if ($token = $this->newToken($user->user_enc_id, \Yii::$app->request->post('source'))) {
                            $data = $this->returnData($user, $token);
                            return $this->response(200, $data);
                        }
                    } else {
                        return $this->response(500);
                    }
                }
            }
            return $this->response(409, $model->getErrors());
        }
        return $this->response(422);
    }

    private function usernameValid($model)
    {
        $usernamesModel = new Usernames();
        $usernamesModel->username = $model->username;
        $usernamesModel->assigned_to = 1;
        if (!$usernamesModel->validate()) {
            return false;
        } else {
            return true;
        }
    }

    private function userValid($username)
    {
        $user_exists = Usernames::find()
            ->where(['username' => $username])
            ->exists();

        if ($user_exists) {
            return true;
        } else {
            return false;
        }
    }

    private function returnData($user, $token)
    {
        return [
            'user_id' => $token->user_enc_id,
            'username' => $user->username,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'initials_color' => $user->initials_color,
            'access_token' => $token->access_token,
            'refresh_token' => $token->refresh_token,
            'access_token_expiry_time' => $token->access_token_expiration,
            'refresh_token_expiry_time' => $token->refresh_token_expiration
        ];
    }

    private function returnToken($token)
    {
        return [
            'user_id' => $token->user_enc_id,
            'access_token' => $token->access_token,
            'refresh_token' => $token->refresh_token,
            'access_token_expiry_time' => $token->access_token_expiration,
            'refresh_token_expiry_time' => $token->refresh_token_expiration
        ];
    }

    private function newUser($model)
    {
        $user = new Candidates();
        $usernamesModel = new Usernames();
        $usernamesModel->username = $model->username;
        $usernamesModel->assigned_to = 1;
        if (!$usernamesModel->validate() || !$usernamesModel->save()) {
            return false;
        }
        $user->username = strtolower($model->username);
        $user->first_name = ucfirst(strtolower($model->first_name));
        $user->last_name = ucfirst(strtolower($model->last_name));
        $user->phone = $model->phone;
        $user->email = strtolower($model->email);
        $user->user_enc_id = time() . mt_rand(10, 99);
        $user->user_type_enc_id = UserTypes::findOne(['user_type' => 'Individual'])->user_type_enc_id;
        $user->initials_color = RandomColors::one();
        $user->created_on = date('Y-m-d H:i:s', strtotime('now'));
        $user->status = "Active";
        $user->last_visit = date('Y-m-d H:i:s');
        $user->last_visit_through = "EYAPP";
        $user->signed_up_through = "EYAPP";
        $user->setPassword($model->password);
        $user->generateAuthKey();
        if ($user->save()) {
            Yii::$app->individualSignup->registrationEmail($user->user_enc_id);
            $mail = Yii::$app->mail;
            $mail->receivers = [];
            $mail->receivers[] = [
                "name" => $user->first_name . " " . $user->last_name,
                "email" => $user->email,
            ];
            $mail->subject = 'Welcome to Empower Youth';
            $mail->template = 'thank-you';
            if ($mail->send()) {
                $mail_logs = new EmailLogs();
                $utilitesModel = new Utilities();
                $utilitesModel->variables['string'] = time() . rand(100, 100000);
                $mail_logs->email_log_enc_id = $utilitesModel->encrypt();
                $mail_logs->email_type = 5;
                $mail_logs->user_enc_id = $user->user_enc_id;
                $mail_logs->receiver_name = $user->first_name . " " . $user->last_name;
                $mail_logs->receiver_email = $user->email;
                $mail_logs->receiver_phone = $user->phone;
                $mail_logs->subject = 'Welcome to Empower Youth';
                $mail_logs->template = 'thank-you';
                $mail_logs->is_sent = 1;
                $mail_logs->save();
            }
            return $user;
        }
        return false;
    }

    private function newToken($user_id, $source)
    {
        $token = new UserAccessTokens();
        $time_now = date('Y-m-d H:i:s');
        $token->access_token_enc_id = time() . mt_rand(10, 99);
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

    private function withoutPassword($username)
    {

        $user = Candidates::find()
            ->where(['username' => $username])
            ->orWhere(['email' => $username])
            ->one();
        if ($user > 0) {
            return $this->response(409);
        } else {
            return $this->response(404);
        }
    }

    private function findUser($model)
    {
        $user = Candidates::findOne([
            'username' => $model->username,
        ]);
        if (!$user) {
            $user = Candidates::findOne([
                'email' => $model->username,
            ]);
        }
        return $user;
    }

    private function findToken($user, $source)
    {
        return UserAccessTokens::findOne([
            'user_enc_id' => $user->user_enc_id,
            'source' => $source
        ]);
    }

    private function onlyTokens($token)
    {
        $time_now = date('Y-m-d H:i:s');
        $token->access_token = \Yii::$app->security->generateRandomString(32);
        $token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
        $token->refresh_token = \Yii::$app->security->generateRandomString(32);
        $token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
        if ($token->save()) {
            return $token;
        }
        return $token->getErrors();
    }

    public function actionLogin()
    {

        $params = \Yii::$app->request->post();

        $already_taken = [
            'username' => 'Username already taken'
        ];

        $username = $params['username'];
        $password = $params['password'];
        $source = $params['source'];

        if ($this->userValid($username)) {
            if ($params['password'] == '' && $params['password'] == null) {
                return $this->response(409, $already_taken);
            }
        }

        if (!isset($password) && isset($username)) {
            $user = Candidates::find()
                ->where(['username' => $username])
                ->orWhere(['email' => $username])
                ->one();
            if (!empty($user)) {
                return $this->response(409);
            } else {
                return $this->response(404);
            }
        }

        if (isset($username) && isset($password) && isset($source)) {
            $model = new LoginForm();

            if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '')) {
                if ($model->login()) {
                    $user = $this->findUser($model);
                    $user->last_visit = date('Y-m-d H:i:s');
                    $user->last_visit_through = "EYAPP";
                    if (!$user->update()) {
                        return $this->response(500, 'an error occurred');
                    }
                    $token = $this->findToken($user, $source);
                    if (empty($token)) {
                        if ($token = $this->newToken($user->user_enc_id, $source)) {
                            $data = $this->returnData($user, $token);
                            return $this->response(200, $data);
                        }
                    } else {
                        if ($token = $this->onlyTokens($token)) {
                            $data = $this->returnData($user, $token);
                            return $this->response(200, $data);
                        }
                    }
                }
                return $this->response(409, $model->getErrors());
            }
        } else {
            return $this->response(422);
        }
        return $this->response(405);
    }

    public function actionForgotPassword()
    {
        $email = Yii::$app->request->post('email');
        $model = new ForgotPasswordForm();
        $user = Users::find()
            ->select(['user_enc_id', 'email'])
            ->where(['status' => 'Active', 'is_deleted' => 0])
            ->andWhere(['or', ['email' => $email], ['username' => $email]])
            ->asArray()
            ->one();

        $model->email = $user['email'];
        if (empty($user)) {
            $this->response(404, ['message' => 'not found']);
        } else {
            if ($model) {
                if ($model->forgotPassword()) {
                    return $this->response(200, ['message' => 'An email with instructions has been sent to your email address (please also check your spam folder).']);
                } else {
                    return $this->response(500, ['message' => 'An error has occurred. Please try again.']);
                }
            }
        }
    }

    public function actionUserData()
    {
        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        if (!$token_holder_id) {
            return $this->response(401, 'unauthorized');
        }

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        $user = Users::find()
            ->select(['user_enc_id', 'first_name', 'last_name', 'username', 'phone', 'email', 'initials_color',
                'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", image_location, "/", image) ELSE NULL END user_image'
            ])
            ->where(['user_enc_id' => $user->user_enc_id])
            ->asArray()
            ->one();

        if ($user) {
            return $this->response(200, $user);
        } else {
            return $this->response(404, 'not found');
        }
    }


//    public function actionRefreshAccessToken(){
//        if(\Yii::$app->request->post('refresh_token')){
//            $token = UserAccessTokens::findOne([
//                'refresh_token' => \Yii::$app->request->post('refresh_token')
//            ]);
//            if($token) {
//                if ($token = $this->onlyTokens($token)) {
//                    $data = $this->returnToken($token);
//                    return $this->response(200, $data);
//                }
//            }else{
//                return $this->response(201);
//            }
//        }
//        return $this->response(202);
//    }
}
