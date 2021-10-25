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
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!Yii::$app->user->isGuest) {
                $sidebarpage = Yii::$app->getRequest()->getQueryParam('sidebarpage');
                $l = 20;
                $o = ($sidebarpage-1)*$l;
                $type = ucfirst(Yii::$app->request->post('type'));
                $review_list = ReviewedApplications::find()
                    ->alias('a')
                    ->select(['a.review_enc_id', 'a.application_enc_id as application_id', 'CONCAT(a.application_enc_id, "-", f.location_enc_id) data_key', 'a.review', 'd.name as title', 'b.slug', '(CASE WHEN e.initials_color IS NOT NULL THEN e.initials_color ELSE i.initials_color END) as color', '(CASE WHEN e.name IS NOT NULL THEN e.name ELSE i.name END) as org_name', 'CASE WHEN e.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", e.logo_location, "/", e.logo) ELSE CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '", i.logo_location, "/", i.logo) END logo'])
                    ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                    ->andwhere(['a.review' => 1])
                    ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
                    ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
                    ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
                    ->leftJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
                    ->leftJoin(ApplicationPlacementLocations::tablename() . 'as f', 'f.application_enc_id = a.application_enc_id')
                    ->andwhere(['b.is_deleted' => 0, 'b.application_for' =>1, 'b.status' => 'Active'])
                    ->joinWith(['applicationEnc g' => function($g){
                        $g->distinct();
                        $g->joinWith(['applicationTypeEnc h']);
                        $g->joinWith(['unclaimedOrganizationEnc i']);
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
                ];
            } else {
                return [
                    'status' => 201,
                ];
            }
        }
    }
}