<?php

namespace frontend\controllers;
use common\models\RandomColors;
use yii\web\Controller;
use Yii;

class TestCacheController extends Controller
{
    public function actionRazor(){
       openssl_decrypt('2ot/AeU2VBorgGAuuqmrL2NSyw31x/bLGFXSgNGT7Cc=','AES-256-CBC',Yii::$app->params->EmpowerYouth->privateKey,0,Yii::$app->params->EmpowerYouth->privateKey);
      // openssl_encrypt('','AES-256-CBC',Yii::$app->params->EmpowerYouth->privateKey,0,Yii::$app->params->EmpowerYouth->privateKey);
    }
}
