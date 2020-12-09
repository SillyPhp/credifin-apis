<?php

namespace api\modules\v2\controllers;

use api\modules\v1\models\Candidates;
use api\modules\v1\models\JobApply;
use api\modules\v2\controllers\ApiBaseController;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\ApplicationTypes;
use common\models\AppliedApplications;
use common\models\EmployerApplications;
use common\models\ErexxEmployerApplications;
use common\models\InterviewProcessFields;
use common\models\OrganizationInterviewProcess;
use common\models\ReviewedApplications;
use common\models\ShortlistedApplications;
use common\models\UserAccessTokens;
use common\models\UserOtherDetails;
use common\models\Users;
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
                'shortlist-application',
                'apply',
                'process-bar',
                'cancel-job'
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'application-detail' => ['POST', 'OPTIONS'],
                'shortlist-application' => ['POST', 'OPTIONS'],
                'apply' => ['POST', 'OPTIONS'],
                'process-bar' => ['POST', 'OPTIONS'],
                'cancel-job' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    private function userId()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
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

    private function getOrgId()
    {
        if ($user = $this->isAuthorized()) {
            $organizations = Users::find()
                ->alias('a')
                ->select(['b.organization_enc_id college_id'])
                ->joinWith(['organizationEnc b'], false)
                ->where(['a.user_enc_id' => $user->user_enc_id])
                ->asArray()
                ->one();
            return $organizations['college_id'];
        }
    }

    private function getClgId()
    {
        if ($user = $this->isAuthorized()) {
            $clg_id = UserOtherDetails::find()
                ->where(['user_enc_id' => $user->user_enc_id, 'is_deleted' => 0])
                ->one();

            return $clg_id->organization_enc_id;
        }
    }

    public function actionApplicationDetail()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $req = Yii::$app->request->post();
        if (!empty($req['slug'])) {
            $data = $this->getApplication($req['slug']);

            if (empty($data)) {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
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
                        ->where(['review' => 1, 'application_enc_id' => $data['application_enc_id'], 'created_by' => $user->user_enc_id])
                        ->exists();
                    $data["hasReviewed"] = $reviewlist;
                } else {
                    return $this->response(401);
                }
            }

            if (!empty($data['timings_from']) && !empty($data['timings_to'])) {
                $data['timings_from'] = date("H:i", strtotime($data['timings_from']));
                $data['timings_to'] = date("H:i", strtotime($data['timings_to']));
            }

            if ($data['status'] != 'Active') {
                $data['is_closed'] = true;
            } else {
                $data['is_closed'] = false;
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
                    $data["applicationEmployeeBenefits"][$i]["icon"] = Url::to(Yii::$app->params->upload_directories->benefits->icon . $d["icon_location"] . DIRECTORY_SEPARATOR . $d["icon"], 'https');
                } else {
                    $data["applicationEmployeeBenefits"][$i]["icon"] = Url::to('@commonAssets/employee-benefits/plus-icon.svg', 'https');
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

            if ($this->getOrgId()) {
                $is_approve = ErexxEmployerApplications::find()
                    ->select(['is_college_approved', 'is_deleted'])
                    ->where(['employer_application_enc_id' => $data['application_enc_id'], 'college_enc_id' => $this->getOrgId()])
                    ->asArray()
                    ->one();

                $data['is_college_approved'] = $is_approve['is_college_approved'];
                $data['is_college_deleted'] = $is_approve['is_deleted'];
            }

            $application_process = OrganizationInterviewProcess::find()
                ->alias('a')
                ->distinct()
                ->select(['a.interview_process_enc_id'])
                ->joinWith(['interviewProcessFields b' => function ($b) {
                    $b->select(['b.interview_process_enc_id', 'b.field_enc_id', 'b.field_name', 'b.sequence', '(CASE
                        WHEN b.icon = "fa fa-sitemap" THEN "fas fa-sitemap"
                        WHEN b.icon = "fa fa-phone" THEN "fas fa-phone"
                        WHEN b.icon = "fa fa-user" THEN "fas fa-user"
                        WHEN b.icon = "fa fa-cogs" THEN "fas fa-cogs"
                        WHEN b.icon = "fa fa-user-circle" THEN "fas fa-user-circle"
                        WHEN b.icon = "fa fa-users" THEN "fas fa-users"
                        WHEN b.icon = "fa fa-video-camera" THEN "fas fa-video"
                        WHEN b.icon = "fa fa-check" THEN "fas fa-check"
                        WHEN b.icon = "fa fa-pencil-square-o" THEN "fas fa-pen-square"
                        WHEN b.icon = "fa fa-envelope" THEN "fas fa-envelope"
                        WHEN b.icon = "fa fa-question" THEN "fas fa-question"
                        WHEN b.icon = "fa fa-paper-plane" THEN "fas fa-paper-plane"
                        ELSE "fas fa-plus"
                        END) as icon']);
                }])
                ->where(['a.interview_process_enc_id' => $data['interview_process_enc_id'], 'a.is_deleted' => 0])
                ->asArray()
                ->one();
            $data['process'] = $application_process;

            $applied = AppliedApplications::find()
                ->distinct()
                ->alias('a')
                ->select(['a.applied_application_enc_id', 'f.first_name', 'f.last_name', 'a.status', 'e1.name title', 'e2.name parent_category', 'e3.designation', 'g.semester', 'g1.name department', 'f.username', 'e.slug org_slug',
                    'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", f.image_location, "/", f.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(f.first_name, " ", f.last_name), "&size=200&rounded=false&background=", REPLACE(f.initials_color, "#", ""), "&color=ffffff") END image',
                    'a.created_by student_id', 'a.current_round'
                ])
                ->innerJoinWith(['applicationEnc b' => function ($b) {
                    $b->innerJoinWith(['erexxEmployerApplications c' => function ($c) {
                        $c->innerJoinWith(['collegeEnc d']);
                    }]);
                    $b->innerJoinWith(['organizationEnc e']);
                    $b->joinWith(['title ee' => function ($ee) {
                        $ee->joinWith(['categoryEnc e1']);
                        $ee->joinWith(['parentEnc e2']);
                    }], false);
                    $b->joinWith(['designationEnc e3'], false);
                    $b->onCondition(['b.is_deleted' => 0]);
                }], false)
                ->innerJoinWith(['createdBy f' => function ($f) {
                    $f->innerJoinWith(['userOtherInfo g' => function ($g) {
                        $g->joinWith(['departmentEnc g1']);
                    }]);
                    $f->onCondition(['f.is_deleted' => 0]);
                }], false)
                ->where(['d.organization_enc_id' => $this->getOrgId(), 'g.organization_enc_id' => $this->getOrgId(), 'b.application_enc_id' => $data['application_enc_id'], 'a.is_deleted' => 0, 'e.is_deleted' => 0])
                ->andWhere(['e.has_placement_rights' => 1, 'g.college_actions' => 0]);
            $count = $applied->count();
            $applied = $applied->asArray()
                ->all();

            if ($applied && $application_process) {
                foreach ($applied as $key => $val) {
                    foreach ($application_process['interviewProcessFields'] as $a) {
                        if ($val['current_round'] == $a['sequence']) {
                            $applied[$key]['process_name'] = $a['field_name'];
                        }
                    }
                }
            }

            $data['applied_count'] = $count;
            $data['applied_list'] = $applied;
            $data['is_blocked'] = $this->isHired();


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
                'a.status',
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
                'b.saturday_frequency',
                'b.sunday_frequency',
                'b.interview_start_date',
                'b.interview_end_date',
                'w.organization_enc_id',
                'REPLACE(w.name, "&amp;", "&") as organization_name',
                'w.initials_color color',
                'w.email',
                'w.website',
                'w.slug org_slug',
                'r.name application_type',
                'CASE WHEN w.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", w.logo_location, "/", w.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", w.name, "&size=200&rounded=false&background=", REPLACE(w.initials_color, "#", ""), "&color=ffffff") END logo',
                'CASE WHEN w.cover_image IS NULL THEN NULL ELSE CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image, 'https') . '",w.cover_image_location, "/", w.cover_image) END cover_image'
            ])
            ->where([
                'a.slug' => $slug,
                'a.is_deleted' => 0,
            ])
            ->joinWith(['applicationTypeEnc r'], false)
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
                $x->onCondition(['g.is_deleted' => 0]);
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
                    $x->groupBy(['s.city_enc_id']);
                }], false);
                $x->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 's.latitude', 's.longitude', 't.city_enc_id', 't.name']);
            }])
            ->joinWith(['applicationInterviewLocations p' => function ($x) {
                $x->onCondition(['p.is_deleted' => 0]);
                $x->joinWith(['locationEnc u' => function ($x) {
                    $x->joinWith(['cityEnc v'], false);
                }], false);
                $x->select(['p.location_enc_id', 'p.application_enc_id', 'u.latitude', 'u.longitude', 'v.city_enc_id', 'v.name']);
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

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
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
                    return $this->response(201, ['status' => 200]);
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
                    return $this->response(200, ['status' => 200]);
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
                    return $this->response(200, ['status' => 201]);
                } else {
                    return $this->response(500, 'Job is not deleted in shortlist');
                }
            }
        } else {
            return $this->response(422);
        }
    }

    public function actionApply()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 202 Accepted");
            exit;
        }

        $model = new \api\modules\v2\models\JobApply();

        $reqParams = Yii::$app->request->post();

        if (!empty($reqParams['app_id']) && isset($reqParams['city_id'])) {

            if ($reqParams['city_id'] != '') {
                $city_enc_ids = $reqParams['city_id'];
            } else {
                $city_enc_ids = [];
            }

            $id = $reqParams['app_id'];

            $application_details = EmployerApplications::find()
                ->where([
                    'application_enc_id' => $id,
                    'is_deleted' => 0,
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
                    ->where(['a.application_enc_id' => $reqParams['app_id']])
                    ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                    ->andWhere(['b.field_name' => 'Get Applications'])
                    ->exists();

                $model->id = $reqParams['app_id'];
//                $model->resume_list = $reqParams['resume_enc_id'];
                $model->location_pref = $city_enc_ids;

                if ($application_questionnaire) {
                    $model->status = 'incomplete';
                } else {
                    $model->status = 'Pending';
                }

                if ($res = $model->saveValues()) {
                    if ($d = $this->profileCompletions()) {
                        return $this->response(200, ['status' => 200, 'profile' => $d]);
                    } else {
                        $d = ['is_completed' => false, 'percent' => 0];
                        return $this->response(200, ['status' => 200, 'profile' => $d]);
                    }
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

    private function profileCompletions()
    {
        if ($user = $this->isAuthorized()) {
            $data = Users::find()
                ->alias('a')
                ->select(['a.user_enc_id', 'a.city_enc_id', 'b.cgpa'])
                ->joinWith(['userOtherInfo b'], false)
                ->joinWith(['userPreferences c' => function ($c) {
                    $c->select(['c.preference_enc_id', 'c.created_by', 'c.assigned_to']);
                }])
                ->where(['a.user_enc_id' => $user->user_enc_id, 'a.is_deleted' => 0, 'a.status' => 'Active'])
                ->asArray()
                ->one();

            if ($data) {
                $per = 0;
                $total = 4;
                $t = 100 / $total;
                if ($data['city_enc_id']) {
                    $per += $t;
                }
                if ($data['cgpa']) {
                    $per += $t;
                }
                if ($data['userPreferences']) {
                    foreach ($data['userPreferences'] as $p) {
                        if ($p['preference_enc_id']) {
                            $per += $t;
                        }
                    }
                }
                $profile_completed = false;
                if ($per == 100) {
                    $profile_completed = true;
                }
                return ['is_completed' => $profile_completed, 'percent' => $per];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function isHired()
    {
        if ($user = $this->isAuthorized()) {

            $hired = AppliedApplications::find()
                ->distinct()
                ->alias('a')
                ->innerJoinWith(['applicationEnc b' => function ($b) {
                    $b->innerJoinWith(['erexxEmployerApplications c' => function ($c) {
                        $c->onCondition(['c.is_deleted' => 0, 'c.status' => 'Active', 'c.college_enc_id' => $this->getClgId()]);
                    }]);
                }], false)
                ->where([
                    'a.created_by' => $user->user_enc_id,
                    'a.is_deleted' => 0,
                    'a.status' => 'Hired',
                ])
                ->asArray()
                ->all();

            if ($hired) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionUserProcess()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();

            if (isset($params['application_id']) && !empty($params['application_id'])) {
                $application_id = $params['application_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $applied_user = AppliedApplications::find()
                ->distinct()
                ->alias('a')
                ->where(['a.application_enc_id' => $application_id, 'a.created_by' => $user->user_enc_id])
                ->select(['a.applied_application_enc_id', 'a.status', 'i.icon', 'h.name org_name', 'h.slug org_slug', 'g.name title', 'b.slug', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'COUNT(c.is_completed) total'])
                ->joinWith(['applicationEnc b' => function ($b) {
                    $b->joinWith(['organizationEnc h'], false);
                    $b->joinWith(['title f' => function ($b) {
                        $b->joinWith(['parentEnc i'], false);
                        $b->joinWith(['categoryEnc g'], false);
                    }], false);

                }], false)
                ->joinWith(['appliedApplicationProcesses c' => function ($b) {
                    $b->joinWith(['fieldEnc d'], false);
                    $b->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon']);
                }])
                ->groupBy(['a.applied_application_enc_id'])
                ->asArray()
                ->one();

            if ($applied_user) {
                return $this->response(200, ['status' => 200, 'data' => $applied_user]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionCancelJob()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (isset($params['applied_application_id']) && !empty($params['applied_application_id'])) {
                $applied_app_id = $params['applied_application_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $application = AppliedApplications::find()
                ->where(['applied_application_enc_id' => $applied_app_id])
                ->one();

            if ($application) {
                $application->status = 'Cancelled';
                $application->last_updated_on = date('Y-m-d H:i:s');
                $application->last_updated_by = $user->user_enc_id;
                if ($application->update()) {
                    return $this->response(200, ['status' => 200, 'message' => 'Cancelled']);
                } else {
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionProcessBar()
    {
        if ($user = $this->isAuthorized()) {
            $params = Yii::$app->request->post();
            if (isset($params['limit']) && !empty($params['limit'])) {
                $limit = $params['limit'];
            } else {
                $limit = 5;
            }

            $process = EmployerApplications::find()
                ->distinct()
                ->alias('a')
                ->select(['a.application_enc_id', 'b.applied_application_enc_id', 'b.status',
                    'COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) as active', 'COUNT(h.is_completed) as total',
                    'ROUND((COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) / COUNT(h.is_completed)) * 100, 0) AS per',
                    'i.name type', 'g.name as org_name',
                    'd.name as title', 'cc.assigned_category_enc_id',
                    'CASE WHEN e.icon IS NULL OR e.icon = "" THEN "' . Url::to('@commonAssets/employee-benefits/plus-icon.svg', 'https') . '" ELSE CONCAT("' . Url::to('@commonAssets/categories/', 'https') . '", e.icon) END icon'
                ])
                ->joinWith(['appliedApplications b' => function ($b) {
                    $b->joinWith(['appliedApplicationProcesses h']);
                }], false)
                ->joinWith(['applicationTypeEnc i'], false)
                ->joinWith(['organizationEnc g'], false)
                ->joinWith(['title cc' => function ($c) {
                    $c->joinWith(['categoryEnc d']);
                    $c->joinWith(['parentEnc e']);
                }], false)
                ->innerJoinWith(['erexxEmployerApplications c' => function ($c) {
                    $c->onCondition(['c.is_deleted' => 0, 'c.status' => 'Active', 'c.college_enc_id' => $this->getClgId()]);
                }], false)
                ->where(['b.created_by' => $user->user_enc_id])
                ->limit($limit)
                ->groupBy(['h.applied_application_enc_id'])
                ->orderBy(['b.id' => SORT_DESC])
                ->asArray()
                ->all();

            if ($process) {
                return $this->response(200, ['status' => 200, 'data' => $process]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionApplicationProcess()
    {
        if ($user = $this->isAuthorized()) {

            $params = Yii::$app->request->post();

            if (isset($params['employer_app_id']) && !empty($params['employer_app_id'])) {
                $app_id = $params['employer_app_id'];
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'missing information']);
            }

            $application_name = EmployerApplications::find()
                ->alias('a')
                ->select(['c.name job_title', 'a.slug', 'a.application_enc_id', 'a.interview_process_enc_id', 'ate.name application_type', 'pe.icon',
                    '(CASE
                WHEN a.experience = "0" THEN "No Experience"
                WHEN a.experience = "1" THEN "Less Than 1 Year"
                WHEN a.experience = "2" THEN "1 Year"
                WHEN a.experience = "3" THEN "2-3 Years"
                WHEN a.experience = "3-5" THEN "3-5 Years"
                WHEN a.experience = "5-10" THEN "5-10 Years"
                WHEN a.experience = "10-20" THEN "10-20 Years"
                WHEN a.experience = "20+" THEN "More Than 20 Years"
                WHEN a.minimum_exp = "0" AND a.maximum_exp IS NUll THEN "No Experience"
                WHEN a.minimum_exp = "20" AND a.maximum_exp = "20+" THEN "More Than 20 Years Experience"
                WHEN a.minimum_exp IS NOT NUll AND a.maximum_exp IS NOT NUll THEN CONCAT(a.minimum_exp,"-",a.maximum_exp," Years Experience")
                WHEN a.minimum_exp IS NOT NUll AND a.maximum_exp IS NUll THEN CONCAT("Minimum ",a.minimum_exp," Years Experience") 
                WHEN a.minimum_exp IS NUll AND a.maximum_exp IS NOT NUll THEN CONCAT("Maximum ",a.maximum_exp," Years Experience") 
                ELSE "No Experience" 
                END) as experience', 'ao.wage_type', 'ao.fixed_wage', 'ao.min_wage', 'ao.max_wage', 'ao.wage_duration'])
                ->where(['a.application_enc_id' => $app_id])
                ->joinWith(['title b' => function ($b) {
                    $b->joinWith(['categoryEnc c'], false, 'INNER JOIN');
                    $b->joinWith(['parentEnc pe'], false, 'INNER JOIN');
                }], false, 'INNER JOIN')
                ->joinWith(['applicationTypeEnc ate'], false)
                ->joinWith(['interviewProcessEnc d' => function ($d) {
                    $d->select(['d.interview_process_enc_id']);
                    $d->joinWith(['interviewProcessFields']);
                }])
                ->joinWith(['applicationPlacementLocations o' => function ($b) {
                    $b->onCondition(['o.is_deleted' => 0]);
                    $b->joinWith(['locationEnc s' => function ($b) {
                        $b->joinWith(['cityEnc t'], false);
                    }], false);
                    $b->select(['o.location_enc_id', 'o.application_enc_id', 'SUM(o.positions) positions', 's.latitude', 's.longitude', 't.city_enc_id', 't.name']);
                    $b->distinct();
                }])
                ->joinWith(['applicationInterviewLocations p' => function ($b) {
                    $b->onCondition(['p.is_deleted' => 0]);
                    $b->joinWith(['locationEnc u' => function ($b) {
                        $b->joinWith(['cityEnc v'], false);
                    }], false);
                    $b->select(['p.location_enc_id', 'p.application_enc_id', 'v.city_enc_id', 'v.name', 'u.latitude as interview_lat', 'u.longitude as interview_long']);
                }])
                ->joinWith(['applicationOptions ao'], false)
                ->asArray()
                ->one();

            return $this->response(200, ['status' => 200, 'message' => $application_name]);
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

}