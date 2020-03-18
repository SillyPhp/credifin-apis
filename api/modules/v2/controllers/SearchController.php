<?php

namespace api\modules\v2\controllers;

use common\models\ApplicationTypes;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
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
                'internships' =>['POST','OPTIONS']
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
                    $x->select(['b.organization_enc_id', 'b.name organization_name', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Internships" Then 1 END) as internships_count', 'count(CASE WHEN c.application_enc_id IS NOT NULL AND d.name = "Jobs" Then 1 END) as jobs_count', 'b.slug org_slug', 'e.business_activity', 'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END logo']);
                    $x->joinWith(['businessActivityEnc e'], false);
                    $x->joinWith(['employerApplications c' => function ($y) use ($college_id) {
                        $y->innerJoinWith(['erexxEmployerApplications f']);
                        $y->joinWith(['applicationTypeEnc d'], true);
                        $y->andWhere([
                            'c.status' => 'Active',
                            'c.is_deleted' => 0,
                            'f.college_enc_id' => $college_id['organization_enc_id']
                        ]);
                        $y->andWhere(['in', 'c.application_for', [0, 2]]);
                    }], false);
                }])
                ->where(['aa.college_enc_id' => $college_id, 'aa.organization_approvel' => 1, 'aa.college_approvel' => 1, 'aa.is_deleted' => 0]);

            if (isset($name) && !empty($name)) {
                $org->andWhere([
                    'or',
                    ['like', 'b.name', $name],
                    ['like', 'b.slug', $name],
                ]);
            }

            if (isset($page) && !empty($page)) {
                $org->limit = 1;
                $org->offset = ($page - 1) * 1;
            }

            $result = $org->asArray()->all();
            return $this->response(200, $result);
        }

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
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name parent_category',
                    'ee.name title',
                    'a.employer_application_enc_id',
                    'b.slug',
                    'm.fixed_wage as fixed_salary',
                    'm.wage_type salary_type',
                    'm.max_wage as max_salary',
                    'm.min_wage as min_salary',
                    'm.wage_duration as salary_duration',
                    'dd.designation',
                    'z.name job_type'
                ])
                ->joinWith(['employerApplicationEnc b' => function ($b) {
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
                        $f->groupBy(['f.placement_location_enc_id']);
                    }], true);
                    $b->joinWith(['applicationTypeEnc z']);
                }], true)
                ->where(['a.college_enc_id' => $college_id, 'a.is_deleted' => 0, 'a.status' => 'Active', 'a.is_college_approved' => 1]);
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
            if ($type) {
                $jobs->andWhere(['z.name' => $type]);
            }
            if (isset($options['limit'])) {
                $jobs->limit = $options['limit'];
                $jobs->offset = ($options['page'] - 1) * $options['limit'];
            }
            $result = $jobs->
            asArray()
                ->all();


            $i = 0;
            foreach ($result as $val) {
                $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
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
                $data['name'] = $j['name'];
                $data['job_type'] = $j['job_type'];
                $data['logo'] = $j['logo'];
                $data['org_slug'] = $j['org_slug'];
                $data['title'] = $j['title'];
                $data['slug'] = $j['slug'];
                $data['designation'] = $j['designation'];
                $data['salary'] = $j['salary'];
                foreach ($j['employerApplicationEnc']['applicationPlacementLocations'] as $l) {
                    array_push($locations, $l['name']);
                    $positions += $l['positions'];
                }

                foreach ($j['employerApplicationEnc']['applicationEducationalRequirements'] as $a) {
                    array_push($educational_requirement, $a['educational_requirement']);
                }

                foreach ($j['employerApplicationEnc']['applicationSkills'] as $s) {
                    array_push($skills, $s['skill']);
                }

                $data['process'] = $j['employerApplicationEnc']['interviewProcessEnc']['interviewProcessFields'];
                $data['location'] = implode(',', $locations);
                $data['positions'] = $positions;
                $data['education'] = implode(',', $educational_requirement);
                $data['skills'] = implode(',', $skills);
                array_push($resultt, $data);
            }

            return $resultt;
        }
    }
}