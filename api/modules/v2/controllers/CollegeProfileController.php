<?php


namespace api\modules\v2\controllers;


use api\modules\v1\models\Candidates;
use api\modules\v2\models\ProfilePicture;
use common\models\ApplicationEducationalRequirements;
use common\models\AppliedApplications;
use common\models\AssignedCollegeCourses;
use common\models\Cities;
use common\models\CollegeAdmissionDetail;
use common\models\CollegeCourses;
use common\models\CollegeCoursesPool;
use common\models\CollegeCutoff;
use common\models\CollegeFaculty;
use common\models\CollegeInfrastructure;
use common\models\CollegeInfrastructureDetail;
use common\models\CollegePlacementHighlights;
use common\models\CollegeRecruitmentByCourse;
use common\models\CollegeScholarships;
use common\models\CollegeSections;
use common\models\CollegeSettings;
use common\models\Departments;
use common\models\Designations;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\InterviewProcessFields;
use common\models\OrganizationOtherDetails;
use common\models\Organizations;
use common\models\ReferralReviewTracking;
use common\models\spaces\Spaces;
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
                'add-course-recruitment' => ['POST', 'OPTIONS'],
                'update-course-recruitment' => ['POST', 'OPTIONS'],
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

            $user_type = Users::find()
                ->where(['user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            if ($user_type['organization_enc_id']) {
                $organizations = Users::find()
                    ->alias('a')
                    ->select(['b.name', 'b.phone', 'b.email', 'b.organization_enc_id college_id', 'c.code referral_code',
                        'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
                    ->joinWith(['organizationEnc b' => function ($b) {
                        $b->joinWith(['referrals c'], false);
                    }], false)
                    ->where(['a.user_enc_id' => $user->user_enc_id])
                    ->asArray()
                    ->all();

                return $this->response(200, ['status' => 200, 'detail' => $organizations]);
            } else {
                $organizations = Users::find()
                    ->alias('a')
                    ->select(['b.name', 'b.phone', 'b.email', 'b.organization_enc_id college_id', 'c.code referral_code',
                        'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
                    ->joinWith(['teachers cc' => function ($cc) {
                        $cc->joinWith(['collegeEnc b' => function ($b) {
                            $b->joinWith(['referrals c'], false);
                        }], false);
                    }], false)
                    ->where(['a.user_enc_id' => $user->user_enc_id])
                    ->asArray()
                    ->all();

                return $this->response(200, ['status' => 200, 'detail' => $organizations]);
            }
        }
    }

    public function actionFetchDetails()
    {
        if ($user = $this->isAuthorized()) {
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id', 'b.name', 'b.phone', 'b.email', 'b.website', 'b.description',
                    'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',
                    'c.affiliated_to', 'd.name city'])
                ->joinWith(['organizationEnc b' => function ($b) {
                    $b->joinWith(['organizationOtherDetails c' => function ($c) {
                        $c->joinWith(['locationEnc d']);
                    }]);
                }], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();

            $courses = AssignedCollegeCourses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['courseEnc c'], false)
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $organizations['organization_enc_id'], 'a.is_deleted' => 0])
                ->orderBy(['c.course_name' => SORT_ASC])
                ->asArray()
                ->all();

            $streams = AssignedCollegeCourses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'c.course_name stream'])
                ->joinWith(['courseEnc c'], false)
                ->where(['a.organization_enc_id' => $organizations['organization_enc_id'], 'a.is_deleted' => 0, 'c.type' => 'Stream'])
                ->orderBy(['c.course_name' => SORT_ASC])
                ->asArray()
                ->all();

            return $this->response(200, ['status' => 200, 'detail' => $organizations, 'courses' => $courses, 'streams' => $streams]);
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
                        ->select(['CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
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

            $already_have = AssignedCollegeCourses::find()
                ->alias('a')
                ->joinWith(['courseEnc b'])
                ->where(['a.organization_enc_id' => $college_id, 'b.course_name' => $req['course_name'], 'a.is_deleted' => 0])
                ->one();

            if (empty($already_have)) {

                $college_course_id = CollegeCoursesPool::find()
                    ->where(['course_name' => $req['course_name']])
                    ->one();

                if (!$college_course_id->course_enc_id) {
                    $college_course_id = new CollegeCoursesPool();
                    $utilities = new Utilities();
                    $utilities->variables['string'] = time() . rand(100, 100000);
                    $college_course_id->course_enc_id = $utilities->encrypt();
                    $college_course_id->course_name = $req['course_name'];
                    $college_course_id->created_by = $user->user_enc_id;
                    $college_course_id->created_on = date('Y-m-d H:i:s');
                    if (!$college_course_id->save()) {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                }

                $course = new AssignedCollegeCourses();
                $utilities = new Utilities();
                $utilities->variables['string'] = time() . rand(100, 100000);
                $course->assigned_college_enc_id = $utilities->encrypt();
                $course->organization_enc_id = $college_id;
                $course->course_enc_id = $college_course_id->course_enc_id;
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
                            $sections->assigned_college_enc_id = $course->assigned_college_enc_id;
                            $sections->section_name = $s['value'];
                            $sections->created_by = $user->user_enc_id;
                            $sections->created_on = date('Y-m-d H:i:s');
                            $sections->save();
                        }
                    }

                    $courses = AssignedCollegeCourses::find()
                        ->distinct()
                        ->alias('a')
                        ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                        ->joinWith(['courseEnc c'], false)
                        ->joinWith(['collegeSections b' => function ($b) {
                            $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                            $b->onCondition(['b.is_deleted' => 0]);
                        }])
                        ->where(['a.organization_enc_id' => $college_id, 'a.is_deleted' => 0])
//                        ->groupBy(['b.course_name'])
                        ->asArray()
                        ->all();

                    return $this->response(200, ['status' => 200, 'courses' => $courses]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'There is an error']);
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

            $course = AssignedCollegeCourses::find()
                ->where(['assigned_college_enc_id' => $req['course_id']])
                ->one();

            $already_have = AssignedCollegeCourses::find()
                ->alias('a')
                ->joinWith(['courseEnc b'])
                ->where(['a.organization_enc_id' => $college_id, 'b.course_name' => $req['course_name'], 'a.is_deleted' => 0])
                ->andWhere(['not', ['a.assigned_college_enc_id' => $req['course_id']]])
                ->one();

            if (empty($already_have)) {
                if (!empty($course)) {

                    $college_course_id = CollegeCoursesPool::find()
                        ->where(['course_name' => $req['course_name']])
                        ->one();

                    if (!$college_course_id->course_enc_id) {
                        $college_course_id = new CollegeCoursesPool();
                        $utilities = new Utilities();
                        $utilities->variables['string'] = time() . rand(100, 100000);
                        $college_course_id->course_enc_id = $utilities->encrypt();
                        $college_course_id->course_name = $req['course_name'];
                        $college_course_id->created_by = $user->user_enc_id;
                        $college_course_id->created_on = date('Y-m-d H:i:s');
                        if (!$college_course_id->save()) {
                            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                        }
                    }

                    $course->course_enc_id = $college_course_id->course_enc_id;
                    $course->course_duration = $req['course_duration'];
                    $course->type = $req['type'];
                    $course->updated_by = $user->user_enc_id;
                    $course->updated_on = date('Y-m-d H:i:s');
                    if ($course->update()) {
                        $this->updateSections($req['sections'], $req['course_id'], $user->user_enc_id);
                        $courses = AssignedCollegeCourses::find()
                            ->distinct()
                            ->alias('a')
                            ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                            ->joinWith(['courseEnc c'], false)
                            ->joinWith(['collegeSections b' => function ($b) {
                                $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                                $b->onCondition(['b.is_deleted' => 0]);
                            }])
                            ->where(['a.organization_enc_id' => $college_id, 'a.is_deleted' => 0])
//                            ->groupBy(['a.course_name'])
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

    public function actionRemoveCourse()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getOrgId();
            $params = Yii::$app->request->post();
            if (isset($params['course_enc_id']) && !empty($params['course_enc_id'])) {
                $course_id = $params['course_enc_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $course = AssignedCollegeCourses::find()
                ->where(['assigned_college_enc_id' => $course_id])
                ->one();

            if ($course) {
                $course->is_deleted = 1;
                $course->updated_by = $user->user_enc_id;
                $course->updated_on = date('Y-m-d H:i:s');
                if ($course->update()) {
                    $courses = AssignedCollegeCourses::find()
                        ->distinct()
                        ->alias('a')
                        ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                        ->joinWith(['courseEnc c'], false)
                        ->joinWith(['collegeSections b' => function ($b) {
                            $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                            $b->onCondition(['b.is_deleted' => 0]);
                        }])
                        ->where(['a.organization_enc_id' => $college_id, 'a.is_deleted' => 0])
//                            ->groupBy(['a.course_name'])
                        ->asArray()
                        ->all();
                    return $this->response(200, ['status' => 200, 'courses' => $courses]);
//                    return $this->response(200, ['status' => 200, 'message' => 'deleted']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }

            return $this->response(200, ['status' => 200, 'message' => 'deleted']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetStreams()
    {
        $streams = CollegeCoursesPool::find()
            ->select(['course_enc_id', 'course_name stream'])
            ->where(['is_deleted' => 0, 'status' => 'Approved', 'type' => 'Stream'])
            ->asArray()
            ->all();

        if ($streams) {
            return $this->response(200, ['status' => 200, 'streams' => $streams]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionSaveStreams()
    {
        if ($user = $this->isAuthorized()) {

            $param = Yii::$app->request->post();
            $college_id = $this->getOrgId();

            if (!isset($param['course_enc_id']) && empty($param['course_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $already_exists = AssignedCollegeCourses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'c.course_name stream'])
                ->joinWith(['courseEnc c'], false)
                ->where(['a.organization_enc_id' => $college_id, 'a.is_deleted' => 0, 'c.type' => 'Stream', 'c.course_enc_id' => $param['course_enc_id']])
                ->asArray()
                ->one();

            if (!$already_exists) {

                $assigned = new AssignedCollegeCourses();
                $utilities = new Utilities();
                $utilities->variables['string'] = time() . rand(100, 100000);
                $assigned->assigned_college_enc_id = $utilities->encrypt();
                $assigned->organization_enc_id = $college_id;
                $assigned->course_enc_id = $param['course_enc_id'];
                $assigned->created_by = $user->user_enc_id;
                $assigned->created_on = date('Y-m-d H:i:s');
                if (!$assigned->save()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }

                $streams = AssignedCollegeCourses::find()
                    ->distinct()
                    ->alias('a')
                    ->select(['a.assigned_college_enc_id', 'c.course_name stream'])
                    ->joinWith(['courseEnc c'], false)
                    ->where(['a.organization_enc_id' => $college_id, 'a.is_deleted' => 0, 'c.type' => 'Stream'])
                    ->orderBy(['c.course_name' => SORT_ASC])
                    ->asArray()
                    ->all();

                return $this->response(200, ['status' => 200, 'message' => 'successfully added', 'streams' => $streams]);
            } else {
                return $this->response(409, ['status' => 409, 'message' => 'already exists']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveStream()
    {
        if ($user = $this->isAuthorized()) {
            $college_id = $this->getOrgId();
            $param = Yii::$app->request->post();
            if (!isset($param['course_enc_id']) && empty($param['course_enc_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $stream = AssignedCollegeCourses::find()
                ->where(['assigned_college_enc_id' => $param['course_enc_id']])
                ->one();

            if ($stream) {
                $stream->is_deleted = 1;
                $stream->updated_by = $user->user_enc_id;
                $stream->updated_on = date('Y-m-d H:i:s');
                if ($stream->update()) {
                    $streams = AssignedCollegeCourses::find()
                        ->distinct()
                        ->alias('a')
                        ->select(['a.assigned_college_enc_id', 'c.course_name stream'])
                        ->joinWith(['courseEnc c'], false)
                        ->where(['a.organization_enc_id' => $college_id, 'a.is_deleted' => 0, 'c.type' => 'Stream'])
                        ->orderBy(['c.course_name' => SORT_ASC])
                        ->asArray()
                        ->all();

                    return $this->response(200, ['status' => 200, 'streams' => $streams]);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            }

            return $this->response(200, ['status' => 200, 'message' => 'deleted']);

        } else {
            return $this->response(404, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function updateSections($sections, $course_id, $user_id)
    {
        $clg_sections = CollegeSections::find()
            ->where(['assigned_college_enc_id' => $course_id, 'is_deleted' => 0])
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
            $sections->assigned_college_enc_id = $course_id;
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

            $params = Yii::$app->request->post();

            $limit = Yii::$app->request->post('limit');
            $type = Yii::$app->request->post('type');

            $rejected_companies = ErexxCollaborators::find()
                ->select(['organization_enc_id'])
                ->where(['college_enc_id' => $college_id, 'is_deleted' => 1])
                ->asArray()
                ->all();

            $ids = [];
            foreach ($rejected_companies as $r) {
                array_push($ids, $r['organization_enc_id']);
            }

            $jobs = EmployerApplications::find()
                ->alias('a')
                ->distinct()
                ->select([
                    'a.application_enc_id',
                    'a.slug',
                    'a.status',
                    'a.last_date',
                    'a.joining_date',
                    'b.employer_application_enc_id',
                    'b.is_college_approved',
                    'y.interview_process_enc_id',
                    'bb.name',
                    'bb.organization_enc_id',
                    'bb.slug org_slug',
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=true&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name parent_category',
                    'ee.name title',
                    'm.fixed_wage as fixed_salary',
                    'm.wage_type salary_type',
                    'm.max_wage as max_salary',
                    'm.min_wage as min_salary',
                    'm.wage_duration as salary_duration',
                    'dd.designation',
                    'z.name job_type',
                    'b.is_deleted',
                    'm.positions',
                    'a.created_on'
                ])
                ->joinWith(['applicationJobDescriptions ii' => function ($x) {
                    $x->onCondition(['ii.is_deleted' => 0]);
                    $x->joinWith(['jobDescriptionEnc jj'], false);
                    $x->select(['ii.application_enc_id', 'jj.job_description_enc_id', 'jj.job_description']);
                }])
                ->joinWith(['erexxEmployerApplications b' => function ($b) use ($college_id) {
                    $b->onCondition(['b.college_enc_id' => $college_id, 'b.status' => 'Active']);
                }], false)
                ->joinWith(['organizationEnc bb'], false)
                ->joinWith(['interviewProcessEnc y' => function ($y) {
                    $y->select(['y.interview_process_enc_id']);
                    $y->joinWith(['interviewProcessFields yy' => function ($yy) {
                        $yy->select(['yy.interview_process_enc_id', 'yy.sequence', 'yy.field_name']);
                    }]);
                }])
                ->joinWith(['applicationEducationalRequirements bc' => function ($bc) {
                    $bc->select(['bc.application_enc_id', 'cb.educational_requirement']);
                    $bc->joinWith(['educationalRequirementEnc cb'], false);
                }])
                ->joinWith(['applicationSkills bbc' => function ($bbc) {
                    $bbc->select(['bbc.application_enc_id', 'skill']);
                    $bbc->joinWith(['skillEnc cbb'], false);
                }])
                ->joinWith(['designationEnc dd'], false)
                ->joinWith(['title d' => function ($d) {
                    $d->joinWith(['parentEnc e']);
                    $d->joinWith(['categoryEnc ee']);
                }], false)
                ->joinWith(['applicationOptions m'], false)
                ->joinWith(['applicationPlacementLocations f' => function ($f) {
                    $f->select(['f.application_enc_id', 'g.name', 'f.placement_location_enc_id', 'f.positions']);
                    $f->joinWith(['locationEnc ff' => function ($z) {
                        $z->joinWith(['cityEnc g']);
                    }], false);
                    $f->onCondition(['f.is_deleted' => 0]);
                }], true)
                ->joinWith(['applicationTypeEnc z'])
                ->joinWith(['applicationEmployeeBenefits za' => function ($za) {
                    $za->select(['za.application_benefit_enc_id',
                        'za.benefit_enc_id', 'za.application_enc_id',
                        'zb.benefit',
                        'CASE WHEN zb.icon IS NULL OR zb.icon = "" THEN "' . Url::to('@commonAssets/employee-benefits/plus-icon.svg', 'https') . '" ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->benefits->icon, 'https') . '", zb.icon_location, "/", zb.icon) END icon']);
                    $za->joinWith(['benefitEnc zb'], false);
                    $za->onCondition(['za.is_available' => 1, 'za.is_deleted' => 0]);
                }])
                ->joinWith(['appliedApplications zaa' => function ($zaa) use ($college_id) {
                    $zaa->select(['zaa.application_enc_id', 'zaa.applied_application_enc_id', 'fa.username', 'gg.organization_enc_id']);
                    $zaa->joinWith(['createdBy fa' => function ($f) use ($college_id) {
                        $f->joinWith(['userOtherInfo gg' => function ($gg) use ($college_id) {
                            $gg->onCondition(['gg.organization_enc_id' => $college_id, 'gg.is_deleted' => 0]);
                        }]);
                        $f->onCondition(['fa.is_deleted' => 0]);
                    }], false);
                    $zaa->onCondition(['zaa.is_deleted' => 0]);
                }], false)
                ->where([
                    'a.is_deleted' => 0,
//                    'a.status' => 'Active',
                    'z.name' => $type,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1,
                    'bb.is_deleted' => 0,
                    'bb.status' => 'Active',
                    'a.application_for' => 2,
                    'a.for_all_colleges' => 1,
                ])
//                ->andWhere(['or', 'a.for_all_colleges', 1])
                ->andWhere(['NOT', ['bb.organization_enc_id' => $ids]]);
            if (isset($params['slug']) && !empty($params['slug'])) {
                $jobs->andWhere(['bb.slug' => $params['slug']]);
            }
            if ($limit) {
                $jobs->limit($limit);
            }
            $result = $jobs
//                ->orderBy(['b.is_college_approved' => SORT_DESC])
                ->orderBy([new \yii\db\Expression('a.status = "Active" desc'), 'b.is_college_approved' => SORT_DESC, 'gg.organization_enc_id' => SORT_ASC])
                ->asArray()
                ->all();

            if ($type == 'Internships') {
                $i = 0;
                foreach ($result as $val) {
                    if ($val['salary_type'] == "Fixed") {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = $val['fixed_salary'] . ' p.m.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = $val['fixed_salary'] * 4 . ' p.m.';
                        }
                    } elseif ($val['salary_type'] == "Negotiable") {
                        if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                            if ($val['salary_duration'] == "Monthly") {
                                $result[$i]['salary'] = (string)$val['min_salary'] . " - ₹" . (string)$val['max_salary'] . ' p.m.';
                            } elseif ($val['salary_duration'] == "Weekly") {
                                $result[$i]['salary'] = (string)($val['min_salary'] * 4) . " - ₹" . (string)($val['max_salary'] * 4) . ' p.m.';
                            }
                        } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                            if ($val['salary_duration'] == "Monthly") {
                                $result[$i]['salary'] = (string)$val['min_salary'] . ' p.m.';
                            } elseif ($val['salary_duration'] == "Weekly") {
                                $result[$i]['salary'] = (string)($val['min_salary'] * 4) . ' p.m.';
                            }
                        } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                            if ($val['salary_duration'] == "Monthly") {
                                $result[$i]['salary'] = (string)$val['max_salary'] . ' p.m.';
                            } elseif ($val['salary_duration'] == "Weekly") {
                                $result[$i]['salary'] = (string)($val['max_salary'] * 4) . ' p.m.';
                            }
                        }
                    } elseif ($val['salary_type'] == "Performance Based") {
                        if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                            if ($val['salary_duration'] == "Monthly") {
                                $result[$i]['salary'] = (string)$val['min_salary'] . " - ₹" . (string)$val['max_salary'] . ' p.m.';
                            } elseif ($val['salary_duration'] == "Weekly") {
                                $result[$i]['salary'] = (string)($val['min_salary'] * 4) . " - ₹" . (string)($val['max_salary'] * 4) . ' p.m.';
                            }
                        } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                            if ($val['salary_duration'] == "Monthly") {
                                $result[$i]['salary'] = (string)$val['min_salary'] . ' p.m.';
                            } elseif ($val['salary_duration'] == "Weekly") {
                                $result[$i]['salary'] = (string)($val['min_salary'] * 4) . ' p.m.';
                            }
                        } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                            if ($val['salary_duration'] == "Monthly") {
                                $result[$i]['salary'] = (string)$val['max_salary'] . ' p.m.';
                            } elseif ($val['salary_duration'] == "Weekly") {
                                $result[$i]['salary'] = (string)($val['max_salary'] * 4) . ' p.m.';
                            }
                        }
                    } elseif ($val['salary_type'] == "Unpaid") {
                        $result[$i]['salary'] = 'Unpaid';
                    }
                    $i++;
                }
            } else {
                $i = 0;
                foreach ($result as $val) {
//                    $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
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
                    ->where(['a.application_enc_id' => $j['application_enc_id'], 'a.is_deleted' => 0,
                        'g.organization_enc_id' => $college_id, 'g.is_deleted' => 0])
                    ->asArray()
                    ->one();

                $datetime1 = new \DateTime(date('Y-m-d', strtotime($j['created_on'])));
                $datetime2 = new \DateTime(date('Y-m-d'));

                $diff = $datetime1->diff($datetime2);

                $data = [];
                $locations = [];
                $educational_requirement = [];
                $skills = [];
                $positions = 0;
                $data['filling_soon'] = ($diff->days > 10) ? true : false;
                $data['name'] = $j['name'];
                $data['application_enc_id'] = $j['application_enc_id'];
                $data['organization_enc_id'] = $j['organization_enc_id'];
                $data['is_deleted'] = $j['is_deleted'];
                $data['job_type'] = $j['job_type'];
                $data['logo'] = $j['logo'];
                $data['org_slug'] = $j['org_slug'];
                $data['title'] = $j['title'];
                $data['is_college_approved'] = $j['is_college_approved'];
                $data['slug'] = $j['slug'];
                $data['last_date'] = $j['last_date'];
                $data['joining_date'] = $j['joining_date'];
                $data['designation'] = $j['designation'];
                $data['benefits'] = $j['applicationEmployeeBenefits'];
                $data['jobDescription'] = $j['applicationJobDescriptions'];
                $data['salary'] = $j['salary'];
                $data['applied'] = $j['appliedApplications'];
                if ($j['status'] != 'Active') {
                    $data['is_closed'] = true;
                } else {
                    $data['is_closed'] = false;
                }
                foreach ($j['applicationPlacementLocations'] as $l) {
                    if (!in_array($l['name'], $locations)) {
                        array_push($locations, $l['name']);
                        $positions += $l['positions'];
                    }
                }

                $data['is_exclusive'] = $this->__exclusiveJob($j['application_enc_id']);
                foreach ($j['applicationEducationalRequirements'] as $a) {
                    array_push($educational_requirement, $a['educational_requirement']);
                }

                foreach ($j['applicationSkills'] as $s) {
                    array_push($skills, $s['skill']);
                }

                $data['process'] = $j['interviewProcessEnc']['interviewProcessFields'];
                $data['location'] = $locations ? implode(',', $locations) : 'Work From Home';
                $data['positions'] = $positions ? $positions : $j['positions'];
                $data['education'] = implode(', ', $educational_requirement);
                $data['skills'] = implode(', ', $skills);
                $data['applied_count'] = $count['count'];
                array_push($resultt, $data);
            }

            $data = [];
            $j = 0;
            foreach ($resultt as $r) {
                if ($r['is_deleted'] != 1) {
                    array_push($data, $resultt[$j]);
                }
                $j++;
            }

            return $this->response(200, ['status' => 200, 'jobs' => $data]);
        } else {
            return $this->response(401);
        }
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
                    'CASE WHEN bb.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", bb.logo_location, "/", bb.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", bb.name, "&size=200&rounded=false&background=", REPLACE(bb.initials_color, "#", ""), "&color=ffffff") END logo',
                    'e.name parent_category',
                    'ee.name title',
                    'a.employer_application_enc_id',
                    'a.is_college_approved',
                    'b.slug',
                    'b.status',
                    'b.last_date',
                    'b.joining_date',
                    'm.fixed_wage as fixed_salary',
                    'm.wage_type salary_type',
                    'm.max_wage as max_salary',
                    'm.min_wage as min_salary',
                    'm.wage_duration as salary_duration',
                    'dd.designation',
                    'z.name job_type',
                    'm.positions'
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
//                    'b.status' => 'Active',
                    'b.application_for' => 2,
                    'bb.is_erexx_approved' => 1,
                    'bb.has_placement_rights' => 1
                ]);
            if ($type) {
                $jobs->andWhere(['z.name' => $type]);
            }
            if ($limit) {
                $jobs->limit($limit);
            }
            $result = $jobs
                ->orderBy([new \yii\db\Expression('b.status = "Active" desc')])
                ->asArray()
                ->all();


            $i = 0;
            foreach ($result as $val) {
//                $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
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
            $total_applied_count = 0;
            $total_hired_count = 0;
            foreach ($result as $j) {

                $count = AppliedApplications::find()
                    ->alias('a')
                    ->select(['COUNT(a.applied_application_enc_id) count'])
                    ->innerJoinWith(['createdBy f' => function ($f) {
                        $f->innerJoinWith(['userOtherInfo g']);
                        $f->onCondition(['f.is_deleted' => 0]);
                    }], false)
                    ->where(['a.application_enc_id' => $j['employerApplicationEnc']['application_enc_id'],
                        'a.is_deleted' => 0, 'g.organization_enc_id' => $college_id,
                        'g.is_deleted' => 0
                    ])
                    ->asArray()
                    ->one();

                $data = [];
                $locations = [];
                $educational_requirement = [];
                $skills = [];
                $positions = 0;
                $datetime1 = new \DateTime(date('Y-m-d', strtotime($j['created_on'])));
                $datetime2 = new \DateTime(date('Y-m-d'));

                $diff = $datetime1->diff($datetime2);
                $data['filling_soon'] = ($diff->days > 10) ? true : false;
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

                $hired = EmployerApplications::find()
                    ->alias('a')
                    ->joinWith(['appliedApplications b' => function ($b) {
                        $b->joinWith(['createdBy c' => function ($c) {
                            $c->innerJoinWith(['userOtherInfo d']);
                        }]);
                    }], false)
                    ->where(['a.application_enc_id' => $j['application_enc_id'], 'd.organization_enc_id' => $this->getOrgId(), 'b.status' => 'Hired'])
                    ->asArray()
                    ->count();

                $data['is_exclusive'] = $this->__exclusiveJob($j['employer_application_enc_id']);
                $data['process'] = $j['employerApplicationEnc']['interviewProcessEnc']['interviewProcessFields'];
                $data['location'] = $locations ? implode(',', $locations) : 'Work From Home';
                $data['positions'] = $positions ? $positions : $j['positions'];
                $data['education'] = implode(',', $educational_requirement);
                $data['skills'] = implode(',', $skills);
                $data['applied_count'] = $count['count'];
                $total_applied_count += $count['count'];
                $total_hired_count += $hired;

                array_push($resultt, $data);
            }

            $count = [];
            $count['approved_count'] = $this->approvedJobsCount($type, $college_id);
            $count['pending_count'] = $this->pendingJobsCount($type, $college_id);
            $count['rejected_count'] = $this->rejectedJobsCount($type, $college_id);
            $count['total_applied_count'] = $total_applied_count;
            $count['total_hired_count'] = $total_hired_count;

            return $this->response(200, ['status' => 200, 'jobs' => $resultt, 'counts' => $count]);
        } else {
            return $this->response(401);
        }
    }

    private function approvedJobsCount($type, $college_id)
    {
        return ErexxEmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->joinWith(['employerApplicationEnc b' => function ($b) {
                $b->joinWith(['organizationEnc bb'], false);
                $b->joinWith(['applicationTypeEnc c']);
            }], false)
            ->where([
                'a.college_enc_id' => $college_id,
                'a.is_college_approved' => 1,
                'a.status' => 'Active',
                'a.is_deleted' => 0,
                'b.status' => 'Active',
                'b.application_for' => 2,
                'b.is_deleted' => 0,
                'bb.is_deleted' => 0,
                'bb.is_erexx_approved' => 1,
                'bb.has_placement_rights' => 1,
                'bb.status' => 'Active',
            ])
            ->andWhere(['c.name' => $type])
            ->count();
    }

    private function RejectedJobsCount($type, $college_id)
    {
        return ErexxEmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->joinWith(['employerApplicationEnc b' => function ($b) {
                $b->joinWith(['organizationEnc bb'], false);
                $b->joinWith(['applicationTypeEnc c']);
            }], false)
            ->where([
                'a.college_enc_id' => $college_id,
                'a.is_college_approved' => 1,
                'a.status' => 'Active',
                'a.is_deleted' => 1,
                'b.application_for' => 2,
                'b.is_deleted' => 0,
                'bb.is_deleted' => 0,
                'bb.is_erexx_approved' => 1,
                'bb.has_placement_rights' => 1
            ])
            ->andWhere(['c.name' => $type])
            ->count();
    }

    public function pendingJobsCount($type, $college_id)
    {

        $rejected_companies = ErexxCollaborators::find()
            ->select(['organization_enc_id'])
            ->where(['college_enc_id' => $college_id, 'is_deleted' => 1])
            ->asArray()
            ->all();

        $ids = [];
        foreach ($rejected_companies as $r) {
            array_push($ids, $r['organization_enc_id']);
        }

        $count = EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->select([
                'a.application_enc_id',
                'b.is_college_approved',
                'b.is_deleted'
            ])
            ->joinWith(['erexxEmployerApplications b' => function ($b) use ($college_id) {
                $b->onCondition(['b.college_enc_id' => $college_id]);
            }], false)
            ->joinWith(['organizationEnc bb'], false)
            ->joinWith(['interviewProcessEnc y' => function ($y) {
                $y->select(['y.interview_process_enc_id']);
                $y->joinWith(['interviewProcessFields yy' => function ($yy) {
                    $yy->select(['yy.interview_process_enc_id', 'yy.sequence', 'yy.field_name']);
                }]);
            }])
            ->joinWith(['applicationEducationalRequirements bc' => function ($bc) {
                $bc->select(['bc.application_enc_id', 'cb.educational_requirement']);
                $bc->joinWith(['educationalRequirementEnc cb'], false);
            }])
            ->joinWith(['applicationSkills bbc' => function ($bbc) {
                $bbc->select(['bbc.application_enc_id', 'skill']);
                $bbc->joinWith(['skillEnc cbb'], false);
            }])
            ->joinWith(['designationEnc dd'], false)
            ->joinWith(['title d' => function ($d) {
                $d->joinWith(['parentEnc e']);
                $d->joinWith(['categoryEnc ee']);
            }], false)
            ->joinWith(['applicationOptions m'], false)
            ->joinWith(['applicationPlacementLocations f' => function ($f) {
                $f->select(['f.application_enc_id', 'g.name', 'f.placement_location_enc_id', 'f.positions']);
                $f->joinWith(['locationEnc ff' => function ($z) {
                    $z->joinWith(['cityEnc g']);
                }], false);
                $f->onCondition(['f.is_deleted' => 0]);
            }], true)
            ->joinWith(['applicationTypeEnc z'])
            ->where([
                'a.is_deleted' => 0,
                'a.status' => 'Active',
                'z.name' => $type,
                'bb.is_erexx_approved' => 1,
                'bb.has_placement_rights' => 1,
                'bb.is_deleted' => 0,
                'bb.status' => 'Active',
                'a.application_for' => 2,
                'a.for_all_colleges' => 1,
            ])
            ->andWhere(['NOT', ['bb.organization_enc_id' => $ids]])
            ->asArray()
            ->all();

        $i = 0;
        $counts = [];
        foreach ($count as $c) {
            if ($c['is_deleted'] != 1) {
                if ($c['is_college_approved'] != 1) {
                    array_push($counts, $count[$i]);
                }
            }
            $i++;
        }

        return count($counts);
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

            $applied_user = AppliedApplications::find()
                ->alias('a')
                ->select(['a.applied_application_enc_id', 'b.slug', 'c.name', 'a.status', 'f.user_enc_id',
                    'f.username',
                    'CONCAT(f.first_name, " ", f.last_name) name', 'a.current_round',
                    'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(f.first_name, " ", f.last_name), "&size=200&rounded=false&background=", REPLACE(f.initials_color, "#", ""), "&color=ffffff") END image',
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
                    $cc->select(['cc.applied_application_enc_id', 'cc.process_enc_id', 'cc.field_enc_id', 'dd.sequence', 'dd.field_name', '(CASE
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
                ->joinWith(['candidateRejections j' => function ($j) {
                    $j->select(['j.candidate_rejection_enc_id',
                        'j.applied_application_enc_id',
                        'j.rejection_type',
                    ]);
                    $j->joinWith(['candidateRejectionReasons j1' => function ($j1) {
                        $j1->select(['j1.rejection_reasons_enc_id', 'j1.candidate_rejection_enc_id', 'j1.candidate_rejection_reasons_enc_id', 'j2.reason']);
                        $j1->joinWith(['rejectionReasonsEnc j2']);
                    }]);
                    $j->joinWith(['candidateConsiderJobs ccj' => function ($ccj) {
                        $ccj->select(['ccj.consider_job_enc_id', 'ccj.candidate_rejection_enc_id', 'ccj.application_enc_id']);
                        $ccj->joinWith(['applicationEnc ae' => function ($ae) {
                            $ae->select(['ae.application_enc_id', 'ae.slug', 'ccc.name job_title', 'pe.icon']);
                            $ae->joinWith(['title bae' => function ($bae) {
                                $bae->joinWith(['categoryEnc ccc'], false);
                                $bae->joinWith(['parentEnc pe'], false);
                            }], false);
                        }]);
                    }]);
                    $j->onCondition(['j.is_deleted' => 0]);
                }])
                ->groupBy(['a.applied_application_enc_id'])
                ->where(['b.slug' => $slug, 'a.is_deleted' => 0, 'd.college_enc_id' => $college_id, 'g.organization_enc_id' => $college_id])
                ->asArray()
                ->all();

            $process = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'b.field_enc_id', 'b.sequence', 'b.field_name', '(CASE
                        WHEN b.icon = "fa fa-sitemap" THEN "fas fa-sitemap"
                        WHEN b.icon = "fa fa-phone" THEN "fas fa-phone"
                        WHEN b.icon = "fa fa-user" THEN "fas fa-user"
                        WHEN b.icon = "fa fa-cogs" THEN "fas fa-cogs"
                        WHEN b.icon = "fa fa-user-circle" THEN "fas fa-user-circle"
                        WHEN b.icon = "fa fa-users" THEN "fas fa-users"
                        WHEN b.icon = "fa fa-video-camera" THEN "fas fa-video"
                        WHEN b.icon = "fa fa-check" THEN "fas fa-check"
                        WHEN b.icon = "fa fa-pencil-square-o" THEN "fas fa-pen-square"
                        WHEN b.icon = "fa fa-envelope" THEN "fas fa-envelope"
                        WHEN b.icon = "fa fa-question" THEN "fas fa-question"
                        WHEN b.icon = "fa fa-paper-plane" THEN "fas fa-paper-plane"
                        ELSE "fas fa-plus"
                        END) as icon'])
                ->where(['a.slug' => $slug])
                ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.interview_process_enc_id = a.interview_process_enc_id')
                ->asArray()
                ->all();

            $application_detail = EmployerApplications::find()
                ->alias('a')
                ->select(['c.name job_title', 'a.slug', 'a.status', 'a.application_enc_id', 'a.interview_process_enc_id', 'ate.name application_type', 'pe.icon',
                    '(CASE
                WHEN a.experience = "0" THEN "No Experience"
                WHEN a.experience = "1" THEN "Less Than 1 Year"
                WHEN a.experience = "2" THEN "1 Year"
                WHEN a.experience = "3" THEN "2-3 Years"
                WHEN a.experience = "3-5" THEN "3-5 Years"
                WHEN a.experience = "5-10" THEN "5-10 Years"
                WHEN a.experience = "10-20" THEN "10-20 Years"
                WHEN a.experience = "20+" THEN "More Than 20 Years"
                WHEN a.minimum_exp = "0" AND a.maximum_exp IS NUll THEN "No Experience"
                WHEN a.minimum_exp = "20" AND a.maximum_exp = "20+" THEN "More Than 20 Years Experience"
                WHEN a.minimum_exp IS NOT NUll AND a.maximum_exp IS NOT NUll THEN CONCAT(a.minimum_exp,"-",a.maximum_exp," Years Experience")
                WHEN a.minimum_exp IS NOT NUll AND a.maximum_exp IS NUll THEN CONCAT("Minimum ",a.minimum_exp," Years Experience") 
                WHEN a.minimum_exp IS NUll AND a.maximum_exp IS NOT NUll THEN CONCAT("Maximum ",a.maximum_exp," Years Experience") 
                ELSE "No Experience" 
                END) as experience', 'ao.wage_type', 'ao.fixed_wage', 'ao.min_wage', 'ao.max_wage', 'ao.wage_duration', 'ao.positions'])
                ->where(['a.slug' => $slug])
                ->joinWith(['title b' => function ($b) {
                    $b->joinWith(['categoryEnc c'], false, 'INNER JOIN');
                    $b->joinWith(['parentEnc pe'], false, 'INNER JOIN');
                }], false, 'INNER JOIN')
                ->joinWith(['applicationTypeEnc ate'], false)
                ->joinWith(['applicationPlacementLocations o' => function ($b) {
                    $b->onCondition(['o.is_deleted' => 0]);
                    $b->joinWith(['locationEnc s' => function ($b) {
                        $b->joinWith(['cityEnc t'], false);
                    }], false);
                    $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 's.latitude', 's.longitude', 't.city_enc_id', 't.name']);
                    $b->distinct();
                }])
                ->joinWith(['applicationOptions ao'], false)
                ->asArray()
                ->one();

            if ($application_detail) {
                if ($application_detail['status'] != 'Active') {
                    $application_detail['is_closed'] = true;
                } else {
                    $application_detail['is_closed'] = false;
                }

                $locations = [];
                $positions = 0;
                if ($application_detail['applicationPlacementLocations']) {
                    foreach ($application_detail['applicationPlacementLocations'] as $l) {
                        if (!in_array($l['name'], $locations)) {
                            array_push($locations, $l['name']);
                            $positions += $l['positions'];
                        }
                    }
                }

                if ($application_detail['wage_type'] == 'Fixed') {
                    if ($application_detail['wage_duration'] == 'Monthly') {
                        $application_detail['fixed_wage'] = $application_detail['fixed_wage'] * 12;
                    } elseif ($application_detail['wage_duration'] == 'Hourly') {
                        $application_detail['fixed_wage'] = $application_detail['fixed_wage'] * 40 * 52;
                    } elseif ($application_detail['wage_duration'] == 'Weekly') {
                        $application_detail['fixed_wage'] = $application_detail['fixed_wage'] * 52;
                    }
                    setlocale(LC_MONETARY, 'en_IN');
                    $application_detail['amount'] = '₹' . utf8_encode(money_format('%!.0n', $application_detail['fixed_wage'])) . 'p.a.';
                } else if ($application_detail['wage_type'] == 'Negotiable') {
                    if ($application_detail['wage_duration'] == 'Monthly') {
                        $application_detail['min_wage'] = $application_detail['min_wage'] * 12;
                        $application_detail['max_wage'] = $application_detail['max_wage'] * 12;
                    } elseif ($application_detail['wage_duration'] == 'Hourly') {
                        $application_detail['min_wage'] = $application_detail['min_wage'] * 40 * 52;
                        $application_detail['max_wage'] = $application_detail['max_wage'] * 40 * 52;
                    } elseif ($application_detail['wage_duration'] == 'Weekly') {
                        $application_detail['min_wage'] = $application_detail['min_wage'] * 52;
                        $application_detail['max_wage'] = $application_detail['max_wage'] * 52;
                    }
                    setlocale(LC_MONETARY, 'en_IN');
                    if (!empty($application_detail['min_wage']) && !empty($application_detail['max_wage'])) {
                        $application_detail['amount'] = '₹' . utf8_encode(money_format('%!.0n', $application_detail['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $application_detail['max_wage'])) . 'p.a.';
                    } elseif (!empty($application_detail['min_wage'])) {
                        $application_detail['amount'] = 'From ₹' . utf8_encode(money_format('%!.0n', $application_detail['min_wage'])) . 'p.a.';
                    } elseif (!empty($application_detail['max_wage'])) {
                        $application_detail['amount'] = 'Upto ₹' . utf8_encode(money_format('%!.0n', $application_detail['max_wage'])) . 'p.a.';
                    } elseif (empty($application_detail['min_wage']) && empty($application_detail['max_wage'])) {
                        $application_detail['amount'] = 'Negotiable';
                    }
                }

                $application_detail['locations'] = $locations;
                $application_detail['positions'] = $positions ? $positions : $application_detail['positions'];
                $application_detail['icon'] = Url::to('@commonAssets/categories/' . $application_detail['icon'], 'https');
            }

            if ($process) {
                foreach ($process as $k => $v) {
                    $process[$k]['count'] = 0;
                }
            }

            $h_count = 0;
            $i = 0;
            foreach ($applied_user as $p) {
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

                foreach ($process as $k => $v) {
                    if ($v['sequence'] == $p['current_round']) {
                        $process[$k]['count'] += 1;
                    }
                }

                if ($p['status'] == 'Hired') {
                    $h_count += 1;
                }


                if ($user_data['skill'] != null) {
                    $user_data['skill'] = explode(',', $user_data['skill']);
                }
                $applied_user[$i]['user_data'] = $user_data;
                $i++;
            }

            if ($applied_user) {
                return $this->response(200, ['status' => 200, 'data' => $applied_user, 'process' => $process, 'hired_count' => $h_count, 'total_count' => count($applied_user), 'application_detail' => $application_detail]);
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
                    'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
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

    public function actionSaveInfo()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $org_other_detail = OrganizationOtherDetails::find()
                ->where(['organization_enc_id' => $this->getOrgId()])
                ->one();

            $org = Organizations::find()
                ->where(['organization_enc_id' => $this->getOrgId()])
                ->one();

            if ($org) {
                if (isset($params['description']) || isset($params['website'])) {
                    $org->description = $params['description'] ? $params['description'] : $org->description;
                    $org->website = $params['website'] ? $params['website'] : $org->website;
                    if (!$org->update()) {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                }
            }

            if (!$org_other_detail) {
                $org_other_detail = new OrganizationOtherDetails();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $org_other_detail->organization_other_details_enc_id = $utilitiesModel->encrypt();
                $org_other_detail->organization_enc_id = $this->getOrgId();
                $org_other_detail->affiliated_to = $params['affiliated_to'];
                $org_other_detail->accredited_to = $params['accredited_to'];
                $org_other_detail->entrance_exam = $params['entrance_exam'];
                $org_other_detail->total_programs = $params['total_programs'];
                $org_other_detail->popular_course = $params['popular_course'];
                $org_other_detail->top_recruiter = $params['top_recruiter'];
                $org_other_detail->brochure = $params['brochure'];
                $org_other_detail->established_in = $params['established_in'];
                $org_other_detail->university_type = $params['university_type'];
                $org_other_detail->application_mode = $params['application_mode'];
                $org_other_detail->fees = $params['fees'];
                $org_other_detail->updated_on = date('Y-m-d H:i:s');
                if (!$org_other_detail->save()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
            }

            $org_other_detail->affiliated_to = $params['affiliated_to'] ? $params['affiliated_to'] : $org_other_detail->affiliated_to;
            $org_other_detail->accredited_to = $params['accredited_to'] ? $params['accredited_to'] : $org_other_detail->accredited_to;
            $org_other_detail->entrance_exam = $params['entrance_exam'] ? $params['entrance_exam'] : $org_other_detail->entrance_exam;
            $org_other_detail->total_programs = $params['total_programs'] ? $params['total_programs'] : $org_other_detail->total_programs;
            $org_other_detail->popular_course = $params['popular_course'] ? $params['popular_course'] : $org_other_detail->popular_course;
            $org_other_detail->top_recruiter = $params['top_recruiter'] ? $params['top_recruiter'] : $org_other_detail->top_recruiter;
            $org_other_detail->brochure = $params['brochure'] ? $params['brochure'] : $org_other_detail->brochure;
            $org_other_detail->established_in = $params['established_in'] ? $params['established_in'] : $org_other_detail->established_in;
            $org_other_detail->university_type = $params['university_type'] ? $params['university_type'] : $org_other_detail->university_type;
            $org_other_detail->application_mode = $params['application_mode'] ? $params['application_mode'] : $org_other_detail->application_mode;
            $org_other_detail->fees = $params['fees'] ? $params['fees'] : $org_other_detail->fees;
            $org_other_detail->updated_on = date('Y-m-d H:i:s');
            if (!$org_other_detail->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
        }
        return $this->response(401, ['status' => 401, 'unauthorized']);
    }

    public function actionGetInfo()
    {
        if ($user = $this->isAuthorized()) {

            $info = OrganizationOtherDetails::find()
                ->alias('a')
                ->select(['a.organization_other_details_enc_id', 'a.organization_enc_id',
                    'a.total_programs', 'a.established_in', 'a.application_mode', 'a.affiliated_to', 'a.accredited_to',
                    'a.entrance_exam', 'a.popular_course', 'a.top_recruiter', 'a.brochure', 'a.university_type',
                    'b.description', 'b.website'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.organization_enc_id' => $this->getOrgId()])
                ->asArray()
                ->one();

            if ($info) {
                return $this->response(200, ['status' => 200, 'org_info' => $info]);
            }

            return $this->response(404, ['status' => 401, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionSaveScholarships()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $scholarship = new CollegeScholarships();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $scholarship->college_scholarship_enc_id = $utilitiesModel->encrypt();
            $scholarship->college_enc_id = $this->getOrgId();
            $scholarship->title = $params['title'];
            $scholarship->amount = $params['amount'];
            $scholarship->detail = $params['detail'];
            $scholarship->apply_link = $params['apply_link'];
            $scholarship->created_by = $user->user_enc_id;
            $scholarship->created_on = date('Y-m-d H:i:s');
            if (!$scholarship->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateScholarships()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (isset($params['scholarship_id']) && !empty($params['scholarship_id'])) {
                $scholarship = CollegeScholarships::findOne(['college_scholarship_enc_id' => $params['scholarship_id']]);

                if ($scholarship) {
                    $scholarship->title = $params['title'];
                    $scholarship->amount = $params['amount'];
                    $scholarship->detail = $params['detail'];
                    $scholarship->apply_link = $params['apply_link'];
                    $scholarship->updated_by = $user->user_enc_id;
                    $scholarship->updated_on = date('Y-m-d H:i:s');
                    if (!$scholarship->update()) {
                        return $this->response(500, ['status' => 500, 'error' => $scholarship->getErrors()]);
                    }

                    return $this->response(200, ['status' => 200, 'message' => 'updated']);
                }

                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

            return $this->response(422, ['status' => 422, 'message' => 'missing information "scholarship_id"']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetScholarships()
    {
        if ($user = $this->isAuthorized()) {

            $scholarship = CollegeScholarships::find()
                ->select(['college_scholarship_enc_id', 'title', 'amount', 'detail', 'apply_link'])
                ->where(['college_enc_id' => $this->getOrgId(), 'is_deleted' => 0])
                ->asArray()
                ->all();

            if ($scholarship) {
                return $this->response(200, ['status' => 200, 'scholarships' => $scholarship]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveScholarships()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['scholarship_id']) || empty($params['scholarship_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "scholarship_id"']);
            }

            $scholarships = CollegeScholarships::findOne(['college_scholarship_enc_id' => $params['scholarship_id'], 'is_deleted' => 0]);

            if ($scholarships) {
                $scholarships->is_deleted = 1;
                $scholarships->updated_by = $user->user_enc_id;
                $scholarships->updated_on = date('Y-m-d H:i:s');
                if (!$scholarships->update()) {
                    return $this->response(500, ['status' => 500, 'error' => $scholarships->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'removed']);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionSaveCutoff()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $cutoff = CollegeCutoff::findOne(['assgined_course_enc_id' => $params['course_id'], 'college_enc_id' => $this->getOrgId()]);

            if ($cutoff) {
                $cutoff->general = $params['general'];
                $cutoff->obc = $params['obc'];
                $cutoff->sc = $params['sc'];
                $cutoff->st = $params['st'];
                $cutoff->pwd = $params['pwd'];
                $cutoff->ews = $params['ews'];
                $cutoff->mode = $params['mode'];
                $cutoff->last_updated_by = $user->user_enc_id;
                $cutoff->last_updated_on = date('Y-m-d H:i:s');
                if (!$cutoff->update()) {
                    return $this->response(500, $cutoff->getErrors());
                }

                return $this->response(200, ['status' => 200, 'successfully updated']);
            }

            $cutoff = new CollegeCutoff();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $cutoff->college_cut_off_enc_id = $utilitiesModel->encrypt();
            $cutoff->assgined_course_enc_id = $params['course_id'];
            $cutoff->college_enc_id = $this->getOrgId();
            $cutoff->general = $params['general'];
            $cutoff->obc = $params['obc'];
            $cutoff->sc = $params['sc'];
            $cutoff->st = $params['st'];
            $cutoff->pwd = $params['pwd'];
            $cutoff->ews = $params['ews'];
            $cutoff->created_by = $user->user_enc_id;
            $cutoff->created_on = date('Y-m-d H:i:s');
            if (!$cutoff->save()) {
                print_r($cutoff->getErrors());
                die();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionCutoffList()
    {
        if ($user = $this->isAuthorized()) {

            $college_id = $this->getOrgId();

            $cutoffs = CollegeCutoff::find()
                ->alias('a')
                ->select(['a.college_cut_off_enc_id', 'a.assgined_course_enc_id', 'c.course_name', 'a.college_enc_id', 'a.general', 'a.obc',
                    'a.sc', 'a.st', 'a.pwd', 'a.ews', 'a.mode'])
                ->joinWith(['assginedCourseEnc b' => function ($b) {
                    $b->joinWith(['courseEnc c']);
                }], false)
                ->where(['a.is_deleted' => 0, 'a.college_enc_id' => $college_id])
                ->asArray()
                ->all();

            if ($cutoffs) {
                return $this->response(200, ['status' => 200, 'cutoff' => $cutoffs]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveCutoff()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['cutoff_id']) || empty($params['cutoff_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "cutoff_id"']);
            }

            $cutoff = CollegeCutoff::findOne(['college_cut_off_enc_id' => $params['cutoff_id'], 'is_deleted' => 0]);

            if ($cutoff) {

                $cutoff->is_deleted = 1;
                $cutoff->last_updated_by = $user->user_enc_id;
                $cutoff->last_updated_on = date('Y-m-d H:i:s');
                if (!$cutoff->update()) {
                    return $this->response(500, ['status' => 500, 'error' => $cutoff->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'removed']);

            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddFaculty()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

//            $image = UploadedFile::getInstanceByName('image');

            // this is for update
            if (isset($params['faculty_id']) && !empty($params['faculty_id'])) {
                $faculty = CollegeFaculty::findOne(['college_faculty_enc_id' => $params['faculty_id'], 'is_deleted' => 0]);

                if (!$faculty) {
                    return $this->response(404, ['status' => 404, 'message' => 'not found']);
                }

                $faculty->last_updated_by = $user->user_enc_id;
                $faculty->last_updated_on = date('Y-m-d H:i:s');

            } else {

                $faculty = new CollegeFaculty();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $faculty->college_faculty_enc_id = $utilitiesModel->encrypt();
                $faculty->college_enc_id = $this->getOrgId();
                $faculty->created_by = $user->user_enc_id;
                $faculty->created_on = date('Y-m-d H:i:s');

            }

            $faculty->faculty_name = $params['name'];
            $faculty->designation_enc_id = $this->saveDesignation($params['designation']);
            $faculty->department_enc_id = $this->saveDepartment($params['department']);
            $faculty->experience = $params['experience'];

            if (isset($params['image']) && !empty($params['image']) && $params['image'] != '') {

                $image = base64_decode($params['image']);

                $faculty->image_location = \Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->collegeProfile->faculty_image . $faculty->image_location . '/';

                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $encrypted_string = $utilitiesModel->encrypt();
                if (substr($encrypted_string, -1) == '.') {
                    $encrypted_string = substr($encrypted_string, 0, -1);
                }

                $faculty->image = $encrypted_string . '.png';
                $file = dirname(__DIR__, 4) . '/files/temp/' . $user->image;
                if (file_put_contents($file, $image)) {
                    $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                    $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                    $result = $my_space->uploadFile($file, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $faculty->image, "public");
                    if (file_exists($file)) {
                        unlink($file);
                    }
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'file put error']);
                }
            }

            if (isset($params['faculty_id']) && !empty($params['faculty_id'])) {
                if (!$faculty->update()) {
                    return $this->response(500, ['status' => 500, 'error' => $faculty->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
            } else {

                if (!$faculty->save()) {
                    return $this->response(500, ['status' => 500, 'error' => $faculty->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionFacultyList()
    {
        if ($user = $this->isAuthorized()) {

            $faculty = CollegeFaculty::find()
                ->alias('a')
                ->select(['a.college_faculty_enc_id', 'a.faculty_name', 'a.experience', 'b.designation', 'c.name department',
                    'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->collegeProfile->faculty_image, 'https') . '", a.image_location, "/", a.image) ELSE NULL END image'])
                ->joinWith(['designationEnc b'], false)
                ->joinWith(['departmentEnc c'], false)
                ->where(['a.is_deleted' => 0, 'a.college_enc_id' => $this->getOrgId()])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();

            if ($faculty) {
                return $this->response(200, ['status' => 200, 'faculty_list' => $faculty]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveFaculty()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['faculty_id']) || empty($params['faculty_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "faculty_id"']);
            }

            $faculty = CollegeFaculty::findOne(['college_faculty_enc_id' => $params['faculty_id']]);

            if ($faculty) {
                $faculty->is_deleted = 1;
                $faculty->last_updated_by = $user->user_enc_id;
                $faculty->last_updated_on = date('Y-m-d H:i:s');
                if (!$faculty->update()) {
                    return $this->response(500, ['status' => 500, 'error' => $faculty->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'removed']);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    private function saveDesignation($designation)
    {
        $user = $this->isAuthorized();

        $desi = Designations::find()
            ->where(['designation' => $designation, 'is_deleted' => 0])
            ->one();

        if ($desi) {
            return $desi->designation_enc_id;
        }

        $desigModel = new Designations;
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $desigModel->designation_enc_id = $utilitiesModel->encrypt();
        $utilitiesModel->variables['name'] = $designation;
        $utilitiesModel->variables['table_name'] = Designations::tableName();
        $utilitiesModel->variables['field_name'] = 'slug';
        $desigModel->slug = $utilitiesModel->create_slug();
        $desigModel->designation = $designation;
        $desigModel->organization_enc_id = $this->getOrgId();
        $desigModel->created_on = date('Y-m-d H:i:s');
        $desigModel->created_by = $user->user_enc_id;
        if ($desigModel->save()) {
            return $desigModel->designation_enc_id;
        }
        return false;
    }

    private function saveDepartment($departmentt)
    {

        $department = Departments::findOne(['name' => $departmentt]);

        if ($department) {
            return $department->department_enc_id;
        }

        $department = new Departments();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $department->department_enc_id = $utilitiesModel->encrypt();
        $department->name = $departmentt;
        if (!$department->save()) {
            print_r($department->getErrors());
            die();
            return false;
        }

        return $department->department_enc_id;
    }

    public function actionSaveCoursesFee()
    {
        if ($user = $this->isAuthorized()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $params = Yii::$app->request->post();

                $already_have = AssignedCollegeCourses::find()
                    ->alias('a')
                    ->joinWith(['courseEnc b'])
                    ->where(['a.organization_enc_id' => $this->getOrgId(), 'b.course_name' => $params['course_name'], 'a.is_deleted' => 0])
                    ->one();

                if ($already_have) {
                    return $this->response(409, ['status' => 409, 'message' => 'conflict, course already exists']);
                }

                $course = CollegeCoursesPool::findOne(['course_name' => $params['course_name']]);

                if (!$course) {
                    $course = new CollegeCoursesPool();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $course->course_enc_id = $utilitiesModel->encrypt();
                    $course->course_name = $params['course_name'];
                    $course->created_by = $user->user_enc_id;
                    $course->created_on = date('Y-m-d H:i:s');
                    if (!$course->save()) {
                        $transaction->rollback();
                        return $this->response(500, ['status' => 500, 'message' => $course->getErrors()]);
                    }

                    if (isset($params['stream_id']) && !empty($params['stream_id'])) {
                        $stream = CollegeCoursesPool::findOne(['course_enc_id' => $course->course_enc_id]);
                        $stream->parent_enc_id = $params['stream_id'];
                        $stream->updated_by = $user->user_enc_id;
                        $stream->updated_on = date('Y-m-d H:i:s');
                        if (!$stream->update()) {
                            $transaction->rollback();
                            return $this->response(500, ['status' => 500, 'message' => $stream->getErrors()]);
                        }
                    }
                } else {

                    if (isset($params['stream_id']) && !empty($params['stream_id'])) {
                        if ($course->parent_enc_id == null) {
                            $stream = CollegeCoursesPool::findOne(['course_enc_id' => $course->course_enc_id]);
                            $stream->parent_enc_id = $params['stream_id'];
                            $stream->updated_by = $user->user_enc_id;
                            $stream->updated_on = date('Y-m-d H:i:s');
                            if (!$stream->update()) {
                                $transaction->rollback();
                                return $this->response(500, ['status' => 500, 'message' => $stream->getErrors()]);
                            }
                        }
                    }

                }

                $assigned_college_courses = new AssignedCollegeCourses();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $assigned_college_courses->assigned_college_enc_id = $utilitiesModel->encrypt();
                $assigned_college_courses->course_enc_id = $course->course_enc_id;
                $assigned_college_courses->organization_enc_id = $this->getOrgId();
                $assigned_college_courses->course_duration = $params['duration'];
                $assigned_college_courses->type = $params['type'];
                $assigned_college_courses->created_by = $user->user_enc_id;
                $assigned_college_courses->created_on = date('Y-m-d H:i:s');
                if (!$assigned_college_courses->save()) {
                    $transaction->rollback();
                    return $this->response(500, ['status' => 500, 'message' => $assigned_college_courses->getErrors()]);
                }

                $college_admission_detail = new CollegeAdmissionDetail();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $college_admission_detail->admission_detail_enc_id = $utilitiesModel->encrypt();
                $college_admission_detail->assigned_course_id = $assigned_college_courses->assigned_college_enc_id;
                $college_admission_detail->fees = $params['fees'];
                if (isset($params['scholarship_id']) && !empty($params['scholarship_id'])) {
                    $college_admission_detail->scholarship_enc_id = $params['scholarship_id'];
                }
                $college_admission_detail->created_by = $user->user_enc_id;
                $college_admission_detail->created_on = date('Y-m-d H:i:s');
                if (!$college_admission_detail->save()) {
                    $transaction->rollback();
                    return $this->response(500, ['status' => 500, 'message' => $college_admission_detail->getErrors()]);
                }


                $transaction->commit();
                return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);

            } catch (\Exception $e) {
                $transaction->rollback();
                return $this->response(500, ['status' => 500, 'message' => $e->getMessage()]);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionEditAdmissionDetail()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $admissionDetail = CollegeAdmissionDetail::findOne(['assigned_course_id' => $params['college_course_id']]);

            if (isset($params['duration']) && !empty($params['duration'])) {
                $assignedCourse = AssignedCollegeCourses::findOne(['assigned_college_enc_id' => $params['college_course_id']]);
                $assignedCourse->course_duration = $params['duration'];
                $assignedCourse->type = $params['type'];
                $assignedCourse->updated_by = $user->user_enc_id;
                $assignedCourse->updated_on = date('Y-m-d H:i:s');
                if(!$assignedCourse->update()){
                    return $this->response(500, ['status' => 500, 'message' => $assignedCourse->getErrors()]);
                }
            }

            if ($admissionDetail) {
                $admissionDetail->fees = $params['fees'];
                $admissionDetail->registration_fee = $params['registration_fee'];
                if (isset($params['scholarship_id']) && !empty($params['scholarship_id'])) {
                    $admissionDetail->scholarship_enc_id = $params['scholarship_id'];
                }
                $admissionDetail->selection_process = $params['selection_process'];
                $admissionDetail->eligibility_criteria = $params['eligibility_criteria'];
                $admissionDetail->other_details = $params['other_details'];
                $admissionDetail->updated_by = $user->user_enc_id;
                $admissionDetail->updated_on = date('Y-m-d H:i:s');
                if (!$admissionDetail->update()) {
                    return $this->response(500, ['status' => 500, 'message' => $admissionDetail->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);

            } else {
                $admissionDetail = new CollegeAdmissionDetail();
                $admissionDetail->admission_detail_enc_id = Yii::$app->security->generateRandomString();
                $admissionDetail->assigned_course_id = $params['college_course_id'];
                $admissionDetail->fees = $params['fees'];
                $admissionDetail->registration_fee = $params['registration_fee'];
                if (isset($params['scholarship_id']) && !empty($params['scholarship_id'])) {
                    $admissionDetail->scholarship_enc_id = $params['scholarship_id'];
                }
                $admissionDetail->selection_process = $params['selection_process'];
                $admissionDetail->eligibility_criteria = $params['eligibility_criteria'];
                $admissionDetail->other_details = $params['other_details'];
                $admissionDetail->created_by = $user->user_enc_id;
                $admissionDetail->created_on = date('Y-m-d H:i:s');
                if (!$admissionDetail->save()) {
                    return $this->response(500, ['status' => 500, 'message' => $admissionDetail->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetAdmissionCourses()
    {
        if ($user = $this->isAuthorized()) {

            $courses = AssignedCollegeCourses::find()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'a.course_enc_id', 'b.course_name', 'a.course_duration', 'a.type', 'b1.course_name stream',
                    'c.selection_process', 'c.eligibility_criteria', 'c.other_details', 'c.fees', 'c.assigned_course_id', 'c.scholarship_enc_id', 'c1.title scholarship_title'])
                ->joinWith(['courseEnc b' => function ($b) {
                    $b->joinWith(['parentEnc b1']);
                }], false)
                ->joinWith(['collegeAdmissionDetails c' => function ($c) {
                    $c->joinWith(['scholarshipEnc c1']);
                }], false)
                ->where(['a.organization_enc_id' => $this->getOrgId(), 'a.is_deleted' => 0])
                ->asArray()
                ->all();

            if ($courses) {
                return $this->response(200, ['status' => 200, 'courses' => $courses]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddInfra()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['name']) || empty($params['name'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "name"']);
            }

            $icon = UploadedFile::getInstanceByName('icon');

            $infra = new CollegeInfrastructure();
            $infra->college_infrastructure_enc_id = Yii::$app->security->generateRandomString();
            $infra->infra_name = $params['name'];
            $infra->created_by = $user->user_enc_id;
            $infra->created_on = date('Y-m-d H:i:s');
            if ($icon) {

                $infra->icon_location = \Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->collegeProfile->infrastructure_icon . $infra->icon_location . '/';
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);

                $encrypted_string = $utilitiesModel->encrypt();
                if (substr($encrypted_string, -1) == '.') {
                    $encrypted_string = substr($encrypted_string, 0, -1);
                }

                $infra->icon = $encrypted_string . '.png';
                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFile($icon->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $infra->icon, "public");
            }
            if (!$infra->save()) {
                return $this->response(500, ['status' => 500, 'error' => $infra->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'successfully saved', 'college_infrastructure_enc_id' => $infra->college_infrastructure_enc_id]);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionInfraList()
    {
        if ($user = $this->isAuthorized()) {

            $infra_list = CollegeInfrastructure::find()
                ->select(['college_infrastructure_enc_id', 'infra_name',
                    'CASE WHEN icon IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->collegeProfile->infrastructure_icon, 'https') . '", icon_location, "/", icon) ELSE NULL END icon',
                ])
                ->where(['is_deleted' => 0])
                ->asArray()
                ->all();

            if ($infra_list) {
                return $this->response(200, ['status' => 200, 'infrastructure_list' => $infra_list]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddInfraDetail()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $infra = CollegeInfrastructureDetail::findOne(['college_infrastructure_enc_id' => $params['college_infra_id'], 'college_enc_id' => $this->getOrgId()]);

            if ($infra) {

                $infra->description = $params['description'];
                $infra->is_deleted = 0;
                $infra->last_updated_by = $user->user_enc_id;
                $infra->last_updated_on = date('Y-m-d H:i:s');
                if (!$infra->update()) {
                    return $this->response(500, ['status' => 500, 'message' => $infra->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);

            } else {

                $infra = new CollegeInfrastructureDetail();
                $infra->college_infrastructure_detail_enc_id = Yii::$app->security->generateRandomString();
                $infra->college_infrastructure_enc_id = $params['college_infra_id'];
                $infra->college_enc_id = $this->getOrgId();
                $infra->description = $params['description'];
                $infra->created_by = $user->user_enc_id;
                $infra->created_on = date('Y-m-d H:i:s');
                if (!$infra->save()) {
                    return $this->response(500, ['status' => 500, 'message' => $infra->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'saved']);
            }


        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionInfraDetailList()
    {
        if ($user = $this->isAuthorized()) {

            $list = CollegeInfrastructureDetail::find()
                ->select(['college_infrastructure_detail_enc_id', 'college_infrastructure_enc_id',
                    'description'])
                ->where(['college_enc_id' => $this->getOrgId(), 'is_deleted' => 0])
                ->asArray()
                ->all();

            if ($list) {
                return $this->response(200, ['status' => 200, 'list' => $list]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveInfra()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['college_infra_id']) || empty($params['college_infra_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "college_infra_id"']);
            }

            $infra = CollegeInfrastructureDetail::findOne(['college_infrastructure_enc_id' => $params['college_infra_id'], 'college_enc_id' => $this->getOrgId()]);

            if ($infra) {

                $infra->is_deleted = 1;
                $infra->last_updated_by = $user->user_enc_id;
                $infra->last_updated_on = date('Y-m-d H:i:s');
                if (!$infra->update()) {
                    return $this->response(500, ['status' => 500, 'message' => $infra->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'removed']);

            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddPlacementHighlights()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $highlights = CollegePlacementHighlights::findOne(['college_enc_id' => $this->getOrgId()]);

            if (!$highlights) {
                $highlights = new CollegePlacementHighlights();
                $highlights->college_placement_highlight_enc_id = Yii::$app->security->generateRandomString();
                $highlights->college_enc_id = $this->getOrgId();
                $highlights->companies_visited = $params['companies_visited'];
                $highlights->top_recruiter = $params['top_recruiter'];
                $highlights->companies_offering_dream_packages = $params['dream_packages'];
                $highlights->highest_stipend_offered = $params['highest_stipend_offered'];
                $highlights->highest_placement_package = $params['highest_placement_package'];
                $highlights->created_by = $user->user_enc_id;
                $highlights->created_on = date('Y-m-d H:i:s');
                if (!$highlights->save()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $highlights->getErrors()]);
                }

                return $this->response(200, ['status' => 200, 'message' => 'data saved']);
            }

            $highlights->companies_visited = $params['companies_visited'] ? $params['companies_visited'] : $highlights->companies_visited;
            $highlights->top_recruiter = $params['top_recruiter'] ? $params['top_recruiter'] : $highlights->top_recruiter;
            $highlights->companies_offering_dream_packages = $params['dream_packages'] ? $params['dream_packages'] : $highlights->companies_offering_dream_packages;
            $highlights->highest_stipend_offered = $params['highest_stipend_offered'] ? $params['highest_stipend_offered'] : $highlights->highest_stipend_offered;
            $highlights->highest_placement_package = $params['highest_placement_package'] ? $params['highest_placement_package'] : $highlights->highest_placement_package;
            $highlights->updated_by = $user->user_enc_id;
            $highlights->updated_on = date('Y-m-d H:i:s');
            if (!$highlights->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $highlights->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'data updated']);


        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionShowPlacementHighlights()
    {
        if ($user = $this->isAuthorized()) {
            $highlights = CollegePlacementHighlights::find()
                ->select(['college_placement_highlight_enc_id', 'companies_visited', 'top_recruiter', 'companies_offering_dream_packages',
                    'highest_stipend_offered', 'highest_placement_package'])
                ->where(['college_enc_id' => $this->getOrgId()])
                ->asArray()
                ->one();

            if ($highlights) {
                return $this->response(200, ['status' => 200, 'highlights' => $highlights]);
            }

            return $this->response(404, ['status' => 404, 'not found']);

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionAddCourseRecruitment()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            $recruitment = new CollegeRecruitmentByCourse();
            $recruitment->college_recruitment_by_course_enc_id = Yii::$app->security->generateRandomString();
            $recruitment->college_enc_id = $this->getOrgId();
            $recruitment->assigned_course_enc_id = $params['assigned_course_enc_id'];
            $recruitment->average_package = $params['average_package'];
            $recruitment->highest_package = $params['highest_package'];
            $recruitment->total_offers = $params['total_offers'];
            $recruitment->students_placed = $params['students_placed'];
            $recruitment->companies_visiting = $params['companies_visiting'];
            $recruitment->created_by = $user->user_enc_id;
            $recruitment->created_on = date('Y-m-d H:i:s');
            if (!$recruitment->save()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $recruitment->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'saved']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionUpdateCourseRecruitment()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['recruitment_id']) || empty($params['recruitment_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "recruitment_id"']);
            }

            $recruitment = CollegeRecruitmentByCourse::findOne(['college_recruitment_by_course_enc_id' => $params['recruitment_id']]);

            $recruitment->average_package = $params['average_package'] ? $params['average_package'] : $recruitment->average_package;
            $recruitment->highest_package = $params['highest_package'] ? $params['highest_package'] : $recruitment->highest_package;
            $recruitment->total_offers = $params['total_offers'] ? $params['total_offers'] : $recruitment->total_offers;
            $recruitment->students_placed = $params['students_placed'] ? $params['students_placed'] : $recruitment->students_placed;
            $recruitment->companies_visiting = $params['companies_visiting'] ? $params['companies_visiting'] : $recruitment->companies_visiting;
            $recruitment->updated_by = $user->user_enc_id;
            $recruitment->updated_on = date('Y-m-d H:i:s');
            if (!$recruitment->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $recruitment->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'updated']);
        } else {
            return $this->response(401, ['status' => 401, 'mesasge' => 'unauthorized']);
        }
    }

    public function actionShowCourseRecruitments()
    {
        if ($user = $this->isAuthorized()) {

            $recruitments = CollegeRecruitmentByCourse::find()
                ->alias('a')
                ->select(['a.college_recruitment_by_course_enc_id', 'a.assigned_course_enc_id', 'a.average_package', 'a.highest_package', 'a.total_offers',
                    'a.students_placed', 'a.companies_visiting', 'b1.course_name'])
                ->joinWith(['assignedCourseEnc b' => function ($b) {
                    $b->joinWith(['courseEnc b1'], false);
                }], false)
                ->where(['a.is_deleted' => 0, 'a.college_enc_id' => $this->getOrgId()])
                ->asArray()
                ->all();

            if ($recruitments) {
                return $this->response(200, ['status' => 200, 'recruitments' => $recruitments]);
            }

            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionRemoveCourseRecruitment()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (!isset($params['recruitment_id']) || empty($params['recruitment_id'])) {
                return $this->response(422, ['status' => 422, 'message' => 'missing information "recruitment_id"']);
            }

            $recruitment = CollegeRecruitmentByCourse::findOne(['college_recruitment_by_course_enc_id' => $params['recruitment_id']]);

            $recruitment->is_deleted = 1;
            $recruitment->updated_by = $user->user_enc_id;
            $recruitment->updated_on = date('Y-m-d H:i:s');
            if (!$recruitment->update()) {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $recruitment->getErrors()]);
            }

            return $this->response(200, ['status' => 200, 'message' => 'removed']);
        } else {
            return $this->response(401, ['status' => 401, 'mesasge' => 'unauthorized']);
        }
    }

}