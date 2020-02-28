<?php

namespace api\modules\v1\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v1\models\Cards;
use api\modules\v1\models\JobApply;
use api\modules\v1\models\JobDetail;
use common\models\Organizations;
use common\models\Posts;
use common\models\ReviewedApplications;
use common\models\ShortlistedApplications;
use common\models\ApplicationTypes;
use common\models\UnclaimedOrganizations;
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
            'except' => [
                'list',
                'detail',
                'application-detail',
                'get-jobs-by-organization',
                'search',
                'jobs-near-me',
                'test'
            ],
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

        if ($parameters['careers'] && !empty($parameters['careers'])) {
            $options['for_careers'] = (int)$parameters['careers'];
        }

        $options['type'] = 'Jobs';

        $result = Cards::jobs($options);

        if (count($result) > 0) {
            return $this->response(200, $result);
        } else {
            return $this->response(404, 'Not Found');
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
                return $this->response(404, 'Not Found');
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
                    return $this->response(401, 'unauthorized');
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
                ];
            }

            if (!$data["vacancies"]) {
                $data["vacancies"] = null;
            }

            $data['icon'] = Url::to('/assets/common/categories/profile/' . $data['icon_png'], 'https');
            unset($data['icon_png']);
            $data['preferred_gender'] = $this->prefferedGender($data['preferred_gender']);

            $result['applicationDetails'] = $data;

            return $this->response(200, $result);
        } else {
            return $this->response(422, 'Missing Information');
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
            ->select(['user_enc_id', 'resume_enc_id', 'title', 'CONCAT("' . Url::to(Yii::$app->params->upload_directories->resume->file, 'https') . '", resume_location, "/", resume) url'])
            ->where(['user_enc_id' => $user->user_enc_id])
            ->asArray()
            ->all();

        if (sizeof($resume) != 0) {
            return $this->response(200, $resume);
        } else {
            return $this->response(404, 'Not Found');
        }

    }

    public function actionApply()
    {
        $model = new JobApply();

        $reqParams = Yii::$app->request->post();

        if (!empty($reqParams['job_id']) && !empty($reqParams['resume_enc_id'])) {

            if ($reqParams['city_id'] != '') {
                $city_enc_ids = explode(",", $reqParams['city_id']);
            } else {
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
                return $this->response(404, 'Not Found');
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
                    return $this->response(500, 'Not Saved');
                }
            } else {
                return $this->response(409, 'conflict');
            }
        } else {
            return $this->response(422, 'Missing Information');
        }
    }

    public function actionGetJobsByOrganization()
    {
        $parameters = \Yii::$app->request->post();
        $options = [];

        if (!empty($parameters['org_enc_id']) && isset($parameters['org_enc_id'])) {
            $options['org_enc_id'] = $parameters['org_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        if (!empty($parameters['type']) && isset($parameters['type'])) {
            $options['type'] = $parameters['type'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        if (!empty($parameters['keyword']) && isset($parameters['keyword'])) {
            $options['keyword'] = $parameters['keyword'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        $organization_applications = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.slug', 'h.name'])
            ->joinWith(['designationEnc l'], false)
            ->joinWith(['applicationOptions as f'], false)
            ->joinWith(['title g' => function ($z) {
                $z->joinWith(['categoryEnc as h'], false);
                $z->joinWith(['parentEnc p'], false);
            }], false)
            ->joinWith(['preferredIndustry o'], false)
            ->joinWith(['applicationTypeEnc as j'], false)
            ->innerJoinWith(['organizationEnc b' => function ($a) {
                $a->onCondition(['b.status' => 'Active', 'b.is_deleted' => 0]);
            }], false)
            ->where(['a.organization_enc_id' => $options['org_enc_id'], 'a.is_deleted' => 0, 'a.status' => 'Active', 'j.name' => $options['type']]);

        if (!empty($options['keyword'])) {

            $organization_applications->andWhere([
                'or',
                ['like', 'a.slug', $options['keyword']],
                ['like', 'l.designation', $options['keyword']],
                ['like', 'h.name', $options['keyword']],
                ['like', 'o.industry', $options['keyword']],
                ['like', 'p.name', $options['keyword']],
            ]);
        }
        $data = $organization_applications->asArray()->all();

        if ($data == null || empty($data) || $data == '') {
            return $this->response(404, 'Not Found');
        } else {
            return $this->response(200, $data);
        }
    }

    private function findUnclaimed($s)
    {
        return UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.organization_type_enc_id', 'a.name', 'a.slug', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo', 'a.initials_color color'])
            ->joinWith(['organizationTypeEnc b' => function ($y) {
                $y->select(['b.business_activity_enc_id', 'b.business_activity']);
            }])
            ->joinWith(['newOrganizationReviews c' => function ($x) {
                $x->select(['c.organization_enc_id', 'ROUND(AVG(c.average_rating)) average_rating', 'COUNT(c.review_enc_id) reviews_cnt'])
                    ->groupBy(['c.organization_enc_id']);
            }])
            ->where([
                'a.is_deleted' => 0,
                'a.status' => 1
            ])
            ->andFilterWhere([
                'or',
                ['like', 'a.name', $s],
                ['like', 'a.slug', $s],
                ['like', 'a.website', $s],
                ['like', 'b.business_activity', $s],
            ])
            ->groupBy(['a.organization_enc_id'])
            ->asArray()
            ->all();
    }

    public function actionSearch()
    {
        $parameters = \Yii::$app->request->post();
        if (isset($parameters['keyword']) && !empty($parameters['keyword'])) {
            $s = $parameters['keyword'];
            $options['keyword'] = $parameters['keyword'];
        } else {
            return $this->response(422, 'Missing Information');
        }
        $result = [];

        $organizations = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name', 'a.slug', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE NULL END logo', 'a.initials_color color'])
            ->joinWith(['organizationTypeEnc b'], false)
            ->joinWith(['businessActivityEnc c'], false)
            ->joinWith(['industryEnc d'], false)
            ->joinWith(['employerApplications e' => function ($x) {
                $x->select(['e.organization_enc_id', 'COUNT(e.application_enc_id) applications_cnt'])
                    ->onCondition([
                        'e.status' => 'Active',
                        'e.is_deleted' => 0
                    ])
                    ->groupBy(['e.organization_enc_id']);
            }])
            ->joinWith(['organizationReviews f' => function ($y) {
                $y->select(['f.organization_enc_id', 'ROUND(AVG(f.average_rating)) average_rating', 'COUNT(f.review_enc_id) reviews_cnt'])
                    ->groupBy(['f.organization_enc_id']);
            }])
            ->where([
                'a.is_deleted' => 0,
                'a.status' => 'Active'
            ])
            ->andFilterWhere([
                'or',
                ['like', 'a.name', $s],
                ['like', 'a.slug', $s],
                ['like', 'a.website', $s],
                ['like', 'b.organization_type', $s],
                ['like', 'c.business_activity', $s],
                ['like', 'd.industry', $s]
            ])
            ->groupBy(['a.organization_enc_id'])
            ->limit(8);

        $result['organizations'] = $organizations->asArray()->all();

        $unclaimed = $this->findUnclaimed($s);


        $result['School'] = [];
        $result['College'] = [];
        $result['Educational Institute'] = [];
        $result['Recruiter'] = [];
        $result['Business'] = [];
        $result['Scholarship Fund'] = [];
        $result['Banking & Finance Company'] = [];
        $result['Others'] = [];
        foreach ($unclaimed as $uc) {
            $ba = $uc['organizationTypeEnc']['business_activity'];
            if ($ba) {
                if (count($result[$ba]) < 8) {
                    array_push($result[$ba], $uc);
                }
            }
        }

        $result['jobs'] = Cards::jobs($options);
        $result['internships'] = Cards::internships($options);

        $posts = Posts::find()
            ->select([
                'title',
                'CONCAT("' . Url::to('/blog/', 'https') . '", slug) link',
                'excerpt',
                'CASE WHEN featured_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->posts->featured_image, 'https') . '", featured_image_location, "/", featured_image) ELSE NULL END image'
            ])
            ->where([
                'status' => 'Active',
                'is_deleted' => 0
            ])
            ->andFilterWhere([
                'or',
                ['like', 'title', $s],
                ['like', 'slug', $s],
                ['like', 'meta_keywords', $s],
            ]);

        $posts_filter = $posts->asArray()->all();


        $result['posts'] = $posts_filter;


        if (empty($result['organizations'])
            && empty($result['School'])
            && empty($result['College'])
            && empty($result['Educational Institute'])
            && empty($result['Recruiter'])
            && empty($result['Business'])
            && empty($result['Scholarship Fund'])
            && empty($result['Banking & Finance Company'])
            && empty($result['Others'])
            && empty($result['jobs'])
            && empty($result['internships'])
            && empty($result['posts'])) {
            return $this->response(404, 'Not Found');
        } else {
            return $this->response(200, $result);
        }
    }

    public function actionApplicationDetail()
    {
        $req = Yii::$app->request->post();
        if (!empty($req['id'])) {
            $data = $this->getApplication($req['id']);

            if (empty($data)) {
                return $this->response(404, 'Not Found');
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
                        ->where(['review' => 1, 'application_enc_id' => $req['id'], 'created_by' => $user->user_enc_id])
                        ->exists();
                    $data["hasReviewed"] = $reviewlist;
                } else {
                    return $this->response(401, 'unauthorized');
                }
            }

            if ($data['wage_type'] == 'Fixed') {
                if ($data['wage_duration'] == 'Monthly') {
                    $data['fixed_wage'] = $data['fixed_wage'] * 12;
                } elseif ($data['wage_duration'] == 'Hourly') {
                    $data['fixed_wage'] = $data['fixed_wage'] * 40 * 52;
                } elseif ($data['wage_duration'] == 'Weekly') {
                    $data['fixed_wage'] = $data['fixed_wage'] * 52;
                }
                setlocale(LC_MONETARY, 'en_IN');
                $data['amount'] = '₹' . utf8_encode(money_format('%!.0n', $data['fixed_wage'])) . 'p.a.';
            } else if ($data['wage_type'] == 'Negotiable') {
                if ($data['wage_duration'] == 'Monthly') {
                    $data['min_wage'] = $data['min_wage'] * 12;
                    $data['max_wage'] = $data['max_wage'] * 12;
                } elseif ($data['wage_duration'] == 'Hourly') {
                    $data['min_wage'] = $data['min_wage'] * 40 * 52;
                    $data['max_wage'] = $data['max_wage'] * 40 * 52;
                } elseif ($data['wage_duration'] == 'Weekly') {
                    $data['min_wage'] = $data['min_wage'] * 52;
                    $data['max_wage'] = $data['max_wage'] * 52;
                }
                setlocale(LC_MONETARY, 'en_IN');
                if (!empty($data['min_wage']) && !empty($data['max_wage'])) {
                    $data['amount'] = '₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . ' - ' . '₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.a.';
                } elseif (!empty($data['min_wage'])) {
                    $data['amount'] = 'From ₹' . utf8_encode(money_format('%!.0n', $data['min_wage'])) . 'p.a.';
                } elseif (!empty($data['max_wage'])) {
                    $data['amount'] = 'Upto ₹' . utf8_encode(money_format('%!.0n', $data['max_wage'])) . 'p.a.';
                } elseif (empty($data['min_wage']) && empty($data['max_wage'])) {
                    $data['amount'] = 'Negotiable';
                }
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
            return $this->response(422, 'Missing information');
        }
    }

    private function getApplication($id)
    {
        $application = EmployerApplications::find()
            ->select(['organization_enc_id', 'unclaimed_organization_enc_id'])
            ->where([
                'application_enc_id' => $id,
                'is_deleted' => 0,
            ])
            ->asArray()
            ->one();

        $application_data = EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->where([
                'a.application_enc_id' => $id,
                'a.is_deleted' => 0,
            ])
            ->joinWith(['applicationTypeEnc r' => function ($x) {
                $x->andWhere(['r.name' => 'Jobs']);
            }], false)
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
            ->joinWith(['designationEnc n'], false)
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
            }]);
        if ($application['organization_enc_id']) {

            $application_data->joinWith(['applicationOptions b'], false)
                ->joinWith(['organizationEnc w' => function ($s) {
                    $s->onCondition(['w.status' => 'Active', 'w.is_deleted' => 0]);
                }], false);
            $image_link = Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https');

        } else {
            $application_data->joinWith(['applicationUnclaimOptions b'], false)
                ->joinWith(['unclaimedOrganizationEnc w' => function ($s) {
                    $s->onCondition(['w.status' => 1, 'w.is_deleted' => 0]);
                }], false);

            $image_link = Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo, 'https');
        }
        $application_data->joinWith(['preferredIndustry x'], false);
        $data1 = $application_data->select([
            'a.id',
            'a.application_enc_id',
            '(CASE WHEN a.organization_enc_id IS NOT NULL THEN "claimed" ELSE "unclaimed" END) as company_type',
            '(CASE WHEN a.interview_process_enc_id IS NOT NULL THEN "ai_job" ELSE "quick_job" END) as job_type',
            'x.industry',
            'a.title',
            '(CASE
                    WHEN a.preferred_gender = "0" THEN "No preferred gender"
                    WHEN a.preferred_gender = "1" THEN "Male"
                    WHEN a.preferred_gender = "2" THEN "Female"
                    WHEN a.preferred_gender = "3" THEN "Transgender"
                    END) as preferred_gender',
            'TRIM(REPLACE(a.description, "\n", " ")) as description',
            'a.designation_enc_id',
            'n.designation',
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
            '(CASE
                    WHEN a.experience = "0" THEN "No Experience"
                    WHEN a.experience = "1" THEN "Less Than 1 Year"
                    WHEN a.experience = "2" THEN "1 Year"
                    WHEN a.experience = "3" THEN "2 - 3 Years"
                    WHEN a.experience = "3 - 5" THEN "3 - 5 Years"
                    WHEN a.experience = "5 - 10" THEN "5 - 10 Years"
                    WHEN a.experience = "10 - 20" THEN "10 - 20 Years"
                    WHEN a.experience = "20 + " THEN "More Than 20 Years"
                    ELSE "No Experience"
                    END) as experience',
            'w.organization_enc_id',
            'w.name organization_name',
            'w.initials_color color',
            'w.email',
            'w.website',
            'CASE WHEN w.logo IS NULL THEN NULL ELSE CONCAT("' . $image_link . '",w.logo_location, "/", w.logo) END logo',
            'CASE WHEN w.cover_image IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, true) . '",w.cover_image_location, "/", w.cover_image) END cover_image'
        ])
            ->asArray()
            ->one();

        if ($application['organization_enc_id']) {
            $data2 = $application_data->select(['b.wage_type',
                'b.wage_duration',
                'b.fixed_wage',
                'b.min_wage',
                'b.max_wage',
                'b.working_days',
                'b.interview_start_date',
                'b.interview_end_date',])
                ->asArray()
                ->all();
        } else {
            $data2 = $application_data->select(['b.wage_type',
                'b.wage_duration',
                'b.fixed_wage',
                'b.min_wage',
                'b.max_wage',
                'b.job_url'
            ])
                ->asArray()
                ->all();
        }

        unset($data2[0]['applicationEmployeeBenefits']);
        unset($data2[0]['applicationEducationalRequirements']);
        unset($data2[0]['applicationSkills']);
        unset($data2[0]['applicationJobDescriptions']);
        unset($data2[0]['applicationPlacementLocations']);
        unset($data2[0]['applicationInterviewLocations']);
        unset($data2[0]['applicationUnclaimOptions']);

        $result = array_merge($data1, $data2[0]);

        return $result;
    }

    public function actionJobsNearMe()
    {

        $parameters = \Yii::$app->request->post();
        $options = [];
        if (!empty($parameters['latitude']) && isset($parameters['latitude'])) {
            $options['latitude'] = $parameters['latitude'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        if (!empty($parameters['longitude']) && isset($parameters['longitude'])) {
            $options['longitude'] = $parameters['longitude'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        if (!empty($parameters['radius']) && isset($parameters['radius'])) {
            $options['radius'] = $parameters['radius'];
        } else {
            $options['radius'] = 25;
        }

        if (!empty($parameters['type']) && isset($parameters['type'])) {
            $options['type'] = $parameters['type'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        if ($parameters['page'] && (int)$parameters['page'] >= 1) {
            $options['page'] = $parameters['page'];
        } else {
            $options['page'] = 1;
        }

        if (!empty($parameters['walkin']) && (int)$parameters['walkin'] == 1) {
            $options['walkin'] = $parameters['walkin'];
        } else {
            $options['walkin'] = 0;
        }

        if ($parameters['keyword'] && !empty($parameters['keyword'])) {
            $options['keyword'] = $parameters['keyword'];
        }

        $data = Cards::jobsNearMe($options);

        if (!empty($data)) {
            return $this->response(200, $data);
        } else {
            return $this->response(404, 'Not Found');
        }


    }

}
