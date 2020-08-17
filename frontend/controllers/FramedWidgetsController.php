<?php

namespace frontend\controllers;

use common\models\Organizations;
use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;

class FramedWidgetsController extends Controller
{
  public $layout = 'widget-layout';
  public function actionEducationsLoan($id)
   { 
       $wid = Organizations::find()
           ->select(['organization_enc_id'])
           ->where(['organization_enc_id'=>$id])
           ->asArray()->one();
       if ($wid){
           return $this->render('education-loan',['wid'=>$wid['organization_enc_id']]);
       }
       else{
           return 'Unauthorized';
       }
   }
}