<?php


namespace api\modules\v2\controllers;


use api\modules\v1\models\Candidates;
use api\modules\v2\models\ProfilePicture;
use common\models\ApplicationEducationalRequirements;
use common\models\AppliedApplications;
use common\models\Cities;
use common\models\CollegeCourses;
use common\models\CollegeSections;
use common\models\CollegeSettings;
use common\models\ErexxEmployerApplications;
use common\models\OrganizationOtherDetails;
use common\models\Organizations;
use common\models\Teachers;
use common\models\User;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use common\models\Utilities;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;

class CollegeProfileController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-image' => ['POST', 'OPTIONS'],
                'upload-logo' => ['POST', 'OPTIONS'],
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

    public function actionOrgData()
    {
        if ($user = $this->isAuthorized()) {
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.name', 'b.phone', 'b.email', 'b.organization_enc_id college_id', 'c.code referral_code',
                    'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
                ->joinWith(['organizationEnc b' => function ($b) {
                    $b->joinWith(['referrals c'], false);
                }], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'detail' => $organizations]);
        }
    }

    public function actionFetchDetails()
    {
        if ($user = $this->isAuthorized()) {
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id', 'b.name', 'b.phone', 'b.email', 'b.website', 'b.description',
                    'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',
                    'c.affiliated_to', 'd.name city'])
                ->joinWith(['organizationEnc b' => function ($b) {
                    $b->joinWith(['organizationOtherDetails c' => function ($c) {
                        $c->joinWith(['locationEnc d']);
                    }]);
                }], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $courses = CollegeCourses::find()
                ->alias('a')
                ->select(['a.college_course_enc_id', 'a.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.college_course_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $organizations['organization_enc_id']])
                ->groupBy(['a.course_name'])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'detail' => $organizations, 'courses' => $courses]);
        } else {
            return $this->response(401);
        }
    }

    public function actionSaveDetail()
    {
        if ($user = $this->isAuthorized()) {
            $data = Yii::$app->request->post();
            $update_detail = Organizations::find()
                ->where(['organization_enc_id' => $data['org_enc_id']])
                ->one();

            if (!empty($update_detail)) {
                $update_detail->description = $data['description'];
                $update_detail->website = $data['website'];
                $update_detail->last_updated_on = date('Y-m-d H:i:s');
                $update_detail->last_updated_by = $user->user_enc_id;
                if ($update_detail->update()) {
                    if ($this->saveOtherDetails($data)) {
                        return $this->response(200, ['status' => 200]);
                    } else {
                        return false;
                    }
                }
            } else {
                return $this->response(404);
            }

        } else {
            return $this->response(401);
        }
    }

    private function saveOtherDetails($data)
    {
        $other_details = OrganizationOtherDetails::find()
            ->where(['organization_enc_id' => $data['org_enc_id']])
            ->one();

        if (!empty($other_details)) {
            $city_id = Cities::findone([
                'name' => $data['location']
            ]);

            $city_enc_id = $city_id->city_enc_id;

            $other_details->location_enc_id = $city_enc_id;
            $other_details->affiliated_to = $data['university'];
            if ($other_details->update()) {
                return true;
            }
        } else {
            $model = new OrganizationOtherDetails();
            $utilities = new Utilities();
            $utilities->variables['string'] = time() . rand(100, 100000);
            $model->organization_other_details_enc_id = $utilities->encrypt();
            $model->organization_enc_id = $data['org_enc_id'];
            $model->affiliated_to = $data['university'];
            $city_id = Cities::findone([
                'name' => $data['location']
            ]);

            $city_enc_id = $city_id->city_enc_id;
            $model->location_enc_id = $city_enc_id;
            if ($model->save()) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionUploadLogo()
    {
        if ($user = $this->isAuthorized()) {
            $pictureModel = new ProfilePicture();
            $pictureModel->profile_image = UploadedFile::getInstanceByName('profile_image');
            if ($pictureModel->profile_image && $pictureModel->validate()) {
                if ($org_id = $pictureModel->updateLogo()) {
                    $logo = Organizations::find()
                        ->select(['CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
                        ->where(['organization_enc_id' => $org_id])
                        ->asArray()
                        ->one();
                    return $this->response(200, ['status' => 200, 'logo' => $logo['logo']]);
                }
                return $this->response(500);
            } else {
                return $this->response(409);
            }
        } else {
            return $this->response(401);
        }
    }

    public function actionSaveCourse()
    {
        if ($user = $this->isAuthorized()) {

            $req = Yii::$app->request->post();
            $college_id = $this->getOrgId();

            if (!isset($req['course_duration']) && empty($req['course_duration'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            } elseif (!isset($req['type']) && empty($req['type'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            } elseif (!isset($req['course_name']) && empty($req['course_name'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $already_have = CollegeCourses::find()
                ->where(['organization_enc_id' => $college_id, 'course_name' => $req['course_name']])
                ->one();

            if (empty($already_have)) {

                $course = new CollegeCourses();
                $utilities = new Utilities();
                $utilities->variables['string'] = time() . rand(100, 100000);
                $course->college_course_enc_id = $utilities->encrypt();
                $course->organization_enc_id = $college_id;
                $course->course_name = $req['course_name'];
                $course->course_duration = (int)$req['course_duration'];
                $course->type = $req['type'];
                $course->created_by = $user->user_enc_id;
                $course->created_on = date('Y-m-d H:i:s');
                if ($course->save()) {

                    if ($req['sections']) {
                        foreach ($req['sections'] as $s) {
                            $sections = new CollegeSections();
                            $utilities = new Utilities();
                            $utilities->variables['string'] = time() . rand(100, 100000);
                            $sections->section_enc_id = $utilities->encrypt();
                            $sections->college_course_enc_id = $course->college_course_enc_id;
                            $sections->section_name = $s['value'];
                            $sections->created_by = $user->user_enc_id;
                            $sections->created_on = date('Y-m-d H:i:s');
                            $sections->save();
                        }
                    }

                    $courses = CollegeCourses::find()
                        ->alias('a')
                        ->select(['a.college_course_enc_id', 'a.course_name', 'a.course_duration', 'a.type'])
                        ->joinWith(['collegeSections b' => function ($b) {
                            $b->select(['b.college_course_enc_id', 'b.section_enc_id', 'b.section_name']);
                            $b->onCondition(['b.is_deleted' => 0]);
                        }])
                        ->where(['a.organization_enc_id' => $college_id])
                        ->groupBy(['a.course_name'])
                        ->asArray()
                        ->all();

                    return $this->response(200, ['status' => 200, 'courses' => $courses]);
                } else {
                    return $this->response(409, ['status' => 409, 'message' => 'There is an error']);
                }
            } else {
                return $this->response(409, ['status' => 409, 'message' => 'already added']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateCourse()
    {
        if ($user = $this->isAuthorized()) {
            $req = Yii::$app->request->post();
            $college_id = $this->getOrgId();

            $course = CollegeCourses::find()
                ->where(['college_course_enc_id' => $req['course_id']])
                ->one();

            $already_have = CollegeCourses::find()
                ->where(['organization_enc_id' => $college_id, 'course_name' => $req['course_name']])
                ->andWhere(['not', ['college_course_enc_id' => $req['course_id']]])
                ->one();

            if (empty($already_have)) {
                if (!empty($course)) {
                    $course->course_name = $req['course_name'];
                    $course->course_duration = $req['course_duration'];
                    $course->type = $req['type'];
                    $course->updated_by = $user->user_enc_id;
                    $course->updated_on = date('Y-m-d H:i:s');
                    if ($course->update()) {
                        $this->updateSections($req['sections'], $req['course_id'], $user->user_enc_id);
                        $courses = CollegeCourses::find()
                            ->alias('a')
                            ->select(['a.college_course_enc_id', 'a.course_name', 'a.course_duration', 'a.type'])
                            ->joinWith(['collegeSections b' => function ($b) {
                                $b->select(['b.college_course_enc_id', 'b.section_enc_id', 'b.section_name']);
                                $b->onCondition(['b.is_deleted' => 0]);
                            }])
                            ->where(['a.organization_enc_id' => $college_id])
                            ->groupBy(['a.course_name'])
                            ->asArray()
                            ->all();
                        return $this->response(200, ['status' => 200, 'courses' => $courses]);
                    } else {
                        return $this->response(409, ['status' => 409, 'message' => 'There is an error']);
                    }
                } else {
                    return $this->response(404);
                }
            } else {
                return $this->response(409, ['status' => 409, 'message' => 'already added']);
            }
        } else {
            return $this->response(401);
        }
    }

    private function updateSections($sections, $course_id, $user_id)
    {
        $clg_sections = CollegeSections::find()
            ->where(['college_course_enc_id' => $course_id, 'is_deleted' => 0])
            ->asArray()
            ->all();

        $old_sections = [];
        foreach ($clg_sections as $c) {
            array_push($old_sections, $c['section_enc_id']);
        }

        $new_sections = [];
        foreach ($sections as $s) {
            array_push($new_sections, $s['key']);
        }

        //check difference between sections
        $to_be_deleted_sections = array_diff($old_sections, $new_sections);

        $new_sections_to_add = [];
        foreach ($sections as $s) {
            if ($s['key'] == '') {
                array_push($new_sections_to_add, $s['value']);
            }
        }

//        to add new sections
        foreach ($new_sections_to_add as $s) {
            $sections = new CollegeSections();
            $utilities = new Utilities();
            $utilities->variables['string'] = time() . rand(100, 100000);
            $sections->section_enc_id = $utilities->encrypt();
            $sections->college_course_enc_id = $course_id;
            $sections->section_name = $s;
            $sections->created_by = $user_id;
            $sections->created_on = date('Y-m-d H:i:s');
            $sections->save();
        }

//        to delete old sections
        foreach ($to_be_deleted_sections as $s) {
            $section = CollegeSections::find()
                ->where(['section_enc_id' => $s])
                ->one();

            if ($section) {
                $section->is_deleted = 1;
                $section->update();
            }
        }

    }

    public function actionLatestJobs()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getOrgId();
            $limit = Yii::$app->request->post('limit');
            $type = Yii::$app->request->post('type');
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
                    'a.is_college_approved',
                    'b.slug',
                    'b.last_date',
                    'b.joining_date',
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
                            $z->groupBy(['ff.city_enc_id']);
                        }], false);
                        $f->onCondition(['f.is_deleted' => 0]);
                        $f->groupBy(['f.placement_location_enc_id']);
                    }], true);
                    $b->joinWith(['applicationTypeEnc z']);
                }], true)
                ->where([
                    'a.college_enc_id' => $college_id,
                    'a.is_deleted' => 0,
                    'b.is_deleted' => 0,
                    'bb.is_deleted' => 0,
                    'a.status' => 'Active',
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1
                ]);
            if ($type) {
                $jobs->andWhere(['z.name' => $type]);
            }
            if ($limit) {
                $jobs->limit($limit);
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

                $count = AppliedApplications::find()
                    ->alias('a')
                    ->select(['COUNT(a.applied_application_enc_id) count'])
                    ->innerJoinWith(['createdBy f' => function ($f) {
                        $f->innerJoinWith(['userOtherInfo g']);
                        $f->onCondition(['f.is_deleted' => 0]);
                    }], false)
                    ->where(['a.application_enc_id' => $j['employerApplicationEnc']['application_enc_id'], 'a.is_deleted' => 0])
                    ->asArray()
                    ->one();

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
                $data['is_college_approved'] = $j['is_college_approved'];
                $data['slug'] = $j['slug'];
                $data['last_date'] = $j['last_date'];
                $data['joining_date'] = $j['joining_date'];
                $data['designation'] = $j['designation'];
                $data['salary'] = $j['salary'];
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

                $data['process'] = $j['employerApplicationEnc']['interviewProcessEnc']['interviewProcessFields'];
                $data['location'] = implode(',', $locations);
                $data['positions'] = $positions;
                $data['education'] = implode(',', $educational_requirement);
                $data['skills'] = implode(',', $skills);
                $data['applied_count'] = $count['count'];
                array_push($resultt, $data);
            }

            return $this->response(200, ['status' => 200, 'jobs' => $resultt]);
        } else {
            return $this->response(401);
        }
    }

    public function actionApprovedJobs()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getOrgId();
            $limit = Yii::$app->request->post('limit');
            $type = Yii::$app->request->post('type');
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
                    'a.is_college_approved',
                    'b.slug',
                    'b.last_date',
                    'b.joining_date',
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
                ->where([
                    'a.college_enc_id' => $college_id,
                    'a.is_deleted' => 0,
                    'b.is_deleted' => 0,
                    'bb.is_deleted' => 0,
                    'a.status' => 'Active',
                    'a.is_college_approved' => 1,
                    'b.status' => 'Active',
                    'b.application_for' => [0, 2],
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1
                ]);
            if ($type) {
                $jobs->andWhere(['z.name' => $type]);
            }
            if ($limit) {
                $jobs->limit($limit);
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

                $count = AppliedApplications::find()
                    ->alias('a')
                    ->select(['COUNT(a.applied_application_enc_id) count'])
                    ->innerJoinWith(['createdBy f' => function ($f) {
                        $f->innerJoinWith(['userOtherInfo g']);
                        $f->onCondition(['f.is_deleted' => 0]);
                    }], false)
                    ->where(['a.application_enc_id' => $j['employerApplicationEnc']['application_enc_id'], 'a.is_deleted' => 0])
                    ->asArray()
                    ->one();

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
                $data['is_college_approved'] = $j['is_college_approved'];
                $data['slug'] = $j['slug'];
                $data['last_date'] = $j['last_date'];
                $data['joining_date'] = $j['joining_date'];
                $data['designation'] = $j['designation'];
                $data['salary'] = $j['salary'];
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

                $data['process'] = $j['employerApplicationEnc']['interviewProcessEnc']['interviewProcessFields'];
                $data['location'] = implode(',', $locations);
                $data['positions'] = $positions;
                $data['education'] = implode(',', $educational_requirement);
                $data['skills'] = implode(',', $skills);
                $data['applied_count'] = $count['count'];
                array_push($resultt, $data);
            }

            return $this->response(200, ['status' => 200, 'jobs' => $resultt]);
        } else {
            return $this->response(401);
        }
    }

    public function actionCandidatesProcess()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getOrgId();
            $param = Yii::$app->request->post();

            if (isset($param['slug']) && !empty($param['slug'])) {
                $slug = $param['slug'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $process = AppliedApplications::find()
                ->alias('a')
                ->select(['a.applied_application_enc_id', 'b.slug', 'c.name', 'a.status', 'f.user_enc_id',
                    'f.username, CONCAT(f.first_name, " ", f.last_name) name, CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) ELSE NULL END image',
                    'COUNT(CASE WHEN cc.is_completed = 1 THEN 1 END) as active',
                    'COUNT(cc.is_completed) total',
                    'gg.name title'])
                ->joinWith(['applicationEnc b' => function ($b) {
                    $b->joinWith(['organizationEnc c']);
                    $b->joinWith(['title ff' => function ($ff) {
                        $ff->joinWith(['parentEnc ii'], false);
                        $ff->joinWith(['categoryEnc gg'], false);
                    }], false);
                    $b->joinWith(['erexxEmployerApplications d']);
                }], false)
                ->joinWith(['appliedApplicationProcesses cc' => function ($cc) {
                    $cc->joinWith(['fieldEnc dd'], false);
                    $cc->select(['cc.applied_application_enc_id', 'cc.process_enc_id', 'cc.field_enc_id', 'dd.field_name','(CASE
                        WHEN dd.icon = "fa fa-sitemap" THEN "fas fa-sitemap"
                        WHEN dd.icon = "fa fa-phone" THEN "fas fa-phone"
                        WHEN dd.icon = "fa fa-user" THEN "fas fa-user"
                        WHEN dd.icon = "fa fa-cogs" THEN "fas fa-cogs"
                        WHEN dd.icon = "fa fa-user-circle" THEN "fas fa-user-circle"
                        WHEN dd.icon = "fa fa-users" THEN "fas fa-users"
                        WHEN dd.icon = "fa fa-video-camera" THEN "fas fa-video"
                        WHEN dd.icon = "fa fa-check" THEN "fas fa-check"
                        WHEN dd.icon = "fa fa-pencil-square-o" THEN "fas fa-pen-square"
                        WHEN dd.icon = "fa fa-envelope" THEN "fas fa-envelope"
                        WHEN dd.icon = "fa fa-question" THEN "fas fa-question"
                        WHEN dd.icon = "fa fa-paper-plane" THEN "fas fa-paper-plane"
                        ELSE "fas fa-plus"
                        END) as icon']);
                }])
                ->innerJoinWith(['createdBy f' => function ($f) {
                    $f->innerJoinWith(['userOtherInfo g']);
                    $f->onCondition(['f.is_deleted' => 0]);
                }], false)
                ->groupBy(['a.applied_application_enc_id'])
                ->where(['b.slug' => $slug, 'a.is_deleted' => 0, 'd.college_enc_id' => $college_id])
                ->asArray()
                ->all();

            $i = 0;
            foreach ($process as $p) {
                $user_data = Users::find()
                    ->alias('a')
                    ->select(['a.user_enc_id', 'GROUP_CONCAT(DISTINCT(b1.skill) SEPARATOR ",") skill', 'GROUP_CONCAT(DISTINCT(e1.industry) SEPARATOR ",") industry'])
                    ->joinWith(['userSkills b' => function ($b) {
                        $b->joinWith(['skillEnc b1'], false);
                        $b->onCondition(['b.is_deleted' => 0]);
                    }], false)
                    ->joinWith(['userWorkExperiences c' => function ($cc) {
                        $cc->select(['c.created_by', 'c.company', 'c.is_current', 'c.title']);
                    }])
                    ->joinWith(['userEducations d' => function ($d) {
                        $d->select(['d.user_enc_id', 'd.institute', 'd.degree']);
                    }])
                    ->joinWith(['userPreferredIndustries e' => function ($e) {
                        $e->joinWith(['industryEnc e1'], false);
                        $e->onCondition(['e.is_deleted' => 0]);
                    }], false)
                    ->where(['a.user_enc_id' => $p['user_enc_id']])
                    ->asArray()
                    ->one();


                if($user_data['skill'] != null) {
                    $user_data['skill'] = explode(',', $user_data['skill']);
                }
                $process[$i]['user_data'] = $user_data;
                $i++;
            }

            if ($process) {
                return $this->response(200, ['status' => 200, 'data' => $process]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'Not Found']);
            }
        }
    }

    public function actionTeacherCollegeDetail()
    {
        if ($user = $this->isAuthorized()) {
            $detail = Teachers::find()
                ->alias('a')
                ->select(['b.name', 'b.phone', 'b.email', 'b.organization_enc_id college_id', 'c.code referral_code',
                    'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
                ->joinWith(['collegeEnc b' => function ($b) {
                    $b->joinWith(['referrals c'], false);
                }], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            if ($detail) {
                return $this->response(200, ['status' => 200, 'data' => $detail]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unathorized']);
        }
    }


}