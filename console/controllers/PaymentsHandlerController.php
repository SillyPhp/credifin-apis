<?php

namespace console\controllers;
use common\models\EducationLoanPayments;
use console\models\PaymentsHandler;
use Yii;
use yii\console\Controller;

class PaymentsHandlerController extends Controller
{
    public function actionStatusUpdate()
    {
        ini_set('max_execution_time', 0);
        $start = microtime(true);
        $options = [];
        //processing applications between 7 days only
        $options['today'] = date('Y-m-d H:i:s');
        $options['interval'] = date("Y-m-d H:i:s", strtotime("-7 days"));
        $applications = PaymentsHandler::get($options);
        $i = 0; //counter for total result processed
        $j = 0; // counter for total success updates of payments status that updated;
        if (!empty($applications)){
            foreach ($applications as $app)
            {
                //api hit call to empower youth for payment token information and its status
                $url = 'https://www.empoweryouth.com/api/v3/payments/get-status?token_id='.$app['payment_token'];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                $header = [
                    'Accept: application/json, text/plain, */*',
                    'Content-Type: application/json;charset=utf-8',
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                $result = curl_exec($ch);
                $result = json_decode($result,true);
                $j++;
                if ($result['response']['status']==200)
                {
                    $i++;
                    //once the payment is set captured its is not being udated next time
                    Yii::$app->db->createCommand()->update(EducationLoanPayments::tableName(), ['payment_status' => $result['response']['payment_status'], 'updated_on' => date('Y-m-d H:i:s')], ['education_loan_payment_enc_id'=>$app['education_loan_payment_enc_id'],'loan_enc_id' => $app['loan_app_enc_id']])->execute();
                }
            }
            $end = number_format((microtime(true) - $start), 2);
            echo ' Query Success, ';
            echo $j.' Results Proccessed in '.$end.' Time, ';
            echo $i.' Payment Status Updated ';
            exit();
        }
        else{
            echo 'No Applications Found';
            exit();
        }
    }
}