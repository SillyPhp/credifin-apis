<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use common\models\EmployerApplications;
use common\models\ApplicationPlacementLocations;
use common\models\Organizations;
use common\models\ReviewedApplications;
use common\models\Categories;
use common\models\AssignedCategories;

class ReviewedApplicationsController extends Controller{

    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'active' => ['post'],
                ],
            ],
        ];
    }

    public function actionReviewList()
    {
        if (Yii::$app->request->isAjax) {
            if (!Yii::$app->user->isGuest) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $sidebarpage = Yii::$app->getRequest()->getQueryParam('sidebarpage');
                $l = 20;
                $o = ($sidebarpage-1)*$l;
                $type = Yii::$app->request->post('type');
                $review_list = ReviewedApplications::find()
                    ->alias('a')
                    ->select(['a.review_enc_id', 'a.application_enc_id as application_id', 'CONCAT(a.application_enc_id, "-", f.location_enc_id) data_key', 'a.review', 'd.name as title', 'b.slug', 'e.initials_color color', 'e.name as org_name', 'CASE WHEN e.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", e.logo_location, "/", e.logo) ELSE NULL END logo'])
                    ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                    ->andwhere(['a.review' => 1])
                    ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
                    ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
                    ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
                    ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
                    ->innerJoin(ApplicationPlacementLocations::tablename() . 'as f', 'f.application_enc_id = a.application_enc_id')
                    ->andwhere(['b.is_deleted' => 0])
                    ->joinWith(['applicationEnc g' => function($g){
                        $g->distinct();
                        $g->joinWith(['applicationTypeEnc h']);
                    }],false)
                    ->andwhere(['h.name' => $type])
                    ->groupBy(['b.application_enc_id'])
                    ->orderBy(['a.id' => SORT_DESC])
                    ->limit($l)
                    ->offset($o)
                    ->asArray()
                    ->all();
                return [
                    'cards' => $review_list,
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Your Experience has been added.',
                ];
            } else {
                return [
                    'status' => 201,
                ];
            }
        }
    }
}