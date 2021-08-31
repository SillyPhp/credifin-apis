<?php

namespace frontend\controllers;

use common\models\Countries;
use common\models\Organizations;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;

class FramedWidgetsController extends Controller
{
    public $layout = 'widget-layout';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'sharing-graphic' => ['GET'],
            ]
        ];
        return $behaviors;
    }
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

   public function actionApplyLoan()
   {
       $india = Countries::findOne(['name' => 'India'])->country_enc_id;
       return $this->render('/education-loans/apply-general-loan-form', [
           'india' => $india,
       ]);
   }

    public function actionLender($id)
    {
        $getLender = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id'])
            ->joinWith(['selectedServices b'=>function($b){
                $b->joinWith(['serviceEnc c'],false,'INNER JOIN');
            }],false,'INNER JOIN')
            ->where(['a.organization_enc_id'=>$id])
            ->andWhere(['c.name'=>'Loans'])
            ->one();
        if ($getLender){
            $india = Countries::findOne(['name' => 'India'])->country_enc_id;
            return $this->render('/education-loans/apply-general-loan-form', [
                'india' => $india,
                'getLender' => $getLender['organization_enc_id'],
            ]);
        }else{
            return 'Unauthorized';
        }
    }
}