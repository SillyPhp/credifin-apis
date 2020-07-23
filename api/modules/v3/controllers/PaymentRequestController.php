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
        $timestamp =  date_timestamp_get($date);
        $params= Yii::$app->request->post();
        //params list start
        $currency = $params['currency'];
        $amount = $params['amount'];
        $contact = $params['contact'];
        $email = $params['email'];
        //unique number string
        $mtx = Yii::$app->getSecurity()->generateRandomString();
        //params list end

        $access_key = 'cbfba3d0-ba9e-11ea-8e90-4384c267ea22';
        $secret_key = '1c29e11346b1b5a16814c41930a9b4dbf8540b04';
        $params = 'currency='.$currency.'&amount='.$amount.'&contact='.$contact.'&mtx='.$mtx.'&email='.$email.'';
        $url = "https://sandbox-icp-api.bankopen.co/api/payment_token?$params";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        $header = [
            'Accept:*/*',
            'X-O-Timestamp: '.$timestamp.'',
            'Content-Type: application/json',
            'Authorization: '.$access_key.':'.$secret_key.''
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        return json_decode($result);
    }
}