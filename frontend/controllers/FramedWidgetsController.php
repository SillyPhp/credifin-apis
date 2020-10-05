<?php

namespace frontend\controllers;

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

   public function actionApplicationSharingImage()
   {
           $this->layout = 'null-layout';
           $content = Yii::$app->request->get();
           if (empty($content)):
               return 'Params Not Found';
           endif;
           return $this->render('sharing-graphic',['content'=>$content]);
   }
}