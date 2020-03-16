<?php

namespace api\modules\v2\controllers;

use api\modules\v2\models\ValidateUser;
use common\models\Departments;
use common\models\EducationalRequirements;
use common\models\UserOtherDetails;
use common\models\WhatsappInvitation;
use http\Env\Response;
use Yii;
use api\modules\v1\models\Candidates;
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
                'find-user'
                ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'signup' => ['POST'],
                'save-other-detail' => ['POST','OPTIONS'],
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

    public function actionSignup()
    {

        $model = new IndividualSignup();
        if ($model->load(Yii::$app->request->post(), '')) {
            if ($model->validate()) {

                if (!$this->usernameValid($model)) {
                    return $this->response(409, [
                        'username' => 'Username already taken'
                    ]);
                }

                if ($model->ref != '' && $model->invitation != '') {
                    if ($this->getRef($model) && $this->getInvitation($model)) {
                        if ($model->saveUser()) {
                            return $this->response(200, ['status' => 200]);
                        } else {
                            return $this->response(500, ['status' => 500]);
                        }
                    } else {
                        return $this->response(404, ['status' => 404, 'message' => 'Invalid Link']);
                    }
                } else {
                    if ($model->saveUser()) {
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
                return $this->response(200, ['status' => 200]);
            } else {
                return $this->response(409, $model->getErrors());
            }
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
            ->from(WhatsappInvitation::tableName() . 'as a')
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
                    if ($user_type['type'] != 'College') {
                        return false;
                    }
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
        $time_now = date('Y-m-d H:i:s', time('now'));
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
        $time_now = date('Y-m-d H:i:s', time('now'));
        $token->access_token_enc_id = time() . mt_rand(10, 99);
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
            ->joinWith(['userOtherInfo d' => function ($d) {
                $d->joinWith(['organizationEnc e']);
            }], false)
            ->where(['a.user_enc_id' => $source->user_enc_id])
            ->asArray()
            ->one();

        return [
            'user_id' => $source->user_enc_id,
            'username' => $user->username,
            'user_type' => $user_type['user_type'],
            'city' => $user_type['city_name'],
            'college' => $user_type['org_name'],
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'initials_color' => $user->initials_color,
            'access_token' => $source->access_token,
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

        $find_user = UserAccessTokens::find()
            ->select(['*'])
            ->where(['access_token' => $access_token, 'source' => $source])
            ->asArray()
            ->one();

        if (!empty($find_user)) {
            $user_type = Users::find()
                ->where(['!=', 'organization_enc_id', 'null'])
                ->exists();


            $user_detail = Users::find()
                ->alias('a')
                ->select(['a.first_name', 'a.last_name', 'a.username', 'a.phone', 'a.email', 'a.initials_color', 'b.user_type', 'c.name city_name', 'e.name org_name', 'd.organization_enc_id'])
                ->joinWith(['userTypeEnc b'], false)
                ->joinWith(['cityEnc c'], false)
                ->joinWith(['userOtherInfo d' => function ($d) {
                    $d->joinWith(['organizationEnc e']);
                }], false)
                ->where(['a.user_enc_id' => $find_user['user_enc_id']])
                ->asArray()
                ->one();

        }

        return [
            'user_id' => $find_user['user_enc_id'],
            'username' => $user_detail['username'],
            'user_type' => $user_detail['user_type'],
            'user_other_detail' => $this->userOtherDetail($find_user['user_enc_id']),
            'city' => $user_detail['city_name'],
            'college' => $user_detail['org_name'],
            'college_enc_id' => $user_detail['organization_enc_id'],
            'email' => $user_detail['email'],
            'first_name' => $user_detail['first_name'],
            'last_name' => $user_detail['last_name'],
            'phone' => $user_detail['phone'],
            'initials_color' => $user_detail['initials_color'],
            'access_token' => $find_user['access_token'],
            'refresh_token' => $find_user['refresh_token'],
            'access_token_expiry_time' => $find_user['access_token_expiration'],
            'refresh_token_expiry_time' => $find_user['refresh_token_expiration'],
        ];
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

        $e = EducationalRequirements::find()
            ->where([
                'educational_requirement' => $data['course_name']
            ])
            ->one();

        if ($e) {
            $user_other_details->educational_requirement_enc_id = $e->educational_requirement_enc_id;
        } else {
            $eduReq = new EducationalRequirements();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $eduReq->educational_requirement_enc_id = $utilitiesModel->encrypt();
            $eduReq->educational_requirement = $data['course_name'];
            $eduReq->created_on = date('Y-m-d H:i:s');
            $eduReq->created_by = $user_id;
            if (!$eduReq->save()) {
                return false;
            }
            $user_other_details->educational_requirement_enc_id = $eduReq->educational_requirement_enc_id;
        }

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
}