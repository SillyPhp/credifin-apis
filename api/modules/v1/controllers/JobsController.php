<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v1\models\Cards;
use api\modules\v1\models\JobApply;
use api\modules\v1\models\JobDetail;
use common\models\ShortlistedApplications;
use common\models\ApplicationTypes;
use common\models\UserAccessTokens;
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

class JobsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => ['list', 'detail'],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'list' => ['POST'],
                'detail' => ['POST'],
                'apply' => ['POST'],
                'available-resume' => ['POST']
            ]
        ];
        return $behaviors;
    }

    //create, update, delete, view, index
//    public $modelClass = 'common\models\EmployerApplications';

    public function actionList()
    {
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

        if ($parameters['careers'] && !empty($parameters['careers'])){
            $options['for_careers'] = (int)$parameters['careers'];
        }

        $options['type'] = 'Jobs';

        $result = Cards::jobs($options);

        if (count($result) > 0) {
            return $this->response(200, $result);
        } else {
            return $this->response(404);
        }
    }

    public function actionDetail()
    {
        $parameters = \Yii::$app->request->post();

        if (!empty($parameters['id'])) {

            $result = [];

            $application_type = ApplicationTypes::find()
                ->select(['application_type_enc_id'])
                ->where(['name' => 'Jobs'])
                ->asArray()
                ->one();

            $id = $parameters['id'];

            $application_details = EmployerApplications::find()
                ->where([
                    'application_enc_id' => $id,
                    'is_deleted' => 0,
                    'application_type_enc_id' => $application_type["application_type_enc_id"]
                ])
                ->one();

            if (!$application_details) {
                return $this->response(404);
            }


            if (Yii::$app->request->headers->get('Authorization') && Yii::$app->request->headers->get('source')) {

                $token_holder_id = UserAccessTokens::find()
                                    ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
                                    ->andWhere(['source' => Yii::$app->request->headers->get('source')])
                                    ->one();

                $user = Candidates::findOne([
                    'user_enc_id' => $token_holder_id->user_enc_id
                ]);

                if ($user) {
                    $hasApplied = AppliedApplications::find()
                        ->where(['application_enc_id' => $application_details->application_enc_id])
                        ->andWhere(['created_by' => $user->user_enc_id])
                        ->exists();
                    $result['hasApplied'] = $hasApplied;

                    $shortlist = ShortlistedApplications::find()
                        ->select('shortlisted')
                        ->where(['shortlisted' => 1, 'application_enc_id' => $application_details->application_enc_id, 'created_by' => $user->user_enc_id])
                        ->exists();
                    $result["hasShortlisted"] = $shortlist;
                }else{
                    return $this->response(401);
                }
            }

            $organization_details = $application_details
                ->getOrganizationEnc()
                ->select(['organization_enc_id','name', 'initials_color color', 'email', 'website', 'CASE WHEN logo IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '",logo_location, "/", logo) END logo', 'CASE WHEN cover_image IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, true) . '",cover_image_location, "/", cover_image) END cover_image'])
                ->asArray()
                ->one();

            $result['organisation'] = $organization_details;

            $application_questionnaire = ApplicationInterviewQuestionnaire::find()
                ->alias('a')
                ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                ->where(['a.application_enc_id' => $application_details->application_enc_id])
                ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                ->andWhere(['b.field_name' => 'Get Applications'])
                ->exists();

            $result['hasQuestionnaire'] = $application_questionnaire;

            $object = new JobDetail();
            $data = $object
                ->getCloneData($application_details->application_enc_id);

            $i = 0;
            foreach ($data["applicationEmployeeBenefits"] as $d) {
                if(!empty($d["icon"])) {
                    $data["applicationEmployeeBenefits"][$i]["full_location"] = Url::to(Yii::$app->params->upload_directories->benefits->icon . $d["icon_location"] . DIRECTORY_SEPARATOR . $d["icon"], true);
                } else{
                    $data["applicationEmployeeBenefits"][$i]["full_location"] = Url::to('@commonAssets/employee-benefits/plus-icon.svg', true);
                }
                $i++;
            }
            $temp = $data["cat_name"];
            $data["cat_name"] = $data["name"];
            $data["name"] = $temp;
            unset($data["id"]);
            unset($data["application_number"]);
            unset($data["application_enc_id"]);
            unset($data["designation_enc_id"]);
            unset($data["category_enc_id"]);
            unset($data["cat_id"]);
            unset($data["title"]);
            unset($data["slug"]);
            unset($data["preferred_industry"]);
            unset($data["interview_process_enc_id"]);
            unset($data["slug"]);
            unset($data["option_enc_id"]);
            unset($data["fixed_wage"]);
            unset($data["min_wage"]);
            unset($data["max_wage"]);
            unset($data["ctc"]);
            unset($data["wage_duration"]);
            unset($data["has_placement_offer"]);
            unset($data["pre_placement_offer"]);
            unset($data["wage_duration"]);
            unset($data["applicationInterviewQuestionnaires"]);
            unset($data["saturday_frequency"]);
            unset($data["sunday_frequency"]);
            unset($data["has_questionnaire"]);
            unset($data["has_benefits"]);
            unset($data["has_online_interview"]);
            unset($data["internship_duration"]);
            unset($data["internship_duration_type"]);
            unset($data["created_on"]);
            unset($data["created_by"]);
            unset($data["last_updated_on"]);
            unset($data["last_updated_by"]);

            $data['description'] = strip_tags($data['description']);
            $data['description'] = str_replace("&nbsp;", "", $data['description']);

            $data["vacancies"] = 0;
            if (!empty($data['applicationPlacementLocations'])) {
                foreach ($data['applicationPlacementLocations'] as $apl) {
                    $data["vacancies"] += $apl['positions'];
                }
            }
            
            if(empty($data['applicationInterviewLocations'])){
                $data['applicationInterviewLocations'][] = [
                       "location_enc_id" => "kdmvkdkv",
                       "application_enc_id" => "kdmklvadkv",
                       "city_enc_id" => "",
                       "name" => "Online"
                ];
            }

            if(!$data["vacancies"]){
                $data["vacancies"] = 0;
            }
            
            $data['icon'] = Url::to('/assets/common/categories/profile/' . $data['icon_png'], true);
            unset($data['icon_png']);
            $data['preferred_gender'] = $this->prefferedGender($data['preferred_gender']);

            $result['applicationDetails'] = $data;

            return $this->response(200, $result);
        } else {
            return $this->response(422);
        }
    }

    private function prefferedGender($g)
    {
        switch ($g) {
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

    public function actionAvailableResume()
    {
        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        $resume = UserResume::find()
            ->select(['user_enc_id', 'resume_enc_id', 'title', 'CONCAT("' . Url::to(Yii::$app->params->upload_directories->resume->file, true) . '", resume_location, "/", resume) url'])
            ->where(['user_enc_id' => $user->user_enc_id])
            ->asArray()
            ->all();

        if (sizeof($resume) != 0) {
            return $this->response(200, $resume);
        } else {
            return $this->response(404);
        }

    }

    public function actionApply()
    {
        $model = new JobApply();

        $reqParams = Yii::$app->request->post();

        if (!empty($reqParams['job_id']) && !empty($reqParams['resume_enc_id']) && isset($reqParams['city_id'])) {

            if($reqParams['city_id'] != ''){
                $city_enc_ids = explode(",", $reqParams['city_id']);
            }else{
                $city_enc_ids = [];
            }

            $application_type = ApplicationTypes::find()
                ->select(['application_type_enc_id'])
                ->where(['name' => 'Jobs'])
                ->asArray()
                ->one();

            $id = $reqParams['job_id'];

            $application_details = EmployerApplications::find()
                ->where([
                    'application_enc_id' => $id,
                    'is_deleted' => 0,
                    'application_type_enc_id' => $application_type["application_type_enc_id"]
                ])
                ->one();

            if (!$application_details) {
                return $this->response(404);
            }

            $token_holder_id = UserAccessTokens::find()
                ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
                ->andWhere(['source' => Yii::$app->request->headers->get('source')])
                ->one();

            $user = Candidates::findOne([
                'user_enc_id' => $token_holder_id->user_enc_id
            ]);

            $hasApplied = AppliedApplications::find()
                ->where(['application_enc_id' => $application_details->application_enc_id])
                ->andWhere(['created_by' => $user->user_enc_id])
                ->exists();

            if (!$hasApplied) {
                $application_questionnaire = ApplicationInterviewQuestionnaire::find()
                    ->alias('a')
                    ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                    ->where(['a.application_enc_id' => $reqParams['job_id']])
                    ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                    ->andWhere(['b.field_name' => 'Get Applications'])
                    ->exists();

                $model->id = $reqParams['job_id'];
                $model->resume_list = $reqParams['resume_enc_id'];
                $model->location_pref = $city_enc_ids;

                if ($application_questionnaire) {
                    $model->status = 'incomplete';
                } else {
                    $model->status = 'Pending';
                }

                if ($res = $model->saveValues()) {
                    return $this->response(200, $res);
                } else {
                    return $this->response(500);
                }
            } else {
                return $this->response(409);
            }
        } else {
            return $this->response(422);
        }
    }
}
