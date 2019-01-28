<?php

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\models\IndividualSignup;
use api\modules\v1\models\LoginForm;
use api\modules\v1\models\Clients;
use common\models\RandomColors;

class OauthController extends ApiBaseController{

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'signup' => ['POST'],
                'login' => ['POST'],
                'refresh-token' => ['POST']
            ]
        ];
        return $behaviors;
    }

    /**
     * This is the signup endpoint
     * @var http://www.aditya.eygb.me/api/v1/oauth/signup
     * @param first_name
     * @param last_name
     * @param email
     * @param password
     * @param password_confirm
     * @param phone
     * @param username
     * @return Returns access token and auth key
     */
    public function actionSignup(){
        $model = new IndividualSignup();
        if($model->load(\Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()){
            $user = new Clients();
            $user->username = $model->username;
            $user->first_name = $model->first_name;
            $user->last_name = $model->last_name;
            $user->phone = $model->phone;
            $user->email = $model->email;
            $user->user_enc_id = time().mt_rand(10,99);
            $user->user_type_enc_id = 'VkRqU1NjSGZNOWQzZnV2NDB0ckY5Zz09';
            $user->initials_color = RandomColors::one();
            $user->access_token = \Yii::$app->security->generateRandomString(32);
            $user->created_on = date('Y-m-d H:i:s', strtotime('now'));
            $user->token_expiration_time = date('Y-m-d H:i:s', time());
            $user->setPassword($model->password);
            $user->generateAuthKey();
            if($user->save()) {
                $data = [
                    'access_token' => $user->access_token,
                    'auth_key' => $user->auth_key
                ];
                return $this->response(200, $data);
            }else{
                return $this->response(201, "Couldnt save the data");
            }
        }
        return $this->response(201, $model->getErrors(), false);

    }

    /**
     * This is the login endpoint
     * @var http://www.aditya.eygb.me/api/v1/oauth/login
     * @param username It can be email too
     * @param password
     * @return Returns access token only
     */
    public function actionLogin(){
        $model = new LoginForm();
        $username = \Yii::$app->request->post('username');
        $password = \Yii::$app->request->post('password');
        if(!isset($password) && isset($username)){
            $user = Clients::findOne([
                'username' => $username
            ]);
            if($user > 0) {
                return $this->response(201, 'User already exists');
            }else{
                return $this->response(201, "User doesn't exist");
            }
        }
        if($model->load(\Yii::$app->getRequest()->getBodyParams(), '') && $model->login()){
            $user = Clients::findOne([
                'username' => $model->username
            ]);
            $user->access_token = \Yii::$app->security->generateRandomString();
            $user->token_expiration_time = date('Y-m-d H:i:s', time());
            if($user->save()) {
                $data = [
                    'access_token' => $user->access_token,
                ];
                return $this->response(200, $data);
            }else{
                return $this->response(201, "Couldnt log you in");
            }
        }
        return $this->response(201, $model->getErrors(), false);
    }

    /**
     * This is the refresh token endpoint
     * @var http://www.aditya.eygb.me/api/v1/oauth/refresh-token
     * @param auth_key
     * @return Returns access token
     */
    public function actionRefreshToken(){
        if(\Yii::$app->request->post('auth_key')){
            $user = Clients::findOne([
                'auth_key' => \Yii::$app->request->post('auth_key')
            ]);
            if($user) {
                $user->access_token = \Yii::$app->security->generateRandomString();
                $user->token_expiration_time = date('Y-m-d H:i:s', time());
                if ($user->save()) {
                    $data = [
                        'access_token' => $user->access_token
                    ];
                    return $this->response(200, $data);
                } else {
                    return $this->response(201, "Couldnt refresh the token");
                }
            }else{
                return $this->response(201, "Invalid access token");
            }
        }
        return $this->response(201, 'Invalid Request');
    }
}