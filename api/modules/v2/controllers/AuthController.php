<?php

namespace api\modules\v2\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v2\models\IndividualSignup;
use api\modules\v2\models\LoginForm;
use common\models\User;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\Users;
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
//            print_r($model);
//            die();
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

    public function actionUsername(){
        $username = Yii::$app->request->post('username');
        $user_names = Usernames::find()
            ->where(['username'=>$username])
            ->exists();

        if($user_names){
            return $this->response(200,['status'=>201,'exists'=>true]);
        }else{
            return $this->response(200,['status'=>200,'exists'=>false]);
        }
    }

    public function actionLogin(){
        $model = new LoginForm();
        if($model->load(Yii::$app->request->post(), '')){
            if($model->login()){
                $source = Yii::$app->request->post()['source'];
                $user = $this->findUser($model);
                if($user->organization_enc_id){
                    $user_type = Users::find()
                        ->alias('a')
                        ->select(['a.user_enc_id','a.organization_enc_id','c.business_activity type'])
                        ->joinWith(['organizationEnc b'=>function($b){
                            $b->joinWith(['businessActivityEnc c']);
                        }],false)
                        ->where(['a.user_enc_id'=>$user->user_enc_id,'b.is_erexx_registered'=>1,'b.is_deleted'=>0])
                        ->asArray()
                        ->one();
                    if($user_type['type'] != 'College'){
                        return false;
                    }
                }
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

        $user_type = Users::find()
            ->alias('a')
            ->select(['a.user_enc_id','b.user_type','c.name city_name','e.name org_name'])
            ->joinWith(['userTypeEnc b'],false)
            ->joinWith(['cityEnc c'],false)
            ->joinWith(['userOtherInfo d'=>function($d){
                $d->joinWith(['organizationEnc e']);
            }],false)
            ->where(['a.user_enc_id'=>$source->user_enc_id])
            ->asArray()
            ->one();

        return [
            'user_id' => $source->user_enc_id,
            'username' => $user->username,
            'user_type' => $user_type['user_type'],
            'city' => $user_type['city_name'],
            'college' => $user_type['org_name'],
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

    public function actionFindUser(){

        $access_token = Yii::$app->request->post('access_token');
        $source = Yii::$app->request->post('source');

        $find_user = UserAccessTokens::find()
            ->select(['*'])
            ->where(['access_token'=>$access_token,'source'=>$source])
            ->asArray()
            ->one();

        if(!empty($find_user)){
            $user_type = Users::find()
                ->where(['!=','organization_enc_id','null'])
                ->exists();


            $user_detail = Users::find()
                ->alias('a')
                ->select(['a.first_name','a.last_name','a.username','a.phone','a.email','a.initials_color','b.user_type','c.name city_name','e.name org_name','d.organization_enc_id'])
                ->joinWith(['userTypeEnc b'],false)
                ->joinWith(['cityEnc c'],false)
                ->joinWith(['userOtherInfo d'=>function($d){
                    $d->joinWith(['organizationEnc e']);
                }],false)
                ->where(['a.user_enc_id'=>$find_user['user_enc_id']])
                ->asArray()
                ->one();

        }

        return [
            'user_id' => $find_user['user_enc_id'],
            'username' => $user_detail['username'],
            'user_type' => $user_detail['user_type'],
            'city' => $user_detail['city_name'],
            'college' => $user_detail['org_name'],
            'college_enc_id' => $user_detail['organization_enc_id'],
            'email' => $user_detail['email'],
            'first_name' => $user_detail['first_name'],
            'last_name' => $user_detail['last_name'],
            'phone' => $user_detail['phone'],
            'initials_color' => $user_detail['initials_color'],
            'access_token' => $find_user['access_token'],
            'refresh_token' => $find_user['refresh_token'],
            'access_token_expiry_time' => $find_user['access_token_expiration'],
            'refresh_token_expiry_time' => $find_user['refresh_token_expiration'],
        ];
    }
}