<?php

namespace account\controllers;

use account\models\scheduler\InterviewForm;
use common\models\ApplicationInterviewLocations;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\AppliedApplications;
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

class SchedularController extends Controller
{
    public function actionTest()
    {
        return $this->render('test');
    }

    public function actionFindApplications()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $req = Yii::$app->request->post();
            $organization_id = Yii::$app->user->identity->organization->organization_enc_id;
            $res = $this->findOrganizationApplications($organization_id);
            return [
                'response' => $res
            ];
        }
    }

    public function findOrganizationApplications($id)
    {
        return EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.title', 'b.assigned_category_enc_id', 'b.category_enc_id', 'b.parent_enc_id', 'CONCAT(c.name, " - ", d.name) application_name'])
            ->innerJoinWith(['applicationInterviewQuestionnaires z'])
            ->innerJoinWith(['appliedApplications t'])
            ->joinWith(['title b' => function ($x) {
                $x->joinWith(['categoryEnc c']);
                $x->joinWith(['parentEnc d']);
            }], false)
            ->where([
                'a.organization_enc_id' => $id,
                'a.is_deleted' => 0,
            ])
            ->groupBy(['a.application_enc_id'])
            ->asArray()
            ->all();
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
            ->asArray()
            ->all();
    }

    public function actionFindCandidates()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $req = Yii::$app->request->post();
            $res = $this->findAppliedCandidates($req['application_id']);
            return [
                'results' => $res
            ];
        }
    }

    public function findAppliedCandidates($id)
    {
        return AppliedApplications::find()
            ->alias('a')
            ->select(['a.applied_application_enc_id', 'a.resume_enc_id', 'b.user_enc_id', 'CONCAT(c.first_name, " ", c.last_name) full_name', 'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, true) . '", c.image_location, "/", c.image) ELSE  CONCAT("https://ui-avatars.com/api/?name=", c.first_name, " ", c.last_name, "&size=200&rounded=false&background=", REPLACE(c.initials_color, "#", ""), "&color=ffffff") END image'])
            ->joinWith(['resumeEnc b' => function ($x) {
                $x->joinWith(['userEnc c']);
//                    $x->groupBy(['b.user_enc_id']);
            }], false)
            ->where([
                'application_enc_id' => $id
            ])
            ->groupBy(['b.user_enc_id'])
            ->asArray()
            ->all();
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
                $res['mode'] = $req['mode'];
                $res['interviewers'] = [];
                $res['timings'] = [];
                foreach ($req['interviewers'] as $r) {
                    $res['interviewers'][] = [
                        'name' => $r['name'],
                        'email' => $r['email'],
                        'phone' => $r['phone'],
                    ];
                }
                foreach ($req['timings'] as $key => $value) {
                    $res['timings'][$key] = $value;
                }
            } else {
                $res['application'] = $req['application_id'];
                if ($req['selected_location']) {
                    $res['selected_location'] = $req['selected_location'];
                }
                $res['type'] = $req['type'];
                $res['selected_candidate'] = $req['selected_candidate'];
                $res['interviewers'] = [];
                $res['timings'] = [];
                foreach ($req['interviewers'] as $r) {
                    $res['interviewers'][] = [
                        'name' => $r['name'],
                        'email' => $r['email'],
                        'phone' => $r['phone'],
                    ];
                }
                foreach ($req['timings'] as $key => $value) {
                    $res['timings'][$key] = $value;
                }
            }

            $save = $this->saveData($res);
//            $res = $this->findOrganizationInterviewLocations($req['application_id']);
            return [
                'status' => 200,
                'response' => $res
            ];
        }
    }

    private function saveData($data)
    {
        print_r($data);
        die();
        if ($data['mode'] == 'online') {
            $mode = 1;
        } elseif ($data['mode'] == 'at_location') {
            $mode = 2;
        }

        $interview = new ScheduledInterview();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $interview->scheduled_interview_enc_id = $utilitiesModel->encrypt();
        $interview->scheduled_interview_type_enc_id = $this->interviewType($data['type']);
        $interview->application_enc_id = $data['application'];
        $interview->interview_mode = $mode;
        $interview->interview_location_enc_id = $data['selected_location'];
        $interview->created_by = Yii::$app->user->identity->organization->organization_enc_id;
        $interview->created_on = date('Y-m-d H:i:s');

        if ($interview->save()) {

            if($data['type'] == 'fixed') {

                $interview_options = new InterviewOptions();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $interview_options->interview_options_enc_id = $utilitiesModel->encrypt();
                $interview_options->scheduled_interview_enc_id = $interview['scheduled_interview_enc_id'];
                $interview_options->process_field_enc_id = $data['selected_round'];
                $interview_options->number_of_candidates = $data['number_of_candidates'];
                if (!$interview_options->save()) {

                }

            }elseif ($data['type'] == 'flexible'){

                $interview_candidate = new InterviewCandidates();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $interview_candidate->interview_candidate_enc_id = $utilitiesModel->encrypt();
                $interview_candidate->scheduled_interview_enc_id = $interview['scheduled_interview_enc_id'];
                $interview_candidate->applied_application_enc_id = '';
            }

            $interviewer = new Interviewers();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $interviewer->interviewers_enc_id = $utilitiesModel->encrypt();
            $interviewer->scheduled_interview_enc_id = $interview['scheduled_interview_enc_id'];

            if($interviewer->save()){

                $interviewer_detail = new InterviewerDetail();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $interviewer_detail->interviewer_detail_enc_id = $utilitiesModel->encrypt();
                $interviewer_detail->interviewer_enc_id = $interviewer['interviewers_enc_id'];
                $interviewer_detail->name = $data['name'];
                $interviewer_detail->email = $data['email'];
                $interviewer_detail->phone = $data['phone'];
                if (!$interviewer_detail->save()){

                }
            }

            foreach ($data['timings'] as $date => $time) {

                $interview_dates = new InterviewDates();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $interview_dates->interview_dates_enc_id = $utilitiesModel->encrypt();
                $interview_dates->scheduled_interview_enc_id = $interview['scheduled_interview_enc_id'];
                $interview_dates->interview_date = $date;
                if ($interview_dates->save()) {

                    $interview_date_timing = new InterviewDateTimings();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $interview_date_timing->interview_date_timing_enc_id = $utilitiesModel->encrypt();
                    $interview_date_timing->interview_dates_enc_id = $interview_dates['interview_dates_enc_id'];
                    $interview_date_timing->from = $time[0]['from'];
                    $interview_date_timing->to = $time[0]['to'];
                    if($interview_date_timing->save()){

                    }

                }
            }


        }

        print_r($interview_options);
        die();
    }

    private function interviewType($type)
    {

        $type = InterviewTypes::find()
            ->select(['interview_type_enc_id'])
            ->where(['name' => $type])
            ->one();

        return $type->interview_type_enc_id;
    }
}