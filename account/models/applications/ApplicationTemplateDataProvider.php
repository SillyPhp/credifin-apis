<?php

namespace account\models\applications;
use common\models\ApplicationTemplates;
use common\models\Utilities;
use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Model;

class ApplicationTemplateDataProvider extends Model
{
    public function setValues($model, $aidk)
    {
        $object = ApplicationTemplates::find()
            ->alias('a')
            ->where(['a.application_enc_id' => $aidk])
            ->select(['a.application_enc_id','b.internship_duration','b.internship_duration_type','b.saturday_frequency','b.sunday_frequency','b.interview_start_date','b.pre_placement_offer','b.has_placement_offer', 'b.interview_end_date', 'a.interview_process_enc_id', 'b.pre_placement_offer', 'b.has_placement_offer', 'b.has_questionnaire', 'b.wage_duration', 'b.wage_type', 'b.min_wage', 'b.max_wage', 'b.fixed_wage', 'b.wage_type', 'a.experience', 'a.preferred_industry', 'a.preferred_gender', 'a.description', 'a.type', 'a.timings_from', 'a.timings_to', 'a.joining_date', 'a.last_date', 'l.category_enc_id primaryfield', 'm.name titles', 'n.designation_enc_id', 'n.designation',
                '(CASE
                WHEN b.wage_type = "Unpaid" THEN 0
                WHEN b.wage_type = "Fixed" THEN 1
                WHEN b.wage_type = "Negotiable" THEN 2
                WHEN b.wage_type = "Performance Based" THEN 3
                END) as wage_type', 'b.working_days'])
            ->joinwith(['title0 k' => function ($b) {
                $b->joinWith(['parentEnc l'], false);
                $b->joinWith(['categoryEnc m'], false);
            }], false)
            ->joinWith(['designationEnc n'], false)
            ->joinWith(['applicationOptionsTemplates b'], false)
            ->joinWith(['applicationTemplateJobDescriptions i' => function ($b) {
                $b->joinWith(['jobDescriptionEnc j'], false);
                $b->select(['i.application_enc_id', 'j.job_description']);
            }])
            ->joinWith(['applicationSkillsTemplates g' => function ($b) {
//                $b->andWhere(['g.is_deleted' => 0]);
                $b->joinWith(['skillEnc h'], false);
                $b->select(['g.application_enc_id', 'h.skill']);
            }])
            ->joinWith(['applicationEduReqTemplates e' => function ($b) {
                $b->joinWith(['educationalRequirementEnc f'], false);
                $b->select(['e.application_enc_id', 'f.educational_requirement']);
            }])
            ->joinWith(['appInterviewQuestionnaireTemplates q' => function ($b) {
                $b->select(['q.field_enc_id', 'q.questionnaire_enc_id', 'q.application_enc_id']);
            }])
            ->asArray()
            ->one();
        $jobDescription = ArrayHelper::getColumn($object['applicationTemplateJobDescriptions'], 'job_description');
        $skills = ArrayHelper::getColumn($object['applicationSkillsTemplates'], 'skill');
        $education_qualifaication = ArrayHelper::getColumn($object['applicationEduReqTemplates'], 'educational_requirement');
        $questionnaire = ArrayHelper::getColumn($object['appInterviewQuestionnaireTemplates'], 'questionnaire_enc_id');
        $questionfields = ArrayHelper::getColumn($object['appInterviewQuestionnaireTemplates'], 'field_enc_id');
        setlocale(LC_MONETARY, 'en_IN');
        $model->title = $object['titles'];
        $model->designations = $object['designation'];
        $model->primaryfield = $object['primaryfield'];
        $model->mainfield = $object['primaryfield'];
        $model->type = $object['type'];
        $model->gender = $object['preferred_gender'];
        $model->from = date("g:i a", strtotime($object['timings_from']));
        $model->to = date("g:i a", strtotime($object['timings_to']));
//        $model->earliestjoiningdate = date('d-M-Y', strtotime($object['joining_date']));
//        $model->last_date = date('d-M-Y', strtotime($object['last_date']));
        $model->min_exp = $object['experience'];
        $model->othrdetail = $object['description'];
        $model->industry = $object['preferred_industry'];
        $model->pref_indus = $object['preferred_industry'];
        $model->wage_type = $object['wage_type'];
        $model->wage_duration = $object['wage_duration'];
        $model->min_wage = utf8_encode(money_format('%!.0n', $object['min_wage']));
        $model->max_wage = utf8_encode(money_format('%!.0n', $object['max_wage']));
        $model->fixed_wage = utf8_encode(money_format('%!.0n', $object['fixed_wage']));
        $model->weekdays = json_decode($object['working_days']);
        $model->clone_desc = json_encode($jobDescription);
        $model->clone_skills = json_encode($skills);
        $model->clone_edu = json_encode($education_qualifaication);
        $model->questionnaire_selection = $object['has_questionnaire'];
        $model->weekoptsat = $object['saturday_frequency'];
        $model->weekoptsund = $object['sunday_frequency'];
        $model->pre_placement_package = $object['pre_placement_offer'];
        $model->pre_placement_offer = $object['has_placement_offer'];
        $model->interview_process = $object['interview_process_enc_id'];
        $model->internship_duration = $object['internship_duration'];
        $model->internship_duration_type = $object['internship_duration_type'];
        if (!empty($object['interview_start_date']) || !empty($object['interview_end_date'])) {
            $model->interradio = 1;
//            $model->startdate = date('d-m-y', strtotime($object['interview_start_date']));
//            $model->enddate = date('d-m-y', strtotime($object['interview_end_date']));
            $model->interviewstarttime = date('g:i a', strtotime($object['interview_start_date']));
            $model->interviewendtime = date('g:i a', strtotime($object['interview_end_date']));
        } else {
            $model->interradio = 0;
        }
        $model->questionnaire = $questionnaire;
        $model->questionfields = json_encode($questionfields);
        return $model;
    }
}