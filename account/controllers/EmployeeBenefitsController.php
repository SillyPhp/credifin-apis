<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use account\models\benefits\Benefits;
use common\models\EmployeeBenefits;

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

    public function actionCreateBenefit()
    {
        $BenefitsModel = new Benefits();
        $benefits = EmployeeBenefits::find()
            ->select(['benefit_enc_id', 'benefit', 'icon', 'icon_location'])
            ->orderBy(['id' => SORT_ASC])
            ->asArray()
            ->all();
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

        return $this->renderAjax('add-benefit', [
            'BenefitsModel' => $BenefitsModel,
            'benefits' => $benefits,
        ]);
    }

}
