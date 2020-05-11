<?php


namespace api\modules\v2\controllers;


use api\modules\v1\models\Candidates;
use common\models\AppliedApplications;
use common\models\Cities;
use common\models\Countries;
use common\models\EmployeeBenefits;
use common\models\EmployerApplications;
use common\models\Utilities;
use common\models\ErexxEmployerApplications;
use common\models\FollowedOrganizations;
use common\models\Industries;
use common\models\OrganizationEmployeeBenefits;
use common\models\OrganizationEmployees;
use common\models\OrganizationImages;
use common\models\OrganizationLocations;
use common\models\Organizations;
use common\models\States;
use common\models\UserAccessTokens;
use common\models\UserOtherDetails;
use common\models\Users;
use yii\filters\auth\HttpBearerAuth;
use Yii;
use yii\helpers\Url;
use yii\filters\Cors;

class OrganizationsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'detail',
                'opportunities',
                'applied-users',
                'locations',
                'follow'],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'detail' => ['POST', 'OPTIONS'],
                'opportunities' => ['POST', 'OPTIONS'],
                'locations' => ['POST', 'OPTIONS'],
                'follow' => ['POST', 'OPTIONS'],
                'applied-users' => ['POST', 'OPTIONS'],

            ]
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

    private function getOrgId()
    {
        if ($user = $this->isAuthorized()) {
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id college_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();
            return $organizations['college_id'];
        } else {
            return $this->response(401);
        }
    }

    public function actionOpportunities()
    {
        $req = Yii::$app->request->post();
        if (isset($req['slug']) && !empty($req['slug'])) {
            $options['slug'] = $req['slug'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
        }

        if ($req['limit']) {
            $options['limit'] = $req['limit'];
        } else {
            $options['limit'] = 6;
        }

        if ($user = $this->isAuthorized()) {
            $user = Users::find()
                ->where(['user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            if ($user['organization_enc_id']) {
                $options['college_id'] = $user['organization_enc_id'];
                $options['type'] = 'Jobs';
                $jobs = $this->getJobs($options);
                $options['type'] = 'Internships';
                $internships = $this->getJobs($options);
            } else {
                $college_id = UserOtherDetails::find()
                    ->where(['user_enc_id' => $user['user_enc_id']])
                    ->asArray()
                    ->one();
                if (!empty($college_id)) {
                    $options['college_id'] = $college_id['organization_enc_id'];
                    $options['type'] = 'Jobs';
                    $jobs = $this->getJobs($options);
                    $options['type'] = 'Internships';
                    $internships = $this->getJobs($options);
                } else {
                    return $this->response(404, ['status' => 404, 'Message' => 'Not Found']);
                }
            }

            if (empty($jobs) && empty($internships)) {
                return $this->response(404, ['status' => 404, 'Message' => 'Not Found']);
            } else {
                return $this->response(200, ['status' => 200, 'jobs' => $jobs, 'internships' => $internships]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
    }

    public function getJobs($options)
    {
        $jobs = ErexxEmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->select([
                'bb.name',
                'bb.slug org_slug',
                'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
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
                'z.name job_type',
                '(CASE
                WHEN b.experience = "0" THEN "No Experience"
                WHEN b.experience = "1" THEN "Less Than 1 Year Experience"
                WHEN b.experience = "2" THEN "1 Year Experience"
                WHEN b.experience = "3" THEN "2-3 Years Experience"
                WHEN b.experience = "3-5" THEN "3-5 Years Experience"
                WHEN b.experience = "5-10" THEN "5-10 Years Experience"
                WHEN b.experience = "10-20" THEN "10-20 Years Experience"
                WHEN b.experience = "20+" THEN "More Than 20 Years Experience"
                ELSE "No Experience"
               END) as experience',
                'b.type'
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
            ->where(['a.college_enc_id' => $options['college_id'], 'bb.slug' => $options['slug'], 'a.is_deleted' => 0, 'a.status' => 'Active', 'a.is_college_approved' => 1]);
        if ($options['type']) {
            $jobs->andWhere(['z.name' => $options['type']]);
        }
        if ($options['limit']) {
            $jobs->limit($options['limit']);
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

        return $result;

    }

    public function actionLocations()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $req = Yii::$app->request->post();
        if (!empty($req['slug'])) {
            $result = [];

            $organization = Organizations::find()
                ->select(['organization_enc_id', 'name', 'email', 'tag_line', 'initials_color', 'establishment_year', 'description', 'mission', 'vision', 'value', 'website', 'phone', 'fax', 'facebook', 'google', 'twitter', 'linkedin', 'instagram', 'number_of_employees', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo', 'CASE WHEN cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, 'https') . '", cover_image_location, "/", cover_image) ELSE NULL END cover_image'])
                ->where(['slug' => $req['slug']])
                ->andWhere(['status' => 'Active'])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->one();

            if ($organization) {

                $organizationLocations = OrganizationLocations::find()
                    ->alias('a')
                    ->select(['a.location_enc_id', 'a.location_name', 'a.address', 'a.postal_code', 'a.latitude', 'a.longitude', 'b.name as city', 'c.name as state', 'd.name as country'])
                    ->innerJoin(Cities::tableName() . 'as b', 'b.city_enc_id = a.city_enc_id')
                    ->innerJoin(States::tableName() . 'as c', 'c.state_enc_id = b.state_enc_id')
                    ->innerJoin(Countries::tableName() . 'as d', 'd.country_enc_id = c.country_enc_id')
                    ->where(['a.organization_enc_id' => $organization['organization_enc_id'], 'a.status' => 'Active', 'a.is_deleted' => 0])
                    ->asArray()
                    ->all();
                $result['organization_locations'] = $organizationLocations;

                return $this->response(200, $result);
            } else {
                return $this->response(404);
            }
        } else {
            return $this->response(422);
        }
    }

    public function actionDetail()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $req = Yii::$app->request->post();
        if (!empty($req['slug'])) {
            $result = [];

            $organization = Organizations::find()
                ->select(['organization_enc_id', 'name', 'slug username', 'email', 'tag_line', 'initials_color', 'establishment_year', 'industry_enc_id', 'description', 'mission', 'vision', 'value', 'website', 'phone', 'fax', 'facebook', 'google', 'twitter', 'linkedin', 'instagram', 'number_of_employees', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo', 'CASE WHEN cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, 'https') . '", cover_image_location, "/", cover_image) ELSE NULL END cover_image'])
                ->where(['slug' => $req['slug']])
                ->andWhere(['status' => 'Active', 'has_placement_rights' => 1])
                ->andWhere(['is_deleted' => 0])
                ->asArray()
                ->one();

            if ($organization) {
                $result['organization'] = $organization;

                $benefit = OrganizationEmployeeBenefits::find()
                    ->alias('a')
                    ->select(['a.organization_benefit_enc_id', 'b.benefit', 'CASE WHEN b.icon IS NULL OR b.icon = "" THEN "' . Url::to('@commonAssets/employee-benefits/plus-icon.svg', 'https') . '" ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->benefits->icon, 'https') . '", b.icon_location, "/", b.icon) END icon'])
                    ->innerJoin(EmployeeBenefits::tableName() . 'as b', 'b.benefit_enc_id = a.benefit_enc_id')
                    ->where(['a.organization_enc_id' => $organization['organization_enc_id']])
                    ->andWhere(['a.is_deleted' => 0])
                    ->asArray()
                    ->all();
                $result['benefit'] = $benefit;

                $gallery = OrganizationImages::find()
                    ->select(['image_enc_id', 'CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->image, 'https') . '", image_location, "/",  image) image'])
                    ->where(['organization_enc_id' => $organization['organization_enc_id']])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->all();
                $result['gallery'] = $gallery;

                $team = OrganizationEmployees::find()
                    ->select(['first_name', 'last_name', 'designation', 'facebook', 'twitter', 'linkedin', 'employee_enc_id', 'CASE WHEN image IS NOT NULL OR image = "" THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->employees->image, 'https') . '", image_location, "/", image) ELSE NULL END image'])
                    ->where(['organization_enc_id' => $organization['organization_enc_id']])
                    ->andWhere(['is_deleted' => 0])
                    ->asArray()
                    ->all();
                $result['team'] = $team;

                $opportunities_count = EmployerApplications::find()
                    ->where(['organization_enc_id' => $organization['organization_enc_id'], 'is_deleted' => 0])
                    ->count();
                $result['opportunties_count'] = $opportunities_count;

                $industry = Industries::find()
                    ->select(['industry'])
                    ->where(['industry_enc_id' => $organization['industry_enc_id']])
                    ->asArray()
                    ->one();
                $result['industry'] = $industry['industry'];

                if (Yii::$app->request->headers->get('Authorization') && Yii::$app->request->headers->get('source')) {

                    $token_holder_id = UserAccessTokens::find()
                        ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
                        ->andWhere(['source' => Yii::$app->request->headers->get('source')])
                        ->one();

                    $user = Candidates::findOne([
                        'user_enc_id' => $token_holder_id->user_enc_id
                    ]);

                    if ($user) {
                        $follow = FollowedOrganizations::find()
                            ->select('followed')
                            ->where(['created_by' => $user->user_enc_id, 'organization_enc_id' => $organization['organization_enc_id']])
                            ->asArray()
                            ->one();
                        $result['follow'] = $follow['followed'];
                    }
                }

                return $this->response(200, $result);
            } else {
                return $this->response(404);
            }
        } else {
            return $this->response(422);
        }
    }

    public function actionFollow()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $req = Yii::$app->request->post();
        if (!empty($req['id'])) {
            $token_holder_id = UserAccessTokens::find()
                ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
                ->andWhere(['source' => Yii::$app->request->headers->get('source')])
                ->one();

            $user = Candidates::findOne([
                'user_enc_id' => $token_holder_id->user_enc_id
            ]);

            $chkuser = FollowedOrganizations::find()
                ->select('followed')
                ->where(['created_by' => $user->user_enc_id, 'organization_enc_id' => $req['id']])
                ->asArray()
                ->one();

            $status = $chkuser['followed'];

            if (empty($chkuser)) {
                $followed = new FollowedOrganizations();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $followed->followed_enc_id = $utilitiesModel->encrypt();
                $followed->organization_enc_id = $req['id'];
                $followed->user_enc_id = $user->user_enc_id;
                $followed->followed = 1;
                $followed->created_on = date('Y-m-d H:i:s');
                $followed->created_by = $user->user_enc_id;
                $followed->last_updated_on = date('Y-m-d H:i:s');
                $followed->last_updated_by = $user->user_enc_id;
                if ($followed->save()) {
                    return $this->response(200, ['status' => 200]);
                } else {
                    return $this->response(500);
                }
            } else if ($status == 1) {
                $update = Yii::$app->db->createCommand()
                    ->update(FollowedOrganizations::tableName(), ['followed' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $user->user_enc_id], ['created_by' => $user->user_enc_id, 'organization_enc_id' => $req['id']])
                    ->execute();
                if ($update == 1) {
                    return $this->response(200, ['status' => 201]);
                }
            } else if ($status == 0) {
                $update = Yii::$app->db->createCommand()
                    ->update(FollowedOrganizations::tableName(), ['followed' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $user->user_enc_id], ['created_by' => $user->user_enc_id, 'organization_enc_id' => $req['id']])
                    ->execute();
                if ($update == 1) {
                    return $this->response(200, ['status' => 200]);
                }
            }
        } else {
            return $this->response(422);
        }

    }

    public function actionAppliedUsers()
    {
        $req = Yii::$app->request->post();
        if (isset($req['slug']) && !empty($req['slug'])) {
            $slug = $req['slug'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
        }

        $college_id = $this->getOrgId();
        $applied = AppliedApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.applied_application_enc_id', 'f.first_name', 'f.last_name', 'a.status', 'e1.name title', 'e2.name parent_category', 'e3.designation', 'g.semester', 'g1.name department', 'f.username', 'e.slug org_slug',
                'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) ELSE NULL END image',
                'a.created_by student_id'])
            ->innerJoinWith(['applicationEnc b' => function ($b) {
                $b->innerJoinWith(['erexxEmployerApplications c' => function ($c) {
                    $c->innerJoinWith(['collegeEnc d']);
                }]);
                $b->innerJoinWith(['organizationEnc e']);
                $b->joinWith(['title ee' => function ($ee) {
                    $ee->joinWith(['categoryEnc e1']);
                    $ee->joinWith(['parentEnc e2']);
                }], false);
                $b->joinWith(['designationEnc e3'], false);
                $b->onCondition(['b.is_deleted' => 0]);
            }], false)
            ->innerJoinWith(['createdBy f' => function ($f) {
                $f->innerJoinWith(['userOtherInfo g' => function ($g) {
                    $g->joinWith(['departmentEnc g1']);
                }]);
                $f->onCondition(['f.is_deleted' => 0]);
            }], false)
            ->where(['d.organization_enc_id' => $college_id, 'e.slug' => $slug, 'a.is_deleted' => 0, 'e.is_deleted' => 0])
            ->andWhere(['e.has_placement_rights' => 1, 'g.college_actions' => 0])
            ->asArray()
            ->all();

        return $this->response(200, $applied);
    }
}