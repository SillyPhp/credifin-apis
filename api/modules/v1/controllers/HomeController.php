<?php


namespace api\modules\v1\controllers;


use common\models\ApplicationPlacementCities;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\ApplicationUnclaimOptions;
use common\models\AssignedCategories;
use common\models\Cities;
use common\models\EmployerApplications;
use common\models\IndianGovtDepartments;
use common\models\OrganizationLocations;
use common\models\Organizations;
use common\models\States;
use common\models\TwitterJobs;
use common\models\UnclaimedOrganizations;
use common\models\UsaDepartments;
use common\models\Users;
use yii\db\Expression;
use Yii;
use yii\helpers\Url;

class HomeController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'top-learning-categories' => ['POST'],
                'get-stats' => ['POST'],
                'top-cities' => ['POST'],
                'featured' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionTopLearningCategories()
    {

        $params = Yii::$app->request->post();

        if (isset($params['limit']) && !empty($params['limit'])) {
            $limit = $params['limit'];
        } else {
            $limit = 8;
        }

        if (isset($params['page']) && !empty($params['page'])) {
            $page = $params['page'];
        }

        $categories = AssignedCategories::find()
            ->select(['COUNT(d.video_enc_id) as total', 'a.assigned_category_enc_id', 'a.category_enc_id', 'a.parent_enc_id', 'CASE WHEN a.icon IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->categories->icon->png->icon, 'https') . '", a.icon_location, "/", a.icon) ELSE "' . Url::to('/assets/themes/ey/images/pages/learning-corner/othercategory.png', 'https') . '" END icon', 'c.slug', 'c.name'])
            ->alias('a')
            ->distinct()
            ->joinWith(['categoryEnc c'], false)
            ->joinWith(['learningVideos d' => function ($b) {
                $b->andOnCondition(['d.status' => 1]);
                $b->andOnCondition(['d.is_deleted' => 0]);
            }], false)
            ->groupBy(['a.assigned_category_enc_id'])
            ->where(['a.is_deleted' => 0, 'a.status' => 'Approved'])
            ->andWhere([
                'or',
                ['not', ['a.parent_enc_id' => NULL]],
                ['not', ['a.parent_enc_id' => ""]]
            ])
            ->andWhere(['a.assigned_to' => 'Videos'])
            ->orderBy(['total' => SORT_DESC, 'c.name' => SORT_ASC]);

        if ((int)$limit) {
            $categories->limit($limit)->offset(($page - 1) * $limit);
        }

        $result = $categories->asArray()->all();

        if ($result) {
            return $this->response(200, $result);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionGetStats()
    {

        $type = Yii::$app->request->post('type');


        $total_jobs = $this->getData('Jobs');
        $total_internships = $this->getData('Internships');
        $total = $this->getData('');

        if ($type == 'jobs') {
            $cards = ['jobs' => $total_jobs['total_applications'], 'profiles' => $total_jobs['titles'], 'location' => $total_jobs['locations'], 'companies' => $total_jobs['org']];
        } elseif ($type == 'internships') {
            $cards = ['profiles' => $total_internships['titles'], 'internships' => $total_internships['total_applications'], 'location' => $total_internships['locations'], 'companies' => $total_internships['org']];
        } else {
            $cards = ['jobs' => $total_jobs['total_applications'], 'internships' => $total_internships['total_applications'], 'location' => $total['locations'], 'companies' => $total_jobs['org']];
        }

        if ($cards) {
            return $this->response(200, $cards);
        } else {
            return $this->response(404, 'not found');
        }

    }

    private function getData($type)
    {
        $titles = AssignedCategories::find()
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['not', ['parent_enc_id' => null]]);
        if ($type == "") {
            $titles->andWhere(['in', 'assigned_to', ['Jobs', 'Internships']]);
        } else {
            $titles->andWhere(['assigned_to' => $type]);
        }
        $titles_count = $titles->count();

        $cards1 = ApplicationPlacementLocations::find()
            ->alias('a')
            ->joinWith(['applicationEnc b' => function ($b) use ($type) {
                $b->andWhere(['b.status' => 'Active', 'b.is_deleted' => 0]);
                $b->joinWith(['applicationTypeEnc c' => function ($b) use ($type) {
                    if ($type) {
                        $b->andWhere(['c.name' => $type]);
                    }
                }]);
            }], false)
            ->joinWith(['locationEnc d'], false)
            ->select(['SUM(a.positions) total', 'COUNT(d.location_enc_id) locations'])
            ->asArray()
            ->one();

        $cards2 = ApplicationUnclaimOptions::find()
            ->alias('a')
            ->joinWith(['applicationEnc b' => function ($b) use ($type) {
                $b->andWhere(['b.status' => 'Active', 'b.is_deleted' => 0]);
                $b->joinWith(['applicationTypeEnc c' => function ($b) use ($type) {
                    if ($type) {
                        $b->andWhere(['c.name' => $type]);
                    }
                }]);
            }], false)
            ->select(['SUM(a.positions) total'])
            ->asArray()
            ->one();
        $unclaim_locations = ApplicationPlacementCities::find()->count();
        $org_claim = Organizations::find()->count();
        $org_unclaim = UnclaimedOrganizations::find()->count();

        $twitter = TwitterJobs::find()
            ->alias('a')
            ->joinWith(['applicationTypeEnc b' => function ($b) use ($type) {
                $b->andWhere(['b.name' => $type]);
            }])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->count();

        if ($type == 'Jobs') {
            $usaGov = UsaDepartments::find()
                ->select('SUM(total_applications) as total')
                ->asArray()
                ->one();
            $indianGov = IndianGovtDepartments::find()
                ->select('SUM(total_applications) as total')
                ->asArray()
                ->one();
        } else {
            $usaGov['total'] = 0;
            $indianGov['total'] = 0;
        }

        return [
            'total_applications' => $cards1['total'] + $cards2['total'] + $twitter + $usaGov['total'] + $indianGov['total'],
            'org' => $org_claim + $org_unclaim,
            'locations' => $cards1['locations'] + $unclaim_locations,
            'titles' => $titles_count,
        ];
    }

    public function actionTopCities()
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
            ->innerJoin(Users::tableName() . 'as g', 'g.user_enc_id = e.created_by')
            ->andWhere(['e.is_deleted' => 0, 'b.name' => 'India'])
            ->andWhere(['in', 'c.name', ['Ludhiana', 'Mainpuri', 'Jalandhar']]);
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
            ->andWhere(['j.is_deleted' => 0, 'l.is_deleted' => 0]);
        $ai_jobs_city_wise = $ai_jobs->addSelect('c.name city_name')->groupBy('c.id');
        $cities_jobs = (new \yii\db\Query())
            ->from([
                $other_jobs_city_wise->union($ai_jobs_city_wise),
            ])
            ->select(['city_name', 'SUM(job_count) as jobs', 'SUM(internship_count) as internships'])
            ->groupBy('city_enc_id')
            ->orderBy(['jobs' => SORT_DESC])
            ->limit(4)
            ->all();

        $i = 0;
        foreach ($cities_jobs as $c) {
            $cities_jobs[$i]['total_openings'] = $c['jobs'] + $c['internships'];
            $cities_jobs[$i]['city_image'] = Url::to('@commonAssets/images/cities/' . preg_replace('/\s+/', '_', strtolower($c["city_name"])) . '.png', 'https');
            $i++;
        }

        if ($cities_jobs) {
            return $this->response(200, $cities_jobs);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionFeatured()
    {
        $organizations = \common\models\Organizations::find()
            ->select(['organization_enc_id', 'slug', 'initials_color color', 'name', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
            ->where(['is_sponsored' => 1])
            ->limit(6)
            ->asArray()
            ->all();

        if ($organizations) {
            return $this->response(200, $organizations);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionFeaturedEmployers()
    {
        $companies = Organizations::find()
            ->alias('z')
            ->select(['z.organization_enc_id', 'z.slug', 'z.initials_color color', 'z.name', 'CASE WHEN z.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", z.logo_location, "/", z.logo) ELSE NULL END logo'])
            ->joinWith(['businessActivityEnc a'], false)
            ->joinWith(['organizationLabels ol' => function ($x) {
                $x->onCondition(['ol.label_for' => 0, 'ol.is_deleted' => 0]);
                $x->joinWith(['labelEnc le' => function ($l) {
                    $l->onCondition(['le.is_deleted' => 0]);
                }], false);
            }], false)
            ->andWhere(['not', ['z.logo' => null]])
            ->andWhere(['not', ['z.logo' => ""]])
            ->andWhere(['z.status' => 'Active', 'z.is_deleted' => 0])
            ->andWhere(['le.name' => 'Featured'])
            ->andWhere(['not', ['in', 'a.business_activity', ['College', 'Educational Institute', 'School']]])
            ->orderby(new Expression('rand()'))
            ->limit(12)
            ->asArray()
            ->all();

        if ($companies) {
            return $this->response(200, $companies);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionCountries()
    {
        $strJsonFileContents = file_get_contents(dirname(__DIR__, 4) . '/files/' . 'countries.json');
        $countries = json_decode($strJsonFileContents, true);

        foreach ($countries as $k => $v) {
            if ($v['name'] == 'New Zealand') {
                $countries[$k]['icon'] = Url::to('@eyAssets/images/pages/world-job/newzealan.png', 'https');
            } elseif ($v['name'] == 'Hong Kong') {
                $countries[$k]['icon'] = Url::to('@eyAssets/images/pages/world-job/hong-kong.png', 'https');
            } else {
                $countries[$k]['icon'] = Url::to('@eyAssets/images/pages/world-job/' . strtolower($v['name']) . '.png', 'https');
            }
        }

        if ($countries) {
            return $this->response(200, $countries);
        } else {
            return $this->response(404, 'not found');
        }
    }
}