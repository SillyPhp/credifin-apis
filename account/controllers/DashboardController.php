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
use common\models\EmployerApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Organizations;
use common\models\AppliedApplications;
use common\models\AppliedApplicationProcess;

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
        $model = new \account\models\services\ServiceSelectionForm();


        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            return $this->redirect('/account/dashboard');
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

        return $this->render('index', [
            'applied' => $applied_app,
            'services' => $services,
            'model' => $model,
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

    public function actionBusinessActivity()
    {
        $model = new \account\models\services\ServiceSelectionForm();
        $services = \common\models\Services::find()
            ->select(['service_enc_id', 'name'])
            ->where(['is_always_visible' => 0])
            ->orderBy(['sequence' => SORT_ASC])
            ->asArray()
            ->all();

        $business_activities = \common\models\extended\BusinessActivities::find()
            ->select(['business_activity_enc_id', 'business_activity', 'CONCAT("' . Url::to('@commonAssets/business_activities/') . '", icon_png) icon'])
            ->where(['!=', 'business_activity', 'Business'])
            ->orderBy([new \yii\db\Expression('FIELD (business_activity, "Others") ASC, business_activity ASC')])
            ->asArray()
            ->all();

        return $this->render('organizations/business-activity', [
            'model' => $model,
            'services' => $services,
            'business_activities' => $business_activities,

        ]);
    }

    public function actionCalendar()
    {
        return $this->render('test');
    }

    private function FixedInterview()
    {
        $fixed_interview = AppliedApplicationProcess::find()
            ->alias('a')
            ->select([
                'j.scheduled_interview_enc_id',
                'f.name company_name',
                'h.name job_title',
                'i.name profile',
                '(CASE
                    WHEN j.interview_mode = 1 THEN "online"
                    WHEN j.interview_mode = 2 THEN m.name
                    END) as interview_at',
                'o.interview_date',
                'p.from',
                'p.to',
                'p.interview_date_timing_enc_id',
                'q.name interview_type',
                'b.applied_application_enc_id',
                'c.sequence',
                'b.current_round',
                'd.process_field_enc_id'
            ])
            ->innerJoinWith(['appliedApplicationEnc b' => function ($b) {
                $b->joinWith(['applicationEnc e' => function ($e) {
                    $e->joinWith(['organizationEnc f']);
                    $e->joinWith(['title g' => function ($g) {
                        $g->joinWith(['categoryEnc h']);
                        $g->joinWith(['parentEnc i'], false);
                    }]);
                }], false);
                $b->andWhere(['b.created_by' => Yii::$app->user->identity->user_enc_id]);
            }], false)
            ->innerJoinWith(['fieldEnc c' => function ($c) {
                $c->innerJoinWith(['interviewOptions d' => function ($d) {
                    $d->joinWith(['scheduledInterviewEnc j' => function ($j) {
                        $j->joinWith(['scheduledInterviewTypeEnc q']);
                        $j->joinWith(['interviewLocationEnc k' => function ($k) {
                            $k->joinWith(['locationEnc l' => function ($l) {
                                $l->joinWith(['cityEnc m']);
                            }]);
                        }]);
                    }]);
                }]);
            }], false)
            ->innerJoin(InterviewDates::tableName() . 'as o', 'o.scheduled_interview_enc_id = j.scheduled_interview_enc_id')
            ->innerJoin(InterviewDateTimings::tableName() . 'as p', 'p.interview_date_enc_id = o.interview_date_enc_id')
            ->where(new \yii\db\Expression('`b`.`current_round` = `c`.`sequence`'))
            ->asArray()
            ->all();

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
                'a.interview_candidate_enc_id'

            ])
            ->joinWith(['appliedApplicationEnc b' => function ($b) {
                $b->andWhere(['b.created_by' => Yii::$app->user->identity->user_enc_id]);
                $b->joinWith(['applicationEnc c' => function ($c) {
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
            ->where(['a.status' => 0])
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

            $interviews = array_merge($fixed_interview, $flexible_interview);

            $result = [];
            $data = [];
            foreach ($interviews as $f) {
                $data['EventId'] = $f['scheduled_interview_enc_id'];
                $data['Subject'] = $f['job_title'];
                $data['Profile'] = $f['profile'];
                $data['ThemeColor'] = 'blue';
                $interview_date = $f['interview_date'];
                $from = $f['from'];
                $to = $f['to'];
                $data['Start'] = $interview_date . 'T' . $from;
                $data['End'] = $interview_date . 'T' . $to;
                $data['type'] = $f['interview_type'];
                $data['date_time'] = $f['interview_date_timing_enc_id'];
                $data['applied_application_enc_id'] = $f['applied_application_enc_id'];
                $data['interview_c_enc_id'] = $f['interview_candidate_enc_id'];
                $data['process_field_enc_id'] = $f['process_field_enc_id'];
                array_push($result, $data);
            }

            return json_encode($result);
        }

    }

    public function actionCandidateAccepted()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $date_enc_id = Yii::$app->request->post('date_enc_id');
            $process_id = Yii::$app->request->post('process_id');
            $interview_candidate_id = Yii::$app->request->post('candidate_interview_id');
            $scheduled_interview_enc_id = Yii::$app->request->post('scheduled_interview_enc_id');
            $applied_app_enc_id = Yii::$app->request->post('applied_app_id');
            $type = Yii::$app->request->post('type');

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
                        ->where(['applied_application_enc_id' => $applied_app_enc_id])
                        ->one();

                    $interview_candidates->status = 2;
                    $interview_candidates->interview_date_timing_enc_id = $date_enc_id;

                    if ($interview_candidates->update()) {
                        return [
                            'status' => 200,
                            'message' => 'accepted'
                        ];
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
                        $save_fixed_user_acceptance->applied_application_enc_id = $applied_app_enc_id;
                        $save_fixed_user_acceptance->status = 2;
                        if ($save_fixed_user_acceptance->save()) {
                            return [
                                'status' => 200,
                                'message' => 'accepted'
                            ];
                        }
                    }

                } else {
                    return [
                        'status' => 201,
                        'message' => 'this slot is full.try next time'
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