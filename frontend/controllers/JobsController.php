<?php

namespace frontend\controllers;

use common\models\ApplicationOptions;
use common\models\ApplicationPlacementCities;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationSkills;
use common\models\ApplicationTypes;
use common\models\ApplicationUnclaimOptions;
use common\models\Cities;
use common\models\Designations;
use common\models\IndianGovtDepartments;
use common\models\OrganizationLocations;
use common\models\States;
use common\models\TwitterJobs;
use common\models\UnclaimedOrganizations;
use common\models\UsaDepartments;
use frontend\models\applications\PreferredApplicationCards;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\EmployerApplications;
use common\models\Organizations;
use common\models\ShortlistedApplications;
use common\models\Users;
use common\models\Categories;
use common\models\EmployeeBenefits;
use common\models\AppliedApplications;
use common\models\ReviewedApplications;
use common\models\Industries;
use frontend\models\applications\ApplicationCards;
use common\models\AssignedCategories;
use common\models\BusinessActivities;
use common\models\Skills;
use frontend\models\applications\CreateCompany;
use frontend\models\applications\QuickJob;
use frontend\models\workingProfiles\WorkingProfile;
use account\models\applications\ApplicationForm;

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

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionJobsUnclaimApply()
    {
        if (Yii::$app->request->isPost) {
            if (!Yii::$app->user->isGuest) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $id = Yii::$app->request->post('data');
                $c_id = Yii::$app->request->post('cid');
                $applied_jobs = AppliedApplications::find()
                    ->where(['application_enc_id' => $id])
                    ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
                    ->andWhere(['is_deleted' => 0])
                    ->exists();
                if (!$applied_jobs):
                    $model = new \frontend\models\applications\JobApplied();
                    $model->id = $id;
                    $model->resume_list = NULL;
                    $model->status = 'Pending';
                    $res = $model->saveValues();
                    if ($res['status']) {
                        Yii::$app->notificationEmails->userAppliedNotify(Yii::$app->user->identity->user_enc_id, $id, $company_id = null, $unclaim_company_id = $c_id, $type = "Jobs", $res['aid']);
                        return $res;
                    } else {
                        return false;
                    }
                endif;
            }
        }
    }

    public function actionTest()
    {
        $mail = Yii::$app->mail;
        $mail->receivers = [];
        $mail->receivers = [
            [
                "name" => "Tarandeep Singh",
                "email" => "vasishtshshank@yahoo.com",
            ],
            [
                "name" => "Tarandeep Singh",
                "email" => "vasishtshshank@outlook.com",
            ],
            [
                "name" => "Tarandeep Singh",
                "email" => "vasishtshshank@gmail.com",
            ],
            [
                "name" => "Tarandeep Singh",
                "email" => "shshank@dsbedutech.in",
            ],
            [
                "name" => "Tarandeep Singh",
                "email" => "kashishbudhiraja16781@gmail.com",
            ]
        ];
        $mail->subject = 'Thank you for your review';
        $mail->data = ['job' => ""];
        $mail->template = 'review';
        if ($mail->send()) {
            return "ok";
        }
    }

    public function actionJobsApply()
    {
        $model = new \frontend\models\applications\JobApplied();
        if (Yii::$app->request->isPost) {
            if (!Yii::$app->user->isGuest) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if (Yii::$app->request->post("check") == 1) {
                    $arr_loc = Yii::$app->request->post("json_loc");
                    $model->id = Yii::$app->request->post("application_enc_id");
                    $model->resume_list = Yii::$app->request->post("resume_enc_id");
                    $model->location_pref = $arr_loc;
                    $model->status = Yii::$app->request->post("status");
                    $application_typ = Yii::$app->request->post("application_type");
                    $cid = Yii::$app->request->post("org_id");
                    $res = $model->saveValues();
                    if ($res['status']) {
                        Yii::$app->notificationEmails->userAppliedNotify(Yii::$app->user->identity->user_enc_id, $model->id, $company_id = $cid, $unclaim_company_id = null, $type = $application_typ, $res['aid']);
                        return $res;
                    } else {
                        return false;
                    }
                } else if (Yii::$app->request->post("check") == 0) {
                    $arr_loc = Yii::$app->request->post("json_loc");
                    $model->resume_file = UploadedFile::getInstance($model, 'resume_file');
                    $model->id = Yii::$app->request->post("id");
                    $model->location_pref = $arr_loc;
                    $model->status = Yii::$app->request->post("status");
                    $application_typ = Yii::$app->request->post("application_type");
                    $cid = Yii::$app->request->post("org_id");
                    $res = $model->upload();
                    if ($res['status']) {
                        Yii::$app->notificationEmails->userAppliedNotify(Yii::$app->user->identity->user_enc_id, $model->id, $company_id = $cid, $unclaim_company_id = null, $type = $application_typ, $res['aid']);
                        return $res;
                    } else {
                        return false;
                    }
                }
            }
        }
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $location = Yii::$app->request->post('location');
            $type = Yii::$app->request->post('type');
            $options = [];
            $options['limit'] = 6;
            $options['page'] = 1;
            $options['type'] = $type;
            $options['location'] = $location;
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
            ->select(['city_name', 'SUM(job_count) as jobs'])
            ->groupBy('city_enc_id')
            ->orderBy(['jobs' => SORT_DESC])
            ->limit(4)
            ->all();

        $tweets = $this->_getTweets(null, null, "Jobs", 4, "");

        return $this->render('index', [
            'job_profiles' => $job_profiles,
            'internship_profiles' => $internship_profiles,
            'search_words' => $search_words,
            'cities' => $cities,
            'tweets' => $tweets,
            'cities_jobs' => $cities_jobs
        ]);
    }

    public function actionPreferredList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $options = Yii::$app->request->post();
            $cards = PreferredApplicationCards::jobs($options);
            if ($cards) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'cards' => $cards,
                    'total' => count($cards),
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }


    public function actionList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $parameters = Yii::$app->request->post();
            $options = [];
            if (Yii::$app->request->get('location') || Yii::$app->request->get('keyword')) {
                $parameters['keyword'] = str_replace("-", " ", Yii::$app->request->get('keyword'));
                $parameters['location'] = str_replace("-", " ", Yii::$app->request->get('location'));
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
        if (!empty($application_details->unclaimed_organization_enc_id)) {
            $org_details = $application_details->getUnclaimedOrganizationEnc()->select(['organization_enc_id', 'name org_name', 'initials_color color', 'slug', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();
            $data1 = $object->getCloneUnclaimed($application_details->application_enc_id, $application_type = 'Jobs');
        } else {
            $org_details = $application_details->getOrganizationEnc()->select(['organization_enc_id', 'name org_name', 'initials_color color', 'slug', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();
            $data2 = $object->getCloneData($application_details->application_enc_id, $application_type = 'Jobs');
        }
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
        $model = new \frontend\models\applications\JobApplied();
        return $this->render('/employer-applications/detail', [
            'application_details' => $application_details,
            'data1' => $data1,
            'data2' => $data2,
            'org' => $org_details,
            'applied' => $applied_jobs,
            'type' => $type,
            'model' => $model,
            'shortlist' => $shortlist,
        ]);
    }

    public function actionFetchSkills($q)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $list = Skills::find()
            ->select(['skill text', 'skill id'])
            ->where(['like', 'skill', $q])
            ->andWhere(['is_deleted' => 0])
            ->limit(20)
            ->asArray()
            ->all();
        $out['results'] = array_values($list);
        return $out;
    }

    public function actionCreateCompany()
    {
        $createCompany = new CreateCompany();
        $business = BusinessActivities::find()->select(['business_activity_enc_id', 'business_activity'])->asArray()->all();
        $b = ArrayHelper::map($business, 'business_activity_enc_id', 'business_activity');
        $createCompany->type = $business[4]['business_activity_enc_id'];
        return $this->renderAjax('/jobs/create-company', [
            'createCompany' => $createCompany,
            'b' => $b,
        ]);
    }

    public function actionCreateOrg()
    {
        $createCompany = new CreateCompany();
        if ($createCompany->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $createCompany->logo = UploadedFile::getInstance($createCompany, 'logo');
            if ($createCompany->save()) {
                return [
                    'status' => 'success',
                    'message' => 'Company Has Been Added',
                    'title' => 'Success',
                ];
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Something Went Wrong',
                    'title' => 'Error',
                ];
            }
        }
    }

    public function actionQuickJob()
    {
        if (!Yii::$app->user->identity->organization):
            $this->layout = 'main-secondary';
            $model = new QuickJob();
            $typ = 'Jobs';
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
            return $this->render('quick-job', ['typ' => $typ, 'currencies' => $currencies, 'model' => $model, 'primary_cat' => $primary_cat, 'job_type' => $job_type]);
        else :
            return $this->redirect('/account/jobs/quick-job');
        endif;
    }

    public function actionTwitterJob()
    {
        $this->layout = 'main-secondary';
        $model = new QuickJob();
        $typ = 'Jobs';
        $data = new ApplicationForm();
        $primary_cat = $data->getPrimaryFields();
        $job_type = $data->getApplicationTypes();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save($typ)) {
                Yii::$app->session->setFlash('success', 'Your Job Has Been Posted Successfully Submitted..');
            } else {
                Yii::$app->session->setFlash('error', 'Error Please Contact Supportive Team ');
            }
            return $this->refresh();
        }
        return $this->render('twitter-job', ['typ' => $typ, 'model' => $model, 'primary_cat' => $primary_cat, 'job_type' => $job_type]);
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

            return $this->renderAjax('pop_up_detail', [
                'application_details' => $application_details,
                'type' => $type,
                'data' => $object->getCloneData($application_details['application_enc_id'], $type),
            ]);

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
            $type = 'Jobs';
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
            $type = 'Jobs';
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
        return $this->render('compare-jobs');
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
                    $y->andWhere(['c.name' => 'Jobs']);
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

                $x->joinWith(['applicationTypeEnc z' => function ($zz) {
                    $zz->andWhere(['z.name' => 'Jobs']);
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
            $related_app_data = ApplicationCards::jobs($options);

            return [
                'status' => 200,
                'cards' => $related_app_data
            ];
        }
    }

    public function actionProfiles()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {

            Yii::$app->response->format = Response::FORMAT_JSON;
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
                            $e->andOnCondition(['e.name' => ucfirst('Jobs')]);
                        }], false);
                }], false)
                ->where(['a.assigned_to' => ucfirst('Jobs')])
                ->orderBy([
//                    'total' => SORT_DESC,
                    'b.name' => SORT_ASC,
                ])
                ->asArray()
                ->all();

            if ($activeProfiles) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'categories' => [
                        'jobs' => $activeProfiles,
                    ],
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }

            return $response;
        }
        return $this->render('working-profile');
    }

    public function actionInternational()
    {
        return $this->render('/employer-applications/international', [
            'type' => 'jobs'
        ]);
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

    public function actionGetStats()
    {
        $referrerUrl = trim(Yii::$app->request->referrer, '/');
        $urlParts = parse_url($referrerUrl);
        $controller_id = explode('/', $urlParts['path'])[1];
        $actionid = explode('/', $urlParts['path'])[2];

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $total_jobs = $this->getData('Jobs');
            $total_internships = $this->getData('Internships');
            $total = $this->getData('');

            switch ([$controller_id, $actionid]) {
                case ['jobs', ''] :
                case ['jobs', 'index'] :
                    return [
                        'status' => 200,
                        'cards' => ['jobs' => $total_jobs['total_applications'], 'titles' => $total_jobs['titles'], 'location' => $total_jobs['locations'], 'companies' => $total_jobs['org']]
                    ];
                    break;
                case ['internships', ''] :
                case ['internships', 'index'] :
                    return [
                        'status' => 200,
                        'cards' => ['titles' => $total_internships['titles'], 'internships' => $total_internships['total_applications'], 'location' => $total_internships['locations'], 'companies' => $total_internships['org']]
                    ];
                    break;
                default :
                    return [
                        'status' => 200,
                        'cards' => ['jobs' => $total_jobs['total_applications'], 'internships' => $total_internships['total_applications'], 'location' => $total['locations'], 'companies' => $total_jobs['org']]
                    ];
            }
        }
    }

    private function getData($type)
    {
        $titles = AssignedCategories::find()
            ->andWhere(['is_deleted' => 0])
            ->andWhere(['not', ['parent_enc_id' => null]]);
        if ($type == "") {
            $titles->andWhere(['in', 'assigned_to', ['Jobs', 'Internships']]);
        } else {
            $titles->andWhere(['assigned_to' => $type]);
        }
        $titles_count = $titles->count();

        $cards1 = ApplicationPlacementLocations::find()
            ->alias('a')
            ->joinWith(['applicationEnc b' => function ($b) use ($type) {
                $b->andWhere(['b.status' => 'Active', 'b.is_deleted' => 0]);
                $b->joinWith(['applicationTypeEnc c' => function ($b) use ($type) {
                    if ($type) {
                        $b->andWhere(['c.name' => $type]);
                    }
                }]);
            }], false)
            ->joinWith(['locationEnc d'], false)
            ->select(['SUM(a.positions) total', 'COUNT(d.location_enc_id) locations'])
            ->asArray()
            ->one();

        $cards2 = ApplicationUnclaimOptions::find()
            ->alias('a')
            ->joinWith(['applicationEnc b' => function ($b) use ($type) {
                $b->andWhere(['b.status' => 'Active', 'b.is_deleted' => 0]);
                $b->joinWith(['applicationTypeEnc c' => function ($b) use ($type) {
                    if ($type) {
                        $b->andWhere(['c.name' => $type]);
                    }
                }]);
            }], false)
            ->select(['SUM(a.positions) total'])
            ->asArray()
            ->one();
        $unclaim_locations = ApplicationPlacementCities::find()->count();
        $org_claim = Organizations::find()->count();
        $org_unclaim = UnclaimedOrganizations::find()->count();

        $twitter = TwitterJobs::find()
            ->alias('a')
            ->joinWith(['applicationTypeEnc b' => function ($b) use ($type) {
                $b->andWhere(['b.name' => $type]);
            }])
            ->andWhere(['a.is_deleted' => 0])
            ->asArray()
            ->count();

        if ($type == 'Jobs') {
            $usaGov = UsaDepartments::find()
                ->select('SUM(total_applications) as total')
                ->asArray()
                ->one();
            $indianGov = IndianGovtDepartments::find()
                ->select('SUM(total_applications) as total')
                ->asArray()
                ->one();
        } else {
            $usaGov['total'] = 0;
            $indianGov['total'] = 0;
        }

        return [
            'total_applications' => $cards1['total'] + $cards2['total'] + $twitter + $usaGov['total'] + $indianGov['total'],
            'org' => $org_claim + $org_unclaim,
            'locations' => $cards1['locations'] + $unclaim_locations,
            'titles' => $titles_count,
        ];
    }

//    public function actionTest(){
//        $per = Yii::$app->notification->orgSendMail('zkDKX91qa7majL9wozJj76QVx4NmBW');
////        $per = Yii::$app->notification->orgSendMail(Yii::$app->user->identity->organization_enc_id);
//
//        print_r($per);
//        exit();
//    }
}