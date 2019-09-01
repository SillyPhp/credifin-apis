<?php

namespace api\modules\v2\controllers;

use common\models\AppliedApplications;
use common\models\FollowedOrganizations;
use common\models\Organizations;
use common\models\ShortlistedApplications;
use Yii;
use yii\helpers\Url;

class CandhomeController extends ApiBaseController
{

    public function actionCounts()
    {

        $id = Yii::$app->request->post('id');

        $applied_count = AppliedApplications::find()
            ->alias('a')
            ->select(['COUNT(a.applied_application_enc_id) applied_count'])
            ->joinWith(['resumeEnc b'], false)
            ->where([
                'b.user_enc_id' => $id
            ])
            ->asArray()
            ->all();

        $companies_cnt = Organizations::find()
            ->select(['COUNT(organization_enc_id) companies_count'])
            ->where([
                'is_erexx_registered' => 1,
                'is_deleted' => 0
            ])
            ->asArray()
            ->all();

        $shortlisted_cnt = ShortlistedApplications::find()
            ->select(['COUNT(shortlisted_enc_id) shortlisted_cnt'])
            ->where([
                'created_by' => $id,
                'shortlisted' => 1
            ])
            ->asArray()
            ->all();

        $counts = [
            'applied' => $applied_count,
            'companies' => $companies_cnt,
            'shortlisted' => $shortlisted_cnt
        ];
        return $this->response(200, $counts);
    }

    public function actionGetCompanies()
    {
        $q = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name', 'CONCAT("' . Url::to('/', true) . '", a.slug) profile_link', 'd.business_activity', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo'])
            ->distinct()
            ->innerJoinWith(['employerApplications b' => function ($x) {
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

        return $this->response(200, $q);
    }

    public function actionAppliedApplications()
    {

        $id = Yii::$app->request->post('id');

        $q = AppliedApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.current_round'])
            ->joinWith(['applicationEnc b' => function ($x) {
                $x->joinWith(['organizationEnc d'], false);
                $x->joinWith(['title h' => function ($y) {
                    $y->joinWith(['parentEnc i']);
                    $y->joinWith(['categoryEnc j']);
                }], false);
                $x->joinWith(['applicationPlacementLocations e' => function ($y) use ($x) {
                    $x->select(['b.application_enc_id', 'b.title', 'i.category_enc_id', 'g.name city', 'j.name profile', 'i.name parent_name', 'b.organization_enc_id', 'd.name organization_name', 'CONCAT("' . Url::to('/', true) . '", d.slug) profile_link', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo', 'e.placement_location_enc_id', 'COUNT(e.placement_location_enc_id) cnt']);
                    $y->joinWith(['locationEnc f' => function ($z) {
                        $z->joinWith(['cityEnc g']);
                    }], false);
                    $x->groupBy(['e.placement_location_enc_id']);
                }], false);
            }])
            ->joinWith(['resumeEnc c'], false)
            ->where([
                'c.user_enc_id' => $id,
                'a.is_deleted' => 0
            ])
            ->andWhere([
                '<>', 'a.status', 'Cancelled'
            ])
            ->limit(6)
            ->asArray()
            ->all();
//        return $q;
        return $this->response(200, $q);
    }

    public function actionFollowedCompanies()
    {
        $id = Yii::$app->request->post('id');

        $f = FollowedOrganizations::find()
            ->alias('a')
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
                'a.followed' => 1
            ])
            ->asArray()
            ->all();

        return $this->response(200, $f);
    }
}