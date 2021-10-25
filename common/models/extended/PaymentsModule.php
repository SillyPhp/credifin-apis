<?php
namespace common\models\extended;
use Yii;
use Razorpay\Api\Api;
class PaymentsModule
{
    public static function GetToken($args)
    {
        //Generation of REQUEST_SIGNATURE for a POST Request
        $date = date_create();
        $timestamp = date_timestamp_get($date);
        //params list start
        $currency = $args['currency'];
        $amount = $args['amount'];
        $contact = $args['contact'];
        $email = $args['email'];
        //unique number string
        $mtx = Yii::$app->getSecurity()->generateRandomString();
        //params list end
        if (Yii::$app->params->paymentGateways->mec->icici) {
            $configuration = Yii::$app->params->paymentGateways->mec->icici;
            if ($configuration->mode === "production") {
                $access_key = $configuration->credentials->production->access_key;
                $secret_key = $configuration->credentials->production->secret_key;
                $url = $configuration->credentials->production->url;
            } else {
                $access_key = $configuration->credentials->sandbox->access_key;
                $secret_key = $configuration->credentials->sandbox->secret_key;
                $url = $configuration->credentials->sandbox->url;
            }
        }
        $params = 'currency=' . $currency . '&amount=' . $amount . '&contact=' . $contact . '&mtx=' . $mtx . '&email=' . $email . '';
        $url = $url . "?$params";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        $header = [
            'Accept:*/*',
            'X-O-Timestamp: ' . $timestamp . '',
            'Content-Type: application/json',
            'Authorization: ' . $access_key . ':' . $secret_key . ''
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        return json_decode($result, true);
    }

    private static function _razorPayToken($options=[])
    {
        $date = date_create();
        $timestamp = date_timestamp_get($date);
        $api_key = Yii::$app->params->razorPay->prod->apiKey;
        $api_secret = Yii::$app->params->razorPay->prod->apiSecret;
        $api = new Api($api_key,$api_secret);
        unset($options['accessKey']);
        if (isset($options['amount'])&&isset($options['currency'])){
            $options['receipt'] = 'order_rcptid_'.$timestamp;
            $order  = $api->order->create($options);
            return $order;
        }
    }

    public static function _authPayToken($options)
    {
        if ($options['accessKey']===Yii::$app->params->EmpowerYouth->permissionKey)
        {
            return self::_razorPayToken($options);
        }else
        {
            return false;
        }
    }

    public static function _defaultPayment(){
        return 500;
    }

    public static function _defaultGst(){
        return 0;
    }
}