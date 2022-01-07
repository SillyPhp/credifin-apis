<?php

namespace frontend\controllers;

use common\models\ApplicationTypes;
use common\models\AppliedApplicationProcess;
use common\models\AppliedApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Cities;
use common\models\EmailLogs;
use common\models\EmployerApplications;
use common\models\InterviewProcessFields;
use common\models\Organizations;
use common\models\ShortlistedApplicants;
use common\models\States;
use common\models\UserAchievements;
use common\models\UserEducation;
use common\models\UserHobbies;
use common\models\UserInterests;
use common\models\UserPreferences;
use common\models\Users;
use common\models\UserWorkExperience;
use frontend\models\profile\UserProfileBasicEdit;
use frontend\models\profile\UserProfilePictureEdit;
use frontend\models\profile\UserProfileSocialEdit;
use frontend\models\UserTaskForm;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class UsersController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        return parent::beforeAction($action);
    }

    public function getPreference($type, $id)
    {

        $p = UserPreferences::find()
            ->alias('a')
            ->select([
                'a.preference_enc_id',
                'a.type',
                'a.assigned_to',
                'a.timings_from',
                'a.timings_to',
                'a.salary',
                'a.sat_frequency',
                'a.sun_frequency',
                'a.min_expected_salary',
                'a.max_expected_salary',
                'a.experience',
                'a.working_days',
                'c1.slug industry_slug',
            ])
            ->innerJoinWith(['userPreferredJobProfiles b' => function ($b) {
                $b->select(['b.preference_enc_id', 'b.job_profile_enc_id', 'b1.category_enc_id', 'b1.name profile_name']);
                $b->joinWith(['jobProfileEnc b1'], false);
                $b->andWhere(['b.is_deleted' => 0]);
            }])
            ->innerJoinWith(['userPreferredIndustries c' => function ($c) {
                $c->select(['c.preference_enc_id', 'c.industry_enc_id', 'c1.industry']);
                $c->joinWith(['industryEnc c1'], false);
                $c->andWhere(['c.is_deleted' => 0]);
            }])
            ->innerJoinWith(['userPreferredSkills d' => function ($d) {
                $d->select(['d.preference_enc_id', 'd.preferred_skill_enc_id', 'd1.skill_enc_id', 'd1.skill']);
                $d->joinWith(['skillEnc d1'], false);
                $d->andWhere(['d.is_deleted' => 0]);
            }])
            ->innerJoinWith(['userPreferredLocations e' => function ($e) {
                $e->select(['e.preference_enc_id', 'e.city_enc_id', 'e1.name city_name', 'e2.name state_name', 'e3.name country_name']);
                $e->joinWith(['cityEnc e1' => function ($e1) {
                    $e1->joinWith(['stateEnc e2' => function ($e2) {
                        $e2->joinWith(['countryEnc e3']);
                    }]);
                }], false);
                $e->andWhere(['e.is_deleted' => 0]);
            }])
            ->andWhere(['a.is_deleted' => 0, 'a.created_by' => $id, 'a.assigned_to' => $type])
            ->asArray()
            ->one();

        $skills = [];
        $cities = [];
        $states = [];
        $countries = [];
        $profiles_name = [];
        $industry = [];
        if (!empty($p['userPreferredIndustries'])) {
            foreach ($p['userPreferredIndustries'] as $i_slug) {
                array_push($industry, $i_slug['industry']);
            }
        }
        if (!empty($p['userPreferredJobProfiles'])) {
            foreach ($p['userPreferredJobProfiles'] as $p_slug) {
                array_push($profiles_name, $p_slug['profile_name']);
            }
        }
        if (!empty($p['userPreferredSkills'])) {
            foreach ($p['userPreferredSkills'] as $s) {
                array_push($skills, $s['skill']);
            }
        }
        if (!empty($p['userPreferredLocations'])) {
            foreach ($p['userPreferredLocations'] as $l) {
                array_push($cities, $l['city_name']);
                array_push($states, $l['state_name']);
                array_push($countries, $l['country_name']);
            }
        }
        return [
            'profiles_name' => implode(', ', array_unique($profiles_name)),
            'industry' => implode(', ', array_unique($industry)),
            'skills' => implode(', ', array_unique($skills)),
            'cities' => implode(', ', array_unique($cities)),
            'states' => implode(', ', array_unique($states)),
            'countries' => implode(', ', array_unique($countries)),
            'days' => $p['working_days'],
            'exp' => $p['experience'],
            'min_salary' => $p['min_expected_salary'],
            'max_salary' => $p['max_expected_salary'],
            'sat_frequency' => $p['sat_frequency'],
            'sun_frequency' => $p['sun_frequency'],
            'from' => $p['timings_from'],
            'to' => $p['timings_to'],
            'salary' => $p['salary'],
            'type' => $p['type'],
        ];
    }

    public function actionProfile($username)
    {
        $user = Users::find()
            ->alias('a')
            ->select(['a.*',
                '(CASE 
                WHEN a.is_available = "0" THEN "Not Available"
                WHEN a.is_available = "1" THEN "Available"
                WHEN a.is_available = "2" THEN "Open"
                WHEN a.is_available = "3" THEN "Actively Looking"
                WHEN a.is_available = "4" THEN "Exploring Possibilities"
                ELSE "Undefined"
                END) as availability',
                'ROUND(DATEDIFF(CURDATE(),
                 a.dob)/ 365.25) as age',
                'b.name as city',
                'b.state_enc_id',
                'c.name as job_profile',
                'IF(d.candidate_enc_id != "", "true", "false") as is_shortlisted'
            ])
            ->leftJoin(Cities::tableName() . 'as b', 'b.city_enc_id = a.city_enc_id')
            ->leftJoin(Categories::tableName() . 'as c', 'c.category_enc_id = a.job_function')
            ->leftJoin(ShortlistedApplicants::tableName() . 'as d', 'd.candidate_enc_id = a.user_enc_id')
            ->where(['a.username' => $username, 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if (!count($user) > 0) {
            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }
        $processModel = new UserTaskForm();
        $profileProcess = $processModel->getProfileCompleted($user['user_enc_id']);

        $skills = \common\models\UserSkills::find()
            ->alias('a')
            ->select(['a.skill_enc_id', 'b.skill skills'])
            ->innerJoin(\common\models\Skills::tableName() . 'b', 'b.skill_enc_id = a.skill_enc_id')
            ->where(['a.created_by' => $user['user_enc_id']])
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $language = \common\models\UserSpokenLanguages::find()
            ->alias('a')
            ->select(['a.language_enc_id', 'b.language language'])
            ->innerJoin(\common\models\SpokenLanguages::tableName() . 'b', 'b.language_enc_id = a.language_enc_id')
            ->where(['a.created_by' => $user['user_enc_id']])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->all();

        $userCv = \common\models\UserResume::find()
            ->select(['resume', 'resume_location'])
            ->where(['user_enc_id' => $user['user_enc_id']])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->one();
        $userApplied = "";
        $id = $_GET['id'];
        if (isset($id) && !empty($id)) {
            $userApplied = AppliedApplications::find()
                ->alias('z')
                ->select(['z.*', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 're.resume', 're.resume_location', 'aee.name as app_name', 'aec.name as app_type'])
                ->joinWith(['applicationEnc ae' => function($ae){
                    $ae->joinWith(['applicationTypeEnc aec']);
                    $ae->joinWith(['title aed' => function ($aec) {
                        $aec->joinWith(['categoryEnc aee']);
//                        $aec->joinWith(['parentEnc aef']);
                    }]);
                }], false)
                ->joinWith(['appliedApplicationProcesses c' => function ($c) {
                    $c->joinWith(['fieldEnc d'], false);
                    $c->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon']);
                    $c->onCondition(['c.is_deleted' => 0]);
                }])
                ->joinWith(['resumeEnc re'], false)
                ->andWhere(['z.applied_application_enc_id' => $id, 'z.is_deleted' => 0, 'z.created_by' => $user['user_enc_id'], 'ae.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->asArray()
                ->one();
        }


        $apps = AppliedApplications::find()
            ->alias('a')
            ->select(['a.applied_application_enc_id', 'a.current_round','a.application_enc_id','j.name type', 'c.slug', 'a.status','h.icon as job_icon', 'f.name as title', 'a.applied_application_enc_id app_id', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active'])
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->andWhere(['a.created_by' => $user['user_enc_id'], 'a.is_deleted' => 0])
            ->andWhere(['c.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'c.is_deleted' =>0, 'c.status' => 'Active'])
            ->groupBy('a.applied_application_enc_id')
            ->asArray()
            ->all();

        foreach ($apps as $processField) {
            $process_fields = InterviewProcessFields::find()
                ->select(['field_name', 'field_enc_id', 'icon'])
                ->where(['interview_process_enc_id' => $processField['interview_process_enc_id']])
                ->asArray()
                ->all();
            $processField['process'] = $process_fields;
            $userAppliedData['fields'][] = $processField;
        }
        $education = UserEducation::find()
            ->where(['user_enc_id' => $user['user_enc_id']])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $experience = UserWorkExperience::find()
            ->alias('a')
            ->select(['a.user_enc_id', 'a.experience_enc_id', 'a.is_current', 'a.city_enc_id', 'a.company', 'a.title', 'a.from_date', 'a.to_date', 'b.name city_name'])
            ->where(['a.user_enc_id' => $user['user_enc_id']])
            ->innerJoin(Cities::tableName() . 'as b', 'b.city_enc_id = a.city_enc_id')
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $achievement = UserAchievements::find()
            ->where(['user_enc_id' => $user['user_enc_id'], 'is_deleted' => 0])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $hobbies = UserHobbies::find()
            ->where(['user_enc_id' => $user['user_enc_id'], 'is_deleted' => 0])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $interests = UserInterests::find()
            ->where(['user_enc_id' => $user['user_enc_id'], 'is_deleted' => 0])
            ->orderBy(['created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $job_preference = self::getPreference('Jobs', $user['user_enc_id']);
        $internship_preference = self::getPreference('Internships', $user['user_enc_id']);

        $dataProvider = [
            'user' => $user,
            'skills' => $skills,
            'language' => $language,
            'userCv' => $userCv,
            'userApplied' => $userApplied,
            'userAppliedData' => $userAppliedData,
            'job_preference' => $job_preference,
            'internship_preference' => $internship_preference,
            'education' => $education,
            'experience' => $experience,
            'achievement' => $achievement,
            'hobbies' => $hobbies,
            'interests' => $interests,
            'slug' => $slug,
            'profileProcess' => $profileProcess,
            'available_applications' => $this->getApplications(),
        ];
//        print_r($dataProvider);
//        die();
        if (Yii::$app->user->isGuest) {
            $page = 'guest-view';
        } else {
            $orgId = Users::findOne(['user_enc_id' => Yii::$app->user->identity->user_enc_id])['organization_enc_id'];
            if ($orgId != null || $orgId != "") {
                $this->sendOpenedProfileEmail($user['email'], $user['username'], $userApplied ? $userApplied['app_name']: '', $userApplied ? $userApplied['app_type'] : '');
                $page = 'view';
            } else {
                if (Yii::$app->user->identity->user_enc_id == $user['user_enc_id']) {
                    $page = 'user-view';
                } else {
                    $page = 'guest-view';
                }
            }
        }
        return $this->render($page, $dataProvider);
    }

    private function sendOpenedProfileEmail($receiver_email,$receiver_username,$title,$type){
        $is_sent = EmailLogs::find()
            ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
            ->andWhere(['receiver_email' => $receiver_email])
            ->andWhere(['email_type' => 1])
            ->andWhere(['>=','created_on',date("Y-m-d")])
            ->exists();
        if(!$is_sent){
            $data['org_name'] = Yii::$app->user->identity->organization->name;
            $data['name'] = $title;
            $data['username'] = $receiver_username;
            $data['type'] = $type;

            $subject = "Your Profile Viewed by ".$data['org_name'];
            if(!empty($title)) {
                $template = 'profile-viewed-with-job-by-company';
            } else {
                $template = 'profile-viewed-by-company';
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $email = filter_var($receiver_email, FILTER_SANITIZE_EMAIL);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    Yii::$app->mailer->htmlLayout = 'layouts/email';
                    $mail = Yii::$app->mailer->compose(
                        ['html' => $template],['data'=>$data]
                    )
                        ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
                        ->setTo([$email])
                        ->setSubject($subject);
                    if (!$mail->send()) {
                        return [
                            'status' => 201,
                            'title' => 'Saving Error',
                            'message' => "Model not saved in database",
                        ];
                    }
                    $mail_logs = new EmailLogs();
                    $utilitesModel = new \common\models\Utilities();
                    $utilitesModel->variables['string'] = time() . rand(100, 100000);
                    $mail_logs->email_log_enc_id = $utilitesModel->encrypt();
                    $mail_logs->email_type = 1;
                    $mail_logs->user_enc_id = Yii::$app->user->identity->user_enc_id;
                    $mail_logs->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                    $mail_logs->receiver_email = $email;
                    $mail_logs->subject = $subject;
                    $mail_logs->template = $template;
                    $mail_logs->is_sent = 1;
                    if (!$mail_logs->save()) {
                        $transaction->rollBack();
                        return [
                            'status' => 201,
                            'title' => 'Saving Error',
                            'message' => "Model not saved in database",
                        ];
                    }
                } else {
                    return [
                        'status' => 201,
                        'title' => 'Email',
                        'message' => "Email not validated",
                    ];
                }

                $transaction->commit();
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Email Sent Successfully..'
                ];
            } catch (yii\db\Exception $exception) {
                $transaction->rollBack();
                return [
                    'status' => 201,
                    'title' => 'DB Exceptions',
                    'message' => $exception
                ];
            }

        }
        return true;
    }

    public function actionEdit()
    {
        if (!Yii::$app->user->isGuest && empty(Yii::$app->user->identity->organization)) {
            $userProfilePicture = new UserProfilePictureEdit();
            $basicDetails = new UserProfileBasicEdit();
            $socialDetails = new UserProfileSocialEdit();
            $object = new \account\models\jobs\JobApplicationForm();
            $industry = $object->getPrimaryFields('Profiles');
            $statesModel = new States();
            $getName = $basicDetails->getJobFunction();
            $getCurrentCity = $basicDetails->getCurrentCity();
            $getCategory = $basicDetails->getCurrentCategory();
            $getExperience = $basicDetails->getExperience();
            $getSkills = $basicDetails->getUserSkills();
            $getlanguages = $basicDetails->getUserlanguages();
            return $this->render('edit', [
                'userProfilePicture' => $userProfilePicture,
                'userLanguage' => $getlanguages,
                'userSkills' => $getSkills,
                'getExperience' => $getExperience,
                'getCurrentCity' => $getCurrentCity,
                'getName' => $getName,
                'getCategory' => $getCategory,
                'basicDetails' => $basicDetails,
                'socialDetails' => $socialDetails,
                'statesModel' => $statesModel,
                'industry' => $industry,
            ]);
        } else {
            return 'You are not Login as candidate login';
        }
    }

    private function getApplications()
    {
        if(Yii::$app->user->identity->organization->organization_enc_id) {
            $employer_applications = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.title', 'c.category_enc_id', 'd.name', 'e.name application_type'])
                ->joinWith(['title c' => function ($x) {
                    $x->joinWith(['categoryEnc d'], false);
                }], false)
                ->joinWith(['organizationEnc b'], false)
                ->joinWith(['applicationTypeEnc e'], false)
                ->where(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'a.is_deleted' => 0, 'a.status' => 'Active', 'a.application_for' => 1])
//            ->andWhere(['c.assigned_to' => $type])
                ->asArray()
                ->all();

            return $employer_applications;
        }
    }

    public function actionUpdateBasicDetail()
    {
        $basicDetails = new UserProfileBasicEdit();
        if ($basicDetails->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($basicDetails->update(Yii::$app->request->post())) {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            } else {
                $response = [
                    'status' => 'error',
                    'title' => 'Updated',
                    'message' => 'Already Updated.'
                ];
                return $response;
            }
        }
    }

    public function actionUpdateSocialDetail()
    {
        $socialDetails = new UserProfileSocialEdit();
        if ($socialDetails->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($socialDetails->updateValues()) {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            } else {
                $response = [
                    'status' => 'error',
                    'title' => 'Updated',
                    'message' => 'Already Updated.'
                ];
                return $response;
            }
        }
    }

    public function actionUpdateProfilePicture()
    {
        $userProfilePicture = new UserProfilePictureEdit();
        if (Yii::$app->request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $image = Yii::$app->request->post('data');
            if ($userProfilePicture->update($image)) {
                $response = [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Successfully Updated.'
                ];
                return $response;
            } else {
                $response = [
                    'status' => 'error',
                    'title' => 'Updated',
                    'message' => 'Already Updated.'
                ];
                return $response;
            }
        }
    }

    public function actionResumeLink()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $data = Yii::$app->request->post();

            try {

                $spaces = new \common\models\spaces\Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $cv = $my_space->signedURL(Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->resume->file . $data['resume_location'] . DIRECTORY_SEPARATOR . $data['resume'], "15 minutes");

                return [
                    'status' => 200,
                    'cv_link' => $cv,
                    'message' => 'success'
                ];

            } catch (\Exception $e) {
                return [
                    'status' => 500,
                    'message' => $e->getMessage()
                ];
            }
        }
    }

    public function actionUpdateUser()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $params = Yii::$app->request->post();
            $user = Users::findOne(['user_enc_id' => Yii::$app->user->identity->user_enc_id]);
            if (isset($params['skills']) && !empty($params['skills'])) {

            } elseif (isset($params['languages']) && !empty($params['languages'])) {

            } elseif (isset($params['job_title']) && !empty($params['job_title'])) {
                $category_execute = Categories::find()
                    ->alias('a')
                    ->where(['name' => $params['job_title']]);
                $chk_cat = $category_execute->asArray()->one();
                if (empty($chk_cat)) {
                    $categoriesModel = new Categories;
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $categoriesModel->category_enc_id = $utilitiesModel->encrypt();
                    $categoriesModel->name = $params['job_title'];
                    $utilitiesModel->variables['name'] = $params['job_title'];
                    $utilitiesModel->variables['table_name'] = Categories::tableName();
                    $utilitiesModel->variables['field_name'] = 'slug';
                    $categoriesModel->slug = $utilitiesModel->create_slug();
                    $categoriesModel->created_on = date('Y-m-d H:i:s');
                    $categoriesModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($categoriesModel->save()) {
                        if($id = $this->addNewAssignedCategory($categoriesModel->category_enc_id, $user)){
                            $params['job_function'] = $categoriesModel -> category_enc_id;
                        }
                        $this->addNewAssignedCategory($categoriesModel->category_enc_id, $user);
                    } else {
                        return false;
                    }
                } else {
                    $chk_assigned = $category_execute
                        ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
                        ->select(['b.assigned_category_enc_id', 'a.name', 'a.category_enc_id', 'b.parent_enc_id', 'b.assigned_to'])
                        ->andWhere(['not', ['b.parent_enc_id' => null]])
                        ->andWhere(['b.assigned_to' => 'Profiles', 'b.parent_enc_id' => $this->category])
                        ->asArray()
                        ->one();
                    if (empty($chk_assigned)) {
                        $this->addNewAssignedCategory($chk_cat['category_enc_id'], $user);
                    } else {
                        $user->job_function = $chk_assigned['category_enc_id'];
                        $user->asigned_job_function = $chk_assigned['assigned_category_enc_id'];
                    }
                }
            } else {
                if (isset($params['dob']) && !empty($params['dob'])){
                    $params['dob'] = date('Y-m-d', strtotime($params['dob']));
                }else if(isset($params['year']) && isset($params['month'])){
                    $params['experience'] = json_encode([$params['year'], $params['month']]);
                    unset($params['year']);
                    unset($params['month']);
                }
                if (!$user->updateAttributes($params)) {
                    return ['status' => 500, 'title' => 'error', 'isSaved' => 0];
                }
                return ['status' => 200, 'title' => 'success', 'isSaved' => 1];
            }
        }
    }

    private function addNewAssignedCategory($category_id, $profile)
    {
        $assignedCategoryModel = new AssignedCategories();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assignedCategoryModel->assigned_category_enc_id = $utilitiesModel->encrypt();
        $assignedCategoryModel->category_enc_id = $category_id;
        $assignedCategoryModel->parent_enc_id = $profile;
        $assignedCategoryModel->assigned_to = 'Profiles';
        $assignedCategoryModel->created_on = date('Y-m-d H:i:s');
        $assignedCategoryModel->created_by = Yii::$app->user->identity->user_enc_id;
        if ($assignedCategoryModel->save()) {
            return $assignedCategoryModel -> assigned_category_enc_id;
        } else {
            return false;
        }
    }

}