<?php

namespace api\modules\v1\controllers;

use common\models\UserTypes;
use Yii;
use api\modules\v1\models\IndividualSignup;
use api\modules\v1\models\LoginForm;
use api\modules\v1\models\Candidates;
use common\models\RandomColors;
use common\models\UserAccessTokens;
use common\models\Utilities;

class AuthController extends ApiBaseController{

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'signup' => ['POST'],
                'login' => ['POST'],
                'refresh-access-token' => ['POST']
            ]
        ];
        return $behaviors;
    }

    public function actionSignup(){
        $model = new IndividualSignup();
        if($model->load(\Yii::$app->getRequest()->getBodyParams(), '')){
            if($model->validate()) {
                if ($user = $this->newUser($model)) {
                    if ($token = $this->newToken($user->user_enc_id, \Yii::$app->request->post('source_id'))) {
                        $data = $this->returnData($user, $token);
                        return $this->response(200, $data);
                    }
                }
            }
            return $this->response(203, $model->getErrors());
        }
        return $this->response(600);
    }

    private function returnData($user, $token){
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

    private function returnToken($token){
        return [
            'user_id' => $token->user_enc_id,
            'access_token' => $token->access_token,
            'refresh_token' => $token->refresh_token,
            'access_token_expiry_time' => $token->access_token_expiration,
            'refresh_token_expiry_time' => $token->refresh_token_expiration
        ];
    }

    private function newUser($model){
        $user = new Candidates();
        $user->username = $model->username;
        $user->first_name = $model->first_name;
        $user->last_name = $model->last_name;
        $user->phone = $model->phone;
        $user->email = $model->email;
        $user->user_enc_id = time() . mt_rand(10, 99);
        $user->user_type_enc_id = UserTypes::findOne(['user_type' => 'Individual'])->user_type_enc_id;
        $user->initials_color = RandomColors::one();
        $user->created_on = date('Y-m-d H:i:s', strtotime('now'));
        $user->status = "Active";
        $user->setPassword($model->password);
        $user->generateAuthKey();
        if($user->save()){
            return $user;
        }
        return $user->getErrors();
    }

    private function newToken($user_id, $source_id){
        $token = new UserAccessTokens();
        $time_now = date('Y-m-d H:i:s', time('now'));
        $token->access_token_enc_id = time() . mt_rand(10, 99);
        $token->user_enc_id = $user_id;
        $token->access_token = \Yii::$app->security->generateRandomString(32);
        $token->access_token_expiration = date('Y-m-d H:i:s',strtotime("+43200 minute", strtotime($time_now)));
        $token->refresh_token = \Yii::$app->security->generateRandomString(32);
        $token->refresh_token_expiration = date('Y-m-d H:i:s',strtotime("+11520 minute", strtotime($time_now)));
        $token->source = $source_id;
        if($token->save()){
            return $token;
        }
        return $token->getErrors();
    }

    private function withoutPassword($username){

            $user = Candidates::find()
                    ->where(['username' => $username])
                    ->orWhere(['email' => $username])
                    ->one();
            if($user > 0) {
                return $this->response(103);
            }else{
                return $this->response(201);
            }
    }

    private function findUser($model){
        $user = Candidates::findOne([
            'username' => $model->username,
        ]);
        if(!$user){
            $user = Candidates::findOne([
                'email' => $model->username,
            ]);
        }
        return $user;
    }

    private function findToken($user, $source){
        return UserAccessTokens::findOne([
            'user_enc_id' => $user->user_enc_id,
            'source' => $source
        ]);
    }

    private function onlyTokens($token){
        $time_now = date('Y-m-d H:i:s', time('now'));
        $token->access_token = \Yii::$app->security->generateRandomString(32);
        $token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
        $token->refresh_token = \Yii::$app->security->generateRandomString(32);
        $token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
        if($token->save()){
            return $token;
        }
        return $token->getErrors();
    }

    public function actionLogin(){

        $params = \Yii::$app->request->post();

        $username = $params['username'];
        $password = $params['password'];
        $source = $params['source'];

        if(!isset($password) && isset($username)){
            $user = Candidates::find()
                ->where(['username' => $username])
                ->orWhere(['email' => $username])
                ->one();
            if(!empty($user)) {
                $response = [
                    'status' => 103,
                    'message' => 'User already exists'
                ];
                echo json_encode($response);
                die();
//                return $this->response(103);
            }else{
                $response = [
                    'status' => 201,
                    'message' => 'Resource Not found'
                ];
                echo json_encode($response);
                die();
//                return $this->response(201);
            }
        }

        if(isset($username) && isset($password) && isset($source)) {
            $model = new LoginForm();

            if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '')) {
                if ($model->login()) {
                    $user = $this->findUser($model);
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
                return $this->response(203, $model->getErrors());
            }
        }else{
                return $this->response(202);
        }
        return $this->response(600);
    }

    public function actionRefreshAccessToken(){
        if(\Yii::$app->request->post('refresh_token')){
            $token = UserAccessTokens::findOne([
                'refresh_token' => \Yii::$app->request->post('refresh_token')
            ]);
            if($token) {
                if ($token = $this->onlyTokens($token)) {
                    $data = $this->returnToken($token);
                    return $this->response(200, $data);
                }
            }else{
                return $this->response(201);
            }
        }
        return $this->response(202);
    }
}
