<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Clients;
use api\modules\v1\models\JobApply;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\ApplicationOptions;
use common\models\Cities;
use common\models\Designations;
use common\models\Industries;
use common\models\OrganizationLocations;
use common\models\Organizations;
use common\models\EmployerApplications;
use common\models\AppliedApplications;
use common\models\UserResume;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;
use frontend\models\JobApplied;

class InternshipsController extends ApiBaseController {

    /**
     * This is the compaies list endpoint
     * @var http://www.aditya.eygb.me/api/v1/internships/list
     * @param Input page
     * @param Input location
     * @param Input keyword
     * @param Input company
     * @return Returns application id , category, designation, color, organization link, experience, city, type, title, organization name and logo link
     */
    public function actionList(){
        $parameters = \Yii::$app->request->post();
        $result = [];
        $options = [];
        $limit = 3;

        if ($parameters['page'] && (int)$parameters['page'] >= 1) {
            $page = $parameters['page'];
        } else {
            $page = 1;
        }

        $options['limit'] = $limit;
        $options['offset'] = ($page - 1) * $limit;

        if ($parameters['location'] && !empty($parameters['location'])) {
            $options['location'] = $parameters['location'];
        }

        if ($parameters['keyword'] && !empty($parameters['keyword'])) {
            $options['keyword'] = $parameters['keyword'];
        }

        if ($parameters['company'] && !empty($parameters['company'])) {
            $options['company'] = $parameters['company'];
        }

        $options['type'] = 'Internships';

        $jobcards = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id application_id', 'f.location_enc_id location_id', 'a.created_on', 'i.name category', 'CONCAT("/internship/", a.slug) link', 'd.initials_color color', 'CONCAT("/company/", d.slug) organization_link', 'a.experience', "g.name as city", 'a.type', 'c.name as title', 'd.name as organization_name', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'i.category_enc_id = b.parent_enc_id')
            ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
            ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
            ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0]);

        if (isset($options['company'])) {
            $jobcards->andWhere([
                'or',
                ($options['company']) ? ['like', 'd.name', $options['company']] : ''
            ]);
        }

        if (isset($options['location'])) {
            $jobcards->andWhere([
                'or',
                ['g.name' => $options['location']]
            ]);
        }

        if (isset($options['keyword'])) {
            $jobcards->andWhere([
                'or',
                ['like', 'l.designation', $options['keyword']],
                ['like', 'a.type', $options['keyword']],
                ['like', 'c.name', $options['keyword']],
                ['like', 'h.industry', $options['keyword']],
                ['like', 'i.name', $options['keyword']],
            ]);
        }

        if (isset($options['limit'])) {
            $jobcards->limit = $options['limit'];
        }

        if (isset($options['offset'])) {
            $jobcards->offset = $options['offset'];
        }

        $cards = $jobcards->orderBy(['a.id' => SORT_DESC])->asArray()->all();

        foreach ($cards as $jobcard) {
            $result[] = $jobcard;
        }

        if (count($cards) > 0) {
            return $this->response(200, $result);
        } else {
            return $this->response(201);
        }
    }

    /**
     * This is the compaies detail endpoint
     * @var http://www.aditya.eygb.me/api/v1/internships/detail
     * @return Returns organization name , color, email, website, logo, cover image, has applied, resume, Are there questionnaire, Industry, title, Preferred gender, designation, Profile, Job Type, Experience, Timings from , Timings To, Joining Date, Last Date, Working Days, Salary, Salary Duration , Benefits, Educational Requirement, Skill, Job Description, Placement Locations data, Total Vacancies and Interview Locations
     */
    public function actionDetail(){
        $bodyparam = \Yii::$app->request->post();
        if($bodyparam['id'] && !empty($bodyparam['id'])) {
            $result = [];
            $id = $bodyparam['id'];
            $application_details = EmployerApplications::find()
                ->where([
                    'application_enc_id' => $id,
                    'is_deleted' => 0
                ])
                ->joinWith(['applicationTypeEnc b' => function ($b) {
                    $b->andWhere(['b.name' => 'internships']);
                }])
                ->one();

            if (!$application_details) {
                return $this->response(201);
            }

            $organization_details = $application_details
                ->getOrganizationEnc()
                ->select(['name org_name', 'initials_color color', 'email', 'website', 'CASE WHEN logo IS NULL THEN NULL ELSE CONCAT("' . Yii::$app->params->upload_directories->organizations->logo . '",logo_location, "/", logo) END logo', 'CASE WHEN cover_image IS NULL THEN NULL ELSE CONCAT("' . Yii::$app->params->upload_directories->organizations->cover_image . '",cover_image_location, "/", cover_image) END cover_image'])
                ->asArray()
                ->one();

            $result['organization_name'] = $organization_details['org_name'];
            $result['color'] = $organization_details['color'];
            $result['email'] = $organization_details['email'];
            $result['website'] = $organization_details['website'];
            if ($organization_details['logo']) {
                $result['logo'] = Url::to($organization_details['logo'], true);
            } else {
                $result['logo'] = $organization_details['logo'];
            }
            if ($organization_details['cover_image']) {
                $result['cover_image'] = Url::to($organization_details['cover_image'], true);
            } else {
                $result['cover_image'] = $organization_details['cover_image'];
            }

            $user = Clients::findOne([
//                'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
                'auth_key' => $bodyparam['auth_key']
            ]);

            $hasApplied = AppliedApplications::find()
                ->where(['application_enc_id' => $application_details->application_enc_id])
                ->andWhere(['created_by' => $user->user_enc_id])
                ->exists();
            $result['hasApplied'] = $hasApplied;


            $resume = UserResume::find()
                ->select(['user_enc_id', 'resume_enc_id', 'title', 'CONCAT("'.Url::to(Yii::$app->params->upload_directories->resume->file, true).'", resume_location, "/", resume) url'])
                ->where(['user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->all();
            if (sizeof($resume) != 0) {
                $result['resume'] = $resume;
            } else {
                $result ['resume'] = 'No Resume Found';
            }

            $application_questionnaire = ApplicationInterviewQuestionnaire::find()
                ->alias('a')
                ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                ->where(['a.application_enc_id' => $id])
                ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                ->andWhere(['b.field_name' => 'Get Applications'])
                ->exists();

            $result['areThereQuestionnaire'] = $application_questionnaire;

            $object = new \account\models\jobs\JobApplicationForm();
            $data = $object
                ->getCloneData($application_details->application_enc_id);

            $result['industry'] = $data['industry'];
            $result['description'] = $data['description'];
            $result['title'] = $data['cat_name'];
            $result['preferred_gender'] = $data['preferred_gender'];
            $result['designation'] = $data['designation'];
            $result['profile'] = $data['name'];
            $result['job_type'] = $data['type'];
            $result['timings_from'] = $data['timings_from'];
            $result['timings_to'] = $data['timings_to'];
            $result['joining_date'] = $data['joining_date'];
            $result['last_date'] = $data['last_date'];

            foreach ($data['applicationOptions'] as $datum) {
                $o[$datum['option_name']] = $datum['value'];
            }
            $result['stipened_type'] = $o['stipened_type'];
            $result['pre_placement_offer'] = $o['pre_placement_offer'];
            $result['max_stipened'] = $o['max_stipened'];
            $result['min_stipened'] = $o['min_stipened'];
            $result['fixed_stipened'] = $o['fixed_stipened'];
            $result['interview_start_date'] = $o['interview_start_date'];
            $result['interview_start_time'] = $o['interview_start_time'];
            $result['interview_end_date'] = $o['interview_end_date'];
            $result['interview_end_time'] = $o['interview_end_time'];

            $result['benefits'] = [];
            $aa = 0;
            foreach ($data['applicationEmployeeBenefits'] as $aeb) {
                $result['benefits'][$aa] = $aeb['benefit'];
                $aa++;
            }

            $result['educational_requirement'] = [];
            $bb = 0;
            foreach ($data['applicationEducationalRequirements'] as $aer) {
                $result['educational_requirement'][$bb] = $aer['educational_requirement'];
                $bb++;
            }

            $result['skill'] = [];
            $cc = 0;
            foreach ($data['applicationSkills'] as $as) {
                $result['skill'][$cc] = $as['skill'];
                $cc++;
            }

            $result['job_description'] = [];
            $ii = 0;
            foreach ($data['applicationJobDescriptions'] as $jd) {
                $result['job_description'][$ii] = $jd['job_description'];
                $ii++;
            }

            $result['placement_locations_data'] = [];
            $dd = 0;
            foreach ($data['applicationPlacementLocations'] as $apl) {
                $result['placement_locations_data'][] = [
                    'vacancies' => $apl['positions'],
                    'city_id' => $apl['city_enc_id'],
                    'placement_locations' => $apl['name']
                ];
                $result['vacancies'][$dd] = $apl['positions'];
                $dd++;
            }
            $result['total_vacancies'] = count($result['vacancies']);

            $ee = 0;
            $result['interview_locations'] = [];
            foreach ($data['applicationInterviewLocations'] as $ail) {
                $result['interview_locations'][$ee] = $ail['name'];
                $ee++;
            }

            unset($result['vacancies']);
//            $model = new JobApplied();
            return $this->response(200, $result);
        }else{
            return $this->response(202);
        }
    }

}
