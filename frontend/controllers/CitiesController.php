<?php

namespace frontend\controllers;

use common\models\EmployerApplications;
use common\models\Organizations;
use frontend\models\applications\ApplicationCards;
use Yii;
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

    public function actionIndex()
    {
        $school = 'School';
        $college = 'College';
        $institute = 'Educational Institute';
        $city = 'Ludhiana';

        $jobs_count = $this->getJobsCount($city, 'Jobs');
        $internships_count = $this->getJobsCount($city, 'Internships');
        $org_count = $this->getCompanyCount($city);
        $college_count = $this->getCompanyCount($city, $college);
        $school_count = $this->getCompanyCount($city, $school);
        $institute_count = $this->getCompanyCount($city, $institute);
        $jobs = $this->getJobs($city,'jobs');
        $internships = $this->getJobs($city,'internships');

        return $this->render('index', [
            'job_count' => $jobs_count,
            'internship_count' => $internships_count,
            'org_count' => $org_count,
            'college_count' => $college_count,
            'school_count' => $school_count,
            'institute_count' => $institute_count,
            'jobs'=>$jobs,
            'internships'=>$internships
        ]);
    }

    private function getJobsCount($city, $type)
    {
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
        }
        $result = $organizations->asArray()
            ->all();

        return $result[0]['count'];
    }

    private function getJobs($city, $type)
    {
        $options = [];
        $options['limit'] = 6;

        if ($city) {
            $options['location'] = $city;
        }

        if ($type == 'jobs') {
            $cards = ApplicationCards::jobs($options);
        }elseif ($type == 'internships'){
            $cards = ApplicationCards::internships($options);
        }

        if (count($cards) > 0) {
            return $cards;
        }
    }

}
