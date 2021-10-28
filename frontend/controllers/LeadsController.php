<?php

namespace frontend\controllers;

use common\models\LeadsApplications;
use common\models\LeadsCollegePreference;
use common\models\Utilities;
use yii\web\Response;
use Yii;
use yii\web\Controller;

class LeadsController extends Controller
{

    public function actionUpdateApplication()
    {
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $params = Yii::$app->request->post();
            $field_name = $params['fieldName'];
            $type = $params['type'];
            $value = $params['value'];
            $key = $params['lead_app_id'];
            $seq = $params['sequence'];
            $lead_app_id = $params['lead_app_id'];
            $utilitiesModel = new Utilities();
            if ($lead_app_id) {
                if ($type == 'leadCollegePreference') {
                    $model = LeadsCollegePreference::findOne(['application_enc_id' => $key, 'sequence' => $seq]);
                    if (!$model) {
                        $model = new LeadsCollegePreference();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $model->preference_enc_id = $utilitiesModel->encrypt();
                        $model->application_enc_id = $enc_id = $key;
                        $model->sequence = $seq;
                        if (!Yii::$app->user->isGuest) {
                            $model->created_by = Yii::$app->user->identity->user_enc_id;
                        }
                    }
                } else {
                    $model = LeadsApplications::findOne(['application_enc_id' => $key]);
                    if($field_name == 'college_name'){
                        $field_name = 'college_institute_name';
                    }
                    $enc_id = $key;
                }
            } else {
                $model = new LeadsApplications();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->application_enc_id = $enc_id = $utilitiesModel->encrypt();
                $model->application_number = date('ymd') . time();
                if (!Yii::$app->user->isGuest) {
                    $model->created_by = Yii::$app->user->identity->user_enc_id;
                }
                if($field_name == 'college_name'){
                    $field_name = 'college_institute_name';
                }
            }
            $model->$field_name = $value;
            if ($model->save()) {
                return [
                    'status' => 200,
                    'enc_id' => $enc_id,
                ];
            } else {
                print_r($model->getErrors());
                exit();
            }
        }
    }

}