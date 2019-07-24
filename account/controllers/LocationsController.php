<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\States;
use account\models\locations\LocationForm;
use account\models\locations\OrganizationLocations;
use common\models\Cities;

class LocationsController extends Controller
{

    public function actionCreate()
    {
        $statesModel = new States();
        $locationFormModel = new LocationForm();
        $locationFormModel->location_for  = [1,2];
        if ($locationFormModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($locationFormModel->add()) {
                $locationFormModel = new LocationForm();
                return [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Location successfully added.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Something went wrong. Please try again.',
                    'title' => 'Opps!!',
                ];
            }
        }

        return $this->renderAjax('form', [
            'statesModel' => $statesModel,
            'locationFormModel' => $locationFormModel,
        ]);
    }

    public function actionGetData($id)
    {
        $statesModel = new States();
        $cityModel = new Cities();
        $locationFormModel = new LocationForm();

        $data = OrganizationLocations::find()
            ->select(['*'])
            ->where(['location_enc_id' => $id])
            ->asArray()
            ->one();

        $state_id = Cities::find()
            ->select('state_enc_id')
            ->where(['city_enc_id' => $data['city_enc_id']])
            ->one();

        $locationFormModel->state = $state_id['state_enc_id'];
        $locationFormModel->city = $data['city_enc_id'];
        $locationFormModel->name = $data['location_name'];
        $locationFormModel->phone = $data['phone'];
        $locationFormModel->address = $data['address'];

        $locationFormModel->location_for = json_decode($data['location_for']);

        return $this->renderAjax('updateform', [
            'statesModel' => $statesModel,
            'cityModel' => $cityModel,
            'state_id' => $state_id['state_enc_id'],
            'locationFormModel' => $locationFormModel,
            'data' => $data,

        ]);
    }

    public function actionUpdate($id)
    {
        $locationFormModel = new LocationForm();

        if ($locationFormModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $locations = OrganizationLocations::find()
                ->where(['location_enc_id' => $id])
                ->one();

            $locations->location_name = $locationFormModel['name'];
            $locations->email = $locationFormModel['email'];
            $locations->phone = $locationFormModel['phone'];
            $locations->address = $locationFormModel['address'];
            $locations->city_enc_id = $locationFormModel['city'];
            $locations->latitude = $locationFormModel['latitude'];
            $locations->longitude = $locationFormModel['longitude'];
            $locations->location_for = json_encode($locationFormModel->location_for);

            if ($locations->update()) {
                return [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Location successfully updated.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'title' => 'Opps!!',
                    'message' => 'Please change something to update. Please try again.'
                ];
            }
        }
    }

}