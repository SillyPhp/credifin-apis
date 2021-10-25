<?php

namespace api\modules\v3\controllers;
use common\models\ApplicationTemplates;
use yii\widgets\ActiveForm;
use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
class JobController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-templates' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

   public function actionGetTemplates()
   {
       if (Yii::$app->request->post())
       {
           $id = Yii::$app->request->post('id');
           $type = Yii::$app->request->post('type');
           $get = ApplicationTemplates::find()
               ->alias('a')
               ->select(['a.application_enc_id','c.name parent','d.name title','c.icon_png'])
               ->joinWith(['title0 b'=>function($e)use ($id){
                   $e->joinWith(['parentEnc c'=>function($b) use ($id)
                   {
                       $b->andWhere(['c.category_enc_id'=>$id]);
                   }],false);
                   $e->joinWith(['categoryEnc d'],false);
               }],false)
               ->joinWith(['applicationTypeEnc e'],false)
               ->andWhere(['e.name'=>ucwords($type)])
               ->asArray()
               ->all();

           if ($get){
               return $this->response(200, ['status' => 200, 'data' => $get]);
           }else{
               return $this->response(401, ['status' => 401, 'message' => 'Not Found']);
           }
       }
   }
}