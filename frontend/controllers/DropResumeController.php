<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\OrganizationAssignedCategories;

class DropResumeController extends Controller
{

    public function actionCheckResume()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $slug = Yii::$app->request->post('slug');

            $cv_exists = OrganizationAssignedCategories::find()
                ->alias('a')
                ->select(['a.assigned_category_enc_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['b.slug' => $slug])
                ->exists();

            if ($cv_exists) {
                return 'yes';
            } else {
                return 'no';
            }
        }
    }

}