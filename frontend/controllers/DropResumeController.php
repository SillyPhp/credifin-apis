<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\OrganizationAssignedCategories;

class DropResumeController extends Controller
{

    public function actionCheckResume()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $slug = Yii::$app->request->post('slug');

            $cv_exists = OrganizationAssignedCategories::find()
                ->alias('a')
                ->select(['a.assigned_category_enc_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['b.slug' => $slug])
                ->exists();

            if ($cv_exists) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'yes',
                ];
            } else {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'no',
                ];
            }
        }
    }

}