<?php

namespace api\modules\v2\controllers;

use common\models\ApplicationTypes;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\OrganizationLabels;
use common\models\OrganizationReviews;
use common\models\Organizations;
use common\models\UserOtherDetails;
use Yii;
use yii\helpers\Url;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class SearchController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'companies' => ['POST', 'OPTIONS'],
                'jobs' => ['POST', 'OPTIONS'],
                'internships' => ['POST', 'OPTIONS']
            ]
        ];
        $behaviors['authenticator'] = [
            'except' => [
                'companies',
                'jobs',
                'internships'
            ],
            'class' => HttpBearerAuth::className()
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionJobs()
    {
        $req = Yii::$app->request->post();
        $options = [];

        if ($req['page'] && (int)$req['page'] >= 1) {
            $options['page'] = $req['page'];
        } else {
            $options['page'] = 1;
        }

        $options['limit'] = 9;
        $options['type'] = 'Jobs';

        if ($req['keyword']) {
            $options['keyword'] = $req['keyword'];
            return $this->response(200, $this->findApplications($options));
        } elseif ($req['slug']) {
            $options['slug'] = $req['slug'];
            return $this->response(200, $this->findApplications($options));
        } else {
            return $this->response(200, $this->findApplications($options));
        }
    }

    public function actionCompanies($name = null, $page = null)
    {

        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;
            $college_id = UserOtherDetails::find()
                ->select(['organization_enc_id'])
                ->where(['user_enc_id' => $id])
                ->asArray()
                ->one();

            $org = ErexxCollaborators::find()
                ->alias('aa')
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->distinct()
                ->joinWith(['organizationEnc b' => function ($x) use ($college_id) {
                    $x->groupBy('organization_enc_id');
                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'b.website', 'b.description', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y) use ($college_id) {
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'f.college_enc_id' => $college_id['organization_enc_id'],
                            'f.is_deleted' => 0,
                            'f.is_college_approved' => 1,
                            'f.status' => 'Active',
                        ]);
                    }], false)
                        ->joinWith(['organizationLocations ee' => function ($e) {
                            $e->select(['ee.organization_enc_id', 'ff.city_enc_id', 'ff.name']);
                            $e->joinWith(['cityEnc ff' => function ($ff) {
                                $ff->groupBy(['ff.city_enc_id']);
                            }], false)
                                ->orOnCondition([
                                    'ee.is_deleted' => 0,
                                ]);
                            $e->groupBy(['ee.organization_enc_id']);
                        }]);
                }])
                ->where(['aa.college_enc_id' => $college_id,
                    'aa.organization_approvel' => 1,
                    'aa.college_approvel' => 1,
                    'aa.is_deleted' => 0,
                    'b.is_erexx_approved' => 1,
                    'b.has_placement_rights' => 1]);

            if (isset($name) && !empty($name)) {
                $org->andWhere([
                    'or',
                    ['like', 'b.name', $name],
                    ['like', 'b.slug', $name],
                ]);
            }

            if (isset($page) && !empty($page)) {
                $org->limit = 6;
                $org->offset = ($page - 1) * 6;
            }


            $result = $org->asArray()->all();

            $i = 0;
            foreach ($result as $c) {

                $org_labels = OrganizationLabels::find()
                    ->alias('a')
                    ->select([
                        'a.org_label_enc_id',
                        'a.label_enc_id',
                        'b.name'
                    ])
                    ->joinWith(['labelEnc b'])
                    ->where(['a.label_for' => 1, 'a.organization_enc_id' => $c['organization_enc_id'], 'a.is_deleted' => 0])
                    ->asArray()
                    ->all();

                $labels = [];
                if ($org_labels) {
                    foreach ($org_labels as $l) {
                        switch ($l['name']) {
                            case "Trending":
                                $labels['Trending'] = true;
                                break;
                            case "Promoted":
                                $labels['Promoted'] = true;
                                break;
                            case "New":
                                $labels['New'] = true;
                                break;
                            case "Hot":
                                $labels['Hot'] = true;
                                break;
                            case "Featured":
                                $labels['Featured'] = true;
                                break;
                            case "trendd":
                                $labels['trendd'] = true;
                                break;
                            case "Verified":
                                $labels['Verified'] = true;
                                break;
                        }
                    }
                }
                $result[$i]['labels'] = $labels;

                $reviews = OrganizationReviews::find()
                    ->select(['organization_enc_id', 'ROUND(average_rating) average_rating', 'COUNT(review_enc_id) reviews_cnt'])
                    ->where(['organization_enc_id' => $c['organization_enc_id']])
                    ->asArray()
                    ->one();

                $result[$i]['organizationEnc']['organizationReviews'][0] = $reviews;
                $i++;
            }
            return $this->response(200, $result);
        } else {
            $org = ErexxCollaborators::find()
                ->alias('aa')
                ->select(['aa.collaboration_enc_id', 'aa.organization_enc_id'])
                ->distinct()
                ->innerJoinWith(['organizationEnc b' => function ($x) {
                    $x->groupBy('organization_enc_id');
                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'b.website', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                }])
                ->where(['b.has_placement_rights' => 1, 'b.is_erexx_approved' => 1, 'aa.is_deleted' => 0, 'b.is_deleted' => 0, 'b.status' => 'Active']);

            if (isset($name) && !empty($name)) {
                $org->andWhere([
                    'or',
                    ['like', 'b.name', $name],
                    ['like', 'b.slug', $name],
                ]);
            }

            if (isset($page) && !empty($page)) {
                $org->limit = 6;
                $org->offset = ($page - 1) * 6;
            }

            $result = $org->asArray()->all();

            $i = 0;
            foreach ($result as $c) {

                $org_labels = OrganizationLabels::find()
                    ->alias('a')
                    ->select([
                        'a.org_label_enc_id',
                        'a.label_enc_id',
                        'b.name'
                    ])
                    ->joinWith(['labelEnc b'])
                    ->where(['a.label_for' => 1, 'a.organization_enc_id' => $c['organization_enc_id'], 'a.is_deleted' => 0])
                    ->asArray()
                    ->all();

                $labels = [];
                if ($org_labels) {
                    foreach ($org_labels as $l) {
                        switch ($l['name']) {
                            case "Treanding":
                                $labels['Treanding'] = true;
                                break;
                            case "Promoted":
                                $labels['Promoted'] = true;
                                break;
                            case "New":
                                $labels['New'] = true;
                                break;
                            case "Hot":
                                $labels['Hot'] = true;
                                break;
                            case "Featured":
                                $labels['Featured'] = true;
                                break;
                            case "trendd":
                                $labels['trendd'] = true;
                                break;
                            case "Verified":
                                $labels['Verified'] = true;
                                break;
                        }
                    }
                }
                $result[$i]['labels'] = $labels;

                $jobs_count = $this->getJobsCount('Jobs', $c['organization_enc_id']);
                $internships_count = $this->getJobsCount('Internships', $c['organization_enc_id']);
                $result[$i]['organizationEnc']['jobs_count'] = $jobs_count;
                $result[$i]['organizationEnc']['internships_count'] = $internships_count;
                $i++;
            }

            return $this->response(200, $result);
        }

    }

    private function getJobsCount($type, $org_id)
    {
        $count = ErexxEmployerApplications::find()
            ->distinct()
            ->alias('a')
            ->innerJoinWith(['employerApplicationEnc b' => function ($b) {
                $b->joinWith(['applicationTypeEnc c']);
                $b->joinWith(['organizationEnc d']);
            }], false)
            ->groupBy('a.employer_application_enc_id')
            ->where(['c.name' => $type, 'd.organization_enc_id' => $org_id, 'a.is_deleted' => 0, 'a.status' => 'Active'])
            ->count();
        return $count;
    }

    public function actionInternships()
    {
        $req = Yii::$app->request->post();
        $options = [];

        if ($req['page'] && (int)$req['page'] >= 1) {
            $options['page'] = $req['page'];
        } else {
            $options['page'] = 1;
        }

        $options['limit'] = 9;
        $options['type'] = 'Internships';

        if ($req['keyword']) {
            $options['keyword'] = $req['keyword'];
            return $this->response(200, $this->findApplications($options));
        } else {
            return $this->response(200, $this->findApplications($options));
        }
    }

    private function findApplications($options = [])
    {

        if ($user = $this->isAuthorized()) {
            $id = $user->user_enc_id;
            $college_id = UserOtherDetails::find()
                ->select(['organization_enc_id'])
                ->where(['user_enc_id' => $id])
                ->asArray()
                ->one();

            $type = $options['type'];

            $jobs = ErexxEmployerApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'bb.name',
                    'bb.slug org_slug',
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name parent_category',
                    'ee.name title',
                    'a.employer_application_enc_id',
                    'b.slug',
                    'b.status',
                    'b.last_date',
                    'b.joining_date',
                    'b.created_on',
                    'm.fixed_wage as fixed_salary',
                    'm.wage_type salary_type',
                    'm.max_wage as max_salary',
                    'm.min_wage as min_salary',
                    'm.wage_duration as salary_duration',
                    'dd.designation',
                    'z.name job_type'
                ])
                ->joinWith(['employerApplicationEnc b' => function ($b) {
                    $b->joinWith(['applicationJobDescriptions ii' => function ($x) {
                        $x->onCondition(['ii.is_deleted' => 0]);
                        $x->joinWith(['jobDescriptionEnc jj'], false);
                        $x->select(['ii.application_enc_id', 'jj.job_description_enc_id', 'jj.job_description']);
                    }]);
                    $b->joinWith(['organizationEnc bb' => function ($bb) {
                        $bb->innerJoinWith(['erexxCollaborators0 b1'], false);
                    }], false);
                    $b->select(['b.application_enc_id', 'b.slug', 'y.interview_process_enc_id']);
                    $b->joinWith(['interviewProcessEnc y' => function ($y) {
                        $y->select(['y.interview_process_enc_id']);
                        $y->joinWith(['interviewProcessFields yy' => function ($yy) {
                            $yy->select(['yy.interview_process_enc_id', 'yy.sequence', 'yy.field_name']);
                        }]);
                    }]);
                    $b->joinWith(['applicationEducationalRequirements bc' => function ($bc) {
                        $bc->select(['bc.application_enc_id', 'cb.educational_requirement']);
                        $bc->joinWith(['educationalRequirementEnc cb'], false);
                    }]);
                    $b->joinWith(['applicationSkills bbc' => function ($bbc) {
                        $bbc->select(['bbc.application_enc_id', 'skill']);
                        $bbc->joinWith(['skillEnc cbb'], false);
                    }]);
                    $b->joinWith(['designationEnc dd'], false);
                    $b->joinWith(['title d' => function ($d) {
                        $d->joinWith(['parentEnc e']);
                        $d->joinWith(['categoryEnc ee']);
                    }], false);
                    $b->joinWith(['applicationOptions m'], false);
                    $b->joinWith(['applicationPlacementLocations f' => function ($f) {
                        $f->select(['f.application_enc_id', 'g.name', 'f.placement_location_enc_id', 'f.positions']);
                        $f->joinWith(['locationEnc ff' => function ($z) {
                            $z->joinWith(['cityEnc g']);
                        }], false);
                        $f->onCondition(['f.is_deleted' => 0]);
                        $f->groupBy(['f.placement_location_enc_id']);
                    }], true);
                    $b->joinWith(['applicationTypeEnc z']);
                }], true)
                ->where([
                    'a.college_enc_id' => $college_id,
                    'a.is_deleted' => 0,
                    'a.status' => 'Active',
                    'a.is_college_approved' => 1,
                    'b.application_for' => 2,
//                    'b.status' => 'Active',
                    'b.is_deleted' => 0,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1,
                    'bb.status' => 'Active',
                    'bb.is_deleted' => 0,
                    'b1.is_deleted' => 0,
                    'b1.status' => 'Active',
                    'b1.college_approvel' => 1
                ]);
            if (isset($options['keyword'])) {
                $jobs->andWhere([
                    'or',
                    ['like', 'bb.name', $options['keyword']],
                    ['like', 'dd.designation', $options['keyword']],
                    ['like', 'b.type', $options['keyword']],
                    ['like', 'ee.name', $options['keyword']],
                    ['like', 'e.name', $options['keyword']],
                ]);
            }
            if (isset($options['slug'])) {
                $jobs->andWhere(['bb.slug' => $options['slug']]);
            }
            if ($type) {
                $jobs->andWhere(['z.name' => $type]);
            }
            if (isset($options['limit'])) {
                $jobs->limit = $options['limit'];
                $jobs->offset = ($options['page'] - 1) * $options['limit'];
            }
            $result = $jobs->orderBy([new \yii\db\Expression('b.status = "Active" desc'), 'a.is_college_approved' => SORT_DESC])
                ->asArray()
                ->all();
        } else {
            $type = $options['type'];

            $jobs = ErexxEmployerApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'bb.name',
                    'bb.slug org_slug',
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name parent_category',
                    'ee.name title',
                    'a.employer_application_enc_id',
                    'b.slug',
                    'b.status',
                    'b.last_date',
                    'b.joining_date',
                    'b.created_on',
                    'm.fixed_wage as fixed_salary',
                    'm.wage_type salary_type',
                    'm.max_wage as max_salary',
                    'm.min_wage as min_salary',
                    'm.wage_duration as salary_duration',
                    'dd.designation',
                    'z.name job_type'
                ])
                ->joinWith(['employerApplicationEnc b' => function ($b) {
                    $b->joinWith(['applicationJobDescriptions ii' => function ($x) {
                        $x->onCondition(['ii.is_deleted' => 0]);
                        $x->joinWith(['jobDescriptionEnc jj'], false);
                        $x->select(['ii.application_enc_id', 'jj.job_description_enc_id', 'jj.job_description']);
                    }]);
                    $b->joinWith(['organizationEnc bb'], false);
                    $b->select(['b.application_enc_id', 'b.slug', 'y.interview_process_enc_id']);
                    $b->joinWith(['interviewProcessEnc y' => function ($y) {
                        $y->select(['y.interview_process_enc_id']);
                        $y->joinWith(['interviewProcessFields yy' => function ($yy) {
                            $yy->select(['yy.interview_process_enc_id', 'yy.sequence', 'yy.field_name']);
                        }]);
                    }]);
                    $b->joinWith(['applicationEducationalRequirements bc' => function ($bc) {
                        $bc->select(['bc.application_enc_id', 'cb.educational_requirement']);
                        $bc->joinWith(['educationalRequirementEnc cb'], false);
                    }]);
                    $b->joinWith(['applicationSkills bbc' => function ($bbc) {
                        $bbc->select(['bbc.application_enc_id', 'skill']);
                        $bbc->joinWith(['skillEnc cbb'], false);
                    }]);
                    $b->joinWith(['designationEnc dd'], false);
                    $b->joinWith(['title d' => function ($d) {
                        $d->joinWith(['parentEnc e']);
                        $d->joinWith(['categoryEnc ee']);
                    }], false);
                    $b->joinWith(['applicationOptions m'], false);
                    $b->joinWith(['applicationPlacementLocations f' => function ($f) {
                        $f->select(['f.application_enc_id', 'g.name', 'f.placement_location_enc_id', 'f.positions']);
                        $f->joinWith(['locationEnc ff' => function ($z) {
                            $z->joinWith(['cityEnc g']);
                        }], false);
                        $f->onCondition(['f.is_deleted' => 0]);
                        $f->groupBy(['f.placement_location_enc_id']);
                    }], true);
                    $b->joinWith(['applicationTypeEnc z']);
                }], true)
                ->where([
                    'a.is_deleted' => 0,
                    'a.status' => 'Active',
                    'a.is_college_approved' => 1,
                    'b.application_for' => 2,
//                    'b.status' => 'Active',
                    'b.is_deleted' => 0,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1,
                    'bb.status' => 'Active',
                    'bb.is_deleted' => 0
                ]);
            if (isset($options['keyword'])) {
                $jobs->andWhere([
                    'or',
                    ['like', 'bb.name', $options['keyword']],
                    ['like', 'dd.designation', $options['keyword']],
                    ['like', 'b.type', $options['keyword']],
                    ['like', 'ee.name', $options['keyword']],
                    ['like', 'e.name', $options['keyword']],
                ]);
            }
            if (isset($options['slug'])) {
                $jobs->andWhere(['bb.slug' => $options['slug']]);
            }
            if ($type) {
                $jobs->andWhere(['z.name' => $type]);
            }
            if (isset($options['limit'])) {
                $jobs->limit = $options['limit'];
                $jobs->offset = ($options['page'] - 1) * $options['limit'];
            }
            $result = $jobs->orderBy([new \yii\db\Expression('b.status = "Active" desc'), 'a.is_college_approved' => SORT_DESC])
                ->asArray()
                ->all();
        }


        $i = 0;
        foreach ($result as $val) {
//            $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
            if ($val['salary_type'] == "Fixed") {
                if ($val['salary_duration'] == "Monthly") {
                    $result[$i]['salary'] = $val['fixed_salary'] * 12 . ' p.a.';
                } elseif ($val['salary_duration'] == "Hourly") {
                    $result[$i]['salary'] = $val['fixed_salary'] * 40 * 52 . ' p.a.';
                } elseif ($val['salary_duration'] == "Weekly") {
                    $result[$i]['salary'] = $val['fixed_salary'] * 52 . ' p.a.';
                } else {
                    $result[$i]['salary'] = $val['fixed_salary'] . ' p.a.';
                }
            } elseif ($val['salary_type'] == "Negotiable") {
                if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52) . ' p.a.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52) . ' p.a.';
                    } else {
                        $result[$i]['salary'] = (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']) . ' p.a.';
                    }
                } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = (string)$val['min_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . ' p.a.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = (string)($val['min_salary'] * 52) . ' p.a.';
                    } else {
                        $result[$i]['salary'] = (string)($val['min_salary']) . ' p.a.';
                    }
                } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = (string)$val['max_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = (string)($val['max_salary'] * 40 * 52) . ' p.a.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = (string)($val['max_salary'] * 52) . ' p.a.';
                    } else {
                        $result[$i]['salary'] = (string)($val['max_salary']) . ' p.a.';
                    }
                }
            }
            $i++;
        }

        $resultt = [];
        foreach ($result as $j) {
            $data = [];
            $locations = [];
            $educational_requirement = [];
            $skills = [];
            $positions = 0;
            $datetime1 = new \DateTime(date('Y-m-d', strtotime($j['created_on'])));
            $datetime2 = new \DateTime(date('Y-m-d'));

            $diff = $datetime1->diff($datetime2);
            $data['filling_soon'] = ($diff->days > 10) ? true : false;
            $data['application_enc_id'] = $j['employer_application_enc_id'];
            $data['name'] = $j['name'];
            $data['job_type'] = $j['job_type'];
            $data['logo'] = $j['logo'];
            $data['org_slug'] = $j['org_slug'];
            $data['title'] = $j['title'];
            $data['slug'] = $j['slug'];
            $data['last_date'] = $j['last_date'];
            $data['joining_date'] = $j['joining_date'];
            $data['designation'] = $j['designation'];
            $data['jobDescription'] = $j['employerApplicationEnc']['applicationJobDescriptions'];
            $data['salary'] = $j['salary'];
            if ($j['status'] != 'Active') {
                $data['is_closed'] = true;
            } else {
                $data['is_closed'] = false;
            }
            foreach ($j['employerApplicationEnc']['applicationPlacementLocations'] as $l) {
                if (!in_array($l['name'], $locations)) {
                    array_push($locations, $l['name']);
                    $positions += $l['positions'];
                }
            }

            foreach ($j['employerApplicationEnc']['applicationEducationalRequirements'] as $a) {
                array_push($educational_requirement, $a['educational_requirement']);
            }

            foreach ($j['employerApplicationEnc']['applicationSkills'] as $s) {
                array_push($skills, $s['skill']);
            }

            $data['is_exclusive'] = $this->__exclusiveJob($j['employer_application_enc_id']);
            $data['process'] = $j['employerApplicationEnc']['interviewProcessEnc']['interviewProcessFields'];
            $data['location'] = $locations ? implode(',', $locations) : 'Work From Home';
            $data['positions'] = $positions;
            $data['education'] = implode(',', $educational_requirement);
            $data['skills'] = implode(',', $skills);
            array_push($resultt, $data);
        }

        return $resultt;

    }

    private function __exclusiveJob($app_id)
    {
        $exclusive_job = ErexxEmployerApplications::find()
            ->alias('a')
            ->joinWith(['employerApplicationEnc b'])
            ->where(['a.employer_application_enc_id' => $app_id, 'b.for_all_colleges' => 0])
            ->count();

        if ($exclusive_job == 1) {
            return true;
        } else {
            return false;
        }
    }

}