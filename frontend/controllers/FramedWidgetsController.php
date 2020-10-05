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

   public function actionApplicationSharingImage($content=null)
   { 
       $content = [
           'job_title'=>'(USA) Staff Pharmacist (Hourly) - Wm (Temporary)',
           'company_name'=>'walmart',
           'canvas'=>false,
           'logo'=>'https://www.empoweryouth.com/images/unclaimed-organizations/eFVfBTYw3qeYDyU9sQfKriBUriahw1LdgxGkmLaXkjYXy8XkMo/WLXm0-ZKNKvj39wjcsLHle7u6ePZJ6ho/abvgrG4VyQNjO6zLzk27QpW30A9nXK.png',
           'initial_color'=>'#286090',
           'location'=>'Tepoztlán, Mexico',
       ];
       $this->layout = 'null-layout';
       return $this->render('sharing-graphic',['content'=>$content]);
   }
}