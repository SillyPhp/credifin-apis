<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use account\models\benefits\Benefits;
use common\models\EmployeeBenefits;
use account\models\jobs\JobApplicationForm;
use yii\helpers\ArrayHelper;

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
        $model = new JobApplicationForm();
        $benefits = $BenefitsModel->getAllBenefits();
        $org_benefits = $model->getBenefits();
        if ($BenefitsModel->load(Yii::$app->request->post()))
        {
            $BenefitsModel->benefit = Yii::$app->request->post('str');
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
                    'title' => 'Already Added!!',
                    'message' => 'Benefit Already Added or Something Went Wrong..'
                ];
            }
        }
       else
       {
           return $this->renderAjax('add-benefit', [
               'BenefitsModel' => $BenefitsModel,
               'benefits' => $benefits,
               'org_benefits' => $org_benefits,
           ]);
       }
    }



}
