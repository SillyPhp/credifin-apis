<?php

namespace frontend\controllers;

use common\models\ApplicationPlacementCities;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\AssignedCategories;
use common\models\Cities;
use common\models\EmployerApplications;
use common\models\OrganizationLocations;
use common\models\States;
use Yii;
use yii\web\Controller;

class LocationsController extends Controller
{
    public function actionStates()
    {
        $other_jobs = (new \yii\db\Query())
            ->distinct()
            ->from(States::tableName() . 'as a')
            ->select([
                'a.state_enc_id',
                'b.country_enc_id',
                'c.city_enc_id',
                'count(CASE WHEN e.application_enc_id IS NOT NULL AND f.name = "Jobs" Then 1 END)  as job_count',
                'count(CASE WHEN e.application_enc_id IS NOT NULL AND f.name = "Internships"  Then 1 END)  as internship_count',
            ])
            ->innerJoin(\common\models\Countries::tableName() . 'as b', 'b.country_enc_id = a.country_enc_id')
            ->leftJoin(Cities::tableName() . 'as c', 'c.state_enc_id = a.state_enc_id')
            ->leftJoin(ApplicationPlacementCities::tableName() . 'as d', 'd.city_enc_id = c.city_enc_id')
            ->leftJoin(EmployerApplications::tableName() . 'as e', 'e.application_enc_id = d.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as f', 'f.application_type_enc_id = e.application_type_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as g', 'g.assigned_category_enc_id = e.title')
            ->where(['e.is_deleted' => 0, 'b.name' => 'India']);

        $other_jobs_state_wise = $other_jobs->addSelect('a.name state_name')->groupBy('a.id');
        $other_jobs_city_wise = $other_jobs->addSelect('c.name city_name')->groupBy('c.id');

        $ai_jobs = (new \yii\db\Query())
            ->distinct()
            ->from(States::tableName() . 'as a')
            ->select([
                'a.state_enc_id',
                'b.country_enc_id',
                'c.city_enc_id',
                'count(CASE WHEN j.application_enc_id IS NOT NULL AND k.name = "Jobs" Then 1 END)  as job_count',
                'count(CASE WHEN j.application_enc_id IS NOT NULL AND k.name = "Internships"  Then 1 END)  as internship_count',
            ])
            ->innerJoin(\common\models\Countries::tableName() . 'as b', 'b.country_enc_id = a.country_enc_id')
            ->leftJoin(Cities::tableName() . 'as c', 'c.state_enc_id = a.state_enc_id')
            ->leftJoin(OrganizationLocations::tableName() . 'as h', 'h.city_enc_id = c.city_enc_id')
            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as i', 'i.location_enc_id = h.location_enc_id')
            ->innerJoin(EmployerApplications::tableName() . 'as j', 'j.application_enc_id = i.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as k', 'k.application_type_enc_id = j.application_type_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as l', 'l.assigned_category_enc_id = j.title')
            ->where(['j.is_deleted' => 0, 'l.is_deleted' => 0, 'b.name' => 'India']);

        $ai_jobs_state_wise = $ai_jobs->addSelect('a.name state_name')->groupBy('a.id');
        $ai_jobs_city_wise = $ai_jobs->addSelect('c.name city_name')->groupBy('c.id');

        $states = (new \yii\db\Query())
            ->from([
                $other_jobs_state_wise->union($ai_jobs_state_wise),
            ])
            ->select(['state_name', 'SUM(job_count) as jobs', 'SUM(internship_count) as internships'])
            ->groupBy('state_enc_id')
            ->orderBy(['state_name' => SORT_ASC])
            ->all();

        $cities = (new \yii\db\Query())
            ->from([
                $other_jobs_city_wise->union($ai_jobs_city_wise),
            ])
            ->select(['city_name', 'SUM(job_count) as jobs', 'SUM(internship_count) as internships'])
            ->groupBy('city_enc_id')
            ->orderBy(['jobs' => SORT_DESC])
            ->limit(4)
            ->all();

        return $this->render('states', [
            'cities' => $cities,
            'states' => $states,
        ]);
    }


    private function getTwitterApplications($type)
    {
        $states = States::find()
            ->alias('z')
            ->select([
                'z.state_enc_id',
                'w.country_enc_id',
                'y.city_enc_id',
                'z.name',
                'count(CASE WHEN b.tweet_enc_id IS NOT NULL Then 1 END)  as twitter'
            ])
            ->joinWith(['countryEnc w' => function ($w) {
                $w->andWhere(['w.name' => 'India']);
            }], false)
            ->joinWith(['cities y' => function ($y) use ($type) {
                $y->innerJoinWith(['twitterPlacementCities x' => function ($x) use ($type) {
                    $x->select(['x.city_enc_id', 'b.tweet_enc_id', 'b.job_title', 'e.assigned_to', 'f.name', 'f.slug']);
                    $x->joinWith(['tweetEnc b' => function ($b) use ($type) {
                        $b->joinWith(['jobTitle e' => function ($d) use ($type) {
                            $d->joinWith(['categoryEnc f']);
                            $d->andWhere(['e.assigned_to' => $type]);
                        }]);
                        $b->andWhere(['b.is_deleted' => 0]);
                    }], false);
                    $x->distinct();
                }]);
            }], false)
            ->groupBy(['z.id'])
            ->asArray()
            ->all();
        return $states;
    }

}