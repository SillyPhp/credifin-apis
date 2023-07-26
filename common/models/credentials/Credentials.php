<?php

namespace common\models\credentials;

use Yii;

class Credentials
{
    public static function getrazorpayKey($options)
    {
        $today_date = new \DateTime();
        $today_date = $today_date->format('Y-m-d H:i:s');
        try {
            $get = \common\models\Credentials::find()
                ->where(['cred_for' => 'RAZORPAY'])
                ->andWhere([
                    'is_deleted' => 0,
                    'organization_enc_id' => $options['org_id'],
                    'env' => Yii::$app->params->EmpowerYouth->env,
                ])
                ->orderBy(['id' => SORT_DESC])
                ->one();
            if ($get) {
                if ($today_date > $get->access_token_expiration) {
                    $newToken = self::newToken($get);
                    if ($newToken) {
                        return $newToken;
                    } else {
                        return false;
                    }
                }
                return self::decryptRazorKeys($get->api_key, $get->api_secret, $get->passphrase);
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    private static function newToken($model)
    {
        $orignalKeys = self::decryptRazorKeys($model->api_key, $model->api_secret, $model->passphrase);
        $random_string = Yii::$app->getSecurity()->generateRandomString(8);
        $time_now = date('Y-m-d H:i:s', time());
        $model->passphrase = $random_string;
        $model->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
        $model->cred_for = 'RAZORPAY';
        $model->api_key = openssl_encrypt($orignalKeys['api_key'], Yii::$app->params->EmpowerYouth->opensslkeys->algo, Yii::$app->params->EmpowerYouth->opensslkeys->passphrase . $random_string, Yii::$app->params->EmpowerYouth->opensslkeys->options, Yii::$app->params->EmpowerYouth->opensslkeys->iv);
        $model->api_secret = openssl_encrypt($orignalKeys['api_secret'], Yii::$app->params->EmpowerYouth->opensslkeys->algo, Yii::$app->params->EmpowerYouth->opensslkeys->passphrase . $random_string, Yii::$app->params->EmpowerYouth->opensslkeys->options, Yii::$app->params->EmpowerYouth->opensslkeys->iv);
        $model->update();
        return self::decryptRazorKeys($model->api_key, $model->api_secret, $model->passphrase);
    }

    private static function decryptRazorKeys($key, $secret, $passphrase)
    {
        $api_key = openssl_decrypt($key, Yii::$app->params->EmpowerYouth->opensslkeys->algo, Yii::$app->params->EmpowerYouth->opensslkeys->passphrase . $passphrase, Yii::$app->params->EmpowerYouth->opensslkeys->options, Yii::$app->params->EmpowerYouth->opensslkeys->iv);
        $api_secret = openssl_decrypt($secret, Yii::$app->params->EmpowerYouth->opensslkeys->algo, Yii::$app->params->EmpowerYouth->opensslkeys->passphrase . $passphrase, Yii::$app->params->EmpowerYouth->opensslkeys->options, Yii::$app->params->EmpowerYouth->opensslkeys->iv);
        return [
            'api_key' => $api_key,
            'api_secret' => $api_secret
        ];
    }
}