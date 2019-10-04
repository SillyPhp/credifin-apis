<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v1\models\Cards;
use api\modules\v1\models\JobApply;
use api\modules\v1\models\JobDetail;
use common\models\ReviewedApplications;
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

class InternshipsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => ['list', 'detail', 'application-detail'],
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

        if ($parameters['careers'] && !empty($parameters['careers'])) {
            $options['for_careers'] = (int)$parameters['careers'];
        }

        $options['type'] = 'Internships';

        $result = Cards::internships($options);

        if (count($result) > 0) {
            return $this->response(200, $result);
        } else {
            return $this->response(404,'Not Found');
        }
    }

    public function actionDetail()
    {
        $parameters = \Yii::$app->request->post();

        if (!empty($parameters['id'])) {

            $application_type = ApplicationTypes::find()
                ->select(['application_type_enc_id'])
                ->where(['name' => 'Internships'])
                ->asArray()
                ->one();
            $result = [];

            $id = $parameters['id'];

            $application_details = EmployerApplications::find()
                ->where([
                    'application_enc_id' => $id,
                    'is_deleted' => 0,
                    'application_type_enc_id' => $application_type["application_type_enc_id"]
                ])
                ->one();

            if (!$application_details) {
                return $this->response(404,'Not Found');
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
                } else {
                    return $this->response(401,'unauthorized');
                }
            }

            $organization_details = $application_details
                ->getOrganizationEnc()
                ->select(['organization_enc_id', 'name', 'initials_color color', 'email', 'website', 'CASE WHEN logo IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '",logo_location, "/", logo) END logo', 'CASE WHEN cover_image IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, true) . '",cover_image_location, "/", cover_image) END cover_image'])
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
                if (!empty($d["icon"])) {
                    $data["applicationEmployeeBenefits"][$i]["full_location"] = Url::to(Yii::$app->params->upload_directories->benefits->icon . $d["icon_location"] . DIRECTORY_SEPARATOR . $d["icon"], 'https');
                } else {
                    $data["applicationEmployeeBenefits"][$i]["full_location"] = Url::to('@commonAssets/employee-benefits/plus-icon.svg', 'https');
                }
                $i++;
            }

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
            unset($data["pre_placement_offer"]);

            $data['description'] = strip_tags($data['description']);
            $data['description'] = str_replace("&nbsp;", " ", $data['description']);
            $data['description'] = str_replace("&amp;", "&", $data['description']);

            $data["vacancies"] = 0;
            if (!empty($data['applicationPlacementLocations'])) {
                foreach ($data['applicationPlacementLocations'] as $apl) {
                    $data["vacancies"] += $apl['positions'];
                }
            }

            if (empty($data['applicationInterviewLocations'])) {
                $data['applicationInterviewLocations'][] = [
                    "location_enc_id" => "kdmvkdkv",
                    "application_enc_id" => "kdmklvadkv",
                    "city_enc_id" => "",
                    "name" => "Online"
                ];;
            }

            if (!$data["vacancies"]) {
                $data["vacancies"] = 0;
            }

            unset($data["internship_duration_type"]);
            unset($data["internship_duration"]);
            unset($data["has_online_interview"]);
            $data['icon'] = Url::to('/assets/common/categories/profile/' . $data['icon_png'], 'https');
            unset($data['icon_png']);

            $result['applicationDetails'] = $data;

            return $this->response(200, $result);
        } else {
            return $this->response(422,'Missing Information');
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

    private function placementOffer($g)
    {
        switch ($g) {
            case 1:
                return "Yes";
            case 2:
                return "No";
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
            ->select(['user_enc_id', 'resume_enc_id', 'title', 'CONCAT("' . Url::to(Yii::$app->params->upload_directories->resume->file, 'https') . '", resume_location, "/", resume) url'])
            ->where(['user_enc_id' => $user->user_enc_id])
            ->asArray()
            ->all();

        if (sizeof($resume) != 0) {
            return $this->response(200, $resume);
        } else {
            return $this->response(404,'Not found');
        }

    }

    public function actionApply()
    {

        $model = new JobApply();

        $reqParams = Yii::$app->request->post();

        if (!empty($reqParams['job_id']) && !empty($reqParams['resume_enc_id']) && !empty($reqParams['city_id'])) {

            if ($reqParams['city_id'] != '') {
                $city_enc_ids = explode(",", $reqParams['city_id']);
            } else {
                $city_enc_ids = [];
            }

            $application_type = ApplicationTypes::find()
                ->select(['application_type_enc_id'])
                ->where(['name' => 'Internships'])
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
                return $this->response(404,'Not Found');
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
                    ->where(['a.application_enc_id' => Yii::$app->request->post("job_id")])
                    ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                    ->andWhere(['b.field_name' => 'Get Applications'])
                    ->exists();

                $model->id = Yii::$app->request->post("job_id");
                $model->resume_list = Yii::$app->request->post("resume_enc_id");
                $model->location_pref = $city_enc_ids;

                if ($application_questionnaire) {
                    $model->status = 'incomplete';
                } else {
                    $model->status = 'Pending';
                }

                if ($res = $model->saveValues()) {
                    return $this->response(200, $res);
                } else {
                    return $this->response(500,'Not Saved');
                }
            } else {
                return $this->response(409,'conflict');
            }

        } else {
            return $this->response(422,'Missing Information');
        }
    }

    public function actionApplicationDetail()
    {
        $req = Yii::$app->request->post();
        if (!empty($req['id'])) {
            $data = $this->getApplication($req['id']);

            if (empty($data)) {
                return $this->response(404,'Not Found');
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
                        ->where(['application_enc_id' => $req['id']])
                        ->andWhere(['created_by' => $user->user_enc_id])
                        ->exists();
                    $data['hasApplied'] = $hasApplied;

                    $shortlist = ShortlistedApplications::find()
                        ->select('shortlisted')
                        ->where(['shortlisted' => 1, 'application_enc_id' => $req['id'], 'created_by' => $user->user_enc_id])
                        ->exists();
                    $data["hasShortlisted"] = $shortlist;

                    $reviewlist = ReviewedApplications::find()
                        ->select(['review'])
                        ->where(['review' =>1,'application_enc_id'=>$req['id'], 'created_by'=>$user->user_enc_id])
                        ->exists();
                    $data["hasReviewed"] = $reviewlist;

                } else {
                    return $this->response(401,'unauthorized');
                }
            }

            if ($data['wage_type'] == 'Fixed') {
                if ($data['wage_duration'] == 'Weekly') {
                    $data['fixed_wage'] = $data['fixed_wage'] / 7 * 30;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $data['amount'] = '₹' . utf8_encode(money_format('%!.0n', $data['fixed_wage'])) . 'p.m.';
            } elseif ($data['wage_type'] == 'Negotiable' || $data['wage_type'] == 'Performance Based') {
                if ($data['wage_duration'] == 'Weekly') {
                    $data['min_wage'] = $data['min_wage'] / 7 * 30;
                    $data['max_wage'] = $data['max_wage'] / 7 * 30;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $data['amount'] = '₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.m.';
            }else{
                $data['amount'] = "Unpaid";
            }
            $data['hasQuestionnaire'] = ApplicationInterviewQuestionnaire::find()
                ->alias('a')
                ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                ->where(['a.application_enc_id' => $req['id']])
                ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                ->andWhere(['b.field_name' => 'Get Applications'])
                ->exists();

            $i = 0;
            foreach ($data["applicationEmployeeBenefits"] as $d) {
                if (!empty($d["icon"])) {
                    $data["applicationEmployeeBenefits"][$i]["full_location"] = Url::to(Yii::$app->params->upload_directories->benefits->icon . $d["icon_location"] . DIRECTORY_SEPARATOR . $d["icon"], 'https');
                } else {
                    $data["applicationEmployeeBenefits"][$i]["full_location"] = Url::to('@commonAssets/employee-benefits/plus-icon.svg', 'https');
                }
                $i++;
            }

            $data['has_placement_offer'] = $this->placementOffer($data['has_placement_offer']);

            $data["vacancies"] = 0;
            if (!empty($data['applicationPlacementLocations'])) {
                foreach ($data['applicationPlacementLocations'] as $apl) {
                    $data["vacancies"] += $apl['positions'];
                }
            }

            if (empty($data['applicationInterviewLocations'])) {
                $data['applicationInterviewLocations'][] = [
                    "location_enc_id" => "kdmvkdkv",
                    "application_enc_id" => "kdmklvadkv",
                    "city_enc_id" => "",
                    "name" => "Online"
                ];
            }

            $data['icon'] = Url::to('/assets/common/categories/profile/' . $data['icon_png'], 'https');
            unset($data['icon_png']);
            unset($data['min_wage']);
            unset($data['max_wage']);
            unset($data['fixed_wage']);

            return $this->response(200, $data);
        } else {
            return $this->response(422,'Missing Information');
        }
    }

    private function getApplication($id)
    {
        return EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->select([
                'a.id',
                'a.application_enc_id',
                'a.title',
                '(CASE
                    WHEN a.preferred_gender = "0" THEN "No preferred gender"
                    WHEN a.preferred_gender = "1" THEN "Male"
                    WHEN a.preferred_gender = "2" THEN "Female"
                    WHEN a.preferred_gender = "3" THEN "Transgender"
                    END) as preferred_gender',
                'TRIM(REPLACE(a.description, "\n", " ")) as description',
                'l.category_enc_id',
                'm.category_enc_id as cat_id',
                'm.name',
                'l.name as cat_name',
                'l.icon_png',
                'a.type',
                'a.slug',
                'a.preferred_industry',
                'a.interview_process_enc_id',
                'a.timings_from',
                'a.timings_to',
                'a.joining_date',
                'a.last_date',
                'b.wage_type',
                'b.wage_duration',
                'b.fixed_wage',
                'b.min_wage',
                'b.max_wage',
                'b.fixed_wage',
                'b.working_days',
                'b.interview_start_date',
                'b.interview_end_date',
                'b.has_placement_offer',
                'w.organization_enc_id',
                'w.name organization_name',
                'w.initials_color color',
                'w.email',
                'w.website',
                'CASE WHEN w.logo IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '",w.logo_location, "/", w.logo) END logo',
                'CASE WHEN w.cover_image IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, true) . '",w.cover_image_location, "/", w.cover_image) END cover_image'
            ])
            ->where([
                'a.application_enc_id' => $id,
                'a.is_deleted' => 0,
            ])
            ->joinWith(['applicationTypeEnc r' => function ($x) {
                $x->andWhere(['r.name' => 'Internships']);
            }], false)
            ->joinWith(['applicationOptions b'], false)
            ->joinWith(['applicationEmployeeBenefits c' => function ($x) {
                $x->onCondition(['c.is_deleted' => 0]);
                $x->joinWith(['benefitEnc d'], false);
                $x->select(['c.application_enc_id', 'c.benefit_enc_id', 'c.is_deleted', 'd.benefit', 'd.icon', 'd.icon_location']);
            }])
            ->joinWith(['applicationEducationalRequirements e' => function ($x) {
                $x->joinWith(['educationalRequirementEnc f'], false);
                $x->select(['e.application_enc_id', 'f.educational_requirement_enc_id', 'f.educational_requirement']);
            }])
            ->joinWith(['applicationSkills g' => function ($x) {
                $x->joinWith(['skillEnc h'], false);
                $x->select(['g.application_enc_id', 'h.skill_enc_id', 'h.skill']);
            }])
            ->joinWith(['applicationJobDescriptions i' => function ($x) {
                $x->onCondition(['i.is_deleted' => 0]);
                $x->joinWith(['jobDescriptionEnc j'], false);
                $x->select(['i.application_enc_id', 'j.job_description_enc_id', 'j.job_description']);
            }])
            ->joinWith(['title k' => function ($x) {
                $x->joinWith(['parentEnc l'], false);
                $x->joinWith(['categoryEnc m'], false);
            }], false)
            ->joinWith(['applicationPlacementLocations o' => function ($x) {
                $x->onCondition(['o.is_deleted' => 0]);
                $x->joinWith(['locationEnc s' => function ($x) {
                    $x->joinWith(['cityEnc t'], false);
                }], false);
                $x->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 't.city_enc_id', 't.name']);
            }])
            ->joinWith(['applicationInterviewLocations p' => function ($x) {
                $x->onCondition(['p.is_deleted' => 0]);
                $x->joinWith(['locationEnc u' => function ($x) {
                    $x->joinWith(['cityEnc v'], false);
                }], false);
                $x->select(['p.location_enc_id', 'p.application_enc_id', 'v.city_enc_id', 'v.name']);
            }])
            ->joinWith(['organizationEnc w' => function ($s) {
                $s->onCondition(['w.status' => 'Active', 'w.is_deleted' => 0]);
            }], false)
            ->asArray()
            ->one();
    }

}
