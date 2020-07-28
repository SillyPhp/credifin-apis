<?php

namespace api\modules\v3\controllers;

use Yii;
use api\modules\v3\models\TokensModel;
use yii\filters\VerbFilter;

class PaymentRequestController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-token' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetToken()
    {
        //Generation of REQUEST_SIGNATURE for a POST Request
        $date = date_create();
        $timestamp = date_timestamp_get($date);
        $params = Yii::$app->request->post();
        //params list start
        $currency = $params['currency'];
        $amount = $params['amount'];
        $contact = $params['contact'];
        $email = $params['email'];
        //unique number string
        $mtx = Yii::$app->getSecurity()->generateRandomString();
        //params list end

        if (Yii::$app->params->paymentGateway->mec->icici) {
            $configuration = Yii::$app->params->paymentGateway->mec->icici;
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
        return json_decode($result);
    }
}