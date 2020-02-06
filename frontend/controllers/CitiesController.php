<?php

namespace frontend\controllers;

use common\models\BusinessActivities;
use common\models\EmployerApplications;
use common\models\NewOrganizationReviews;
use common\models\OrganizationLocations;
use common\models\OrganizationReviews;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use frontend\models\applications\ApplicationCards;
use Yii;
use yii\helpers\Url;
use common\models\Cities;
use common\models\States;
use common\models\Countries;
use yii\web\Controller;
use yii\web\Response;

/**
 * CitiesController implements the CRUD actions for Cities model.
 */
class CitiesController extends Controller
{

    public function actionGetCitiesByState()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($id = Yii::$app->request->post('id')) {
            $cities = Cities::find()->select(['city_enc_id AS id', 'name'])->where(['state_enc_id' => $id])->orderBy(['name' => SORT_ASC])->asArray()->all();
        }

        if (count($cities) > 0) {
            return [
                'status' => 200,
                'cities' => $cities
            ];
        } else {
            return [
                'status' => 0
            ];
        }
    }

    public function actionCityList($q = null, $id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
//        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $cities = Cities::find()
                ->alias('a')
                ->select(['a.city_enc_id AS id', 'a.name AS text'])
                ->innerJoin(States::tableName() . ' as b', 'b.state_enc_id = a.state_enc_id')
                ->innerJoin(Countries::tablename() . ' as c', 'c.country_enc_id = b.country_enc_id')
                ->where(['like', 'a.name', $q])
                ->andWhere(['c.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
                ->limit(20)
                ->asArray()
                ->all();
//            $out['results'] = array_values($cities);
//        } elseif ($id > 0) {
//            $out['results'] = ['id' => $id, 'text' => Cities::find($id)->name];
//        }
//        return $out;

            return $cities;
        }
    }

    public function actionCountryList($q = null)
    {
        if (!is_null($q)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Countries::find()
                ->alias('a')
                ->select(['a.name text', 'a.country_enc_id id'])
                ->where('a.name LIKE "' . $q . '%"')
                ->limit(20)
                ->asArray()
                ->all();
            $out['results'] = array_values($data);
            return $out;
        }
    }

    public function actionCareerCityList($q = null, $cid = 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09')
    {
        if (!is_null($q)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Cities::find()
                ->alias('a')
                ->select(['a.name text', 'a.city_enc_id id'])
                ->where('a.name LIKE "' . $q . '%"')
                ->joinWith(['stateEnc b' => function ($b) use ($cid) {
                    $b->joinWith(['countryEnc c']);
                    $b->andWhere(['c.country_enc_id' => $cid]);
                }], false)
                ->limit(20)
                ->asArray()
                ->all();
            $out['results'] = array_values($data);
            return $out;
        }
    }

    public function actionIndex($location)
    {
        $school = 'School';
        $college = 'College';
        $institute = 'Educational Institute';
        $company = 'Company';
        $city = $location;

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $city = Yii::$app->request->post('city');
            $type = Yii::$app->request->post('type');

            $options = [];
            $options['limit'] = 6;

            if ($city) {
                $options['location'] = $city;
            }

            if ($type == 'jobs') {
                $cards = ApplicationCards::jobs($options);
            } elseif ($type == 'internships') {
                $cards = ApplicationCards::internships($options);
            }

            if (count($cards) > 0) {
                return json_encode([
                    'status' => 200,
                    'cards' => $cards,
                ]);
            }
        }

        $full_location = Cities::find()
            ->alias('a')
            ->select(['a.name city', 'b.name state', 'c.name country'])
            ->innerJoinWith(['stateEnc b' => function ($b) {
                $b->innerJoinWith(['countryEnc c']);
            }], false)
            ->where(['a.name' => $city])
            ->asArray()
            ->one();

        // get jobs and internships counts
        $jobs_count = $this->getJobsCount($city, 'Jobs');
        $internships_count = $this->getJobsCount($city, 'Internships');

        // get org,college,school and institute count
        $org_count = $this->getCompanyCount($city);
        $college_count = $this->getCompanyCount($city, $college);
        $school_count = $this->getCompanyCount($city, $school);
        $institute_count = $this->getCompanyCount($city, $institute);

        // getting company, school, college and institute data
        $companies = $this->getInstitutes($city,$company);
        $institutes = $this->getInstitutes($city, $institute);
        $college = $this->getInstitutes($city, $college);
        $school = $this->getInstitutes($city, $school);

        return $this->render('index', [
            'job_count' => $jobs_count,
            'internship_count' => $internships_count,
            'org_count' => $org_count,
            'college_count' => $college_count,
            'school_count' => $school_count,
            'institute_count' => $institute_count,
            'companies' => $companies,
            'institutes' => $institutes,
            'school' => $school,
            'college' => $college,
            'city' => $full_location
        ]);
    }

    private function getJobsCount($city, $type)
    {
        // getting claimed jobs count
        $claimed = EmployerApplications::find()
            ->alias('a')
            ->select(['count(distinct(a.application_enc_id)) count'])
            ->joinWith(['applicationPlacementLocations b' => function ($b) {
                $b->joinWith(['locationEnc c' => function ($c) {
                    $c->joinWith(['cityEnc d']);
                }]);
            }], false)
            ->joinWith(['applicationTypeEnc e'], false)
            ->Where(['d.name' => $city, 'a.is_deleted' => 0, 'a.status' => 'Active', 'e.name' => $type])
            ->asArray()
            ->all();

        // getting unclaimed jobs count
        $un_claimed = EmployerApplications::find()
            ->alias('a')
            ->select(['count(distinct(a.application_enc_id)) count'])
            ->joinWith(['applicationPlacementCities b' => function ($b) {
                $b->joinWith(['cityEnc c']);
            }], false)
            ->joinWith(['applicationTypeEnc e'], false)
            ->Where(['c.name' => $city, 'a.is_deleted' => 0, 'a.status' => 'Active', 'e.name' => $type])
            ->asArray()
            ->all();

        $total = $claimed[0]['count'] + $un_claimed[0]['count'];

        return $total;
    }

    private function getCompanyCount($city, $type = null)
    {
        // getting claimed companies count
        $organizations = Organizations::find()
            ->alias('a')
            ->select(['count(distinct(a.organization_enc_id)) count'])
            ->joinWith(['organizationLocations b' => function ($b) {
                $b->joinWith(['cityEnc c']);
            }], false)
            ->where(['a.is_deleted' => 0, 'a.status' => 'Active', 'c.name' => $city]);
        if ($type != null) {
            $organizations->joinWith(['businessActivityEnc d'])
                ->andWhere(['d.business_activity' => $type]);
        } else {
            $organizations->joinWith(['businessActivityEnc d'], false)->andWhere(['not in', 'd.business_activity', ['School', 'College', 'Educational Institute']]);
        }
        $org_result = $organizations->asArray()
            ->all();

        // getting unclaimed companies count
        $unclaimed_org = UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['count(distinct(a.organization_enc_id)) count'])
            ->joinWith(['cityEnc b'], false)
            ->where(['a.is_deleted' => 0, 'a.status' => 1, 'b.name' => $city]);
        if ($type != null) {
            $unclaimed_org->joinWith(['organizationTypeEnc d'],false)
                ->andWhere(['d.business_activity' => $type]);
        } else {
            $unclaimed_org->joinWith(['organizationTypeEnc d'], false)->andWhere(['not in', 'd.business_activity', ['School', 'College', 'Educational Institute']]);
        }

        $un_org_result = $unclaimed_org->asArray()
            ->all();


        return $org_result[0]['count'] + $un_org_result[0]['count'];
    }

    private function getInstitutes($city, $type = null)
    {
        // getting claimed org data
        $organizations = Organizations::find()
            ->alias('a')
            ->select(['distinct(a.organization_enc_id)', 'a.name', 'a.initials_color', 'a.slug', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END image','(CASE WHEN a.organization_enc_id IS NOT NULL THEN "claimed" END) as org_type'])
            ->joinWith(['organizationLocations b' => function ($b) {
                $b->joinWith(['cityEnc c']);
            }], false)
            ->joinWith(['organizationReviews e' => function ($e) {
                $e->select(['e.organization_enc_id', 'ROUND(AVG(e.average_rating)) average_rating', 'count(e.review_enc_id) reviews_count']);
            }])
            ->joinWith(['businessActivityEnc d'], false)
            ->where(['a.is_deleted' => 0, 'a.status' => 'Active', 'c.name' => $city]);
        if ($type != null) {
            //if type company then it will return only claimed company data
            if($type == 'Company'){
                $result =
                    $organizations
                        ->andWhere(['not in', 'd.business_activity', ['School', 'College', 'Educational Institute']])
                        ->limit(6)
                        ->asArray()
                        ->all();
                return $result;
            }
            $organizations->andWhere(['d.business_activity' => $type]);
        } else {
            $organizations->andWhere(['not in', 'd.business_activity', ['School', 'College', 'Educational Institute']]);
        }

        // getting unclaimed org data
        $un_org = UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['distinct(a.organization_enc_id)', 'a.name', 'a.initials_color', 'a.slug', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END image','(CASE WHEN a.organization_enc_id IS NOT NULL THEN "unclaimed" END) as org_type'])
            ->innerJoinWith(['cityEnc b'])
            ->joinWith(['organizationTypeEnc d'])
            ->joinWith(['newOrganizationReviews e' => function ($e) {
                $e->select(['e.organization_enc_id', 'ROUND(AVG(e.average_rating)) average_rating', 'count(e.review_enc_id) reviews_count']);
            }])
            ->joinWith(['organizationTypeEnc d'], false)
            ->where(['a.is_deleted' => 0, 'a.status' => 1, 'b.name' => $city]);
        if ($type != null) {
            $un_org->andWhere(['d.business_activity' => $type]);
        } else {
            $un_org->andWhere(['not in', 'd.business_activity', ['School', 'College', 'Educational Institute']]);
        }

        $result =
            $un_org->union($organizations)
                ->limit(6)
                ->asArray()
                ->all();

        return $result;
    }

}
