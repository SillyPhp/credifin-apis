<?php

namespace account\controllers;

use account\models\applications\Applied;
use common\models\ApplicationTypes;
use common\models\InterviewCandidates;
use common\models\InterviewDates;
use common\models\InterviewDateTimings;
use common\models\InterviewOptions;
use common\models\InterviewProcessFields;
use common\models\ScheduledInterview;
use common\models\UserCoachingTutorials;
use common\models\WidgetTutorials;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\HttpException;
use common\models\EmployerApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Organizations;
use common\models\AppliedApplications;
use common\models\AppliedApplicationProcess;
use account\models\organization\CompanyLogoForm;
use account\models\user\UserProfilePictureEdit;
use account\models\applications\Applied;
use common\models\ApplicationTypes;
use common\models\UserCoachingTutorials;
use common\models\Users;
use common\models\WidgetTutorials;

class DashboardController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    private $_condition;

    private function hasViewed()
    {
        $user_viewed = new UserCoachingTutorials();
        $user_v = $user_viewed->find()
            ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'is_viewed' => 1])
            ->asArray()
            ->one();
        if (empty($user_v)) {
            return 0;
        } else {
            return 1;
        }
    }

    public function actionIndex()
    {
        if (Yii::$app->user->identity->organization->organization_enc_id && !Yii::$app->user->identity->organization->business_activity_enc_id) {
            return $this->_businessActivity();
        }

        if (!Yii::$app->user->identity->services['selected_services']) {
            return $this->_services();
        }

        if (Yii::$app->user->identity->organization) {
            $viewed = $this->hasViewed();
            $this->_condition = ['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id];
            $applications = [
                'jobs' => $this->_applications(3),
                'internships' => $this->_applications(3, 'Internships'),
            ];
        } else {
            $viewed = $this->hasViewed();
            $this->_condition = ['b.created_by' => Yii::$app->user->identity->user_enc_id];
        }

        $applied_app = NULL;
        if (empty(Yii::$app->user->identity->organization)) {
            $applied_app = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id application_id', 'i.name type', 'c.name as title', 'b.assigned_category_enc_id', 'f.applied_application_enc_id applied_id', 'f.status', 'd.icon', 'g.name as org_name', 'COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) as active', 'COUNT(h.is_completed) as total', 'ROUND((COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) / COUNT(h.is_completed)) * 100, 0) AS per'])
                ->innerJoin(ApplicationTypes::tableName() . 'as i', 'i.application_type_enc_id = a.application_type_enc_id')
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = b.parent_enc_id')
                ->innerJoin(Organizations::tablename() . 'as g', 'g.organization_enc_id = a.organization_enc_id')
                ->leftJoin(AppliedApplications::tableName() . 'as f', 'f.application_enc_id = a.application_enc_id')
                ->where(['f.created_by' => Yii::$app->user->identity->user_enc_id])
                ->leftJoin(AppliedApplicationProcess::tableName() . 'as h', 'h.applied_application_enc_id = f.applied_application_enc_id')
                ->groupBy(['h.applied_application_enc_id'])
                ->orderBy(['f.id' => SORT_DESC])
                ->asArray()
                ->all();

            $applications_applied = AppliedApplications::find()
                ->select(['applied_application_enc_id id', 'current_round'])
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->orderBy(['id' => SORT_DESC])
                ->asArray()
                ->all();
            $object = new Applied();
            $question = [];
            foreach ($applications_applied as $v) {
                $array = $object->getCurrentQuestions($v['id'], $v['current_round']);
                if (!empty($array)) {
                    $question[] = $array;
                }
            }
        }

        $services = \common\models\Services::find()
            ->alias('a')
            ->select(['a.service_enc_id', 'a.name', 'b.selected_service_enc_id', 'b.is_selected'])
            ->joinWith(['selectedServices b' => function ($b) {
                $b->onCondition($this->_condition);
            }], false)
            ->where(['a.is_always_visible' => 0])
            ->orderBy(['a.sequence' => SORT_ASC])
            ->asArray()
            ->all();

        $servicesModel = new \account\models\services\ServiceSelectionForm();

        return $this->render('index', [
            'applied' => $applied_app,
            'services' => $services,
            'model' => $servicesModel,
            'applications' => $applications,
            'question_list' => $question,
            'viewed' => $viewed,
        ]);
    }

    private function _applications($limit = NULL, $type = 'Jobs')
    {
        $options = [
            'applicationType' => $type,
            'where' => [
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.status' => 'Active',
            ],
            'having' => [
                '>', 'a.last_date', date('Y-m-d')
            ],
            'orderBy' => [
                'a.published_on' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $applications = new \account\models\applications\Applications();
        return $applications->getApplications($options);
    }

    public function actionCoaching()
    {
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post('dat');
            $coaching_category = new WidgetTutorials();
            $tutorial_cat = $coaching_category->find()
                ->where(['name' => $data])
                ->asArray()
                ->one();
            $coaching = new UserCoachingTutorials();
            $coaching->user_coaching_tutorial_enc_id = Yii::$app->security->generateRandomString(12);
            $coaching->tutorial_enc_id = $tutorial_cat["tutorial_enc_id"];
            $coaching->created_by = Yii::$app->user->identity->user_enc_id;
            $coaching->last_updated_by = Yii::$app->user->identity->user_enc_id;
            $coaching->is_viewed = 1;
            $coaching->save();
        }
    }

    public function actionUpdateProfile()
    {
        if (Yii::$app->user->identity->organization) {
            $organization = Organizations::find()
                ->select(['logo', 'logo_location', 'initials_color'])
                ->where(['slug' => Yii::$app->user->identity->organization->slug, 'status' => 'Active', 'is_deleted' => 0])
                ->asArray()
                ->one();
            $companyLogoFormModel = new CompanyLogoForm();
            return $this->render('logo-modal', [
                'companyLogoFormModel' => $companyLogoFormModel,
                'organization' => $organization,
            ]);
        } else {
            $userProfilePicture = new UserProfilePictureEdit();
            $user = Users::find()
                ->select(['image', 'image_location', 'initials_color'])
                ->where(['username' => Yii::$app->user->identity->username, 'status' => 'Active', 'is_deleted' => 0])
                ->asArray()
                ->one();

            return $this->render('user-image-modal', [
                'userProfilePicture' => $userProfilePicture,
                'user' => $user,
            ]);
        }
    }

    private function _businessActivity()
    {

        $model = new \account\models\businessActivities\BusinessActivitySelectionForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->businessActivity = $model->businessActivity[0];
            if ($model->add()) {
                return $this->redirect("/account/dashboard");
            }
        }

        $business_activities = \common\models\extended\BusinessActivities::find()
            ->select(['business_activity_enc_id', 'business_activity', 'CONCAT("' . Url::to('@commonAssets/business_activities/') . '", icon_png) icon'])
            ->orderBy('business_activity ASC')
            ->asArray()
            ->all();
        return $this->render('organizations/business-activity', [
            "model" => $model,
            "business_activities" => $business_activities,
        ]);
    }

    private function _services()
    {
        $model = new \account\models\services\ServiceSelectionForm();

        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            return $this->redirect("/account/dashboard");
        }

        if (!Yii::$app->user->identity->services['selected_services']) {
            $services = \common\models\Services::find()
                ->select(['service_enc_id', 'name'])
                ->where(['is_always_visible' => 0])
                ->orderBy(['sequence' => SORT_ASC])
                ->asArray()
                ->all();

            return $this->render('services', [
                'model' => $model,
                'services' => $services,
            ]);
        }
    }

    private function _uploadImage()
    {
        return $this->render("user-image-modal");
    }

    private function _uploadLogo()
    {
        return $this->render("logo-modal");
    }

    public function actionSkipBusinessActivity()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost && Yii::$app->user->identity->organization->organization_enc_id) {
            $business_activities = \common\models\extended\BusinessActivities::find()
                ->select(['business_activity_enc_id', 'business_activity', 'CONCAT("' . Url::to('@commonAssets/business_activities/') . '", icon_png) icon'])
                ->where(["business_activity" => "Others"])
                ->orderBy('business_activity ASC')
                ->one();

            if (!$business_activities) {
                return [
                    "status" => 201,
                    "title" => "Error",
                    "message" => Yii::t('frontend', 'An error has occurred. Please try again.')
                ];
            }

            $organization = Organizations::findOne([
                "organization_enc_id" => Yii::$app->user->identity->organization->organization_enc_id,
                "status" => "Active",
                "is_deleted" => 0,
            ]);

            if (!$organization) {
                return [
                    "status" => 201,
                    "title" => "Error",
                    "message" => Yii::t('frontend', 'An error has occurred. Please try again.')
                ];
            }

            $organization->business_activity_enc_id = $business_activities->business_activity_enc_id;
            if ($organization->validate() && $organization->update()) {
                return [
                    "status" => 200,
                ];
            } else {
                return [
                    "status" => 201,
                    "title" => "Error",
                    "message" => Yii::t('frontend', 'An error has occurred. Please try again.')
                ];
            }
        } else {
            return [
                "status" => 202,
                "title" => "Error",
                "message" => Yii::t('frontend', 'Invalid request')
            ];
        }
    }

    public function actionCalendar()
    {
        return $this->render('test');
    }

    private function FixedInterview()
    {
        $fixed_interview = AppliedApplicationProcess::find()
            ->alias('a')
            ->distinct()
            ->select([
                'a.field_enc_id',
//                'j.scheduled_interview_enc_id',
                'f.name company_name',
                'h.name job_title',
                'i.name profile',
//                '(CASE
//                    WHEN j.interview_mode = 1 THEN "online"
//                    WHEN j.interview_mode = 2 THEN m.name
//                    END) as interview_at',
                'o.interview_date',
//                'p.from',
//                'p.to',
//                'p.interview_date_timing_enc_id',
//                'q.name interview_type',
                'b.applied_application_enc_id',
//                'c.sequence',
                'b.current_round',
                'z.designation',
//                'd.process_field_enc_id'
            ])
            ->innerJoinWith(['appliedApplicationEnc b' => function ($b) {
                $b->joinWith(['applicationEnc e' => function ($e) {
                    $e->joinWith(['designationEnc z']);
                    $e->joinWith(['organizationEnc f']);
                    $e->joinWith(['title g' => function ($g) {
                        $g->joinWith(['categoryEnc h']);
                        $g->joinWith(['parentEnc i'], false);
                    }]);
                }], false);
                $b->andWhere(['b.created_by' => Yii::$app->user->identity->user_enc_id]);
            }], false)
            ->innerJoinWith(['fieldEnc c' => function ($c) {
                $c->innerJoinWith(['interviewOptions d' => function ($d) use ($c) {
                    $d->joinWith(['scheduledInterviewEnc j' => function ($j) use ($c, $d) {
                        $j->joinWith(['interviewDates o' => function ($o) use ($c, $d, $j) {
                            $c->select(['c.field_enc_id', 'd.process_field_enc_id', 'j.scheduled_interview_enc_id', 'o.interview_date_enc_id',
                                'p.interview_date_timing_enc_id', '(CASE
                    WHEN j.interview_mode = 1 THEN "online"
                    WHEN j.interview_mode = 2 THEN m.name
                    END) as interview_at', 'q.name interview_type', 'd.process_field_enc_id']);
                            $o->joinWith(['interviewDateTimings p']);
                        }]);
                        $j->joinWith(['scheduledInterviewTypeEnc q'], false);
                        $j->joinWith(['interviewLocationEnc k' => function ($k) {
                            $k->joinWith(['locationEnc l' => function ($l) {
                                $l->joinWith(['cityEnc m'], false);
                            }], false);
                        }], false);
                    }]);
                }]);
            }])
            ->where(new \yii\db\Expression('`b`.`current_round` = `c`.`sequence`'))
            ->asArray()
            ->all();


        $all = InterviewCandidates::find()
            ->select(['status', 'process_field_enc_id', 'applied_application_enc_id'])
            ->where(['type' => 'fixed'])
            ->asArray()
            ->all();

        $num = count($fixed_interview);
        $num2 = count($all);

        for ($i = 0; $i < $num; $i++) {
            for ($j = 0; $j < $num2; $j++) {
                if ($fixed_interview[$i]['fieldEnc']['process_field_enc_id'] == $all[$j]['process_field_enc_id'] && $fixed_interview[$i]['applied_application_enc_id'] == $all[$j]['applied_application_enc_id']) {
                    $fixed_interview[$i]['status'] = $all[$j]['status'];
                }
            }
        }

        return $fixed_interview;

    }

    private function FlexibleInterview()
    {
        $flexible_interview = InterviewCandidates::find()
            ->alias('a')
            ->select([
                'e.name job_title',
                'm.name profile',
                'a.scheduled_interview_enc_id',
                'f.name company_name',
                '(CASE
                    WHEN g.interview_mode = 1 THEN "online"
                    WHEN g.interview_mode = 2 THEN j.name
                    END) as interview_at',
                'o.interview_date',
                'p.from',
                'p.to',
                'p.interview_date_timing_enc_id',
                'q.name interview_type',
                'a.applied_application_enc_id',
                'a.interview_candidate_enc_id',
                'a.status',
                'z.designation'
            ])
            ->joinWith(['appliedApplicationEnc b' => function ($b) {
                $b->andWhere(['b.created_by' => Yii::$app->user->identity->user_enc_id]);
                $b->joinWith(['applicationEnc c' => function ($c) {
                    $c->joinWith(['designationEnc z']);
                    $c->joinWith(['organizationEnc f']);
                    $c->joinWith(['title d' => function ($d) {
                        $d->joinWith(['categoryEnc e']);
                        $d->joinWith(['parentEnc m'], false);
                    }]);
                }]);
            }], false)
            ->joinWith(['scheduledInterviewEnc g' => function ($g) {
                $g->joinWith(['scheduledInterviewTypeEnc q']);
                $g->joinWith(['interviewLocationEnc h' => function ($h) {
                    $h->joinWith(['locationEnc i' => function ($i) {
                        $i->joinWith(['cityEnc j']);
                    }]);
                }]);
            }], false)
            ->where(['q.name' => 'flexible'])
            ->innerJoin(InterviewDates::tableName() . 'as o', 'o.scheduled_interview_enc_id = a.scheduled_interview_enc_id')
            ->innerJoin(InterviewDateTimings::tableName() . 'as p', 'p.interview_date_enc_id = o.interview_date_enc_id')
            ->asArray()
            ->all();

        return $flexible_interview;
    }

    public function actionGetEvents()
    {
        if (Yii::$app->request->isAjax) {

            $fixed_interview = $this->FixedInterview();
            $flexible_interview = $this->FlexibleInterview();

            $all = InterviewCandidates::find()
                ->select(['interview_date_timing_enc_id'])
                ->where(['type' => 'fixed'])
                ->asArray()
                ->all();

            $select_time = [];
            foreach ($all as $a) {
                array_push($select_time, $a['interview_date_timing_enc_id']);
            }

            $data = [];
            $i = 0;
            $old_id = null;
            $time_from_to = [];
            $time = [];
            $fixed_result = [];
            $fixed_data = [];
            foreach ($fixed_interview as $f) {
                if ($f['status'] != 3) {
                    $fixed_data['EventId'] = $f['fieldEnc']['scheduled_interview_enc_id'];
                    $fixed_data['Subject'] = $f['job_title'];
                    $fixed_data['Profile'] = $f['profile'];
                    $fixed_data['designation'] = $f['designation'];
                    $fixed_data['ThemeColor'] = 'blue';
                    $fixed_data['type'] = $f['fieldEnc']['interview_type'];
                    $interview_date = $f['interview_date'];
                    $fixed_data['Start'] = $interview_date;
                    $fixed_data['End'] = $interview_date;
                    $fixed_data['applied_application_enc_id'] = $f['applied_application_enc_id'];
                    $fixed_data['process_field_enc_id'] = $f['fieldEnc']['process_field_enc_id'];
                    $fixed_data['status'] = $f['status'];
                    if ($f['fieldEnc']['scheduled_interview_enc_id'] == $old_id) {
                        $old_id = $f['fieldEnc']['scheduled_interview_enc_id'];
                        $i++;
                    } else {
                        $old_id = $f['fieldEnc']['scheduled_interview_enc_id'];
                        $i = 0;
                    }
                    $ti = $f['fieldEnc']['interviewOptions'][0]['scheduledInterviewEnc']['interviewDates'][$i]['interviewDateTimings'];
                    foreach ($ti as $t) {
                        if (!in_array($t['interview_date_timing_enc_id'], $select_time)) {
                            $time_from_to['interview_date_timing_enc_id'] = $t['interview_date_timing_enc_id'];
                            $time_from_to['from'] = date("g:i a", strtotime($t['from']));
                            $time_from_to['to'] = date("g:i a", strtotime($t['to']));
                            array_push($time, $time_from_to);
                        }
                    }
                    $fixed_data['time'] = $time;
                    $time = [];

                    array_push($fixed_result, $fixed_data);
                }
            }

            $time_from_to = [];
            $time = [];
            $result = [];
            $data = [];
            foreach ($flexible_interview as $f) {
                if ($f['status'] != 3) {
                    $data['EventId'] = $f['scheduled_interview_enc_id'];
                    $data['Subject'] = $f['job_title'];
                    $data['Profile'] = $f['profile'];
                    $data['designation'] = $f['designation'];
                    $data['ThemeColor'] = 'blue';
                    $interview_date = $f['interview_date'];
                    $data['Start'] = $interview_date;
                    $data['End'] = $interview_date;
                    $data['type'] = $f['interview_type'];
                    $data['applied_application_enc_id'] = $f['applied_application_enc_id'];
                    $data['interview_c_enc_id'] = $f['interview_candidate_enc_id'];
                    $data['process_field_enc_id'] = $f['process_field_enc_id'];
                    $data['status'] = $f['status'];
                    $time_from_to['interview_date_timing_enc_id'] = $f['interview_date_timing_enc_id'];
                    $time_from_to['from'] = date("g:i a", strtotime($f['from']));
                    $time_from_to['to'] = date("g:i a", strtotime($f['to']));
                    array_push($time, $time_from_to);
                    $data['time'] = $time;
                    $time = [];
                    array_push($result, $data);
                }
            }

            $data = array_merge($fixed_result, $result);

            return json_encode($data);
        }

    }

    public function actionChangeStatus()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $date_enc_id = Yii::$app->request->post('date_enc_id');
            $process_id = Yii::$app->request->post('process_id');
            $interview_candidate_id = Yii::$app->request->post('candidate_interview_id');
            $scheduled_interview_enc_id = Yii::$app->request->post('scheduled_interview_enc_id');
            $applied_app_enc_id = Yii::$app->request->post('applied_app_id');
            $type = Yii::$app->request->post('type');
            $status = Yii::$app->request->post('status');

            $resonse = [
                'status' => 200,
                'message' => 'already exists'
            ];

            if ($type == 'flexible') {

                $interview_candidates = InterviewCandidates::find()
                    ->select('status')
                    ->where(['interview_candidate_enc_id' => $interview_candidate_id])
                    ->asArray()
                    ->one();

                if ($interview_candidates['status'] == 2) {
                    return $resonse;
                } else {

                    $interview_candidates = InterviewCandidates::find()
                        ->where(['interview_candidate_enc_id' => $interview_candidate_id, 'type' => 'flexible'])
                        ->one();

                    $interview_candidates->status = $status;
                    $interview_candidates->interview_date_timing_enc_id = $date_enc_id;

                    if ($interview_candidates->update()) {
                        if ($status == 2) {
                            return [
                                'status' => 200,
                                'message' => 'accepted'
                            ];
                        } elseif ($status == 3) {
                            return [
                                'status' => 200,
                                'message' => 'Rejected'
                            ];
                        }
                    } else {
                        return [
                            'status' => 201,
                            'message' => 'There is an error'
                        ];
                    }
                }
            } elseif ($type == 'fixed') {

                $interview_candidates = InterviewCandidates::find()
                    ->select(['status'])
                    ->where([
                        'scheduled_interview_enc_id' => $scheduled_interview_enc_id,
                        'applied_application_enc_id' => $applied_app_enc_id,
                        'process_field_enc_id' => $process_id,
                        'type' => 'fixed',
                    ])
                    ->asArray()
                    ->one();

                if ($interview_candidates['status'] == 2) {
                    return $resonse;
                }

                $number_of_candidates = $this->checkNumbers($scheduled_interview_enc_id);
                $count = $this->countApplications($scheduled_interview_enc_id);

                if ($count < $number_of_candidates) {

                    if (empty($interview_candidates)) {
                        $save_fixed_user_acceptance = new InterviewCandidates();

                        $utilitiesModel = new \common\models\Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $save_fixed_user_acceptance->interview_candidate_enc_id = $utilitiesModel->encrypt();
                        $save_fixed_user_acceptance->scheduled_interview_enc_id = $scheduled_interview_enc_id;
                        $save_fixed_user_acceptance->interview_date_timing_enc_id = $date_enc_id;
                        $save_fixed_user_acceptance->process_field_enc_id = $process_id;
                        $save_fixed_user_acceptance->type = $type;
                        $save_fixed_user_acceptance->applied_application_enc_id = $applied_app_enc_id;
                        $save_fixed_user_acceptance->status = $status;
                        if ($save_fixed_user_acceptance->save()) {
                            if ($status == 2) {
                                return [
                                    'status' => 200,
                                    'message' => 'accepted'
                                ];
                            } elseif ($status == 3) {
                                return [
                                    'status' => 200,
                                    'message' => 'Rejected'
                                ];
                            }
                        }
                    }

                } else {
                    return [
                        'status' => 201,
                        'message' => 'This slot is full.try next time'
                    ];
                }
            } else {
                return [
                    'status' => 201,
                    'message' => 'an error occured'
                ];
            }

        }

    }

    private function checkNumbers($s_id)
    {

        $number = InterviewOptions::find()
            ->select(['number_of_candidates'])
            ->where(['scheduled_interview_enc_id' => $s_id])
            ->asArray()
            ->one();

        return $number['number_of_candidates'];
    }

    private function countApplications($s_id)
    {
        $count = InterviewCandidates::find()
            ->select(['count(scheduled_interview_enc_id) total_applications'])
            ->where(['scheduled_interview_enc_id' => $s_id])
            ->asArray()
            ->all();

        return $count[0]['total_applications'];
    }


//    public function actionError(){
//        $error = Yii::$app->errorHandler->exception;
//        return $this->render('error',[
//            'error' => $error
//        ]);
//    }

}