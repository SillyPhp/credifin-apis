<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Organizations;
use common\models\Posts;
use common\models\UnclaimedOrganizations;
use frontend\models\applications\ApplicationCards;

class SearchController extends Controller
{
    private function findUnclaimed($s)
    {
        return UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.organization_type_enc_id', 'a.name', 'a.slug as slug', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo', 'a.initials_color color'])
            ->joinWith(['organizationTypeEnc b' => function ($y) {
                $y->select(['b.business_activity_enc_id', 'b.business_activity']);
            }])
            ->joinWith(['newOrganizationReviews c' => function ($x) {
                $x->select(['c.organization_enc_id', 'ROUND(AVG(c.average_rating)) average_rating', 'COUNT(c.review_enc_id) reviews_cnt'])
                    ->groupBy(['c.organization_enc_id']);
            }])
            ->where([
                'a.is_deleted' => 0,
                'a.status' => 1
            ])
            ->andFilterWhere([
                'or',
                ['like', 'a.name', $s],
                ['like', 'a.slug', $s],
                ['like', 'a.website', $s],
                ['like', 'b.business_activity', $s],
            ])
            ->groupBy(['a.organization_enc_id'])
            ->asArray()
            ->all();
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $s = Yii::$app->request->post('keyword');
            $result = [];
            $organizations = Organizations::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'a.name', 'a.slug as slug', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo', 'a.initials_color color'])
                ->joinWith(['organizationTypeEnc b'], false)
                ->joinWith(['businessActivityEnc c'], false)
                ->joinWith(['industryEnc d'], false)
                ->joinWith(['employerApplications e' => function ($x) {
                    $x->select(['e.organization_enc_id', 'COUNT(e.application_enc_id) applications_cnt'])
                        ->onCondition([
                            'e.status' => 'Active',
                            'e.is_deleted' => 0
                        ])
                        ->groupBy(['e.organization_enc_id']);
                }])
                ->joinWith(['organizationReviews f' => function ($y) {
                    $y->select(['f.organization_enc_id', 'ROUND(AVG(f.average_rating)) average_rating', 'COUNT(f.review_enc_id) reviews_cnt'])
                        ->groupBy(['f.organization_enc_id']);
                }])
                ->where([
                    'a.is_deleted' => 0,
                    'a.status' => 'Active'
                ])
                ->andFilterWhere([
                    'or',
                    ['like', 'a.name', $s],
                    ['like', 'a.slug', $s],
                    ['like', 'a.website', $s],
                    ['like', 'b.organization_type', $s],
                    ['like', 'c.business_activity', $s],
                    ['like', 'd.industry', $s]
                ])
                ->groupBy(['a.organization_enc_id'])
                ->limit(8);
            $result['organizations'] = $organizations->asArray()->all();
            $unclaimed = $this->findUnclaimed($s);
            $result['School'] = [];
            $result['College'] = [];
            $result['Educational Institute'] = [];
            $result['Recruiter'] = [];
            $result['Business'] = [];
            $result['Scholarship Fund'] = [];
            $result['Banking & Finance Company'] = [];
            $result['Others'] = [];
            foreach ($unclaimed as $uc) {
                $ba = $uc['organizationTypeEnc']['business_activity'];
                if ($ba) {
                    if (count($result[$ba]) < 8) {
                        array_push($result[$ba], $uc);
                    }
                }
            }

            $options['limit'] = 6;

            if ($s) {
                $options['keyword'] = $s;
            }

            $jobs = ApplicationCards::jobs($options);

            $result['jobs'] = $jobs;

            $final_internships = ApplicationCards::internships($options);

            $result['internships'] = $final_internships;

            $posts = Posts::find()
                ->select([
                    'title',
                    'CONCAT("/blog/", slug) link',
                    'excerpt',
                    'CASE WHEN featured_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image) . '", featured_image_location, "/", featured_image) ELSE NULL END image'
                ])
                ->where([
                    'status' => 'Active',
                    'is_deleted' => 0
                ])
                ->andFilterWhere([
                    'or',
                    ['like', 'title', $s],
                    ['like', 'slug', $s],
                    ['like', 'meta_keywords', $s],
                ])
                ->limit(3);
            $posts_filter = $posts->asArray()->all();
            $result['posts'] = $posts_filter;
            return json_encode($result);
        }
        return $this->render('index');
    }
}