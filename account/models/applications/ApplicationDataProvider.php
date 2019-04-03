<?php

namespace account\models\applications;
use common\models\ApplicationEducationalRequirements;
use common\models\ApplicationEmployeeBenefits;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\ApplicationJobDescription;
use common\models\ApplicationOptions;
use common\models\ApplicationSkills;
use common\models\EducationalRequirements;
use common\models\JobDescription;
use common\models\Skills;
use common\models\Utilities;
use Yii;
use common\models\ApplicationInterviewLocations;
use common\models\ApplicationPlacementLocations;
use common\models\EmployerApplications;
use yii\helpers\ArrayHelper;
use yii\base\Model;

class ApplicationDataProvider extends Model
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
                $b->andWhere(['i.is_deleted' => 0]);
                $b->joinWith(['jobDescriptionEnc j'], false, 'INNER JOIN');
                $b->select(['i.application_enc_id', 'j.job_description']);
            }])
            ->joinWith(['applicationSkills g' => function ($b) {
                $b->andWhere(['g.is_deleted' => 0]);
                $b->joinWith(['skillEnc h'], false, 'INNER JOIN');
                $b->select(['g.application_enc_id', 'h.skill']);
            }])
            ->joinWith(['applicationEducationalRequirements e' => function ($b) {
                $b->andWhere(['e.is_deleted' => 0]);
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

    public function update($model,$aidk,$type)
    {
        $flag = 0;
        if ($type=='Edit_Jobs')
        {
            $typ = 'Jobs';
        }
        elseif ($type=='Clone_Internships')
        {
            $typ = 'Internships';
        }
        $employerApplicationsModel = EmployerApplications::find()
                               ->where(['application_enc_id'=>$aidk])
                               ->one();

        $employerApplicationsModel->interview_process_enc_id = $model->interview_process;
        $employerApplicationsModel->description = $model->othrdetail;
        $employerApplicationsModel->type = $model->type;
        $employerApplicationsModel->timings_from = date("H:i:s", strtotime($model->from));
        $employerApplicationsModel->timings_to = date("H:i:s", strtotime($model->to));
        $employerApplicationsModel->experience = $model->min_exp;
        $employerApplicationsModel->preferred_gender = $model->gender;
        $employerApplicationsModel->joining_date = date('Y-m-d', strtotime($model->earliestjoiningdate));
        $employerApplicationsModel->last_date = date('Y-m-d', strtotime($model->last_date));
        $employerApplicationsModel->last_updated_on = date('Y-m-d H:i:s');
        $employerApplicationsModel->last_updated_by = Yii::$app->user->identity->user_enc_id;
        if ($employerApplicationsModel->save())
        {
            $flag++;
        }
        $getSkills = array_unique(json_decode($model->skillsArray, true));
        if (!empty($getSkills))
        {
            $skill_set = [];
            foreach ($getSkills as $val){
                $chk_skill = Skills::find()
                    ->distinct()
                    ->select(['skill_enc_id'])
                    ->where(['skill'=>$val,'is_deleted'=>0])
                    ->asArray()
                    ->one();
                if (!empty($chk_skill))
                {
                    $skill_set[] = $chk_skill['skill_enc_id'];
                }
                else
                {
                    $skillsModel = new Skills();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $skillsModel->skill_enc_id = $utilitiesModel->encrypt();
                    $skillsModel->skill = $val;
                    $skillsModel->created_on = date('Y-m-d H:i:s');
                    $skillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$skillsModel->save())
                    {
                        return false;
                    }
                    $skill_set[] = $skillsModel->skill_enc_id;
                }
            }
        }
        else
        {
            $skill_set = [];
        }
        $userSkills = ApplicationSkills::find()
            ->where(['application_enc_id'=>$aidk])
            ->andWhere(['is_deleted'=>0])
            ->asArray()
            ->all();
        $skillArray = ArrayHelper::getColumn($userSkills, 'skill_enc_id');
        $new_skill = array_diff($skill_set, $skillArray);
        $delet_skill = array_diff($skillArray, $skill_set);
        if (!empty($new_skill)) {
            foreach ($new_skill as $val) {
                $applicationSkillsModel = new ApplicationSkills();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $applicationSkillsModel->application_skill_enc_id = $utilitiesModel->encrypt();
                $applicationSkillsModel->skill_enc_id = $val;
                $applicationSkillsModel->application_enc_id = $aidk;
                $applicationSkillsModel->created_on = date('Y-m-d H:i:s');
                $applicationSkillsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$applicationSkillsModel->save()) {
                    return false;
                }
                else
                {
                    $flag++;
                }
            }
        }
        if (!empty($delet_skill)) {
            foreach ($delet_skill as $val) {
                $update = Yii::$app->db->createCommand()
                    ->update(ApplicationSkills::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id'=>$aidk,'skill_enc_id'=>$val])
                    ->execute();
                if (!$update) {
                    return false;
                }
                else
                {
                    $flag++;
                }
            }
        }
        $getJd =  array_unique(json_decode($model->checkboxArray, true));
        if (!empty($getJd))
        {
            $jd_set = [];
            foreach ($getJd as $val){
                $chk_jd = JobDescription::find()
                    ->distinct()
                    ->select(['job_description_enc_id'])
                    ->where(['job_description'=>$val,'is_deleted'=>0])
                    ->asArray()
                    ->one();
                if (!empty($chk_jd))
                {
                    $jd_set[] = $chk_jd['job_description_enc_id'];
                }
                else
                {
                    $JobDescriptionModel = new JobDescription();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $JobDescriptionModel->job_description_enc_id = $utilitiesModel->encrypt();
                    $JobDescriptionModel->job_description = $val;
                    $JobDescriptionModel->created_on = date('Y-m-d H:i:s');
                    $JobDescriptionModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$JobDescriptionModel->save())
                    {
                        return false;
                    }
                    $jd_set[] = $JobDescriptionModel->job_description_enc_id;
                }
            }
        }
        else
        {
            $jd_set = [];
        }
        $userjd = ApplicationJobDescription::find()
            ->where(['application_enc_id'=>$aidk])
            ->andWhere(['is_deleted'=>0])
            ->asArray()
            ->all();
        $jdArray = ArrayHelper::getColumn($userjd, 'job_description_enc_id');
        $new_jd = array_diff($jd_set, $jdArray);
        $delet_jd = array_diff($jdArray, $jd_set);
        if (!empty($new_jd)) {
            foreach ($new_jd as $val) {
                $applicationJobDescriptionModel = new ApplicationJobDescription();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $applicationJobDescriptionModel->application_job_description_enc_id = $utilitiesModel->encrypt();
                $applicationJobDescriptionModel->job_description_enc_id = $val;
                $applicationJobDescriptionModel->application_enc_id = $aidk;
                $applicationJobDescriptionModel->created_on = date('Y-m-d H:i:s');
                $applicationJobDescriptionModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$applicationJobDescriptionModel->save()) {
                    return false;
                }
                else
                {
                    $flag++;
                }
            }
        }
        if (!empty($delet_jd)) {
            foreach ($delet_jd as $val) {
                $update = Yii::$app->db->createCommand()
                    ->update(ApplicationJobDescription::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id'=>$aidk,'job_description_enc_id'=>$val])
                    ->execute();
                if (!$update) {
                    return false;
                }
                else
                {
                    $flag++;
                }
            }
        }
        $geted =  array_unique(json_decode($model->qualifications_arr, true));
        if (!empty($geted))
        {
            $ed_set = [];
            foreach ($geted as $val){
                $chk_ed = EducationalRequirements::find()
                    ->distinct()
                    ->select(['educational_requirement_enc_id'])
                    ->where(['educational_requirement'=>$val,'is_deleted'=>0])
                    ->asArray()
                    ->one();
                if (!empty($chk_ed))
                {
                    $ed_set[] = $chk_ed['educational_requirement_enc_id'];
                }
                else
                {
                    $qualificationsModel = new EducationalRequirements();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $qualificationsModel->educational_requirement_enc_id = $utilitiesModel->encrypt();
                    $qualificationsModel->educational_requirement = $val;
                    $qualificationsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                    $qualificationsModel->created_on = date('Y-m-d H:i:s');
                    $qualificationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$qualificationsModel->save())
                    {
                        return false;
                    }
                    $ed_set[] = $qualificationsModel->educational_requirement_enc_id;
                }
            }
        }
        else
        {
            $ed_set = [];
        }
        $usered = ApplicationEducationalRequirements::find()
            ->where(['application_enc_id'=>$aidk])
            ->andWhere(['is_deleted'=>0])
            ->asArray()
            ->all();
        $edArray = ArrayHelper::getColumn($usered, 'educational_requirement_enc_id');
        $new_ed = array_diff($ed_set, $edArray);
        $delet_ed = array_diff($edArray, $ed_set);
        if (!empty($new_ed)) {
            foreach ($new_ed as $val) {
                $applicationEducationalModel = new ApplicationEducationalRequirements();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $applicationEducationalModel->application_educational_requirement_enc_id = $utilitiesModel->encrypt();
                $applicationEducationalModel->educational_requirement_enc_id = $val;
                $applicationEducationalModel->application_enc_id = $aidk;
                $applicationEducationalModel->created_on = date('Y-m-d H:i:s');
                $applicationEducationalModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$applicationEducationalModel->save()) {
                    return false;
                }
                else
                {
                    $flag++;
                }
            }
        }
        if (!empty($delet_ed)) {
            foreach ($delet_ed as $val) {
                $update = Yii::$app->db->createCommand()
                    ->update(ApplicationEducationalRequirements::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id'=>$aidk,'educational_requirement_enc_id'=>$val])
                    ->execute();
                if (!$update) {
                    return false;
                }
                else
                {
                    $flag++;
                }
            }
        }
        if (in_array('online001',$model->interviewcity))
        {
            $has_online_int = 1;
            array_shift($model->interviewcity);
        }
        else{
            $has_online_int = 0;
        }
        switch ($model->wage_type) {
            case 1:
                $wage_type = 'Fixed';
                break;
            case 2:
                $wage_type = 'Negotiable';
                break;
            case 3:
                $wage_type = 'Performance Based';
                break;
            case 0:
                $wage_type = 'Unpaid';
                break;
            default:
                $wage_type = 'Unpaid';
        }
        if (in_array("6", $model->weekdays)) {
            $weekoptionsat = $model->weekoptsat;
        } else if (in_array("7", $model->weekdays)) {
            $weekoptionsund = $model->weekoptsund;
        } else {
            $weekoptionsat = NULL;
            $weekoptionsund = NULL;
        }
        if ($model->interradio == 1) {
            $interview_strt_date =  date('Y-m-d H:i:s', strtotime($model->startdate . ' ' . $model->interviewstarttime));
            $interview_end_date = date('Y-m-d H:i:s', strtotime($model->enddate . ' ' . $model->interviewendtime));
        } else {
            $interview_strt_date = null;
            $interview_end_date = null;
        }
        $applicationoptionsModel = ApplicationOptions::find()
                              ->where(['application_enc_id'=>$aidk])
                              ->one();
        $applicationoptionsModel->wage_type = $wage_type;
        $applicationoptionsModel->fixed_wage = (($model->fixed_wage) ? str_replace(',', '', $model->fixed_wage) : null);
        $applicationoptionsModel->min_wage = (($model->min_wage) ? str_replace(',', '', $model->min_wage) : null);
        $applicationoptionsModel->max_wage = (($model->max_wage) ? str_replace(',', '', $model->max_wage) : null);
        $applicationoptionsModel->ctc = (($model->ctc) ? str_replace(',', '', $model->ctc) : null);
        $applicationoptionsModel->wage_duration = $model->wage_duration;
        $applicationoptionsModel->has_online_interview = $has_online_int;
        $applicationoptionsModel->has_questionnaire = $model->questionnaire_selection;
        $applicationoptionsModel->pre_placement_offer = (($model->pre_placement_package) ? str_replace(',', '', $model->pre_placement_package) : null);
        $applicationoptionsModel->has_placement_offer = (($model->pre_placement_offer) ? str_replace(',', '', $model->pre_placement_offer) : null);
        $applicationoptionsModel->has_benefits = $model->benefit_selection;
        $applicationoptionsModel->working_days = json_encode($model->weekdays);
        $applicationoptionsModel->saturday_frequency = $weekoptionsat;
        $applicationoptionsModel->sunday_frequency = $weekoptionsund;
        $applicationoptionsModel->interview_start_date = $interview_strt_date;
        $applicationoptionsModel->interview_end_date = $interview_end_date;
        $applicationoptionsModel->created_on = date('Y-m-d H:i:s');
        $applicationoptionsModel->created_by = Yii::$app->user->identity->user_enc_id;
        if (!$applicationoptionsModel->save())
        {
            return false;
        }

        if ($model->benefit_selection==1)
        {
            if (!empty($model->emp_benefit)) {
                $benft = ApplicationEmployeeBenefits::find()
                    ->where(['application_enc_id' => $aidk])
                    ->andWhere(['is_deleted' => 0])
                    ->select(['benefit_enc_id'])
                    ->asArray()
                    ->all();

                $bnft_data = ArrayHelper::getColumn($benft, 'benefit_enc_id');
                $new_instrd = array_diff($model->emp_benefit, $bnft_data);
                $b_delt = array_diff($bnft_data, $model->emp_benefit);

                if (!empty($new_instrd)) {
                    foreach ($new_instrd as $val) {
                        $benefitModel = new ApplicationEmployeeBenefits();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $benefitModel->application_benefit_enc_id = $utilitiesModel->encrypt();
                        $benefitModel->benefit_enc_id = $val;
                        $benefitModel->application_enc_id = $aidk;
                        $benefitModel->created_on = date('Y-m-d H:i:s');
                        $benefitModel->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$benefitModel->save()) {
                            return false;
                        }
                    }
                }

                if (!empty($b_delt)) {
                    foreach ($b_delt as $val) {
                        $update = Yii::$app->db->createCommand()
                            ->update(ApplicationEmployeeBenefits::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['benefit_enc_id' => $val, 'application_enc_id' => $aidk])
                            ->execute();
                        if (!$update) {
                            return false;
                        }
                    }
                }
            }
        }
        else
        {
            if (!empty($model->emp_benefit))
            {
                $b_delt = $model->emp_benefit;
                foreach ($b_delt as $val) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ApplicationEmployeeBenefits::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['benefit_enc_id' => $val, 'application_enc_id' => $aidk])
                        ->execute();
                    if (!$update) {
                        return false;
                    }
                }
            }
        }

        $in_loc = ApplicationInterviewLocations::find()
            ->where(['application_enc_id' => $aidk])
            ->andWhere(['is_deleted' => 0])
            ->select(['location_enc_id'])
            ->asArray()
            ->all();

        $int_data = ArrayHelper::getColumn($in_loc, 'location_enc_id');
        $new_int = array_diff($model->interviewcity, $int_data);
        $int_delt = array_diff($int_data, $model->interviewcity);

        if (!empty($new_int)) {
            foreach ($new_int as $interviewcity) {
                $applicationInterviewLocationsModel = new ApplicationInterviewLocations();
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $applicationInterviewLocationsModel->interview_location_enc_id = $utilitiesModel->encrypt();
                $applicationInterviewLocationsModel->location_enc_id = $interviewcity;
                $applicationInterviewLocationsModel->application_enc_id = $aidk;
                $applicationInterviewLocationsModel->created_on = date('Y-m-d H:i:s');
                $applicationInterviewLocationsModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$applicationInterviewLocationsModel->save()) {
                    return false;
                }
            }
        }
        if (!empty($int_delt)) {
            foreach ($int_delt as $k) {
                $update = Yii::$app->db->createCommand()
                    ->update(ApplicationInterviewLocations::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['location_enc_id' => $k, 'application_enc_id' => $aidk])
                    ->execute();
                if (!$update) {
                    return false;
                }
            }
        }
        if ($model->type == "Work From Home"){
            if (!empty($model->placement_loc))
            {
                $user_pl_loc = json_decode($model->placement_loc, true);
                $ploc_delt = ArrayHelper::map($user_pl_loc, 'id', 'value');
                foreach ($ploc_delt as $k => $v) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ApplicationPlacementLocations::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['positions' => $v, 'location_enc_id' => $k, 'application_enc_id' => $aidk])
                        ->execute();

                    if (!$update) {
                        return false;
                    }
                }
            }
        }
        else {
            if (!empty($model->placement_loc)){
                $pl_loc = ApplicationPlacementLocations::find()
                    ->where(['application_enc_id' => $aidk])
                    ->andWhere(['is_deleted' => 0])
                    ->select(['location_enc_id', 'positions'])
                    ->asArray()
                    ->all();

            $user_pl_loc = json_decode($model->placement_loc, true);
            $p1 = ArrayHelper::map($user_pl_loc, 'id', 'value');
            $p2 = ArrayHelper::map($pl_loc, 'location_enc_id', 'positions');
            $new_loc = array_diff($p1, $p2);
            $ploc_delt = array_diff($p2, $p1);
            if (!empty($new_loc)) {
                foreach ($new_loc as $k => $v) {
                    $applicationPlacementLocationsModel = new ApplicationPlacementLocations();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $applicationPlacementLocationsModel->placement_location_enc_id = $utilitiesModel->encrypt();
                    $applicationPlacementLocationsModel->positions = $v;
                    $applicationPlacementLocationsModel->location_enc_id = $k;
                    $applicationPlacementLocationsModel->application_enc_id = $aidk;
                    $applicationPlacementLocationsModel->created_on = date('Y-m-d H:i:s');
                    $applicationPlacementLocationsModel->created_by = Yii::$app->user->identity->user_enc_id;

                    if (!$applicationPlacementLocationsModel->save()) {
                        return false;
                    }
                }
            }

            if (!empty($ploc_delt)) {
                foreach ($ploc_delt as $k => $v) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ApplicationPlacementLocations::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['positions' => $v, 'location_enc_id' => $k, 'application_enc_id' => $aidk])
                        ->execute();

                    if (!$update) {
                        return false;
                    }
                }
            }
        }
        }

        if ($model->questionnaire_selection==1)
        {
            if (!empty($model->question_process))
            {
                $que_p = ApplicationInterviewQuestionnaire::find()
                    ->where(['application_enc_id' => $aidk])
                    ->andWhere(['is_deleted' => 0])
                    ->select(['questionnaire_enc_id', 'field_enc_id'])
                    ->asArray()
                    ->all();
                $que_process = json_decode($model->question_process,true);
                $q1 = ArrayHelper::map($que_process, 'id', 'process_id');
                $q2 = ArrayHelper::map($que_p, 'questionnaire_enc_id', 'field_enc_id');
                $new_que = array_diff($q1, $q2);
                $que_delt = array_diff($q2, $q1);
                if (!empty($new_que)) {
                    foreach ($new_que as $k => $v) {

                        $processModel = new ApplicationInterviewQuestionnaire();
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $processModel->interview_questionnaire_enc_id = $utilitiesModel->encrypt();
                        $processModel->application_enc_id = $aidk;
                        $processModel->field_enc_id = $v;
                        $processModel->questionnaire_enc_id = $k;
                        $processModel->created_on = date('Y-m-d H:i:s');
                        $processModel->created_by = Yii::$app->user->identity->user_enc_id;

                        if (!$processModel->save()) {
                            return false;
                        }
                    }
                }

                if (!empty($que_delt)) {
                    foreach ($que_delt as $k => $v) {
                        $update = Yii::$app->db->createCommand()
                            ->update(ApplicationInterviewQuestionnaire::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['questionnaire_enc_id' => $k, 'field_enc_id' => $v, 'application_enc_id' => $aidk])
                            ->execute();

                        if (!$update) {
                            return false;
                        }
                    }
                }
            }
        }
        else
        {
            $que_process = json_decode($model->question_process,true);
            $que_delt = ArrayHelper::map($que_process, 'id', 'process_id');
            foreach ($que_delt as $k => $v) {
                $update = Yii::$app->db->createCommand()
                    ->update(ApplicationInterviewQuestionnaire::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['questionnaire_enc_id' => $k, 'field_enc_id' => $v, 'application_enc_id' => $aidk])
                    ->execute();

                if (!$update) {
                    return false;
                }
            }
        }
        return true;
    }
}