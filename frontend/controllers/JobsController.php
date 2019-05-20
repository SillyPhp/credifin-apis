<?php

namespace frontend\controllers;

use common\models\Companies;
use common\models\ShortlistedApplications;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use frontend\models\JobApplied;
use common\models\EmployerApplications;
use common\models\ApplicationPlacementLocations;
use common\models\Organizations;
use common\models\OrganizationLocations;
use common\models\Cities;
use common\models\Categories;
use common\models\AssignedCategories;
use common\models\EmployeeBenefits;
use common\models\AppliedApplications;
use common\models\UserResume;
use common\models\ReviewedApplications;
use common\models\Industries;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;
use frontend\models\applications\ApplicationCards;

class JobsController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['job-preview'],
                'rules' => [
                    [
                        'actions' => ['job-preview'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $type = Yii::$app->request->post('type');
            $options = [];
            $options['limit'] = 3;
            $options['page'] = 1;
            $cards = ApplicationCards::jobs($options);
            if ($cards) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'cards' => $cards,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }

        return $this->render('index');
    }


    public function actionList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $parameters = Yii::$app->request->post();

            $options = [];

            if ($parameters['page'] && (int)$parameters['page'] >= 1) {
                $options['page'] = $parameters['page'];
            } else {
                $options['page'] = 1;
            }

            $options['limit'] = 27;

            if ($parameters['location'] && !empty($parameters['location'])) {
                $options['location'] = $parameters['location'];
            }

            if ($parameters['category'] && !empty($parameters['category'])) {
                $options['category'] = $parameters['category'];
            }

            if ($parameters['keyword'] && !empty($parameters['keyword'])) {
                $options['keyword'] = $parameters['keyword'];
            }

            if ($parameters['company'] && !empty($parameters['company'])) {
                $options['company'] = $parameters['company'];
            }

            $cards = ApplicationCards::jobs($options);
            if (count($cards) > 0) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'cards' => $cards,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }

        return $this->render('list');
    }

    public function actionDetail($eaidk)
    {
        $application_details = EmployerApplications::find()
            ->where([
                'slug' => $eaidk,
                'is_deleted' => 0
            ])
            ->one();

        if (!$application_details) {
            return 'Not Found';
        }
        $type = 'Job';
        $object = new \account\models\applications\ApplicationForm();
        $org_details = $application_details->getOrganizationEnc()->select(['name org_name', 'initials_color color', 'slug', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();

        if (!Yii::$app->user->isGuest) {
            $applied_jobs = AppliedApplications::find()
                ->where(['application_enc_id' => $application_details->application_enc_id])
                ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['is_deleted' => 0])
                ->exists();

            $shortlist = \common\models\ShortlistedApplications::find()
                ->select('shortlisted')
                ->where(['shortlisted' => 1, 'application_enc_id' => $application_details->application_enc_id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->one();
        }
        $model = new JobApplied();
        return $this->render('/employer-applications/detail', [
            'application_details' => $application_details,
            'data' => $object->getCloneData($application_details->application_enc_id, $application_type = 'Jobs'),
            'org' => $org_details,
            'applied' => $applied_jobs,
            'type' => $type,
            'model' => $model,
            'shortlist' => $shortlist,
        ]);
    }

    public function actionJobPreview($eipdk)
    {
        if (!empty($eipdk)) {
            $type = 'Job';
            $var = $eipdk;
            $session = Yii::$app->session;
            $object = $session->get($var);
            if (empty($object)) {
                return 'Opps Session expired..!';
            }
            $industry = Industries::find()
                ->where(['industry_enc_id' => $object->industry])
                ->select(['industry'])
                ->asArray()
                ->one();
            $primary_cat = Categories::find()
                ->select(['name', 'icon_png'])
                ->where(['category_enc_id' => $object->primaryfield])
                ->asArray()
                ->one();
            if ($object->benefit_selection == 1) {
                foreach ($object->emp_benefit as $benefit) {
                    $benefits[] = EmployeeBenefits::find()
                        ->select(['benefit', 'icon', 'icon_location'])
                        ->where(['benefit_enc_id' => $benefit])
                        ->asArray()
                        ->one();
                }
            } else {
                $benefits = null;
            }
            if (!empty($object->interviewcity))

                return $this->render('/employer-applications/preview', [
                    'object' => $object,
                    'industry' => $industry,
                    'primary_cat' => $primary_cat,
                    'benefits' => $benefits,
                    'type' => $type
                ]);
        } else {
            return false;
        }
    }

    public function actionItemId()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('itemid');
            $chkshort = ShortlistedApplications::find()
                ->select(['shortlisted'])
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $id])
                ->asArray()
                ->one();
            $short_status = $chkshort['shortlisted'];
            if ($short_status == 1) {
                $response = [
                    'status' => 201,
                    'message' => 'Can not add, it is already shortlisted.',
                ];
                return $response;
            } else {
                $chkuser = ReviewedApplications::find()
                    ->select(['review'])
                    ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $id])
                    ->asArray()
                    ->one();
                $status = $chkuser['review'];
                if (empty($chkuser)) {
                    $model = new ReviewedApplications();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $model->review_enc_id = $utilitiesModel->encrypt();
                    $model->application_enc_id = $id;
                    $model->review = 1;
                    $model->created_on = date('Y-m-d H:i:s');
                    $model->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($model->validate() && $model->save()) {
                        $response = [
                            'status' => 200,
                            'message' => 'Job successfully created in review list.',
                        ];
                        return $response;
                    } else {
                        $response = [
                            'status' => 201,
                            'message' => 'Job not created in review list',
                        ];
                        return $response;
                    }
                } else if ($status == 1) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $id])
                        ->execute();

                    if ($update) {
                        $response = [
                            'status' => 'unshort',
                            'message' => 'Job removed from review list',
                        ];
                        return $response;
                    }
                } else if ($status == 0) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ReviewedApplications::tableName(), ['review' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $id])
                        ->execute();

                    if ($update) {
                        $response = [
                            'status' => 'short',
                            'message' => 'Job added in review list successfully',
                        ];
                        return $response;
                    }
                }
            }

        }
    }

    public function actionJobDetail($eaidk, $type)
    {
        if (Yii::$app->request->isAjax) {
            $application_details = EmployerApplications::find()
                ->alias('a')
                ->select(['a.*', 'b.name org_name', 'b.tag_line', 'b.initials_color color', 'b.slug as org_slug', 'b.email', 'b.website', 'b.logo', 'b.logo_location', 'b.cover_image', 'b.cover_image_location'])
                ->joinWith(['organizationEnc b'], false)
                ->where([
                    'a.slug' => $eaidk,
                    'a.is_deleted' => 0
                ])
                ->asArray()
                ->one();

            if (!$application_details) {
                return 'Not Found';
            }
            $object = new \account\models\applications\ApplicationForm();

            return $this->render('pop_up_detail', [
                'application_details' => $application_details,
                'type' => $type,
                'data' => $object->getCloneData($application_details['application_enc_id'], $type),
            ]);

        }
    }

    public function actionCompare()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $req = Yii::$app->request->post();
            $id = $req['id'];
            $result = $this->getApplicationInfo($id);
            return [
                'status' => 200,
                'message' => $result
            ];
        }
        return $this->render('compare-jobs');
    }

    public function actionGetCompanies($query){
        $companies = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id id','a.name'])
            ->innerJoinWith(['employerApplications b' => function($x){
                $x->onCondition([
                    'b.status' => 'Active',
                    'b.is_deleted' => 0
                ]);
            }],false)
            ->where([
                'a.status' => 'Active',
                'a.is_deleted' => 0
            ])
            ->andFilterWhere(['like', 'a.name', $query])
            ->groupBy(['a.organization_enc_id'])
            ->asArray()
            ->all();
        return json_encode($companies);
    }

    public function actionGetJobs(){
            $req = Yii::$app->request->post();
            $query = $req['q'];
            $id = $req['id'];
            $applications = $req['applications'];
            if(!$applications){
                $applications = [];
            }
            $jobs = Organizations::find()
                ->alias('a')
                ->select(['a.organization_enc_id'])
                ->innerJoinWith(['employerApplications b' => function($x) use($query, $applications){
                    $x->select(['b.application_enc_id', 'b.organization_enc_id', 'c.assigned_category_enc_id', 'c.category_enc_id', 'c.parent_enc_id', 'CONCAT(d.name, " - ",e.name) name']);
                    $x->onCondition([
                        'b.status' => 'Active',
                        'b.is_deleted' => 0
                    ]);

                    $x->andOnCondition(['not in', 'b.application_enc_id', $applications]);

                    $x->joinWith(['title c' => function($y) use($query){

                        $y->andWhere([
                            'c.status' => 'Approved',
                            'c.is_deleted' => 0
                        ]);

                        $y->andFilterWhere([
                            'or',
                            ['like', 'd.name', $query],
                            ['like', 'e.name', $query],
                        ]);

                        $y->joinWith(['categoryEnc d']);
                        $y->joinWith(['parentEnc e']);
                    }], false);

                    $x->groupBy(['b.application_enc_id']);
                }])
                ->where([
                    'a.status' => 'Active',
                    'a.is_deleted' => 0,
                    'a.organization_enc_id' => $id
                ])
                ->groupBy(['a.organization_enc_id'])
                ->asArray()
                ->all();
            return json_encode($jobs[0]['employerApplications']);

    }

    private function getApplicationInfo($id)
    {
        $data = $this->getApplication($id);

        if ($data['application_type'] == 'Job') {
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
        }
        if ($data['application_type'] == 'Internship') {
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
            }
        }
        return $data;
    }

    private function getApplication($id)
    {
        $application = EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->where(['a.application_enc_id' => $id])
            ->joinWith(['preferredIndustry x'], false)
            ->select([
                'a.id',
                'a.application_number',
                'a.application_enc_id',
                'x.industry',
                'a.title',
                'a.preferred_gender',
                'a.description',
                'a.designation_enc_id',
                'n.designation',
                'l.category_enc_id',
                'm.category_enc_id as cat_id',
                'm.name as cat_name',
                'l.name',
                'l.icon_png',
                'a.type',
                'a.slug',
                'a.preferred_industry',
                'a.interview_process_enc_id',
                'a.timings_from',
                'a.timings_to',
                'a.joining_date',
                'a.last_date',
                'w.name organization_name',
                'w.initials_color color',
                'w.slug organization_link',
                '(CASE
                WHEN w.logo IS NULL OR w.logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", w.name, "&size=200&rounded=false&background=", REPLACE(w.initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Yii::$app->params->empower_youth->url . Yii::$app->params->empower_youth->upload_directories->organizations->logo . '", w.logo_location, "/", w.logo) END
                ) organization_logo',
                '(CASE
                WHEN a.experience = "0" THEN "No Experience"
                WHEN a.experience = "1" THEN "Less Than 1 Year"
                WHEN a.experience = "2" THEN "1 Year"
                WHEN a.experience = "3" THEN "2-3 Years"
                WHEN a.experience = "3-5" THEN "3-5 Years"
                WHEN a.experience = "5-10" THEN "5-10 Years"
                WHEN a.experience = "10-20" THEN "10-20 Years"
                WHEN a.experience = "20+" THEN "More Than 20 Years"
                ELSE "No Experience"
                END) as experience', 'b.*, SUBSTRING(r.name, 1, CHAR_LENGTH(r.name) - 1) application_type'])
            ->joinWith(['applicationOptions b'],false)
            ->joinWith(['applicationEmployeeBenefits c' => function ($b) {
                $b->onCondition(['c.is_deleted' => 0]);
                $b->joinWith(['benefitEnc d'], false);
                $b->select(['c.application_enc_id', 'c.benefit_enc_id', 'c.is_deleted', 'd.benefit', 'd.icon', 'd.icon_location']);
            }])
            ->joinWith(['applicationEducationalRequirements e' => function ($b) {
                $b->andWhere(['e.is_deleted' => 0]);
                $b->joinWith(['educationalRequirementEnc f'], false);
                $b->select(['e.application_enc_id', 'f.educational_requirement_enc_id', 'f.educational_requirement']);
            }])
            ->joinWith(['applicationSkills g' => function ($b) {
                $b->andWhere(['g.is_deleted' => 0]);
                $b->joinWith(['skillEnc h'], false);
                $b->select(['g.application_enc_id', 'h.skill_enc_id', 'h.skill']);
            }])
            ->joinWith(['applicationJobDescriptions i' => function ($b) {
                $b->andWhere(['i.is_deleted' => 0]);
                $b->joinWith(['jobDescriptionEnc j'], false);
                $b->select(['i.application_enc_id', 'j.job_description_enc_id', 'j.job_description']);
            }])
            ->joinwith(['title k' => function ($b) {
                $b->joinWith(['parentEnc l'], false);
                $b->joinWith(['categoryEnc m'], false);
            }], false)
            ->joinWith(['designationEnc n'], false)
            ->joinWith(['applicationPlacementLocations o' => function ($b) {
                $b->onCondition(['o.is_deleted' => 0]);
                $b->joinWith(['locationEnc s' => function ($b) {
                    $b->joinWith(['cityEnc t'], false);
                }], false);
                $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 't.city_enc_id', 't.name']);
            }])
            ->joinWith(['applicationInterviewLocations p' => function ($b) {
                $b->onCondition(['p.is_deleted' => 0]);
                $b->joinWith(['locationEnc u' => function ($b) {
                    $b->joinWith(['cityEnc v'], false);
                }], false);
                $b->select(['p.location_enc_id', 'p.application_enc_id', 'v.city_enc_id', 'v.name', 'u.latitude', 'u.longitude']);
            }])
            ->joinWith(['applicationInterviewQuestionnaires q' => function ($b) {
                $b->onCondition(['q.is_deleted' => 0]);
                $b->select(['q.field_enc_id', 'q.questionnaire_enc_id', 'q.application_enc_id']);
            }])
            ->joinwith(['applicationTypeEnc r'], false, 'INNER JOIN')
            ->joinwith(['organizationEnc w' => function ($s) {
                $s->onCondition(['w.status' => 'Active', 'w.is_deleted' => 0]);
            }], false)
            ->asArray()
            ->one();

        return $application;
    }

}