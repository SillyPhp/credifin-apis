<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Clients;
use api\modules\v1\models\Cards;
use api\modules\v1\models\JobApply;
use common\models\ShortlistedApplications;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;
use common\models\EmployerApplications;
use common\models\AppliedApplications;
use common\models\UserResume;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;

class InternshipsController extends ApiBaseController {

    public function actionList(){
        $parameters = \Yii::$app->request->post();
        $options = [];

        if ($parameters['page'] && (int)$parameters['page'] >= 1) {
            $options['page'] = $parameters['page'];
        } else {
            $options['page'] = 1;
        }

        $options['limit'] = 10;

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

        $result = Cards::internships($options);

        if (count($result) > 0) {
            return $this->response(200, $result);
        } else {
            return $this->response(201);
        }
    }

    public function actionDetail(){
        $parameters = \Yii::$app->request->post();
        if(!empty($parameters['id'])) {

            $result = [];

            $id = $parameters['id'];

            $application_details = EmployerApplications::find()
                ->where([
                    'application_enc_id' => $id,
                    'is_deleted' => 0
                ])
                ->joinWith(['applicationTypeEnc b' => function($b){
                    $b->andWhere(['b.name' => 'internships']);
                }])
                ->one();

            if (!$application_details) {
                return $this->response(201);
            }

            $organization_details = $application_details
                ->getOrganizationEnc()
                ->select(['name', 'initials_color color', 'email', 'website', 'CASE WHEN logo IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '",logo_location, "/", logo) END logo', 'CASE WHEN cover_image IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, true) . '",cover_image_location, "/", cover_image) END cover_image'])
                ->asArray()
                ->one();

            $result['organisation'] = $organization_details;

            $user = Clients::findOne([
//                'access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]
                'auth_key' => $parameters['auth_key']
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

            $result["resume"] = (sizeof($resume)!=0) ? $resume : "No Resume Found";

            $application_questionnaire = ApplicationInterviewQuestionnaire::find()
                ->alias('a')
                ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                ->where(['a.application_enc_id' => $application_details->application_enc_id])
                ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                ->andWhere(['b.field_name' => 'Get Applications'])
                ->exists();

            $result['hasQuestionnaire'] = $application_questionnaire;

            $shortlist = ShortlistedApplications::find()
                ->select('shortlisted')
                ->where(['shortlisted' =>1 , 'application_enc_id' => $application_details->application_enc_id, 'created_by' => $user->user_enc_id])
                ->exists();

            $result["hasShortlisted"] = $shortlist;

            $object = new \account\models\jobs\JobApplicationForm();
            $data = $object
                ->getCloneData($application_details->application_enc_id);

            unset($data["id"]);
            unset($data["application_number"]);
            unset($data["application_enc_id"]);
            unset($data["industry"]);
            unset($data["designation_enc_id"]);
            unset($data["designation"]);
            unset($data["category_enc_id"]);
            unset($data["cat_id"]);
            unset($data["title"]);
            unset($data["type"]);
            unset($data["experience"]);
            unset($data["slug"]);
            unset($data["preferred_industry"]);
            $data['preferred_gender'] = $this->prefferedGender($data['preferred_gender']);
            $data['has_placement_offer'] = $this->placementOffer($data['has_placement_offer']);
            unset($data["interview_process_enc_id"]);
            unset($data["option_enc_id"]);
            unset($data["ctc"]);
            unset($data["fixed_wage"]);
            unset($data["min_wage"]);
            unset($data["max_wage"]);
            unset($data["wage_duration"]);
            unset($data["applicationInterviewQuestionnaires"]);
            unset($data["last_updated_by"]);
            unset($data["last_updated_on"]);
            unset($data["created_on"]);
            unset($data["created_by"]);
            unset($data["has_questionnaire"]);
            unset($data["has_benefits"]);
            unset($data["saturday_frequency"]);
            unset($data["sunday_frequency"]);
            unset($data["working_days"]);
            unset($data["pre_placement_offer"]);
            unset($data["timings_from"]);
            unset($data["timings_to"]);
            $data["vacancies"]= 0;
            foreach ($data['applicationPlacementLocations'] as $apl) {
                $data["vacancies"] += $apl['positions'];
            }
            if(!$data["vacancies"]){
                unset($data["vacancies"]);
                $data["applicationPlacementLocations"] = "Work From Home";
            }
            unset($data["internship_duration_type"]);
            unset($data["internship_duration"]);
            unset($data["has_online_interview"]);

            $result['applicationDetails'] = $data;

            return $this->response(200, $result);
        }else{
            return $this->response(202);
        }

    }

    private function prefferedGender($g){
        switch($g){
            case 0:
                return "No Preference";
            case 1:
                return "Male";
            case 2:
                return "Female";
            case 3:
                return "Trans";
            default:
                return "N/A";
        }
    }
    private function placementOffer($g){
        switch($g){
            case 1:
                return "Yes";
            case 2:
                return "No";
        }
    }

    public function actionApply(){

        $model = new JobApply();

        $reqParams = Yii::$app->request->post();

        if(!empty($reqParams['job_id']) && !empty($reqParams['resume_enc_id']) && !empty($reqParams['city_id'])){

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

        }else{
            return $this->response(202);
        }
    }

}
