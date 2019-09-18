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
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Your Job Has Been Posted Successfully Submitted..');
            } else {
                Yii::$app->session->setFlash('error', 'Error Please Contact Supportive Team ');
            }
            return $this->refresh();
        }
        return $this->render('index',['model'=>$model,'primary_cat'=>$primary_cat]);
    }

    public function actionTest()
    {
        return Yii::$app->cache->flush();
    }

}