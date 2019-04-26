<?php

namespace frontend\controllers\learning;

use frontend\models\OrganizationVideoForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class VideosController extends Controller{

    public function actionSubmit(){
        $this->layout = 'main-secondary';

        $learningCornerFormModel = new OrganizationVideoForm();

        if(Yii::$app->request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $learningCornerFormModel->load(Yii::$app->request->post());
            return ActiveForm::validate($learningCornerFormModel);
        }

        if(!Yii::$app->user->isGuest) {
            if ($learningCornerFormModel->load(Yii::$app->request->post()) && $learningCornerFormModel->validate()) {
                if ($learningCornerFormModel->save()) {
                    Yii::$app->session->setFlash('success', 'Your video is submitted successfully.');
                } else {
                    Yii::$app->session->setFlash('error', 'An error has occurred. Please try again later.');
                }
            }
            return $this->render('submit', [
                'learningCornerFormModel' => $learningCornerFormModel,
            ]);
        }else{
            return $this->redirect('/login');
        }
    }

}