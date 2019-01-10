<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use common\models\EmployerApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Organizations;
use common\models\AppliedApplications;
use common\models\AppliedApplicationProcess;

class DashboardController extends Controller
{
    private $_condition;

    public function actionIndex()
    {
        $model = new \account\models\services\ServiceSelectionForm();

        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            return $this->redirect('/account/dashboard');
        }

        if (!Yii::$app->user->identity->services['selected_services']) {
            $services = \common\models\Services::find()
                ->select(['service_enc_id', 'name'])
                ->where(['is_always_visible' => 0])
                ->orderBy(['sequence' => SORT_ASC])
                ->asArray()
                ->all();

            return $this->render('services', [
                'model' => $model,
                'services' => $services,
            ]);
        }

        if (Yii::$app->user->identity->organization->organization_enc_id) {
            $this->_condition = ['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id];
        } else {
            $this->_condition = ['b.created_by' => Yii::$app->user->identity->user_enc_id];
        }

        $services = \common\models\Services::find()
            ->alias('a')
            ->select(['a.service_enc_id', 'a.name', 'b.selected_service_enc_id', 'b.is_selected'])
            ->joinWith(['selectedServices b' => function ($b) {
                $b->onCondition($this->_condition);
            }], false)
            ->where(['a.is_always_visible' => 0])
            ->orderBy(['a.sequence' => SORT_ASC])
            ->asArray()
            ->all();

        $applied_app = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id application_id', 'c.name as title', 'b.assigned_category_enc_id', 'f.applied_application_enc_id applied_id', 'f.status', 'd.icon', 'g.name as org_name', 'COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) as active', 'COUNT(h.is_completed) as total', 'ROUND((COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) / COUNT(h.is_completed)) * 100, 0) AS per'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = b.parent_enc_id')
            ->innerJoin(Organizations::tablename() . 'as g', 'g.organization_enc_id = a.organization_enc_id')
            ->leftJoin(AppliedApplications::tableName() . 'as f', 'f.application_enc_id = a.application_enc_id')
            ->where(['f.created_by' => Yii::$app->user->identity->user_enc_id])
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as h', 'h.applied_application_enc_id = f.applied_application_enc_id')
            ->groupBy(['h.applied_application_enc_id'])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

//        if (Yii::$app->user->identity->organization->organization_enc_id) {
//            $this->_condition = ['IN', 'a.name', '"taskbar_card", "individual_dashboard_applied_applications"'];
//        } else {
//            $this->_condition = ['IN', 'a.name', '"taskbar_card"'];
//        }
//
//        $options = [
//            'where' => ['and',
//                $this->_condition,
//                ['b.is_viewed' => 0],
//            ],
//        ];
//
//        $tutorials = new \account\models\tutorials\Tutorials();

        return $this->render('index', [
            'applied' => $applied_app,
            'services' => $services,
            'model' => $model,
        ]);
    }

}
