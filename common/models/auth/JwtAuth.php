<?php
namespace common\models\auth;
use common\models\Users;
use Yii;
class JwtAuth {
    public static function Auth($tokenString){
        try {
            $token = Yii::$app->jwsManager->load($tokenString);
            $result = Yii::$app->jwsManager->isValid($token);
            return $result;
             }catch (\Exception $e) {
            return false;
        }
    }

    public static function generateToken($payload){
        try {
            $tokenString = Yii::$app->jwsManager->newToken($payload);
            return $tokenString;
        }catch (\Exception $e) {
            return false;
        }
    }
}