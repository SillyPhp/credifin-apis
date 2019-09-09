<?php

namespace account\controllers;
use account\models\applications\ApplicationForm;
use account\models\training_program\TrainingProgram;
use yii\web\Response;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class TrainingProgramController extends Controller
{
    public function actionCreate()
    {
        $model = new TrainingProgram();
        $object = new ApplicationForm();
        $primary_cat = $object->getPrimaryFields();
        if ($model->load(Yii::$app->request->post())) {
            print_r($model);
            exit;
        }
        return $this->render('index',['model'=>$model,'primary_cat'=>$primary_cat]);
    }

}