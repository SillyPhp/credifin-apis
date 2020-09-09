<?php
namespace api\modules\v3\controllers;
use api\modules\v3\models\RetryPayments;
use common\models\EducationLoanPayments;
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
                'get-status' => ['GET'],
                'retry-payment' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetStatus()
    {
        $args = Yii::$app->request->get();
        if ($args['token_id'])
        {
            //Generation of REQUEST_SIGNATURE for a POST Request
            $date = date_create();
            $timestamp = date_timestamp_get($date);
            if (Yii::$app->params->paymentGateways->mec->icici) {
                $configuration = Yii::$app->params->paymentGateways->mec->icici;
                if ($configuration->mode === "production") {
                    $access_key = $configuration->credentials->production->access_key;
                    $secret_key = $configuration->credentials->production->secret_key;
                } else {
                    $access_key = $configuration->credentials->sandbox->access_key;
                    $secret_key = $configuration->credentials->sandbox->secret_key;
                }
            }
            $url = 'https://icp-api.bankopen.co/api/payment_token/'.$args['token_id'].'/payment';
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
                return $this->response(404, ['status' => 404, 'message' => 'Payment Not found']);
            }
        }else{
            return $this->response(422, ['status' => 422, 'message' => 'Missing Arguments']);
        }
    }

    public function actionRetryPayment()
    {
        date_default_timezone_set('Asia/Kolkata');
        $model = new RetryPayments();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->insert()) {
                return $this->response(200, ['status' => 200, 'message' => 'success']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'Something went wrong...']);
            }
        }
    }
}