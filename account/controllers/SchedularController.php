<?php

namespace account\controllers;

use account\models\scheduler\InterviewForm;
use common\models\ApplicationInterviewLocations;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\AppliedApplicationProcess;
use common\models\AppliedApplications;
use common\models\EmailLogs;
use common\models\EmployerApplications;
use common\models\extended\OrganizationInterviewProcess;
use common\models\InterviewCandidates;
use common\models\InterviewDates;
use common\models\InterviewDateTimings;
use common\models\InterviewerDetail;
use common\models\Interviewers;
use common\models\InterviewOptions;
use common\models\InterviewProcessFields;
use common\models\InterviewTypes;
use common\models\ScheduledInterview;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\HttpException;

class SchedularController extends Controller
{
    public function actionInterview($id = null)
    {
        if (Yii::$app->user->identity->organization->organization_enc_id) {
            return $this->render('test',
                [
                    'application_id' => $id,
                ]);
        } else {
            return $this->render('candidate-detail');
//            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionInerviewerStatus($id, $type)
    {
        $interviewer_details = InterviewerDetail::find()
            ->where(['interviewer_detail_enc_id' => $id])
            ->one();

        if ($interviewer_details->status == 1) {
            echo 'You are already accepted.';
        } elseif ($interviewer_details->status == 2) {
            echo 'You are already rejected.';
        } else {

            if (!empty($interviewer_details)) {
                if ($type == 'accept') {
                    $interviewer_details->status = 1;
                } elseif ($type == 'reject') {
                    $interviewer_details->status = 2;
                }

                if ($interviewer_details->update()) {
                     echo 'successfully '.$type.'ed';
                }
            }
        }
    }

    public function actionFindApplications()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $req = Yii::$app->request->post();
            $organization_id = Yii::$app->user->identity->organization->organization_enc_id;
            $app_id = $req['application_id'];
            $res = $this->findOrganizationApplications($organization_id, $app_id);
            return [
                'response' => $res
            ];
        }
    }

    public function findOrganizationApplications($id, $application_id = null)
    {
        $applications = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.title', 'b.assigned_category_enc_id', 'b.category_enc_id', 'b.parent_enc_id', 'CONCAT(c.name, " - ", d.name) application_name'])
//            ->innerJoinWith(['applicationInterviewQuestionnaires z'])
            ->innerJoinWith(['appliedApplications t'])
            ->joinWith(['title b' => function ($x) {
                $x->joinWith(['categoryEnc c']);
                $x->joinWith(['parentEnc d']);
            }], false);
        if ($application_id == null) {
            $applications->where([
                'a.organization_enc_id' => $id,
                'a.is_deleted' => 0,
            ])->andWhere(['<>', 'a.interview_process_enc_id', 'null']);
        } else {
            $applications->where([
                'a.organization_enc_id' => $id,
                'a.application_enc_id' => $application_id,
                'a.is_deleted' => 0,
            ]);
        }
        $result = $applications->groupBy(['a.application_enc_id'])
            ->asArray()
            ->all();

        return $result;
    }

    public function actionFindRounds()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $req = Yii::$app->request->post();
            $res = $this->findApplicationFields($req['application_id']);
            return [
                'results' => $res
            ];
        }
    }

    public function findApplicationFields($id)
    {
        $interview_process = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.interview_process_enc_id', 'b.process_name'])
            ->joinWith(['interviewProcessEnc b'], false)
            ->where([
                'application_enc_id' => $id
            ])
            ->asArray()
            ->one();
        return InterviewProcessFields::find()
            ->select(['field_enc_id', 'field_name', 'field_label'])
            ->where([
                'interview_process_enc_id' => $interview_process['interview_process_enc_id']
            ])
            ->andWhere(['<>', 'field_name', 'Get Applications'])
            ->asArray()
            ->all();
    }

    public function actionFindCandidates()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $req = Yii::$app->request->post();
            $res = $this->findAppliedCandidates($req['application_id'], $req['process_id']);

            return [
                'results' => $res
            ];
        }
    }

    public function findAppliedCandidates($app_id, $process_id)
    {
        $applied_candidates = AppliedApplications::find()
            ->alias('a')
            ->select(['a.applied_application_enc_id', 'a.resume_enc_id', 'b.user_enc_id', 'CONCAT(c.first_name, " ", c.last_name) full_name', 'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, true) . '", c.image_location, "/", c.image) ELSE  CONCAT("https://ui-avatars.com/api/?name=", c.first_name, " ", c.last_name, "&size=200&rounded=false&background=", REPLACE(c.initials_color, "#", ""), "&color=ffffff") END image', 'a.current_round', 'e.sequence'])
            ->joinWith(['resumeEnc b' => function ($x) {
                $x->joinWith(['userEnc c']);
//                    $x->groupBy(['b.user_enc_id']);
            }], false)
            ->joinWith(['appliedApplicationProcesses d' => function ($d) use ($process_id) {
                $d->joinWith(['fieldEnc e']);
                $d->where(['d.field_enc_id' => $process_id]);
            }], false)
            ->where([
                'application_enc_id' => $app_id
            ])
            ->andWhere(new \yii\db\Expression('`a`.`current_round` = `e`.`sequence`'))
            ->groupBy(['b.user_enc_id'])
            ->asArray()
            ->all();

        return $applied_candidates;

    }

    public function actionFindLocations()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $req = Yii::$app->request->post();
            $res = $this->findOrganizationInterviewLocations($req['application_id']);
            return [
                'response' => $res
            ];
        }
    }

    private function findOrganizationInterviewLocations($application_id)
    {
        return ApplicationInterviewLocations::find()
            ->alias('a')
            ->select(['a.interview_location_enc_id', 'a.location_enc_id', 'b.city_enc_id', 'c.name'])
            ->joinWith(['locationEnc b' => function ($x) {
                $x->joinWith(['cityEnc c']);
            }], false)
            ->where([
                'application_enc_id' => $application_id
            ])
            ->asArray()
            ->all();
    }

    public function actionFixInterview()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $req = Yii::$app->request->post();
            $res = [];
            if ($req['type'] == "fixed") {
                $res['application'] = $req['application_id'];
                if ($req['number_of_candidates']) {
                    $res['number_of_candidates'] = $req['number_of_candidates'];
                }
                if ($req['selected_location']) {
                    $res['selected_location'] = $req['selected_location'];
                }
                $res['type'] = $req['type'];
                $res['selected_round'] = $req['selected_round'];
                $res['time_duration'] = $req['time_duration'];
                $res['interview_rooms'] = $req['interview_rooms'];
                if ($req['interviewer_options']) {
                    $res['interviewer_options'] = $req['interviewer_options'];
                }
                $res['mode'] = $req['mode'];
                $res['interviewers'] = [];
                $res['timings'] = [];
                if ($req['interviewers']) {
                    foreach ($req['interviewers'] as $r) {
                        $res['interviewers'][] = [
                            'name' => $r['name'],
                            'email' => $r['email'],
                            'phone' => $r['phone'],
                        ];
                    }
                }
                if ($req['timings']) {
                    foreach ($req['timings'] as $key => $value) {
                        $res['timings'][$key] = $value;
                    }
                }
            } else {
                $res['application'] = $req['application_id'];
                if ($req['selected_location']) {
                    $res['selected_location'] = $req['selected_location'];
                }
                $res['type'] = $req['type'];
                $res['mode'] = $req['mode'];
                $res['selected_round'] = $req['selected_round'];
                $res['selected_candidate'] = $req['selected_candidate'];
                if (empty($res)) {
                    return [
                        'status' => 201,
                    ];
                }
                $res['interviewers'] = [];
                $res['timings'] = [];
                if ($req['interviewers']) {
                    foreach ($req['interviewers'] as $r) {
                        $res['interviewers'][] = [
                            'name' => $r['name'],
                            'email' => $r['email'],
                            'phone' => $r['phone'],
                        ];
                    }
                }
                foreach ($req['timings'] as $key => $value) {
                    $res['timings'][$key] = $value;
                }
            }

            $save = $this->saveData($res);
            if ($save) {
                $job = EmployerApplications::find()
                    ->alias('a')
                    ->select(['a.title', 'b.assigned_category_enc_id', 'b.category_enc_id', 'c.name'])
                    ->joinWith(['title b' => function ($b) {
                        $b->joinWith(['categoryEnc c'], false);
                    }], false)
                    ->where(['a.application_enc_id' => $save[0]->application_enc_id])
                    ->asArray()
                    ->one();
                $this->sendComapanyMail($job, $res['timings']);
                if ($res['interviewer_options']) {
                    $this->sendInterviewerMail($save[2], $res['interviewer_options'], $job, $res['timings']);
                }
                if ($res['type'] == 'fixed') {
                    $this->findCandidates($save[1], $save[0]->application_enc_id, $res['timings'], $job);
                } elseif ($res['type'] == 'flexible') {
                    $this->findCandidatesFlexible($save[0]->scheduled_interview_enc_id, $job, $res['timings']);
                }
                return [
                    'status' => 200,
                    'response' => $res,
                    'data' => $save
                ];
            } else {
                return [
                    'status' => 201,
                ];
            }
//            $res = $this->findOrganizationInterviewLocations($req['application_id']);

        }
    }

    private function sendComapanyMail($data, $timing)
    {
        $mail = Yii::$app->mail;
        $mail->receivers = [];
        $mail->receivers[] = [
            "name" => Yii::$app->user->identity->organization->name,
            "email" => Yii::$app->user->identity->organization->email,
        ];
        $mail->subject = 'New Interview Scheduled By Your Organization';
        $mail->data = ['job' => $data['title'], 'timing' => $timing];
        $mail->template = 'schedular-for-org';
        if ($mail->send()) {
            $mail_logs = new EmailLogs();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $mail_logs->email_log_enc_id = $utilitiesModel->encrypt();
            $mail_logs->email_type = 3;
            $mail_logs->user_enc_id = Yii::$app->user->identity->user_enc_id;
            $mail_logs->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
            $mail_logs->subject = $mail->subject;
            $mail_logs->template = $mail->template;
            $mail_logs->save();
        }
    }

    private function sendInterviewerMail($interviewer, $type, $data, $timing)
    {
        foreach ($interviewer as $i) {
            $mail = Yii::$app->mail;
            $mail->receivers = [];
            $mail->receivers[] = [
                'name' => $i['name'],
                'email' => $i['email']
            ];
            if ($type == 'zero') {
                $mail->subject = 'You are selected to take interview';
                $mail->data = ['data' => $data, 'timing' => $timing, 'name' => $i['name']];
                $mail->template = 'schedular-for-interviewers';
            } elseif ($type == 'one') {
                $mail->subject = 'you are selected to take interview';
                $mail->data = ['data' => $data, 'id' => $i['interviewer_enc_id'], 'timing' => $timing, 'name' => $i['name']];
                $mail->template = 'request-for-acceptance';
            }
            if ($mail->send()) {

            }
        }
    }

    private function sendCandidateMail($applied_candidate, $data, $time)
    {

        $candidates = [];
        $user = [];

        foreach ($applied_candidate as $a) {
            $user['name'] = $a['name'];
            $user['email'] = $a['email'];
            array_push($candidates, $user);
        }

        $mail = Yii::$app->mail;
        $mail->receivers = [];
        $mail->receivers = $candidates;
        $mail->subject = 'interview scheduled by company for ' . $data['name'];
        $mail->data = ['data' => $data, 'timing' => $time];
        $mail->template = 'interview-schedular';
        if ($mail->send()) {

        }
    }

    private function findCandidatesFlexible($id, $data, $time)
    {
        $candidate = InterviewCandidates::find()
            ->alias('a')
            ->select(['a.applied_application_enc_id', 'CONCAT(c.first_name, " ", c.last_name) name', 'c.email'])
            ->joinWith(['appliedApplicationEnc b' => function ($b) {
                $b->joinWith(['createdBy c']);
            }], false)
            ->where(['a.scheduled_interview_enc_id' => $id])
            ->asArray()
            ->all();

        if (!empty($candidate)) {
            $this->sendCandidateMail($candidate, $data, $time);
        }
    }

    private function findCandidates($data, $app_id, $time, $data1)
    {
        $applied_candidates = AppliedApplications::find()
            ->alias('a')
            ->select(['a.applied_application_enc_id', 'a.resume_enc_id', 'b.user_enc_id', 'CONCAT(c.first_name, " ", c.last_name) name', 'c.email', 'a.current_round', 'e.sequence'])
            ->joinWith(['resumeEnc b' => function ($x) {
                $x->joinWith(['userEnc c']);
            }], false)
            ->joinWith(['appliedApplicationProcesses d' => function ($d) use ($data) {
                $d->joinWith(['fieldEnc e']);
                $d->where(['d.field_enc_id' => $data->process_field_enc_id]);
            }], false)
            ->where([
                'application_enc_id' => $app_id
            ])
            ->andWhere(new \yii\db\Expression('`a`.`current_round` = `e`.`sequence`'))
            ->groupBy(['b.user_enc_id'])
            ->asArray()
            ->all();

        if (!empty($applied_candidates)) {
            $this->sendCandidateMail($applied_candidates, $data1, $time);
        }
    }

    private function divideTime($StartTime, $EndTime, $Duration)
    {
        $ReturnArray = [];
        $StartTime = strtotime($StartTime);
        $EndTime = strtotime($EndTime);

        $AddMins = $Duration * 60;

        while ($StartTime <= $EndTime) {
            $ReturnArray[] = date("G:i", $StartTime);
            $StartTime += $AddMins;
        }
        return $ReturnArray;
    }

    private function saveData($data)
    {

        if ($data['type'] == 'fixed') {
            $duration = $data['time_duration'];
            $result = [];

            foreach ($data['timings'] as $date => $value) {
                $result[$date] = [];
                $a = [];
                foreach ($value as $t) {
                    $a = array_merge($a, $this->divideTime($t['from'], $t['to'], $duration));
                }
                array_push($result[$date], $a);
            }
        }


        $_flag = null;

        if ($data['mode'] == 'online') {
            $mode = 1;
        } elseif ($data['mode'] == 'at_location') {
            $mode = 2;
        }

        $candidate_applications = explode(',', $data['selected_candidate']);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $required_data = [];
            $interview = new ScheduledInterview();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $interview->scheduled_interview_enc_id = $utilitiesModel->encrypt();
            $interview->scheduled_interview_type_enc_id = $this->interviewType($data['type']);
            $interview->application_enc_id = $data['application'];
            $interview->interview_mode = $mode;
            if ($mode == 2) {
                $interview->interview_location_enc_id = $data['selected_location'];
            }
            $interview->created_by = Yii::$app->user->identity->user_enc_id;
            $interview->created_on = date('Y-m-d H:i:s');
            array_push($required_data, $interview);

            if ($interview->save()) {

                if ($data['type'] == 'fixed') {

                    $interview_options = new InterviewOptions();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $interview_options->interview_options_enc_id = $utilitiesModel->encrypt();
                    $interview_options->scheduled_interview_enc_id = $interview['scheduled_interview_enc_id'];
                    $interview_options->process_field_enc_id = $data['selected_round'];
                    $interview_options->number_of_candidates = $data['number_of_candidates'];
                    $interview_options->interview_duration = $data['time_duration'];
                    $interview_options->interview_rooms = $data['interview_rooms'];
                    if ($data['interviewer_options']) {
                        if ($data['interviewer_options'] == 'zero') {
                            $interview_options->interviewer_required = 0;
                        } elseif ($data['interviewer_options'] == 'one') {
                            $interview_options->interviewer_required = 1;
                        }
                    }
                    array_push($required_data, $interview_options);
                    if (!$interview_options->save()) {
                        $transaction->rollback();
                        return false;
                    }

                    foreach ($result as $date => $time) {

                        $date = date('Y-m-d', strtotime($date));

                        $interview_dates = new InterviewDates();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $interview_dates->interview_date_enc_id = $utilitiesModel->encrypt();
                        $interview_dates->scheduled_interview_enc_id = $interview['scheduled_interview_enc_id'];
                        $interview_dates->interview_date = $date;
                        if ($interview_dates->save()) {

                            $count = count($time[0]);
                            $j = 0;
                            for ($i = 0; $i <= $count - 2; $i++) {

                                $interview_date_timing = new InterviewDateTimings();
                                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                                $interview_date_timing->interview_date_timing_enc_id = $utilitiesModel->encrypt();
                                $interview_date_timing->interview_date_enc_id = $interview_dates['interview_date_enc_id'];
                                $interview_date_timing->from = date("H:i", strtotime($time[0][$j]));
                                $interview_date_timing->to = date("H:i", strtotime($time[0][++$j]));
                                if (!$interview_date_timing->save()) {
                                    $transaction->rollback();
                                    return false;
                                }
                            }

                        } else {
                            $transaction->rollback();
                            return false;
                        }
                    }

                } elseif ($data['type'] == 'flexible') {

                    foreach ($candidate_applications as $application_enc_id) {
                        $candidate_data = [];
                        $interview_candidate = new InterviewCandidates();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $interview_candidate->interview_candidate_enc_id = $utilitiesModel->encrypt();
                        $interview_candidate->process_field_enc_id = $data['selected_round'];
                        $interview_candidate->type = $data['type'];
                        $interview_candidate->scheduled_interview_enc_id = $interview['scheduled_interview_enc_id'];
                        $interview_candidate->applied_application_enc_id = $application_enc_id;
                        array_push($candidate_data, $interview_candidate);
                        if (!$interview_candidate->save()) {
                            $transaction->rollback();
                            return false;
                        }
                    }
                    array_push($required_data, $candidate_data);


                    foreach ($data['timings'] as $date => $time) {

                        $date = date('Y-m-d', strtotime($date));

                        $interview_dates = new InterviewDates();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $interview_dates->interview_date_enc_id = $utilitiesModel->encrypt();
                        $interview_dates->scheduled_interview_enc_id = $interview['scheduled_interview_enc_id'];
                        $interview_dates->interview_date = $date;
                        if ($interview_dates->save()) {

                            foreach ($time as $t) {

                                $interview_date_timing = new InterviewDateTimings();
                                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                                $interview_date_timing->interview_date_timing_enc_id = $utilitiesModel->encrypt();
                                $interview_date_timing->interview_date_enc_id = $interview_dates['interview_date_enc_id'];
                                $interview_date_timing->from = date("H:i", strtotime($t['from']));
                                $interview_date_timing->to = date("H:i", strtotime($t['to']));
                                if (!$interview_date_timing->save()) {
                                    $transaction->rollback();
                                    return false;
                                }
                            }

                        } else {
                            $transaction->rollback();
                            return false;
                        }
                    }

                }

                if ($data['interviewers']) {
                    $user = [];
                    $users = [];

                    foreach ($data['interviewers'] as $i) {

                        if (!empty($i['name']) && !empty($i['email']) && !empty($i['phone'])) {

                            $interviewer = new Interviewers();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $interviewer->interviewer_enc_id = $utilitiesModel->encrypt();
                            $interviewer->scheduled_interview_enc_id = $interview['scheduled_interview_enc_id'];

                            if ($interviewer->save()) {


                                $interviewer_detail = new InterviewerDetail();
                                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                                $interviewer_detail->interviewer_detail_enc_id = $utilitiesModel->encrypt();
                                $interviewer_detail->interviewer_enc_id = $interviewer['interviewer_enc_id'];
                                $interviewer_detail->name = $i['name'];
                                $interviewer_detail->email = $i['email'];
                                $interviewer_detail->phone = $i['phone'];
                                $user['interviewer_enc_id'] = $interviewer_detail->interviewer_detail_enc_id;
                                $user['name'] = $interviewer_detail->name;
                                $user['email'] = $interviewer_detail->email;
                                array_push($users, $user);

                                if (!$interviewer_detail->save()) {
                                    $transaction->rollback();
                                    return false;
                                }
                            } else {
                                $transaction->rollback();
                                return false;
                            }
                        }

                    }
                    array_push($required_data, $users);

                }

                $transaction->commit();
                return $required_data;
            } else {
                $transaction->rollback();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    private function interviewType($type)
    {

        $type = InterviewTypes::find()
            ->select(['interview_type_enc_id'])
            ->where(['name' => $type])
            ->one();

        return $type->interview_type_enc_id;
    }

    public function actionUpdateInterview()
    {
        if (Yii::$app->user->identity->organization->organization_enc_id) {
            return $this->render('update');
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionGetInterviewData()
    {

        if (Yii::$app->request->isAjax) {

            $company_scheduled_interview = ScheduledInterview::find()
                ->alias('a')
                ->distinct()
                ->select(['a.scheduled_interview_enc_id', 'b.application_enc_id', 'e.name profile', 'd.name job_title', 'f.name interview_type', '(CASE
                    WHEN a.interview_mode = 1 THEN "online"
                    WHEN a.interview_mode = 2 THEN m.name
                    END) as interview_at',
                    'o.interview_date_enc_id',
                    'o.interview_date',
                    'z.designation',
//                    'p.from',
//                    'p.to',
//                    'p.interview_date_timing_enc_id',
                ])
                ->innerJoinWith(['applicationEnc b' => function ($b) {
                    $b->joinWith(['designationEnc z']);
                    $b->joinWith(['title c' => function ($c) {
                        $c->joinWith(['categoryEnc d']);
                        $c->joinWith(['parentEnc e'], false);
                    }], false);
                    $b->onCondition(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]);
                }], false)
                ->joinWith(['interviewLocationEnc k' => function ($k) {
                    $k->joinWith(['locationEnc l' => function ($l) {
                        $l->joinWith(['cityEnc m']);
                    }]);
                }], false)
                ->joinWith(['scheduledInterviewTypeEnc f'], false)
                ->joinWith(['interviewDates o' => function ($o) {
                    $o->andWhere(['o.is_deleted' => 1]);
                    $o->joinWith(['interviewDateTimings p' => function ($p) {
                        $p->andWhere(['p.is_deleted' => 1]);
                    }]);
                }])
                ->where(['a.status' => 1])
                ->asArray()
                ->all();

            $data = [];
            $i = 0;
            $old_id = null;
            $time_from_to = [];
            $time = [];
            $fixed_result = [];
            $fixed_data = [];
            foreach ($company_scheduled_interview as $f) {
                $fixed_data['EventId'] = $f['scheduled_interview_enc_id'];
                $fixed_data['Subject'] = $f['job_title'];
                $fixed_data['Profile'] = $f['profile'];
                $fixed_data['designation'] = $f['designation'];
                $fixed_data['ThemeColor'] = 'green';
                $fixed_data['interview_type'] = $f['interview_type'];
                $fixed_data['interview_at'] = $f['interview_at'];
                $fixed_data['interview_date_enc_id'] = $f['interview_date_enc_id'];
                $interview_date = $f['interview_date'];
                $fixed_data['Start'] = $interview_date;
                $fixed_data['End'] = $interview_date;
                $fixed_data['application_enc_id'] = $f['application_enc_id'];
                $ti = $f['interviewDates'][$i]['interviewDateTimings'];
                if ($f['interview_type'] == 'fixed') {
                    if ($f['scheduled_interview_enc_id'] == $old_id) {
                        $old_id = $f['scheduled_interview_enc_id'];
                        $i++;
                    } else {
                        $old_id = $f['scheduled_interview_enc_id'];
                        $i = 0;
                    }
                    $ti = $f['interviewDates'][$i]['interviewDateTimings'];
                    foreach ($ti as $t) {
                        $time_from_to['interview_date_timing_enc_id'] = $t['interview_date_timing_enc_id'];
                        $time_from_to['from'] = date("g:i a", strtotime($t['from']));
                        $time_from_to['to'] = date("g:i a", strtotime($t['to']));
                        array_push($time, $time_from_to);
                    }
                    $fixed_data['time'] = $time;
                    $time = [];
                } else {
                    $time_from_to['interview_date_timing_enc_id'] = $ti[0]['interview_date_timing_enc_id'];
                    $time_from_to['from'] = date("g:i a", strtotime($ti[0]['from']));
                    $time_from_to['to'] = date("g:i a", strtotime($ti[0]['to']));
                    array_push($time, $time_from_to);
                    $fixed_data['time'] = $time;
                    $time = [];
                }

                array_push($fixed_result, $fixed_data);
            }

            return json_encode($fixed_result);
        }
    }

    public function actionGetUsersData()
    {
        $interviews = InterviewCandidates::find()
            ->alias('a')
            ->select(['a.scheduled_interview_enc_id', 'f.name title'])
            ->joinWith(['appliedApplicationEnc b' => function ($b) {
//                $b->joinWith(['createdBy c']);
                $b->joinWith(['applicationEnc d' => function ($d) {
                    $d->joinWith(['title e' => function ($e) {
                        $e->joinWith(['categoryEnc f'], false);
                    }], false);
                }], false);
            }])
            ->joinWith(['scheduledInterviewEnc c'])
//            ->where(['b.created_by' => Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->all();
        print_r($interviews);
        exit();
    }

    public function actionGetDataToUpdate()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $scheduled_interview_enc_id = Yii::$app->request->post('scheduled_interview_enc_id');
            $id = Yii::$app->request->post('application_enc_id');
            $type = Yii::$app->request->post('type');

            $all_data = [];
            $data = $this->getData($scheduled_interview_enc_id);
            $application_locations = $this->findOrganizationInterviewLocations($id);


            $application_process = $this->findApplicationFields($id);
            $all_data['application_process'] = $application_process;
            $applied_candidates = $this->findAppliedCandidates($id);
            $all_data['applied_candidates'] = $applied_candidates;

            $all_data['application_location'] = $application_locations;
            $all_data['data_to_update'] = $data;

            return json_encode($all_data);
        }
    }

    private function getData($s_id)
    {
        $data = ScheduledInterview::find()
            ->alias('a')
            ->select(['a.scheduled_interview_enc_id', 'a.interview_mode', 'a.interview_location_enc_id', 'b.name interview_type', 'c.number_of_candidates', 'c.process_field_enc_id'])
            ->joinWith(['scheduledInterviewTypeEnc b'], false)
            ->joinWith(['interviewOptions c' => function ($c) {
                $c->onCondition(['c.is_deleted' => 1]);
            }], false)
            ->joinWith(['interviewCandidates d' => function ($d) {
                $d->select(['d.scheduled_interview_enc_id', 'd.applied_application_enc_id']);
                $d->onCondition(['d.is_deleted' => 1]);
            }])
            ->joinWith(['interviewDates f' => function ($f) {
                $f->onCondition(['f.is_deleted' => 1]);
                $f->joinWith(['interviewDateTimings']);
            }])
            ->where(['a.scheduled_interview_enc_id' => $s_id])
            ->groupBy('a.scheduled_interview_enc_id')
            ->asArray()
            ->all();

        return $data;
    }

    public function actionUpdateData()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            //getting data from ajax to update
            $data = Yii::$app->request->post();

            //creating array of applied_application_enc_id
            $candidate_applications = explode(',', $data['candidates']);

            $utilitiesModel = new \common\models\Utilities();

            //check interview scheduled or not
            $sechduled = ScheduledInterview::find()
                ->where(['scheduled_interview_enc_id' => $data['schedule_interview_id']])
                ->one();

            //check interview options data
            $interview_option = InterviewOptions::find()
                ->where(['scheduled_interview_enc_id' => $data['schedule_interview_id'], 'is_deleted' => 1])
                ->one();

            //check interview candidate data
            $interview_candidates = InterviewCandidates::find()
                ->where(['scheduled_interview_enc_id' => $data['schedule_interview_id'], 'is_deleted' => 1])
                ->asArray()
                ->all();

            //extracting applied_application_enc_id
            $candidates_application_enc_id = [];
            foreach ($interview_candidates as $i) {
                array_push($candidates_application_enc_id, $i['applied_application_enc_id']);
            }


            $to_be_added = array_diff($candidate_applications, $candidates_application_enc_id);
            $to_be_deleted = array_diff($candidates_application_enc_id, $candidate_applications);


            //checking interview dates
            $interview_dates = InterviewDates::find()
                ->where(['interview_date_enc_id' => $data['date_enc_id'], 'is_deleted' => 1])
                ->one();

            //check intervie date timings
            $interview_time = InterviewDateTimings::find()
                ->where(['interview_date_timing_enc_id' => $data['date_time_enc_id'], 'is_deleted' => 1])
                ->one();

            //if scheduled go to update
            if ($sechduled) {

                if ($data['i_mode'] == 2) {
                    $sechduled->interview_location_enc_id = $data['location'];
                }
                $sechduled->interview_mode = $data['i_mode'];
                $sechduled->scheduled_interview_type_enc_id = $this->interviewType($data['i_type']);

                if ($sechduled->update()) {

                    //if type fixed then deleted from interview candidates if it has data
                    if ($data['i_type'] == 'fixed') {

                        if ($interview_candidates) {
                            foreach ($candidates_application_enc_id as $id) {
                                $to_delete = InterviewCandidates::find()
                                    ->where(['applied_application_enc_id' => $id, 'is_deleted' => 1])
                                    ->one();

                                $to_delete->is_deleted = 0;
                                if (!$to_delete->update()) {
                                    return false;
                                }
                            }
                        }

                        //update interview options if it has data else add new data
                        if ($interview_option) {
                            $interview_option->process_field_enc_id = $data['application_process'];
                            $interview_option->number_of_candidates = $data['candidate_numbers'];
                            if (!$interview_option->update()) {
                                return false;
                            }
                        } else {
                            $interview_options = new InterviewOptions();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $interview_options->interview_options_enc_id = $utilitiesModel->encrypt();
                            $interview_options->scheduled_interview_enc_id = $data['schedule_interview_id'];
                            $interview_options->process_field_enc_id = $data['application_process'];
                            $interview_options->number_of_candidates = $data['candidate_numbers'];
                            if (!$interview_options->save()) {
                                return false;
                            }
                        }
                    } //if type flexible then delete data from interview option if his has already
                    elseif ($data['i_type'] == 'flexible') {

                        if ($interview_option) {
                            $interview_option->is_deleted = 0;
                            if (!$interview_option->update()) {
                                return false;
                            }
                        }

                        //update data if interview candidates has data
                        if ($interview_candidates) {
                            if (!empty($to_be_added)) {
                                $this->addCandidates($to_be_added, $data);
                            }
                            if (!empty($to_be_deleted)) {
                                foreach ($to_be_deleted as $t) {
                                    $to_delete = InterviewCandidates::find()
                                        ->where(['applied_application_enc_id' => $t])
                                        ->one();

                                    $to_delete->is_deleted = 0;
                                    if (!$to_delete->update()) {
                                        return false;
                                    }
                                }
                            }
                        } else {
                            //saving selected candidates to Interview candidates table
                            $this->addCandidates($candidate_applications, $data);
                        }

                    }


                    if ($interview_dates) {

                        //delete previous data and time from previous data
                        $interview_dates->is_deleted = 0;
                        if ($interview_dates->update()) {
                            $interview_time->is_deleted = 0;
                            if (!$interview_time->update()) {
                                return false;
                            }
                        }

                        //add new row in date_time table
                        $date = date('Y-m-d', strtotime($data['date']));

                        $interview_date = new InterviewDates();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $interview_date->interview_date_enc_id = $utilitiesModel->encrypt();
                        $interview_date->scheduled_interview_enc_id = $data['schedule_interview_id'];
                        $interview_date->interview_date = $date;
                        if ($interview_date->save()) {
                            $interview_date_timing = new InterviewDateTimings();
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $interview_date_timing->interview_date_timing_enc_id = $utilitiesModel->encrypt();
                            $interview_date_timing->interview_date_enc_id = $interview_date['interview_date_enc_id'];
                            $interview_date_timing->from = date("H:i", strtotime($data['time_from']));
                            $interview_date_timing->to = date("H:i", strtotime($data['time_to']));
                            if (!$interview_date_timing->save()) {
                                return false;
                            }
                        }

                    }
                    return true;
                }
            }
        }
    }

    private function addCandidates($candidate_applications, $data)
    {
        $utilitiesModel = new \common\models\Utilities();
        foreach ($candidate_applications as $application_enc_id) {
            $interview_candidate = new InterviewCandidates();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $interview_candidate->interview_candidate_enc_id = $utilitiesModel->encrypt();
            $interview_candidate->scheduled_interview_enc_id = $data['schedule_interview_id'];
            $interview_candidate->applied_application_enc_id = $application_enc_id;
            if (!$interview_candidate->save()) {
                return false;
            }
        }
    }

}