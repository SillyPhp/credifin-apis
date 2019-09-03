<?php

namespace api\modules\v2\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v2\controllers\ApiBaseController;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\AppliedApplications;
use common\models\EmployerApplications;
use common\models\InterviewProcessFields;
use common\models\ReviewedApplications;
use common\models\ShortlistedApplications;
use common\models\UserAccessTokens;
use yii\filters\auth\HttpBearerAuth;
use Yii;
use yii\helpers\Url;

class JobsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'application-detail',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'application-detail' => ['POST','OPTIONS'],
                'shortlist-application' => ['POST','OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    private function userId()
    {

        if( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )
        {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        return $user;
    }

    public function actionApplicationDetail()
    {
        if( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )
        {
            header("HTTP/1.1 202 Accepted");
            exit;
        }


        $req = Yii::$app->request->post();
        if (!empty($req['slug'])) {
            $data = $this->getApplication($req['slug']);

            if (empty($data)) {
                return $this->response(404);
            }

            if (Yii::$app->request->headers->get('authorization') && Yii::$app->request->headers->get('source')) {

                $token_holder_id = UserAccessTokens::find()
                    ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('authorization'))[1]])
                    ->andWhere(['source' => Yii::$app->request->headers->get('source')])
                    ->one();

                $user = Candidates::findOne([
                    'user_enc_id' => $token_holder_id->user_enc_id
                ]);

                if ($user) {
                    $hasApplied = AppliedApplications::find()
                        ->where(['application_enc_id' => $data['application_enc_id']])
                        ->andWhere(['created_by' => $user->user_enc_id])
                        ->exists();
                    $data['hasApplied'] = $hasApplied;

                    $shortlist = ShortlistedApplications::find()
                        ->select('shortlisted')
                        ->where(['shortlisted' => 1, 'application_enc_id' => $data['application_enc_id'], 'created_by' => $user->user_enc_id])
                        ->exists();
                    $data["hasShortlisted"] = $shortlist;

                    $reviewlist = ReviewedApplications::find()
                        ->select(['review'])
                        ->where(['review' =>1,'application_enc_id'=>$data['application_enc_id'], 'created_by'=>$user->user_enc_id])
                        ->exists();
                    $data["hasReviewed"] = $reviewlist;
                } else {
                    return $this->response(401);
                }
            }

            if(!empty($data['timings_from']) && !empty($data['timings_to'])){
                $data['timings_from'] = date("H:i", strtotime($data['timings_from']));
                $data['timings_to'] = date("H:i", strtotime($data['timings_to']));
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
            return $this->response(422);
        }
    }

    private function getApplication($slug)
    {
        return EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->select([
                'a.id',
                'a.application_enc_id',
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
                'b.wage_type',
                'b.wage_duration',
                'b.fixed_wage',
                'b.min_wage',
                'b.max_wage',
                'b.fixed_wage',
                'b.working_days',
                'b.interview_start_date',
                'b.interview_end_date',
                'w.organization_enc_id',
                'w.name organization_name',
                'w.initials_color color',
                'w.email',
                'w.website',
                'CASE WHEN w.logo IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '",w.logo_location, " / ", w.logo) END logo',
                'CASE WHEN w.cover_image IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, true) . '",w.cover_image_location, " / ", w.cover_image) END cover_image'
            ])
            ->where([
                'a.slug' => $slug,
                'a.is_deleted' => 0,
            ])
//            ->joinWith(['applicationTypeEnc r' => function ($x) {
//                $x->andWhere(['r.name' => 'Jobs']);
//            }], false)
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
            ->joinWith(['designationEnc n'], false)
            ->joinWith(['applicationPlacementLocations o' => function ($x) {
                $x->onCondition(['o.is_deleted' => 0]);
                $x->joinWith(['locationEnc s' => function ($x) {
                    $x->joinWith(['cityEnc t'], false);
                }], false);
                $x->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions','s.latitude','s.longitude', 't.city_enc_id', 't.name']);
            }])
            ->joinWith(['applicationInterviewLocations p' => function ($x) {
                $x->onCondition(['p.is_deleted' => 0]);
                $x->joinWith(['locationEnc u' => function ($x) {
                    $x->joinWith(['cityEnc v'], false);
                }], false);
                $x->select(['p.location_enc_id', 'p.application_enc_id','u.latitude' ,'u.longitude','v.city_enc_id', 'v.name']);
            }])
            ->joinWith(['organizationEnc w' => function ($s) {
                $s->onCondition(['w.status' => 'Active', 'w.is_deleted' => 0]);
            }], false)
            ->joinWith(['preferredIndustry x'], false)
            ->asArray()
            ->one();
    }

    public function actionShortlistApplication()
    {

        if( $_SERVER['REQUEST_METHOD'] === 'OPTIONS' )
        {
            header("HTTP/1.1 202 Accepted");
            exit;
        }
        $candidate = $this->userId();
        $parameters = \Yii::$app->request->post();
        

        if (!empty($parameters['application_enc_id']) && isset($parameters['application_enc_id'])) {
            $id = $parameters['application_enc_id'];
            $chkshort = ShortlistedApplications::find()
                ->select(['shortlisted'])
                ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                ->asArray()
                ->one();
            $short_status = $chkshort['shortlisted'];
            if (empty($chkshort)) {
                $shortlist_application = new ShortlistedApplications();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $shortlist_application->shortlisted_enc_id = $utilitiesModel->encrypt();
                $shortlist_application->application_enc_id = $id;
                $shortlist_application->shortlisted = 1;
                $shortlist_application->created_by = $candidate->user_enc_id;
                $shortlist_application->created_on = date('Y-m-d H:i:s');
                if ($shortlist_application->validate() && $shortlist_application->save()) {

                    $chkuser = ReviewedApplications::find()
                        ->select(['review'])
                        ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                        ->asArray()
                        ->one();
                    $status = $chkuser['review'];

                    if ($status == 1) {
                        $delete_application = ReviewedApplications::find()
                            ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                            ->one();
                        $delete_application->review = 0;
                        $delete_application->last_updated_by = $candidate->user_enc_id;
                        $delete_application->last_updated_on = date('Y-m-d H:i:s');
                        $delete_application->update();
                    }
                    return $this->response(201, 'successfully shortlisted.');
                } else {
                    return $this->response(500, 'not shortlisted');
                }
            } elseif ($short_status == 0) {
                $update_shortlisted = ShortlistedApplications::find()
                    ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                    ->one();

                $update_shortlisted->shortlisted = 1;
                $update_shortlisted->last_updated_by = $candidate->user_enc_id;
                $update_shortlisted->last_updated_on = date('Y-m-d H:i:s');
                if ($update_shortlisted->update()) {
                    return $this->response(201, 'successfully shortlisted.');
                } else {
                    return $this->response(500, 'not shorlisted');
                }
            } elseif ($short_status == 1) {
                $delete_shortlisted = ShortlistedApplications::find()
                    ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                    ->one();
                $delete_shortlisted->shortlisted = 0;
                $delete_shortlisted->last_updated_by = $candidate->user_enc_id;
                $delete_shortlisted->last_updated_on = date('Y-m-d H:i:s');
                if ($delete_shortlisted->update()) {
                    return $this->response(200, 'deleted successfully');
                } else {
                    return $this->response(500, 'Job is not deleted in shortlist');
                }
            } else {
                return $this->response(409, 'already deleted or not found');
            }
        } else {
            return $this->response(422);
        }
    }

}