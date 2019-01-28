<?php

namespace api\modules\v1\models;

use Yii;
use common\models\Users;

class Clients extends Users implements \yii\web\IdentityInterface{

    public static function findIdentity($id){
        return static::findOne([
            'id' => $id
        ]);
    }
    public static function findIdentityByAccessToken($token, $type=null){
        if($user=static::findOne(['access_token' => $token])){
            $expires = strtotime("+10080 minute", strtotime($user->token_expiration_time));
            if($expires > time()){
                $user->token_expiration_time = date('Y-m-d H:i:s', strtotime('now'));
                $user->save();
                return $user;
            }else{
                $user->access_token = '';
                $user->save();
            }
        }
    }

    public static function findByUsername($username){
        return static::find()
                ->where(['username' => $username])
                ->orWhere(['email' => $username])
                ->one();
    }

    public function getId(){
        return $this->getPrimaryKey();
    }

    public function getAuthKey(){
        return $this->auth_key;
    }

    public function setPassword($password){
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey(){
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    public function validateAuthKey($authKey){
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password){
        return \Yii::$app->security->validatePassword($password, $this->password);
    }

    public function validatePasswordBasic($password, $userPassword){
        return \Yii::$app->security->validatePassword($password, $userPassword);
    }

}