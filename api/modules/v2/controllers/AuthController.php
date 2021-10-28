<?php

namespace api\modules\v2\controllers;

use api\modules\v2\models\ChangePassword;
use api\modules\v2\models\TeacherSignup;
use api\modules\v2\models\ValidateUser;
use common\models\BusinessActivities;
use common\models\Departments;
use common\models\EducationalRequirements;
use common\models\ErexxSettings;
use common\models\Organizations;
use common\models\UserCoachingTutorials;
use common\models\UserOtherDetails;
use common\models\ErexxWhatsappInvitation;
use http\Env\Response;
use Yii;
use yii\helpers\Url;
use api\modules\v2\models\Candidates;
use api\modules\v2\models\IndividualSignup;
use api\modules\v2\models\LoginForm;
use common\models\EmailLogs;
use common\models\Referral;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\Users;
use yii\filters\Cors;
use yii\filters\auth\HttpBearerAuth;

class AuthController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'save-other-detail',
                'login',
                'signup',
                'validate',
                'username',
                'find-user',
                'teacher-signup',
                'validate-roll-number',
                'change-password',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'signup' => ['POST', 'OPTIONS'],
                'save-other-detail' => ['POST', 'OPTIONS'],
                'login' => ['POST', 'OPTIONS'],
                'validate' => ['POST', 'OPTIONS'],
                'username' => ['POST', 'OPTIONS'],
                'find-user' => ['POST', 'OPTIONS'],
                'teacher-signup' => ['POST', 'OPTIONS'],
                'validate-roll-number' => ['POST', 'OPTIONS'],
                'change-password' => ['POST', 'OPTIONS'],
            ]
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.myecampus.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionTeacherSignup()
    {
        $model = new TeacherSignup();
        if ($model->load(Yii::$app->request->post(), '')) {
            if (!$model->source) {
                $model->source = Yii::$app->getRequest()->getUserIP();
            }
            if ($model->validate()) {

                if (!$this->usernameValid($model)) {
                    return $this->response(409, [
                        'username' => 'Username already taken'
                    ]);
                }

                if ($model->ref != '' && $model->invitation != '') {
                    $invi = EmailLogs::findOne(['email_log_enc_id' => $model->invitation]);
                    if ($this->getRef($model) && $invi->type == 2) {
                        if ($user_id = $model->saveTeacher()) {
                            $token = $this->findToken($user_id, $model->source);
                            if (empty($token)) {
                                if ($token = $this->newToken($user_id, $model->source)) {
                                    $data = $this->returnData($user_id, $token);
                                    return $this->response(200, ['status' => 200, $data]);
                                }
                            } else {
                                if ($token = $this->onlyTokens($token)) {
                                    $data = $this->returnData($user_id, $token);
                                    return $this->response(200, ['status' => 200, $data]);
                                }
                            }
//                            return $this->response(200, ['status' => 200]);
                        } else {
                            return $this->response(500, ['status' => 500]);
                        }
                    } else {
                        return $this->response(404, ['status' => 404, 'message' => 'Invalid Link']);
                    }
                }
            }
            return $this->response(409, $model->getErrors());
        }
    }

    public function actionSignup()
    {

        $model = new IndividualSignup();
        if ($model->load(Yii::$app->request->post(), '')) {
            if (!$model->source) {
                $model->source = Yii::$app->getRequest()->getUserIP();
            }
            if ($model->validate()) {

                if (!$this->usernameValid($model)) {
                    return $this->response(409, [
                        'username' => 'Username already taken'
                    ]);
                }

                if ($model->ref != '') {
                    if ($this->getRef($model)) {
                        if ($user_id = $model->saveUser()) {
                            $token = $this->findToken($user_id, $model->source);
                            if (empty($token)) {
                                if ($token = $this->newToken($user_id, $model->source)) {
                                    $data = $this->returnData($user_id, $token);
                                    return $this->response(200, ['status' => 200, $data]);
                                }
                            } else {
                                if ($token = $this->onlyTokens($token)) {
                                    $data = $this->returnData($user_id, $token);
                                    return $this->response(200, ['status' => 200, $data]);
                                }
                            }
//                            return $this->response(200, ['status' => 200]);
                        } else {
                            return $this->response(500, ['status' => 500]);
                        }
                    } else {
                        return $this->response(404, ['status' => 404, 'message' => 'Invalid Link']);
                    }
                } else {
                    if ($user_id = $model->saveUser()) {
                        $token = $this->findToken($user_id, $model->source);
                        if (empty($token)) {
                            if ($token = $this->newToken($user_id, $model->source)) {
                                $data = $this->returnData($user_id, $token);
                                return $this->response(200, ['status' => 200, $data]);
                            }
                        } else {
                            if ($token = $this->onlyTokens($token)) {
                                $data = $this->returnData($user_id, $token);
                                return $this->response(200, ['status' => 200, $data]);
                            }
                        }
                        return $this->response(200, ['status' => 200]);
                    } else {
                        return $this->response(500, ['status' => 500]);
                    }
                }

            }
            return $this->response(409, $model->getErrors());
        }
        return $this->response(422, 'Not found');
    }

    public function actionValidate()
    {
        $model = new ValidateUser();
        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->validate()) {
                $username = Usernames::find()
                    ->where(['username' => $model->username])
                    ->exists();
                if (!$username) {
                    return $this->response(200, ['status' => 200]);
                } else {
                    return $this->response(409, ['username' => ['username already taken']]);
                }
            } else {
                return $this->response(409, $model->getErrors());
            }
        }
    }

    public function actionValidateRollNumber()
    {
        $roll_no = Yii::$app->request->post('roll_number');
        $roll_no_exists = UserOtherDetails::find()
            ->where(['is_deleted' => 0, 'university_roll_number' => $roll_no])
            ->exists();

        if ($roll_no_exists) {
            return $this->response(409, ['roll_number' => ['Roll Number already taken']]);
        } else {
            return $this->response(200, ['status' => 200]);
        }

    }

    private function getRef($model)
    {
        $ref = Referral::find()
            ->alias('a')
            ->select(['a.referral_enc_id', 'b.organization_enc_id'])
            ->joinWith(['organizationEnc b'])
            ->where(['code' => $model->ref])
            ->asArray()
            ->one();

        if ($ref['organization_enc_id']) {
            return true;
        } else {
            return false;
        }
    }

    private function getInvitation($model)
    {
        $invi = (new \yii\db\Query())
            ->from(EmailLogs::tableName() . 'as a')
            ->select(['email_log_enc_id id'])
            ->where(['email_log_enc_id' => $model->invitation]);

        $invi2 = (new \yii\db\Query())
            ->from(ErexxWhatsappInvitation::tableName() . 'as a')
            ->select(['invitation_enc_id id'])
            ->where(['invitation_enc_id' => $model->invitation]);

        $result = (new \yii\db\Query())
            ->from([
                $invi->union($invi2),
            ])
            ->one();

        return $result;
    }

    public function actionUsername()
    {
        $username = Yii::$app->request->post('username');
        $user_names = Usernames::find()
            ->where(['username' => $username])
            ->exists();

        if ($user_names) {
            return $this->response(200, ['status' => 201, 'exists' => true]);
        } else {
            return $this->response(200, ['status' => 200, 'exists' => false]);
        }
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->login()) {
                $source = Yii::$app->request->post()['source'];
                if (!$source) {
                    $source = Yii::$app->getRequest()->getUserIP();
                }
                $user = $this->findUser($model);
                if ($user->organization_enc_id) {
                    $user_type = Users::find()
                        ->alias('a')
                        ->select(['a.user_enc_id', 'a.organization_enc_id', 'c.business_activity type'])
                        ->joinWith(['organizationEnc b' => function ($b) {
                            $b->joinWith(['businessActivityEnc c']);
                        }], false)
                        ->where(['a.user_enc_id' => $user->user_enc_id, 'b.is_erexx_registered' => 1, 'b.is_deleted' => 0])
                        ->asArray()
                        ->one();
                    if (!in_array($user_type['type'], ['College', 'School'])) {
                        return false;
                    }
                }

                $user->last_visit = date('Y-m-d H:i:s');
                $user->last_visit_through = 'ECAMPUS';
                $user->last_updated_on = date('Y-m-d H:i:s');
                if (!$user->update()) {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }

                $token = $this->findToken($user, $source);
                if (empty($token)) {
                    if ($token = $this->newToken($user->user_enc_id, $source)) {
                        $data = $this->returnData($user, $token);
                        return $this->response(200, $data);
                    }
                } else {
                    if ($token = $this->onlyTokens($token)) {
                        $data = $this->returnData($user, $token);
                        return $this->response(200, $data);
                    }
                }
            }
            return $this->response(409, $model->getErrors());
        }
        return $this->response(422);
    }

    private function onlyTokens($token)
    {
        $time_now = date('Y-m-d H:i:s', time());
        $token->access_token = \Yii::$app->security->generateRandomString(32);
        $token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
        $token->refresh_token = \Yii::$app->security->generateRandomString(32);
        $token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
        if ($token->save()) {
            return $token;
        }
        return $token->getErrors();
    }

    private function newToken($user_id, $source)
    {
        $token = new UserAccessTokens();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $time_now = date('Y-m-d H:i:s', time());
        $token->access_token_enc_id = $utilitiesModel->encrypt();
        $token->user_enc_id = $user_id;
        $token->access_token = \Yii::$app->security->generateRandomString(32);
        $token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
        $token->refresh_token = \Yii::$app->security->generateRandomString(32);
        $token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
        $token->source = $source;
        if ($token->save()) {
            return $token;
        }
        return $token->getErrors();
    }

    private function returnData($user, $source)
    {

        $user_type = Users::find()
            ->alias('a')
            ->select(['a.user_enc_id', 'b.user_type', 'c.name city_name', 'e.name org_name'])
            ->joinWith(['userTypeEnc b'], false)
            ->joinWith(['cityEnc c'], false)
            ->joinWith(['teachers'])
            ->joinWith(['userOtherInfo d' => function ($d) {
                $d->joinWith(['organizationEnc e']);
            }], false)
            ->where(['a.user_enc_id' => $source->user_enc_id])
            ->asArray()
            ->one();

        if ($user_type['user_type'] == 'Executive' || $user_type['user_type'] == 'Skillsup Executive') {
            $user_type['user_type'] = 'Individual';
        }

        return [
            'user_id' => $source->user_enc_id,
            'username' => $user->username,
            'user_type' => (!empty($user_type['teachers']) ? 'teacher' : $user_type['user_type']),
//            'user_type' => $user_type['user_type'],
            'city' => $user_type['city_name'],
            'college' => $user_type['org_name'],
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'initials_color' => $user->initials_color,
            'access_token' => $source->access_token,
            'source' => $source->source,
            'refresh_token' => $source->refresh_token,
            'access_token_expiry_time' => $source->access_token_expiration,
            'refresh_token_expiry_time' => $source->refresh_token_expiration,
        ];
    }

    private function findToken($user, $source)
    {
        return UserAccessTokens::findOne([
            'user_enc_id' => $user->user_enc_id,
            'source' => $source
        ]);
    }

    private function findUser($model)
    {
        $user = Candidates::findOne([
            'username' => $model->username
        ]);
        if (!$user) {
            $user = Candidates::findOne([
                'email' => $model->username
            ]);
        }
        return $user;
    }

    private function usernameValid($model)
    {
        $usernameModel = new Usernames();
        $usernameModel->username = $model->username;
        $usernameModel->assigned_to = 1;
        if (!$usernameModel->validate()) {
            return false;
        }
        return true;
    }

    public function actionFindUser()
    {

        $access_token = Yii::$app->request->post('access_token');
        $source = Yii::$app->request->post('source');
        $type = '';

        $find_user = UserAccessTokens::find()
            ->select(['*'])
            ->where(['access_token' => $access_token, 'source' => $source])
            ->asArray()
            ->one();

        $today_date = new \DateTime();
        $today_date = $today_date->format('Y-m-d H:i:s');

        if ($today_date > $find_user['access_token_expiration']) {
            return false;
        }

        if (!empty($find_user)) {
            $user_type = Users::find()
                ->where(['!=', 'organization_enc_id', 'null'])
                ->exists();


            $user_detail = Users::find()
                ->alias('a')
                ->select(['a.user_enc_id', 'a.first_name',
                    'a.last_name',
                    'a.organization_enc_id college_id',
                    'cc.college_enc_id',
                    'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", a.image_location, "/", a.image) ELSE NULL END image',
                    'a.username', 'a.phone', 'a.email',
                    'a.initials_color', 'b.user_type',
                    'c.name city_name', 'e.name org_name', 'd.organization_enc_id',
                    'd.cgpa', 'd.assigned_college_enc_id', 'd.section_enc_id', 'd.semester',
                    'e.has_loan_featured',
                    'e.has_skillup_featured',
                    'c1.has_skillup_featured teacher_skill_up',
                    'c1.has_loan_featured t_loan_featured',
                    'c1.business_activity_enc_id teacher_org_type', 'ee.business_activity user_org_business_type'
                ])
                ->joinWith(['userTypeEnc b'], false)
                ->joinWith(['cityEnc c'], false)
                ->joinWith(['teachers cc' => function ($cc) {
                    $cc->joinWith(['collegeEnc c1']);
                }])
                ->joinWith(['userOtherInfo d' => function ($d) {
                    $d->joinWith(['organizationEnc e' => function ($e) {
                        $e->joinWith(['businessActivityEnc ee']);
                    }]);
                }], false)
                ->where(['a.user_enc_id' => $find_user['user_enc_id']])
                ->asArray()
                ->one();

            $student_college_id = $user_detail['organization_enc_id'];
            if ($student_college_id) {
                $college_settings = ErexxSettings::find()
                    ->alias('a')
                    ->select(['a.setting', 'a.title', 'b.college_settings_enc_id', 'b.value'])
                    ->joinWith(['collegeSettings b' => function ($b) use ($student_college_id) {
                        $b->onCondition(['b.college_enc_id' => $student_college_id]);
                    }], false)
                    ->where(['a.status' => 'Active'])
                    ->asArray()
                    ->all();

                $j = 0;
                foreach ($college_settings as $c) {
                    if ($c['setting'] == 'show_jobs' || $c['setting'] == 'show_internships') {
                        if ($c['value'] == null) {
                            if ($user_detail['user_org_business_type'] == 'College') {
                                $college_settings[$j]['value'] = 2;
                            }
                        }
                    }
                    $j++;
                }

                $settings = [];
                foreach ($college_settings as $c) {
                    $settings[$c['setting']] = $c['value'] == 2 ? true : false;
                }

                if ($user_detail['user_org_business_type'] == 'School') {
                    $settings['show_quiz'] = true;
                } else {
                    $settings['show_quiz'] = false;
                }
            }

            $college_id = $user_detail['college_id'];
            if ($college_id) {
                $college_settings = ErexxSettings::find()
                    ->alias('a')
                    ->select(['a.setting', 'a.title', 'b.college_settings_enc_id', 'b.value'])
                    ->joinWith(['collegeSettings b' => function ($b) use ($college_id) {
                        $b->onCondition(['b.college_enc_id' => $college_id]);
                    }], false)
                    ->where(['a.status' => 'Active'])
                    ->asArray()
                    ->all();

                $education_loan_college = Organizations::find()
                    ->select(['has_loan_featured', 'has_skillup_featured'])
                    ->where(['organization_enc_id' => $college_id])
                    ->asArray()
                    ->one();

                $business_activity = Organizations::find()
                    ->alias('a')
                    ->select(['a.organization_enc_id', 'c.business_activity'])
                    ->joinWith(['businessActivityEnc c'])
                    ->where(['a.organization_enc_id' => $college_id])
                    ->asArray()
                    ->one();

                if ($business_activity['business_activity'] == 'School') {
                    $j = 0;
                    foreach ($college_settings as $c) {
                        if ($c['setting'] == 'show_teachers') {
                            if ($c['value'] == null) {
                                $college_settings[$j]['value'] = 2;
                            }
                        }
                        $j++;
                    }

                    $settings = [];
                    foreach ($college_settings as $c) {
                        $settings[$c['setting']] = $c['value'] == 2 ? true : false;
                    }
                } else {
                    $j = 0;
                    foreach ($college_settings as $c) {
                        if ($c['setting'] == 'show_jobs' || $c['setting'] == 'show_internships') {
                            if ($c['value'] == null) {
                                $college_settings[$j]['value'] = 2;
                            }
                        }
                        $j++;
                    }

                    $settings = [];
                    foreach ($college_settings as $c) {
                        $settings[$c['setting']] = $c['value'] == 2 ? true : false;
                    }
                }

            }

            $is_viewed_loan_on_dashboard = UserCoachingTutorials::find()
                ->alias('a')
                ->select(['a.user_coaching_tutorial_enc_id', 'a.tutorial_enc_id', 'a.is_viewed'])
                ->joinWith(['tutorialEnc b'])
                ->where(['a.created_by' => $find_user['user_enc_id']])
                ->andWhere(['b.name' => 'not_interested_for_loans'])
                ->asArray()
                ->one();

        }

        if ($user_detail['user_type']== 'Executive' || $user_detail['user_type'] == 'Skillsup Executive') {
            $user_detail['user_type'] = 'Individual';
        }

        $data = [
            'user_id' => $find_user['user_enc_id'],
            'username' => $user_detail['username'],
            'college_settings' => $settings,
            'is_viewed' => $is_viewed_loan_on_dashboard['is_viewed'] == 1 ? True : False,
            'image' => $user_detail['image'],
            'course_enc_id' => $user_detail['assigned_college_enc_id'],
            'section_enc_id' => $user_detail['section_enc_id'],
            'semester' => $user_detail['semester'],
            'user_type' => (!empty($user_detail['teachers']) ? 'teacher' : $user_detail['user_type']),
            'user_other_detail' => $this->userOtherDetail($find_user['user_enc_id']),
            'city' => $user_detail['city_name'],
            'cgpa' => $user_detail['cgpa'],
            'college' => (!empty($user_detail['teachers'][0]['collegeEnc']) ? $user_detail['teachers'][0]['collegeEnc']['name'] : $user_detail['org_name']),
            'college_enc_id' => (!empty($user_detail['teachers']) ? $user_detail['college_enc_id'] : $user_detail['organization_enc_id']),
            'email' => $user_detail['email'],
            'first_name' => $user_detail['first_name'],
            'last_name' => $user_detail['last_name'],
            'phone' => $user_detail['phone'],
            'initials_color' => $user_detail['initials_color'],
            'access_token' => $find_user['access_token'],
            'refresh_token' => $find_user['refresh_token'],
            'access_token_expiry_time' => $find_user['access_token_expiration'],
            'refresh_token_expiry_time' => $find_user['refresh_token_expiration']
        ];

        $data['college_enc_id'] = $data['college_enc_id'] ? $data['college_enc_id'] : $user_detail['college_id'];

        if ($user_detail['teacher_org_type']) {
            $type = BusinessActivities::find()
                ->where(['business_activity_enc_id' => $user_detail['teacher_org_type']])
                ->asArray()
                ->one();

            $data['business_activity'] = $type['business_activity'];
        }

        if ($college_id) {
            $data['business_activity'] = $business_activity['business_activity'];
            $data['education_loan'] = (int)$education_loan_college['has_loan_featured'] == 1 ? true : false;
            $data['has_skillup_featured'] = (int)$education_loan_college['has_skillup_featured'] == 1 ? true : false;
        } elseif ($user_detail['teachers']) {
            $data['has_skillup_featured'] = (int)$user_detail['teacher_skill_up'] == 1 ? true : false;
            $data['education_loan'] = (int)$user_detail['t_loan_featured'] == 1 ? true : false;
        } else {
            $data['business_activity'] = $user_detail['user_org_business_type'];
            $data['education_loan'] = (int)$user_detail['has_loan_featured'] == 1 ? true : false;
            $data['has_skillup_featured'] = (int)$user_detail['has_skillup_featured'] == 1 ? true : false;
        }

        return $data;
    }

    private function userOtherDetail($user_id)
    {
        $user_other_detail = UserOtherDetails::find()
            ->where(['user_enc_id' => $user_id])
            ->exists();

        return $user_other_detail;
    }

    public function actionSaveOtherDetail()
    {

        if ($user = $this->isAuthorized()) {
            $user_id = $user->user_enc_id;
        } else {
            return $this->response(401, ['status' => 401, 'msg' => 'unauthorized']);
        }

        $data = Yii::$app->request->post();

        $user_other_details = new UserOtherDetails();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $user_other_details->user_other_details_enc_id = $utilitiesModel->encrypt();
        $user_other_details->organization_enc_id = $data['college'];
        $user_other_details->user_enc_id = $user_id;

        $d = Departments::find()
            ->where([
                'name' => $data['department']
            ])
            ->one();

        if ($d) {
            $user_other_details->department_enc_id = $d->department_enc_id;
        } else {
            $department = new Departments();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $department->department_enc_id = $utilitiesModel->encrypt();
            $department->name = $data['department'];
            if (!$department->save()) {
                return false;
            }
            $user_other_details->department_enc_id = $department->department_enc_id;
        }

        $user_other_details->assigned_college_enc_id = $data['course_id'];
        $user_other_details->section_enc_id = $data['section_id'];
        $user_other_details->semester = $data['semester'];
        $user_other_details->starting_year = $data['starting_year'];
        $user_other_details->ending_year = $data['ending_year'];
        $user_other_details->university_roll_number = $data['roll_number'];


        if ($data['job_start_month']) {
            $user_other_details->job_start_month = $data['job_start_month'];
        }

        if ($data['job_year']) {
            $user_other_details->job_year = $data['job_year'];
        }

        if ($data['internship_duration']) {
            $user_other_details->internship_duration = $data['internship_duration'];
        }

        if ($data['internship_start_date']) {
            $user_other_details->internship_start_date = $date = date('Y-m-d', strtotime($data['internship_start_date']));
        }

        if (!$user_other_details->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
        } else {
            return $this->response(201, ['status' => 201, 'message' => 'successfully added']);
        }
    }

    public function actionChangePassword()
    {
        if ($user = $this->isAuthorized()) {
            $model = new ChangePassword();
            if ($model->load(Yii::$app->request->post(), '')) {
                if ($model->validate()) {
                    if ($res = $model->changePassword($user->user_enc_id)) {
                        if ($res === 403) {
                            return $this->response(403, ['status' => 403, 'message' => 'password not match']);
                        }
                        return $this->response(200, ['status' => 200, 'message' => 'Successfully updated']);
                    } else {
                        return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                    }
                } else {
                    return $this->response(409, ['status' => 409, $model->getErrors()]);
                }
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'data not found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}