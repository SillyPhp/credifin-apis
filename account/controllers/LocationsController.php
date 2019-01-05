<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\States;
use account\models\locations\LocationForm;

class LocationsController extends Controller
{

    public function actionCreate()
    {
        $statesModel = new States();
        $locationFormModel = new LocationForm();
        if ($locationFormModel->load(Yii::$app->request->post())) {
            if ($locationFormModel->add()) {
                $locationFormModel = new LocationForm();
                Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Location successfully added.'
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
            'statesModel' => $statesModel,
            'locationFormModel' => $locationFormModel,
        ]);
    }

}
