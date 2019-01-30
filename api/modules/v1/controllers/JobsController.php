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

class JobsController extends ApiBaseController {

    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => ['detail', 'list'],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'list' => ['POST'],
                'detail' => ['POST'],
                'apply' => ['POST']
            ]
        ];
        return $behaviors;
    }

    //create, update, delete, view, index
//    public $modelClass = 'common\models\EmployerApplications';

    /**
     * This is the compaies list endpoint
     * @var http://www.aditya.eygb.me/api/v1/jobs/list
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

        $options['type'] = 'Jobs';

        $jobcards = EmployerApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id application_id', 'i.name category', 'l.designation', 'd.initials_color color', 'CONCAT("'.Yii::$app->request->hostInfo . '/company/'. '", d.slug) organization_link', 'a.experience', "g.name as city", 'a.type', 'c.name as title', 'd.name as organization_name', 'CASE WHEN d.logo IS NULL THEN NULL ELSE CONCAT("'.Url::to(Yii::$app->params->upload_directories->organizations->logo, true).'",d.logo_location, "/", d.logo) END logo'])
                    ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                    ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                    ->innerJoin(Categories::tableName() . 'as i', 'i.category_enc_id = b.parent_enc_id')
                    ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                    ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
                    ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
                    ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                    ->innerJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
                    ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
                    ->innerJoin(Designations::tableName() . 'as l', 'l.designation_enc_id = a.designation_enc_id')
                    ->where(['j.name' => $options['type'], 'a.is_deleted' => 0]);


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
     * @var http://www.aditya.eygb.me/api/v1/jobs/detail?id= application id
     * @return Returns organization name , color, email, website, logo, cover image, has applied, resume, Are there questionnaire, Industry, title, Preferred gender, designation, Profile, Job Type, Experience, Timings from , Timings To, Joining Date, Last Date, Working Days, Salary, Salary Duration , Benefits, Educational Requirement, Skill, Job Description, Placement Locations data, Total Vacancies and Interview Locations
     */
    public function actionDetail($id){
            $result = [];

            $application_details = EmployerApplications::find()
                ->where([
                    'application_enc_id' => $id,
                    'is_deleted' => 0
                ])
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
                'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
            ]);

            $hasApplied = AppliedApplications::find()
                ->where(['application_enc_id' => $application_details->application_enc_id])
                ->andWhere(['created_by' => $user->user_enc_id])
                ->exists();
            $result['hasApplied'] = $hasApplied;


            $resume = UserResume::find()
                ->select(['user_enc_id', 'resume_enc_id', 'title'])
                ->where(['user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->all();
            if(sizeof($resume) != 0) {
                $result['resume'] = $resume;
            }else{
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
            $result['title'] = $data['cat_name'];
            $result['preferred_gender'] = $data['preferred_gender'];
            $result['designation'] = $data['designation'];
            $result['profile'] = $data['name'];
            $result['job_type'] = $data['type'];
            $result['experience'] = $data['experience'];
            $result['timings_from'] = $data['timings_from'];
            $result['timings_to'] = $data['timings_to'];
            $result['joining_date'] = $data['joining_date'];
            $result['last_date'] = $data['last_date'];
            foreach($data['applicationOptions'] as $datum){
                if($datum['option_name'] == "working_days") $result['working_days'] = $datum['value'];
                else if($datum['option_name'] == "salary") $result['salary'] = $datum['value'];
                else if($datum['option_name'] == "salary_duration") $result['salary_duration'] = $datum['value'];
            }
            $result['benefits'] = [];
            $aa = 0;
            foreach($data['applicationEmployeeBenefits'] as $aeb){
                $result['benefits'][$aa] = $aeb['benefit'];
                $aa++;
            }
            $result['educational_requirement'] = [];
            $bb = 0;
            foreach($data['applicationEducationalRequirements'] as $aer){
                $result['educational_requirement'][$bb] = $aer['educational_requirement'];
                $bb++;
            }
            $result['skill'] = [];
            $cc = 0;
            foreach($data['applicationSkills'] as $as){
                $result['skill'][$cc] = $as['skill'];
                $cc++;
            }
            $result['job_description'] = [];
            $ii = 0;
            foreach($data['applicationJobDescriptions'] as $jd){
                $result['job_description'][$ii] = $jd['job_description'];
                $ii++;
            }
            $result['placement_locations_data'] = [];
            $dd = 0;

            foreach($data['applicationPlacementLocations'] as $apl){
                $result['placement_locations_data'][] = [
                    'vacancies' =>  $apl['positions'],
                    'city_id' => $apl['city_enc_id'],
                    'placement_locations' => $apl['name']
                ];
                $result['vacancies'][$dd] = $apl['positions'];
                $dd++;
            }
            $result['total_vacancies'] = count($result['vacancies']);
            $ee = 0;
            $result['interview_locations'] = [];
            foreach($data['applicationInterviewLocations'] as $ail){
                $result['interview_locations'][$ee] = $ail['name'];
                $ee++;
            }
            unset($result['vacancies']);
//            $model = new JobApplied();
            return $this->response(200, $result);

    }

    /**
     * This is the job application endpoint
     * @var http://www.aditya.eygb.me/api/v1/jobs/apply
     * @param Input old or new Resume as true
     * @param Input job id
     * @param Input resume enc id
     * @param Input city id
     * @return Returns applied application enc id
     */
    public function actionApply(){
        $model = new JobApply();

        if(Yii::$app->request->post('old') == true){

            $application_questionnaire = ApplicationInterviewQuestionnaire::find()
                ->alias('a')
                ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                ->where(['a.application_enc_id' => Yii::$app->request->post("job_id")])
                ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                ->andWhere(['b.field_name' => 'Get Applications'])
                ->exists();

            $model->id = Yii::$app->request->post("job_id");
            $model->resume_list = Yii::$app->request->post("resume_enc_id");
            $model->location_pref = Yii::$app->request->post("city_id");

            if($application_questionnaire){
                $model->status = 'incomplete';
            }else{
                $model->status = 'Pending';
            }

            if ($res = $model->saveValues()) {
                return $this->response(200, $res);
            } else {
                return $this->response(204);
            }

        }else if(Yii::$app->request->post('new') == true){
            $model->id = Yii::$app->request->post("job_id");
            $model->resume_file = UploadedFile::getInstanceByName('resume_file');
            $model->location_pref = Yii::$app->request->post('city_id');
            $application_questionnaire = ApplicationInterviewQuestionnaire::find()
                ->alias('a')
                ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                ->where(['a.application_enc_id' => Yii::$app->request->post("job_id")])
                ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                ->andWhere(['b.field_name' => 'Get Applications'])
                ->exists();

            if($application_questionnaire){
                $model->status = 'incomplete';
            }else{
                $model->status = 'Pending';
            }

            if ($res = $model->upload()) {
                return $this->response(200, $res);
            } else {
                return $this->response(204);
            }
        }
    }


}