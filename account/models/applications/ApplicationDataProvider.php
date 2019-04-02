<?php

namespace account\models\applications;

use common\models\ApplicationInterviewLocations;
use common\models\ApplicationPlacementLocations;
use common\models\EmployerApplications;
use yii\helpers\ArrayHelper;

class ApplicationDataProvider
{
    public function setValues($model, $aidk)
    {
        $object = EmployerApplications::find()
            ->alias('a')
            ->where(['a.application_enc_id' => $aidk])
            ->select(['a.application_enc_id', 'b.interview_start_date', 'b.interview_end_date', 'a.interview_process_enc_id', 'b.pre_placement_offer', 'b.has_placement_offer', 'b.has_online_interview', 'b.has_questionnaire', 'b.has_benefits', 'b.wage_duration', 'b.wage_type', 'b.min_wage', 'b.max_wage', 'b.fixed_wage', 'b.wage_type', 'a.experience', 'a.preferred_industry', 'a.preferred_gender', 'a.description', 'a.type', 'a.timings_from', 'a.timings_to', 'a.joining_date', 'a.last_date', 'l.category_enc_id primaryfield', 'm.name titles', 'n.designation_enc_id', 'n.designation',
                '(CASE
                WHEN b.wage_type = "Unpaid" THEN 0
                WHEN b.wage_type = "Fixed" THEN 1
                WHEN b.wage_type = "Negotiable" THEN 2
                WHEN b.wage_type = "Performance Based" THEN 3
                END) as wage_type', 'b.working_days'])
            ->joinwith(['title k' => function ($b) {
                $b->joinWith(['parentEnc l'], false);
                $b->joinWith(['categoryEnc m'], false);
            }], 'INNER JOIN', false)
            ->joinWith(['designationEnc n'], false)
            ->joinWith(['applicationOptions b'], false, 'INNER JOIN')
            ->joinWith(['applicationJobDescriptions i' => function ($b) {
                $b->joinWith(['jobDescriptionEnc j'], false, 'INNER JOIN');
                $b->select(['i.application_enc_id', 'j.job_description']);
            }])
            ->joinWith(['applicationSkills g' => function ($b) {
                $b->joinWith(['skillEnc h'], false, 'INNER JOIN');
                $b->select(['g.application_enc_id', 'h.skill']);
            }])
            ->joinWith(['applicationEducationalRequirements e' => function ($b) {
                $b->joinWith(['educationalRequirementEnc f'], false);
                $b->select(['e.application_enc_id', 'f.educational_requirement']);
            }])
            ->joinWith(['applicationEmployeeBenefits c' => function ($b) {
                $b->onCondition(['c.is_deleted' => 0]);
                $b->joinWith(['benefitEnc d'], false);
                $b->select(['c.application_enc_id', 'c.benefit_enc_id']);
            }])
            ->joinWith(['applicationInterviewQuestionnaires q' => function ($b) {
                $b->onCondition(['q.is_deleted' => 0]);
                $b->select(['q.field_enc_id', 'q.questionnaire_enc_id', 'q.application_enc_id']);
            }])
            ->asArray()
            ->one();
        $applicationPlacementLocations = ApplicationPlacementLocations::find()
            ->select(['location_enc_id','positions'])
            ->where(['application_enc_id' => $aidk,'is_deleted'=>0])
            ->asArray()
            ->all();
        $applicationInterviewLocations = ApplicationInterviewLocations::find()
            ->select(['location_enc_id'])
            ->where(['application_enc_id' => $aidk,'is_deleted'=>0])
            ->asArray()
            ->all();
        $jobDescription = ArrayHelper::getColumn($object['applicationJobDescriptions'], 'job_description');
        $PlacementLocations = ArrayHelper::getColumn($applicationPlacementLocations, 'location_enc_id');
        $PlacementPosition = ArrayHelper::getColumn($applicationPlacementLocations, 'positions');
        $skills = ArrayHelper::getColumn($object['applicationSkills'], 'skill');
        $education_qualifaication = ArrayHelper::getColumn($object['applicationEducationalRequirements'], 'educational_requirement');
        $InterviewLocations = ArrayHelper::getColumn($applicationInterviewLocations, 'location_enc_id');
        $questionnaire = ArrayHelper::getColumn($object['applicationInterviewQuestionnaires'], 'questionnaire_enc_id');
        $questionfields = ArrayHelper::getColumn($object['applicationInterviewQuestionnaires'], 'field_enc_id');
        $empBenefits = ArrayHelper::getColumn($object['applicationEmployeeBenefits'], 'benefit_enc_id');
        setlocale(LC_MONETARY, 'en_IN');
        $model->title = $object['titles'];
        $model->designations = $object['designation'];
        $model->primaryfield = $object['primaryfield'];
        $model->type = $object['type'];
        $model->gender = $object['preferred_gender'];
        $model->from = date("g:i a", strtotime($object['timings_from']));
        $model->to = date("g:i a", strtotime($object['timings_to']));
        $model->earliestjoiningdate = date('d-M-Y', strtotime($object['joining_date']));
        $model->last_date = date('d-M-Y', strtotime($object['last_date']));
        $model->min_exp = $object['experience'];
        $model->othrdetail = $object['description'];
        $model->industry = $object['preferred_industry'];
        $model->wage_type = $object['wage_type'];
        $model->wage_duration = $object['wage_duration'];
        $model->min_wage = utf8_encode(money_format('%!.0n', $object['min_wage']));
        $model->max_wage = utf8_encode(money_format('%!.0n', $object['max_wage']));
        $model->fixed_wage = utf8_encode(money_format('%!.0n', $object['fixed_wage']));
        $model->placement_locations = $PlacementLocations;
        $model->weekdays = json_decode($object['working_days']);
        $model->clone_desc = json_encode($jobDescription);
        $model->clone_skills = json_encode($skills);
        $model->clone_edu = json_encode($education_qualifaication);
        $model->questionnaire_selection = $object['has_questionnaire'];
        $model->pre_placement_package = $object['pre_placement_offer'];
        $model->pre_placement_offer = $object['has_placement_offer'];
        $model->benefit_selection = $object['has_benefits'];
        $model->interview_process = $object['interview_process_enc_id'];
        if (!empty($object['interview_start_date']) || !empty($object['interview_end_date'])) {
            $model->interradio = 1;
            $model->startdate = date('d-m-y', strtotime($object['interview_start_date']));
            $model->enddate = date('d-m-y', strtotime($object['interview_end_date']));
            $model->interviewstarttime = date('g:i a', strtotime($object['interview_start_date']));
            $model->interviewendtime = date('g:i a', strtotime($object['interview_end_date']));
        } else {
            $model->interradio = 0;
        }
        if ($object['has_online_interview'] == 1) {
            array_push($InterviewLocations, "online001");
        }
        $model->interviewcity = $InterviewLocations;
        $model->emp_benefit = $empBenefits;
        $model->positions = json_encode($PlacementPosition);
        $model->questionnaire = $questionnaire;
        $model->questionfields = json_encode($questionfields);
        return $model;
    }
}