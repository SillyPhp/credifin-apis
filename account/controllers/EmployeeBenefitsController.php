<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use account\models\benefits\Benefits;

class EmployeeBenefitsController extends Controller
{

    public function actionCreate()
    {
        $BenefitsModel = new Benefits();

        if ($BenefitsModel->load(Yii::$app->request->post()) && $BenefitsModel->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($BenefitsModel->Add()) {
                return [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Benefits successfully added.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'title' => 'Opps!!',
                    'message' => 'Something went wrong. Please try again.'
                ];
            }
        }

        return $this->renderAjax('form', [
            'BenefitsModel' => $BenefitsModel,
        ]);
    }

}
