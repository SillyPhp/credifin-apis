<?php

namespace api\modules\v2\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v2\models\IndividualSignup;
use api\modules\v2\models\LoginForm;
use common\models\UserAccessTokens;
use common\models\Usernames;
use frontend\widgets\Login;
use Yii;

class AuthController extends ApiBaseController{

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'signup' => ['POST'],
//                'login' => ['GET'],
            ]
        ];
        return $behaviors;
    }

    public function actionSignup(){

        $model = new IndividualSignup();
        if($model->load(Yii::$app->request->post(), '')){
            if($model->validate()){
                if(!$this->usernameValid($model)){
                    return $this->response(409, [
                        'username' => 'Username already taken'
                    ]);
                }
                if($model->saveUser()){
                    return $this->response(200);
                }else{
                    return $this->response(500);
                }

            }
            return $this->response(409, $model->getErrors());
        }
        return $this->response(422);
    }

    public function actionLogin(){
        $model = new LoginForm();
        if($model->load(Yii::$app->request->post(), '')){
            if($model->login()){
                $source = Yii::$app->request->post()['source'];
                $user = $this->findUser($model);
                $token = $this->findToken($user, $source);
                if(empty($token)){
                    if($token=$this->newToken($user->user_enc_id,$source)){
                        $data = $this->returnData($user, $token);
                        return $this->response(200, $data);
                    }
                }else{
                    if($token = $this->onlyTokens($token)){
                        $data = $this->returnData($user, $token);
                        return $this->response(200, $data);
                    }
                }
            }
            return $this->response(409, $model->getErrors());
        }
        return $this->response(422);
    }


    private function onlyTokens($token){
        $time_now = date('Y-m-d H:i:s', time('now'));
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
        $time_now = date('Y-m-d H:i:s', time('now'));
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

    private function returnData($user, $source){
        return [
            'user_id' => $source->user_enc_id,
            'username' => $user->username,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'initials_color' => $user->initials_color,
            'access_token' => $source->access_token,
            'refresh_token' => $source->refresh_token,
            'access_token_expiry_time' => $source->access_token_expiration,
            'refresh_token_expiry_time' => $source->refresh_token_expiration,
        ];
    }

    private function findToken($user, $source){
        return UserAccessTokens::findOne([
           'user_enc_id' => $user->user_enc_id,
           'source' => $source
        ]);
    }

    private function findUser($model){
        $user = Candidates::findOne([
            'username' => $model->username
        ]);
        if(!$user){
            $user = Candidates::findOne([
                'email' => $model->username
            ]);
        }
        return $user;
    }

    private function usernameValid($model){
        $usernameModel = new Usernames();
        $usernameModel->username = $model->username;
        $usernameModel->assigned_to = 1;
        if(!$usernameModel->validate()){
            return false;
        }
        return true;
    }
}