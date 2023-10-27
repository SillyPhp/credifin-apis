<?php

namespace api\modules\v4\models;

use Yii;
use common\models\Users;
use common\models\UserAccessTokens;

class Candidates extends Users implements \yii\web\IdentityInterface
{

    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id
        ]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $access_token = UserAccessTokens::findOne(['access_token' => $token]);
        if (!empty($access_token) && Yii::$app->request->headers->get('source') == $access_token->source) {
            if (strtotime($access_token->access_token_expiration) > strtotime("now")) {
                $time_now = date('Y-m-d H:i:s', time('now'));
                $access_token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
                $access_token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
                return static::findOne(['user_enc_id' => $access_token->user_enc_id]);
            }
            return false;
        }
        return false;
    }

    public static function findByUsername($username)
    {
        return static::find()
            ->where(['or', ['username' => $username], ['email' => $username]])
            ->andWhere(['is_deleted' => 0])
            ->one();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function setPassword($password)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

//    public function validatePassword($password){
//        return \Yii::$app->security->validatePassword($password, $this->password);
//    }

    public function validatePassword($password, $hash)
    {
        $model = new \common\models\Utilities();
        $model->variables['password'] = $password;
        $model->variables['hash'] = $hash;
        return $model->verify_pass();
    }

    public function validatePasswordBasic($password, $userPassword)
    {
        return \Yii::$app->security->validatePassword($password, $userPassword);
    }

}
