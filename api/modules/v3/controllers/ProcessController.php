<?php

namespace api\modules\v3\controllers;
use api\modules\v1\models\Cards;
use api\modules\v3\models\ProcessModel;
use yii\widgets\ActiveForm;
use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
class ProcessController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'list-companies' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetProcess()
    {
       $params= Yii::$app->request->post();
       $options = [];
       if ($params['user_id'])
       {
           $options['user_id'] = $params['user_id'];
       }
       if ($params['application_id'])
       {
           $options['application_id'] = $params['application_id'];
       }
        $result = ProcessModel::process($options);

        if ($result) {
            return $this->response(200, $result);
        } else {
            return $this->response(404, 'Not Found');
        }
    }
}