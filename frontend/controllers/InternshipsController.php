<?php

namespace frontend\controllers;

use common\models\ApplicationPlacementCities;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTemplates;
use common\models\ApplicationTypes;
use common\models\Cities;
use common\models\OrganizationLocations;
use common\models\States;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use common\models\EmployerApplications;
use common\models\Categories;
use common\models\Industries;
use common\models\EmployeeBenefits;
use common\models\AppliedApplications;
use common\models\UserResume;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;
use frontend\models\applications\ApplicationCards;
use account\models\applications\ApplicationForm;
use common\models\AssignedCategories;
use common\models\Organizations;
use common\models\Users;
use frontend\models\applications\QuickJob;

class InternshipsController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['internship-preview'],
                'rules' => [
                    [
                        'actions' => ['internship-preview'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->requestedRoute);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $options = [];
            $options['limit'] = 6;
            $options['page'] = 1;
            $cards = ApplicationCards::internships($options);
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
        $job_profiles = AssignedCategories::find()
            ->alias('a')
            ->select(['a.*', 'd.category_enc_id', 'd.name'])
            ->joinWith(['parentEnc d' => function ($z) {
                $z->groupBy(['d.category_enc_id']);
            }], false)
            ->innerJoinWith(['employerApplications b' => function ($x) {
                $x->onCondition([
                    'b.is_deleted' => 0,
                    'b.status' => 'Active'
                ]);
                $x->joinWith(['applicationTypeEnc c' => function ($y) {
                    $y->andWhere(['c.name' => 'Jobs']);
                }], false);
            }], false)
            ->where([
                'a.status' => 'Approved',
                'a.is_deleted' => 0,
            ])->asArray()
            ->all();
        $internship_profiles = AssignedCategories::find()
            ->alias('a')
            ->select(['a.*', 'd.category_enc_id', 'd.name'])
            ->joinWith(['parentEnc d' => function ($z) {
                $z->groupBy(['d.category_enc_id']);
            }])
            ->innerJoinWith(['employerApplications b' => function ($x) {
                $x->onCondition([
                    'b.is_deleted' => 0,
                    'b.status' => 'Active'
                ]);
                $x->joinWith(['applicationTypeEnc c' => function ($y) {
                    $y->andWhere(['c.name' => 'Internships']);
                }], false);
            }], false)
            ->where([
                'a.status' => 'Approved',
                'a.is_deleted' => 0,
            ])->asArray()
            ->all();
        $search_words = AssignedCategories::find()
            ->alias('a')
            ->select(['a.*', 'd.category_enc_id', 'd.name'])
            ->joinWith(['categoryEnc d' => function ($y) {
                $y->groupBy(['d.category_enc_id']);
            }], false)
            ->innerJoinWith(['employerApplications b' => function ($x) {
                $x->onCondition([
                    'b.is_deleted' => 0,
                    'b.status' => 'Active',
                ]);
            }], false)
            ->where([
                'a.status' => 'Approved',
                'a.is_deleted' => 0,
            ])
            ->asArray()
            ->all();
        $cities = EmployerApplications::find()
            ->alias('a')
            ->select(['d.name', 'COUNT(c.city_enc_id) as total', 'c.city_enc_id'])
            ->innerJoinWith(['applicationPlacementLocations b' => function ($x) {
                $x->joinWith(['locationEnc c' => function ($x) {
                    $x->joinWith(['cityEnc d']);
                }], false);
            }], false)
            ->where([
                'a.is_deleted' => 0
            ])
            ->orderBy(['total' => SORT_DESC])
            ->groupBy(['c.city_enc_id'])
            ->asArray()
            ->all();

        $other_jobs = (new \yii\db\Query())
            ->distinct()
            ->from(States::tableName() . 'as a')
            ->select([
                'a.state_enc_id',
                'b.country_enc_id',
                'c.city_enc_id',
                'count(CASE WHEN e.application_enc_id IS NOT NULL AND f.name = "Jobs" Then 1 END)  as job_count',
                'count(CASE WHEN e.application_enc_id IS NOT NULL AND f.name = "Internships"  Then 1 END)  as internship_count',
            ])
            ->innerJoin(\common\models\Countries::tableName() . 'as b', 'b.country_enc_id = a.country_enc_id')
            ->leftJoin(Cities::tableName() . 'as c', 'c.state_enc_id = a.state_enc_id')
            ->leftJoin(ApplicationPlacementCities::tableName() . 'as d', 'd.city_enc_id = c.city_enc_id')
            ->leftJoin(EmployerApplications::tableName() . 'as e', 'e.application_enc_id = d.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as f', 'f.application_type_enc_id = e.application_type_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as g', 'g.assigned_category_enc_id = e.title')
            ->where(['e.is_deleted' => 0, 'b.name' => 'India']);
        $other_jobs_state_wise = $other_jobs->addSelect('a.name state_name')->groupBy('a.id');
        $other_jobs_city_wise = $other_jobs->addSelect('c.name city_name')->groupBy('c.id');
        $ai_jobs = (new \yii\db\Query())
            ->distinct()
            ->from(States::tableName() . 'as a')
            ->select([
                'a.state_enc_id',
                'b.country_enc_id',
                'c.city_enc_id',
                'count(CASE WHEN j.application_enc_id IS NOT NULL AND k.name = "Jobs" Then 1 END)  as job_count',
                'count(CASE WHEN j.application_enc_id IS NOT NULL AND k.name = "Internships"  Then 1 END)  as internship_count',
            ])
            ->innerJoin(\common\models\Countries::tableName() . 'as b', 'b.country_enc_id = a.country_enc_id')
            ->leftJoin(Cities::tableName() . 'as c', 'c.state_enc_id = a.state_enc_id')
            ->leftJoin(OrganizationLocations::tableName() . 'as h', 'h.city_enc_id = c.city_enc_id')
            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as i', 'i.location_enc_id = h.location_enc_id')
            ->innerJoin(EmployerApplications::tableName() . 'as j', 'j.application_enc_id = i.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as k', 'k.application_type_enc_id = j.application_type_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as l', 'l.assigned_category_enc_id = j.title')
            ->where(['j.is_deleted' => 0, 'l.is_deleted' => 0, 'b.name' => 'India']);
        $ai_jobs_state_wise = $ai_jobs->addSelect('a.name state_name')->groupBy('a.id');
        $ai_jobs_city_wise = $ai_jobs->addSelect('c.name city_name')->groupBy('c.id');
        $cities_jobs = (new \yii\db\Query())
            ->from([
                $other_jobs_city_wise->union($ai_jobs_city_wise),
            ])
            ->select(['city_name', 'SUM(internship_count) as internships'])
            ->groupBy('city_enc_id')
            ->orderBy(['internships' => SORT_DESC])
            ->limit(4)
            ->all();


        $tweets = $this->_getTweets($keywords = null, $location = null, $type = "Internships", $limit = 4, $offset = null);
        return $this->render('index', [
            'job_profiles' => $job_profiles,
            'internship_profiles' => $internship_profiles,
            'search_words' => $search_words,
            'cities' => $cities,
            'tweets' => $tweets,
            'cities_jobs' => $cities_jobs

        ]);
    }

    public function actionInternshipPreview($eipdk)
    {
        if (!empty($eipdk)) {
            $type = 'Internship';
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

    public function actionList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $parameters = Yii::$app->request->post();
            $options = [];
            if (Yii::$app->request->get('location')||Yii::$app->request->get('keyword'))
            {
                $parameters['keyword'] = str_replace("-"," ",Yii::$app->request->get('keyword'));
                $parameters['location'] =str_replace("-"," ",Yii::$app->request->get('location'));
            }
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

            $cards = ApplicationCards::internships($options);
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
            ->joinWith(['applicationTypeEnc b' => function ($b) {
                $b->andWhere(['b.name' => 'internships']);
            }])
            ->one();
        $type = 'Internship';
        if (empty($application_details)) {
            return 'Application Not found';
        }
        $object = new \account\models\applications\ApplicationForm();
        if (!empty($application_details->unclaimed_organization_enc_id)) {
            $org_details = $application_details->getUnclaimedOrganizationEnc()->select(['organization_enc_id','name org_name', 'initials_color color', 'slug', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();
            $data1 = $object->getCloneUnclaimed($application_details->application_enc_id, $application_type = 'Internships');
        } else {
            $org_details = $application_details->getOrganizationEnc()->select(['organization_enc_id','name org_name', 'initials_color color', 'slug', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();
            $data2 = $object->getCloneData($application_details->application_enc_id, $application_type = 'Internships');
        }
        if (!Yii::$app->user->isGuest) {
            $applied_jobs = AppliedApplications::find()
                ->where(['application_enc_id' => $application_details->application_enc_id])
                ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->exists();

            $resumes = UserResume::find()
                ->select(['user_enc_id', 'resume_enc_id', 'title'])
                ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->all();

            $app_que = ApplicationInterviewQuestionnaire::find()
                ->alias('a')
                ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                ->where(['a.application_enc_id' => $application_details->application_enc_id])
                ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                ->andWhere(['b.field_name' => 'Get Applications'])
                ->exists();

            $shortlist = \common\models\ShortlistedApplications::find()
                ->select('shortlisted')
                ->where(['shortlisted' => 1, 'application_enc_id' => $application_details->application_enc_id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->one();
        }
        if (!empty($application_details)) {
            $model = new \frontend\models\applications\JobApplied();
            return $this->render('/employer-applications/detail', [
                'application_details' => $application_details,
                'data1' => $data1,
                'data2' => $data2,
                'org' => $org_details,
                'type' => $type,
                'applied' => $applied_jobs,
                'model' => $model,
                'resume' => $resumes,
                'que' => $app_que,
                'shortlist' => $shortlist,
            ]);
        } else {
            return 'Not Found';
        }
    }

    public function actionTemplate($view){
        if(Yii::$app->user->identity->organization) {
            $application = ApplicationTemplates::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.description', 'a.title', 'a.designation_enc_id', 'a.type', 'a.preferred_industry', 'a.interview_process_enc_id', 'a.timings_from', 'a.timings_to', 'a.experience', 'a.preferred_gender', 'zz.name as cat_name', 'zx.name as profile', 'y.designation', 'v.industry'])
                ->joinWith(['title0 z' => function ($z) {
                    $z->joinWith(['categoryEnc zz']);
                    $z->joinWith(['parentEnc zx']);
                }], false)
                ->joinWith(['designationEnc y'])
                ->joinWith(['preferredIndustry v'], false)
                ->joinWith(['applicationEduReqTemplates b' => function ($b) {
                    $b->select(['b.educational_requirement_enc_id', 'b.application_enc_id', 'i.educational_requirement']);
                    $b->joinWith(['educationalRequirementEnc i'], false);
                }])
                ->joinWith(['applicationOptionsTemplates c'])
                ->joinWith(['applicationSkillsTemplates d' => function ($d) {
                    $d->select(['d.application_enc_id', 'd.skill_enc_id', 'g.skill']);
                    $d->joinWith(['skillEnc g'], false);
                }])
                ->joinWith(['applicationTemplateJobDescriptions e' => function ($e) {
                    $e->select(['e.job_description_enc_id', 'e.application_enc_id', 'h.job_description']);
                    $e->joinWith(['jobDescriptionEnc h'], false);
                }])
                ->joinWith(['applicationTypeEnc f'], false)
                ->where(['a.application_enc_id' => $view, 'f.name' => 'Internships'])
                ->asArray()
                ->one();

            return $this->render('/employer-applications/template-preview', [
                'data' => $application,
                'type' => 'Internship'
            ]);
        }
    }

    public function actionQuickInternship()
    {
        if (!Yii::$app->user->identity->organization):
        $this->layout = 'main-secondary';
        $model = new QuickJob();
        $typ = 'Internships';
        $data = new ApplicationForm();
        $primary_cat = $data->getPrimaryFields();
        $job_type = $data->getApplicationTypes();
        $currencies = $data->getCurrency();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save($typ)) {
                Yii::$app->session->setFlash('success', 'Your Job Has Been Posted Successfully Submitted..');
            } else {
                Yii::$app->session->setFlash('error', 'Error Please Contact Supportive Team ');
            }
            return $this->refresh();
        }
        return $this->render('quick-internship', ['typ' => $typ,'currencies'=>$currencies,'model' => $model, 'primary_cat' => $primary_cat, 'job_type' => $job_type]);
        else :
            return $this->redirect('/account/internships/quick-internship');
        endif;
    }

    public function actionSimilarApplication($slug)
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $app_data = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.title'])
                ->joinWith(['title b' => function ($x) {
                    $x->select(['b.assigned_category_enc_id', 'b.category_enc_id', 'b.parent_enc_id', 'c.name title', 'd.name profile']);
                    $x->joinWith(['categoryEnc c'], false);
                    $x->joinWith(['parentEnc d'], false);
                }])
                ->where([
                    'a.slug' => $slug,
                    'a.is_deleted' => 0
                ])
                ->asArray()
                ->one();

            $app_keys = [];
            array_push($app_keys, $app_data['title']['title']);
            array_push($app_keys, $app_data['title']['profile']);

            $options['similar_jobs'] = $app_keys;
            $options['limit'] = 6;
            $related_app_data = ApplicationCards::internships($options);

            return [
                'status' => 200,
                'cards' => $related_app_data
            ];
        }
    }

    public function actionNearMe()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $lat = Yii::$app->request->post('lat');
            $long = Yii::$app->request->post('long');
            $radius = Yii::$app->request->post('inprange');
            $num = Yii::$app->request->post('num');
            $keyword = Yii::$app->request->post('keyword');
            $type = 'Internships';
            $walkin = 0;

            $radius = $radius / 1000;

            $cards = \frontend\models\nearme\ApplicationCards::cards($lat, $long, $radius, $num, $keyword, $type, $walkin);

            return $cards;
        }
        return $this->render('near-me-beta');
    }

    public function actionWalkInInterviews()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $lat = Yii::$app->request->post('lat');
            $long = Yii::$app->request->post('long');
            $radius = Yii::$app->request->post('inprange');
            $num = Yii::$app->request->post('num');
            $keyword = Yii::$app->request->post('keyword');
            $type = 'Internships';
            $walkin = 1;

            $radius = $radius / 1000;

            $cards = \frontend\models\nearme\ApplicationCards::cards($lat, $long, $radius, $num, $keyword, $type, $walkin);

            return $cards;
        }
        return $this->render('walkin-near-me-beta');
    }

    public function actionUserLocation()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            $location = Users::find()
                ->alias('a')
                ->select(['b.name', 'c.name as state_name'])
                ->where(['a.user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->joinWith(['cityEnc as b' => function ($x) {
                    $x->joinWith(['stateEnc as c']);
                }], false)
                ->asArray()
                ->one();

            return json_encode($location);
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
        return $this->render('compare-internships');
    }

    public function actionFindApplication()
    {
        if (Yii::$app->request->isPost && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $req = Yii::$app->request->post();
            $slug = $req['slug'];
            $result = EmployerApplications::find()
                ->where([
                    'slug' => $slug,
                    'is_deleted' => 0,
                ])
                ->asArray()
                ->one();
            return [
                'status' => 200,
                'message' => $result['application_enc_id']
            ];
        }
    }

    public function actionGetCompanies($query)
    {
        $companies = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id id', 'a.name'])
            ->innerJoinWith(['employerApplications b' => function ($x) {
                $x->onCondition([
//                    'b.status' => 'Active',
                    'b.is_deleted' => 0
                ]);
                $x->innerJoinWith(['applicationTypeEnc c' => function ($y) {
                    $y->andWhere(['c.name' => 'Internships']);
                }]);
            }], false)
            ->where([
//                'a.status' => 'Active',
                'a.is_deleted' => 0
            ])
            ->andFilterWhere(['like', 'a.name', $query])
            ->groupBy(['a.organization_enc_id'])
            ->asArray()
            ->all();
        return json_encode($companies);
    }

    public function actionGetJobs()
    {
        $req = Yii::$app->request->post();
        $query = $req['q'];
        $id = $req['id'];
        $applications = $req['applications'];
        if (!$applications) {
            $applications = [];
        }
        $jobs = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id'])
            ->distinct()
            ->innerJoinWith(['employerApplications b' => function ($x) use ($query, $applications) {
                $x->select(['b.application_enc_id', 'b.organization_enc_id', 'c.assigned_category_enc_id', 'c.category_enc_id', 'c.parent_enc_id', 'CONCAT(d.name, " - ",e.name) name']);
                $x->onCondition([
//                    'b.status' => 'Active',
                    'b.is_deleted' => 0
                ]);

                $x->andOnCondition(['not in', 'b.application_enc_id', $applications]);

                $x->joinWith(['title c' => function ($y) use ($query) {

//                    $y->andWhere([
//                        'c.status' => 'Approved',
//                        'c.is_deleted' => 0
//                    ]);

                    $y->andFilterWhere([
                        'or',
                        ['like', 'd.name', $query],
                        ['like', 'e.name', $query],
                    ]);

                    $y->joinWith(['categoryEnc d']);
                    $y->joinWith(['parentEnc e']);
                }], false);

                $x->innerJoinWith(['applicationTypeEnc z' => function ($zz) {
                    $zz->andWhere(['z.name' => 'Internships']);
                }]);

                $x->groupBy(['b.application_enc_id']);

                $x->limit(10);
            }])
            ->where([
//                'a.status' => 'Active',
                'a.is_deleted' => 0,
                'a.organization_enc_id' => $id
            ])
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
            ->joinWith(['applicationOptions b'], false)
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
                $s->onCondition([
//                    'w.status' => 'Active',
                    'w.is_deleted' => 0
                ]);
            }], false)
            ->asArray()
            ->one();

        return $application;
    }

    public function actionProfiles()
    {
        $activeProfiles = AssignedCategories::find()
            ->select(['b.name', 'b.slug', 'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", b.icon) icon', 'COUNT(d.id) as total'])
            ->alias('a')
            ->distinct()
            ->innerJoinWith(['parentEnc b' => function ($b) {
                $b->onCondition([
                    'or',
                    ['!=', 'b.icon', NULL],
                    ['!=', 'b.icon', ''],
                ])
                    ->groupBy(['b.category_enc_id']);
            }], false)
            ->joinWith(['employerApplications d' => function ($d) {
                $d->andOnCondition([
                    'd.status' => 'Active',
                    'd.is_deleted' => 0,
                ])
                    ->joinWith(['applicationTypeEnc e' => function ($e) {
                        $e->andOnCondition(['e.name' => ucfirst('Internships')]);
                    }], false);
            }], false)
            ->where(['a.assigned_to' => ucfirst('Internships')])
            ->orderBy([
//                'total' => SORT_DESC,
                'b.name' => SORT_ASC,
            ])
            ->asArray()
            ->all();
        return $this->render('internship-profiles', ['profiles' => $activeProfiles]);

    }

    private function _getTweets($keywords = null, $location = null, $type = null, $limit = null, $offset = null)
    {
        $tweets1 = (new \yii\db\Query())
            ->distinct()
            ->select(['a.tweet_enc_id', 'a.job_type', 'a.created_on', 'c.name org_name', 'a.html_code', 'f.name profile', 'e.name job_title', 'c.initials_color color', 'CASE WHEN c.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",c.logo_location, "/", c.logo) END logo'])
            ->from(\common\models\TwitterJobs::tableName() . 'as a')
            ->leftJoin(\common\models\TwitterPlacementCities::tableName() . ' g', 'g.tweet_enc_id = a.tweet_enc_id')
            ->leftJoin(\common\models\Cities::tableName() . 'as h', 'h.city_enc_id = g.city_enc_id')
            ->innerJoin(\common\models\AssignedCategories::tableName() . 'as d', 'd.assigned_category_enc_id = a.job_title')
            ->innerJoin(\common\models\Categories::tableName() . 'as e', 'e.category_enc_id = d.category_enc_id')
            ->innerJoin(\common\models\Categories::tableName() . 'as f', 'f.category_enc_id = d.parent_enc_id')
            ->innerJoin(\common\models\UnclaimedOrganizations::tableName() . 'as c', 'c.organization_enc_id = a.unclaim_organization_enc_id')
            ->innerJoin(\common\models\ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->FilterWhere([
                'or',
                ['like', 'a.job_type', $keywords],
                ['like', 'c.name', $keywords],
                ['like', 'f.name', $keywords],
                ['like', 'e.name', $keywords],
                ['like', 'a.html_code', $keywords],
                ['like', 'h.name', $keywords],
            ])
            ->andFilterWhere(['like', 'h.name', $location])
            ->andFilterWhere(['like', 'j.name', $type]);

        $tweets2 = (new \yii\db\Query())
            ->distinct()
            ->select(['a.tweet_enc_id', 'a.job_type', 'a.created_on', 'c.name org_name', 'a.html_code', 'f.name profile', 'e.name job_title', 'c.initials_color color', 'CASE WHEN c.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '",c.logo_location, "/", c.logo) END logo'])
            ->from(\common\models\TwitterJobs::tableName() . 'as a')
            ->leftJoin(\common\models\TwitterPlacementCities::tableName() . ' g', 'g.tweet_enc_id = a.tweet_enc_id')
            ->leftJoin(\common\models\Cities::tableName() . 'as h', 'h.city_enc_id = g.city_enc_id')
            ->innerJoin(\common\models\AssignedCategories::tableName() . 'as d', 'd.assigned_category_enc_id = a.job_title')
            ->innerJoin(\common\models\Categories::tableName() . 'as e', 'e.category_enc_id = d.category_enc_id')
            ->innerJoin(\common\models\Categories::tableName() . 'as f', 'f.category_enc_id = d.parent_enc_id')
            ->innerJoin(\common\models\Organizations::tableName() . 'as c', 'c.organization_enc_id = a.claim_organization_enc_id')
            ->innerJoin(\common\models\ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->FilterWhere([
                'or',
                ['like', 'a.job_type', $keywords],
                ['like', 'c.name', $keywords],
                ['like', 'f.name', $keywords],
                ['like', 'e.name', $keywords],
                ['like', 'a.html_code', $keywords],
                ['like', 'h.name', $keywords],
            ])
            ->andFilterWhere(['like', 'h.name', $location])
            ->andFilterWhere(['like', 'j.name', $type]);

        $result = (new \yii\db\Query())
            ->from([
                $tweets1->union($tweets2),
            ])
            ->limit($limit)
            ->offset($offset)
            ->groupBy('tweet_enc_id')
            ->orderBy(['created_on' => SORT_DESC])
            ->all();

        return $result;
    }

}