<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\Candidates;
use api\modules\v4\models\LoginForm;
use api\modules\v4\models\IndividualSignup;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\Users;
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
                'login'
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'signup' => ['POST', 'OPTIONS'],
                'validate' => ['POST', 'OPTIONS'],
                'login' => ['POST', 'OPTIONS'],
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
                $source = Yii::$app->request->post()['source'];
                if (!$source) {
                    $source = Yii::$app->getRequest()->getUserIP();
                }
                $user = $this->findUser($model);

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

    private function returnData($user, $token)
    {
        $data['username'] = $user->username;
        $data['user_enc_id'] = $user->user_enc_id;
        $data['first_name'] = $user->first_name;
        $data['last_name'] = $user->last_name;
        $data['initials_color'] = $user->initials_color;
        $data['phone'] = $user->phone;
        $data['email'] = $user->email;
        $data['access_token'] = $token->access_token;

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
}