<?php

namespace frontend\controllers;

use common\models\EmployerApplications;
use common\models\JobDescription;
use common\models\Organizations;
use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;

class FullTextSearchController extends Controller
{
    public function actionTest($query=null)
    {
        $result = Yii::$app->db->createCommand("SELECT name FROM {{%unclaimed_organizations}} WHERE MATCH (name) AGAINST ('{$query}' IN NATURAL LANGUAGE MODE);");

        print_r($result->queryAll());
    }

    public function actionPaymentsStatus()
    {
        //Generation of REQUEST_SIGNATURE for a POST Request
        $date = date_create();
        $timestamp =  date_timestamp_get($date);

        //params list start
        //$token_id = 'sb_pt_H80lGJhWMsyCtJ';
        $token_id = 'sb_pt_H80nduGzBfMC9X';
        $mtx = '_jovCVG5KdeO8i96bHiNfgaNfyurhFHN';
        //params list end

        $access_key = 'cbfba3d0-ba9e-11ea-8e90-4384c267ea22';
        $secret_key = '1c29e11346b1b5a16814c41930a9b4dbf8540b04';
        $params = 'payment_token='.$token_id.'';
        $url = "https://sandbox-icp-api.bankopen.co/api/payment_token/tokenvalue/payment?$params";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $header = [
            'Accept:*/*',
            'X-O-Timestamp: '.$timestamp.'',
            'Content-Type: application/json',
            'Authorization: '.$access_key.':'.$secret_key.''
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        echo $result;
        die();
    }
    public function actionSecure()
    {
        return $this->render('secure');
    }

    public function actionWidget(){
        return $this->render('widget');
    }

}