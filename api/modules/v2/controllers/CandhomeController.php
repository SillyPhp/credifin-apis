<?php

namespace api\modules\v2\controllers;

use common\models\AppliedApplications;
use common\models\FollowedOrganizations;
use common\models\Organizations;
use common\models\ShortlistedApplications;
use common\models\UserAccessTokens;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class CandhomeController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-data' => ['POST', 'OPTIONS'],
                'applied-applications' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['http://127.0.0.1:5500'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionGetData()
    {
        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;
        }

        $applied_count = AppliedApplications::find()
            ->alias('a')
            ->select(['COUNT(a.applied_application_enc_id) applied_count'])
            ->joinWith(['applicationEnc c'=>function($c){
                $c->joinWith(['organizationEnc d']);
            }],false)
            ->where([
                'a.created_by' => $id,
                'a.is_deleted' => 0,
                'd.is_erexx_registered' => 1,
                'd.is_deleted' => 0,
                'c.application_for' => 2,
            ])
            ->andWhere(['or',
                ['a.status' => 'Pending'],
                ['a.status' => 'Accepted']
            ])
            ->asArray()
            ->all();

        $companies_cnt = Organizations::find()
            ->alias('a')
            ->distinct()
            ->select(['COUNT(a.organization_enc_id) companies_count'])
            ->where([
                'a.is_erexx_registered' => 1,
                'a.is_deleted' => 0
            ])
            ->asArray()
            ->all();

        $shortlisted_cnt = ShortlistedApplications::find()
            ->alias('a')
            ->select(['COUNT(a.shortlisted_enc_id) shortlisted_cnt'])
            ->joinWith(['applicationEnc c'=>function($c){
                $c->joinWith(['organizationEnc d']);
            }])
            ->where([
                'a.created_by' => $id,
                'a.shortlisted' => 1,
                'd.is_erexx_registered' => 1,
                'd.is_deleted' => 0,
                'c.application_for' => 2,
            ])
            ->asArray()
            ->all();

        $organization = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name', 'a.slug', 'CONCAT("' . Url::to('/', true) . '", a.slug) profile_link', 'd.business_activity', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo'])
            ->distinct()
            ->joinWith(['employerApplications b' => function ($x) {
                $x
                    ->select(['b.organization_enc_id', 'COUNT(b.application_enc_id) application_type', 'c.name'])
                    ->joinWith(['applicationTypeEnc c'], false)
                    ->onCondition([
                        'b.status' => 'Active',
                        'b.is_deleted' => 0,
                        'b.application_for' => 0
                    ])
                    ->orOnCondition([
                        'b.status' => 'Active',
                        'b.is_deleted' => 0,
                        'b.application_for' => 2
                    ])
                    ->groupBy(['b.application_type_enc_id']);
            }])
            ->joinWith(['businessActivityEnc d'], false)
            ->groupBy(['a.organization_enc_id'])
            ->where([
                'a.is_deleted' => 0,
                'a.is_erexx_registered' => 1
            ])
            ->asArray()
            ->all();

        $applied_applications = AppliedApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.current_round'])
            ->joinWith(['applicationEnc b' => function ($x) {
                $x->joinWith(['organizationEnc d'], false);
                $x->joinWith(['title h' => function ($y) {
                    $y->joinWith(['parentEnc i']);
                    $y->joinWith(['categoryEnc j']);
                }], false);
                $x->joinWith(['applicationPlacementLocations e' => function ($y) use ($x) {
                    $x->select(['b.application_enc_id', 'b.title', 'b.slug', 'd.slug comp_slug', 'i.category_enc_id', 'g.name city', 'j.name profile', 'i.name parent_name', 'b.organization_enc_id', 'd.name organization_name', 'CONCAT("' . Url::to('/', true) . '", d.slug) profile_link', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo', 'e.placement_location_enc_id', 'COUNT(e.placement_location_enc_id) cnt']);
                    $y->joinWith(['locationEnc f' => function ($z) {
                        $z->joinWith(['cityEnc g']);
                    }], false);
                    $x->groupBy(['e.placement_location_enc_id']);
                }], false);
            }])
//            ->joinWith(['resumeEnc c'], false)
            ->where([
                'a.created_by' => $id,
                'a.is_deleted' => 0,
                'd.is_erexx_registered' => 1,
                'd.is_deleted' => 0,
                'b.application_for' => 2,
            ])
            ->andWhere(['or',
                ['a.status' => 'Pending'],
                ['a.status' => 'Accepted']
            ])
            ->limit(6)
            ->asArray()
            ->all();

        $followed_org = FollowedOrganizations::find()
            ->alias('a')
            ->distinct()
            ->select(['a.followed_enc_id', 'a.organization_enc_id'])
            ->innerJoinWith(['organizationEnc b' => function ($x) {
                $x->joinWith(['businessActivityEnc e'], false);
                $x->joinWith(['employerApplications c' => function ($y) use ($x) {
                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'CONCAT("' . Url::to('/', true) . '", b.slug) profile_link', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo', 'c.application_enc_id', 'COUNT(c.application_enc_id) application_type', 'd.name']);
                    $y
                        ->joinWith(['applicationTypeEnc d'], false)
                        ->onCondition([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'c.application_for' => 0
                        ])
                        ->orOnCondition([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'c.application_for' => 2
                        ])
                        ->groupBy(['c.application_type_enc_id']);
                }], false);
            }])
            ->where([
                'a.user_enc_id' => $id,
                'a.followed' => 1,
                'b.is_erexx_registered' => 1,
                'b.is_deleted' => 0,
            ])
            ->asArray()
            ->all();

        $counts = [
            'applied_cnt' => $applied_count,
            'companies_cnt' => $companies_cnt,
            'shortlisted_cnt' => $shortlisted_cnt,
            'organization' => $organization,
            'applied_application' => $applied_applications,
            'followed' => $followed_org,
        ];
        return $this->response(200, $counts);
    }

    public function actionAppliedApplications(){
        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;

            $applied_applications = AppliedApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.current_round'])
                ->joinWith(['applicationEnc b' => function ($x) {
                    $x->joinWith(['organizationEnc d'], false);
                    $x->joinWith(['title h' => function ($y) {
                        $y->joinWith(['parentEnc i']);
                        $y->joinWith(['categoryEnc j']);
                    }], false);
                    $x->joinWith(['applicationPlacementLocations e' => function ($y) use ($x) {
                        $x->select(['b.application_enc_id', 'b.title', 'b.slug','i.category_enc_id', 'g.name city', 'j.name profile', 'i.name parent_name', 'b.organization_enc_id','d.slug comp_slug', 'd.name organization_name', 'CONCAT("' . Url::to('/', true) . '", d.slug) profile_link', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo', 'e.placement_location_enc_id', 'COUNT(e.placement_location_enc_id) cnt']);
                        $y->joinWith(['locationEnc f' => function ($z) {
                            $z->joinWith(['cityEnc g']);
                        }], false);
                        $x->groupBy(['e.placement_location_enc_id']);
                    }], false);
                }])
//            ->joinWith(['resumeEnc c'], false)
                ->where([
                    'a.created_by' => $id,
                    'a.is_deleted' => 0,
                    'd.is_erexx_registered' => 1,
                    'd.is_deleted' => 0,
                    'b.application_for' => 2,
                ])
                ->andWhere(['or',
                    ['a.status' => 'Pending'],
                    ['a.status' => 'Accepted']
                ])
                ->limit(6)
                ->asArray()
                ->all();

            return $this->response(200,['status'=>200,'data'=>$applied_applications]);
        }else{
            return false;
        }
    }

//    public function actionGetCompanies()
//    {
//        $q = Organizations::find()
//            ->alias('a')
//            ->select(['a.organization_enc_id', 'a.name', 'CONCAT("' . Url::to('/', true) . '", a.slug) profile_link', 'd.business_activity', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo'])
//            ->distinct()
//            ->joinWith(['employerApplications b' => function ($x) {
//                $x
//                    ->select(['b.organization_enc_id', 'COUNT(b.application_enc_id) application_type', 'c.name'])
//                    ->joinWith(['applicationTypeEnc c'], false)
//                    ->onCondition([
//                        'b.status' => 'Active',
//                        'b.is_deleted' => 0,
//                        'b.application_for' => 0
//                    ])
//                    ->orOnCondition([
//                        'b.status' => 'Active',
//                        'b.is_deleted' => 0,
//                        'b.application_for' => 2
//                    ])
//                    ->groupBy(['b.application_type_enc_id']);
//            }])
//            ->joinWith(['businessActivityEnc d'], false)
//            ->groupBy(['a.organization_enc_id'])
//            ->where([
//                'a.is_deleted' => 0,
//                'a.is_erexx_registered' => 1
//            ])
//            ->asArray()
//            ->all();
//
//        return $this->response(200, $q);
//    }
//
//    public function actionAppliedApplications()
//    {
//
//        $id = Yii::$app->request->post('id');
//
//        $q = AppliedApplications::find()
//            ->alias('a')
//            ->select(['a.application_enc_id', 'a.current_round'])
//            ->joinWith(['applicationEnc b' => function ($x) {
//                $x->joinWith(['organizationEnc d'], false);
//                $x->joinWith(['title h' => function ($y) {
//                    $y->joinWith(['parentEnc i']);
//                    $y->joinWith(['categoryEnc j']);
//                }], false);
//                $x->joinWith(['applicationPlacementLocations e' => function ($y) use ($x) {
//                    $x->select(['b.application_enc_id', 'b.title', 'i.category_enc_id', 'g.name city', 'j.name profile', 'i.name parent_name', 'b.organization_enc_id', 'd.name organization_name', 'CONCAT("' . Url::to('/', true) . '", d.slug) profile_link', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo', 'e.placement_location_enc_id', 'COUNT(e.placement_location_enc_id) cnt']);
//                    $y->joinWith(['locationEnc f' => function ($z) {
//                        $z->joinWith(['cityEnc g']);
//                    }], false);
//                    $x->groupBy(['e.placement_location_enc_id']);
//                }], false);
//            }])
//            ->joinWith(['resumeEnc c'], false)
//            ->where([
//                'c.user_enc_id' => $id,
//                'a.is_deleted' => 0,
//                'd.is_erexx_registered' => 1,
//                'd.is_deleted' => 0,
//                'b.application_for' => 2,
//            ])
//            ->andWhere(['or',
//                ['a.status' => 'Pending'],
//                ['a.status' => 'Accepted']
//            ])
//            ->limit(6)
//            ->asArray()
//            ->all();
////        return $q;
//        return $this->response(200, $q);
//    }
//
//    public function actionFollowedCompanies()
//    {
//        $id = Yii::$app->request->post('id');
//
//        $f = FollowedOrganizations::find()
//            ->alias('a')
//            ->distinct()
//            ->select(['a.followed_enc_id', 'a.organization_enc_id'])
//            ->innerJoinWith(['organizationEnc b' => function ($x) {
//                $x->joinWith(['businessActivityEnc e'], false);
//                $x->joinWith(['employerApplications c' => function ($y) use ($x) {
//                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'CONCAT("' . Url::to('/', true) . '", b.slug) profile_link', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo', 'c.application_enc_id', 'COUNT(c.application_enc_id) application_type', 'd.name']);
//                    $y
//                        ->joinWith(['applicationTypeEnc d'], false)
//                        ->onCondition([
//                            'c.status' => 'Active',
//                            'c.is_deleted' => 0,
//                            'c.application_for' => 0
//                        ])
//                        ->orOnCondition([
//                            'c.status' => 'Active',
//                            'c.is_deleted' => 0,
//                            'c.application_for' => 2
//                        ])
//                        ->groupBy(['c.application_type_enc_id']);
//                }], false);
//            }])
//            ->where([
//                'a.user_enc_id' => $id,
//                'a.followed' => 1,
//                'b.is_erexx_registered' => 1,
//                'b.is_deleted' => 0,
//            ])
//            ->asArray()
//            ->all();
//
//        return $this->response(200, $f);
//    }
}