<?php
namespace api\modules\v3\controllers;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class PaymentsController extends  ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-status' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetStatus()
    {
        $args = Yii::$app->request->post();
        if ($args['token_id'])
        {
            //Generation of REQUEST_SIGNATURE for a POST Request
            $date = date_create();
            $timestamp = date_timestamp_get($date);
//            if (Yii::$app->params->paymentGateways->mec->icici) {
//                $configuration = Yii::$app->params->paymentGateways->mec->icici;
//                if ($configuration->mode === "production") {
//                    $access_key = $configuration->credentials->production->access_key;
//                    $secret_key = $configuration->credentials->production->secret_key;
//                    $url = $configuration->credentials->production->url;
//                } else {
//                    $access_key = $configuration->credentials->sandbox->access_key;
//                    $secret_key = $configuration->credentials->sandbox->secret_key;
//                    $url = $configuration->credentials->sandbox->url;
//                }
//            }
            $access_key = 'cbfba3d0-ba9e-11ea-8e90-4384c267ea22';
            $secret_key = '1c29e11346b1b5a16814c41930a9b4dbf8540b04';
            $url = 'https://sandbox-icp-api.bankopen.co/api/payment_token/'.$args['token_id'].'/payment';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $header = [
                'Accept:*/*',
                'X-O-Timestamp: ' . $timestamp . '',
                'Content-Type: application/json',
                'Authorization: ' . $access_key . ':' . $secret_key . ''
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);
            $response = json_decode($result,true);
            if ($response['status'])
            {
                return $this->response(200, ['status' => 200, 'payment_status' => $response['status']]);
            }else{
                return $this->response(404, ['status' => 404, 'message' => 'Payment found']);
            }
        }else{
            return $this->response(422, ['status' => 422, 'message' => 'Missing Arguments']);
        }
    }
}