<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\db\Expression;
use frontend\models\JobsAlertForm;
use frontend\models\JobApplied;
use common\models\Posts;
use common\models\EmployerApplications;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationOptions;
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
use common\models\ApplicationTypes;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;
use common\models\Designations;

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
        $posts = Posts::find()
            ->where(['status' => 'Active', 'is_deleted' => 'false'])
            ->orderby(['created_on' => SORT_ASC])
            ->limit(4)
            ->asArray()
            ->all();

        $job_cards = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id as id', 'a.created_on', 'h.value as salary', 'a.slug', 'f.name as city', 'a.experience', 'a.type', 'c.name as title', 'd.name as org_name', 'd.logo', 'd.logo_location', 'd.initials_color color'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->leftJoin(OrganizationLocations::tableName() . 'as e', 'e.organization_enc_id = a.organization_enc_id')
            ->innerJoin(Cities::tableName() . 'as f', 'f.city_enc_id = e.city_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as g', 'g.application_type_enc_id = a.application_type_enc_id')
            ->innerJoin(ApplicationOptions::tableName() . 'as h', 'h.application_enc_id = a.application_enc_id')
            ->where(['g.name' => 'Jobs', 'a.is_deleted' => 0, 'h.option_name' => 'salary'])
            ->orderBy(['a.id' => SORT_DESC])
            ->groupBy('a.application_enc_id')
            ->asArray()
            ->limit(8)
            ->all();

        $job_categories = AssignedCategories::find()
            ->select(['a.category_enc_id', 'b.name', 'b.slug', 'b.icon', 'c.name as sub', 'COUNT(d.id) as total', 'e.application_type_enc_id', 'e.name as type'])
            ->alias('a')
            ->joinWith(['parentEnc b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->joinWith(['employerApplications d' => function ($b) {
                $b->joinWith(['applicationTypeEnc e']);
                $b->where(['e.name' => 'Jobs']);
            }], false)
            ->groupBy(['a.parent_enc_id'])
            ->orderBy(['total' => SORT_DESC])
            ->limit(8)
            ->asArray()
            ->all();

        return $this->render('index', [
            'posts' => $posts,
            'cards' => $job_cards,
            'job_categories' => $job_categories,
        ]);
    }

    public function actionReviewList()
    {
        if (Yii::$app->request->isAjax) {
            if (!Yii::$app->user->isGuest) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $sidebarpage = Yii::$app->getRequest()->getQueryParam('sidebarpage');
                $review_list = ReviewedApplications::find()
                    ->alias('a')
                    ->select(['a.review_enc_id', 'a.application_enc_id as application_id', 'CONCAT(a.application_enc_id, "-", f.location_enc_id) data_key', 'a.review', 'd.name as title', 'b.slug', 'e.initials_color color', 'e.name as org_name', 'CASE WHEN e.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", e.logo_location, "/", e.logo) ELSE NULL END logo'])
                    ->offset($sidebarpage)
                    ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                    ->andwhere(['a.review' => 1])
                    ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
                    ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
                    ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
                    ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
                    ->innerJoin(ApplicationPlacementLocations::tablename() . 'as f', 'f.application_enc_id = a.application_enc_id')
                    ->andwhere(['b.is_deleted' => 0])
                    ->groupBy(['b.application_enc_id'])
                    ->limit(4)
                    ->orderBy(['a.id' => SORT_DESC])
                    ->asArray()
                    ->all();
                return [
                    'cards' => $review_list,
                    'status' => 200,
                    'title' => 'Success',
                    'titl2e' => 'test',
                    'message' => 'Your Experience has been added.',
                ];
            } else {
                return [
                    'status' => 201,
                ];
            }
        }
    }

    public function actionList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $parameters = Yii::$app->request->post();
            $options = [];
            $limit = 9;

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

            if ($parameters['type'] && !empty($parameters['type'])) {
                $options['type'] = $parameters['type'];
            } else {
                $options['type'] = 'Jobs';
            }

            return $this->_getCardsFromJobs($options);
        }

        return $this->render('list');
    }


    private function _getCardsFromJobs($options = [])
    {
        $jobcards = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id application_id', 'e.location_enc_id location_id', 'm.value as salary', 'a.last_date', 'i.name category', 'l.designation', 'CONCAT("/job/", a.slug) link', 'd.initials_color color', 'CONCAT("/company/", d.slug) organization_link', 'a.experience', "g.name as city", 'a.type', 'c.name as title', 'd.name as organization_name', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo'])
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
            ->innerJoin(ApplicationOptions::tableName() . 'as m', 'm.application_enc_id = a.application_enc_id')
            ->where(['j.name' => $options['type'], 'a.status' => 'Active', 'a.is_deleted' => 0, 'm.option_name' => 'salary']);
        if (isset($options['type'])) {
            $jobcards->andWhere(['j.name' => $options['type']]);
        }
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

        if (count($cards) > 0) {
            $response = [
                'status' => 200,
                'title' => 'Success',
                'jobcards' => $cards,
            ];
        } else {
            $response = [
                'status' => 201,
            ];
        }
        return $response;
    }

    public function actionFeaturedCompanies()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $companycards = Organizations::find()
                ->select(['initials_color color', 'CONCAT("/company/", slug) link', 'name', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", logo_location, "/", logo) ELSE NULL END logo'])
                ->where(['is_sponsored' => 1])
                ->limit(10)
                ->asArray()
                ->all();
            if ($companycards) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'companycards' => $companycards
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
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

        $object = new \account\models\jobs\JobApplicationForm();
        $org_details = $application_details->getOrganizationEnc()->select(['name org_name', 'initials_color color', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();

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
        }
        $model = new JobApplied();
        return $this->render('detail', [
            'application_details' => $application_details,
            'data' => $object->getCloneData($application_details->application_enc_id),
            'org' => $org_details,
            'applied' => $applied_jobs,
            'model' => $model,
            'resume' => $resumes,
            'que' => $app_que,
        ]);
    }

    public function actionJobalert()
    {
        $JobsAlertForm = new JobsAlertForm();
        return $this->renderAjax('jobsalert', ['JobsAlertForm' => $JobsAlertForm]);
    }

    public function actionAlertsubmit()
    {
        $JobsAlertForm = new UserForm();
        if (Yii::$app->request->isAjax) {
            $JobsAlertForm->load(Yii::$app->request->post());
            return ActiveForm::validate($JobsAlertForm);
        }
    }

    public function actionPrimaryCat()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $primaryfields = Categories::find()
            ->alias('a')
            ->select(['a.name', 'b.assigned_category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['b.assigned_to' => 'Jobs'])
            ->asArray()
            ->all();
        return $primaryfields;
    }

    public function actionJobPreview()
    {
        if ($_GET['data']) {
            $var = $_GET['data'];
            $session = Yii::$app->session;
            $object = $session->get($var);
            if (empty($object)) {
                return 'Opps Session expired..!';
            }
            $int_loc = '';
            if (!empty($object->interviewcity)) {
                foreach ($object->interviewcity as $id) {
                    $int_arr = OrganizationLocations::find()
                        ->alias('a')
                        ->select(['b.name AS city_name'])
                        ->where(['a.location_enc_id' => $id])
                        ->leftJoin(Cities::tableName() . ' as b', 'b.city_enc_id = a.city_enc_id')
                        ->asArray()
                        ->one();

                    $int_loc .= $int_arr['city_name'] . ',';
                }
            }
            $indstry = Industries::find()
                ->where(['industry_enc_id' => $object->pref_inds])
                ->select(['industry'])
                ->asArray()
                ->one();

            $primary_cat = Categories::find()
                ->select(['name'])
                ->where(['category_enc_id' => $object->primaryfield])
                ->asArray()
                ->one();
            if ($object->benefit_selection == 1) {
                foreach ($object->emp_benefit as $benefit) {
                    $benefits[] = EmployeeBenefits::find()
                        ->select(['benefit'])
                        ->where(['benefit_enc_id' => $benefit])
                        ->asArray()
                        ->one();
                }
            } else {
                $benefits = null;
            }

            return $this->render('job-preview', [
                'object' => $object,
                'interview' => $int_loc,
                'indst' => $indstry,
                'primary_cat' => $primary_cat,
                'benefits' => $benefits
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
                $model->created_on = date('Y-m-d h:i:s');
                $model->created_by = Yii::$app->user->identity->user_enc_id;
                if ($model->validate() && $model->save()) {
                    $response = [
                        'status' => 200,
                        'message' => 'Job successfully added to review list.',
                    ];
                    return $response;
                } else {
                    $response = [
                        'status' => 201,
                        'message' => 'An error has occurred. Please try again.',
                    ];
                }
                return $response;
            } else if ($status == 1) {
                $update = Yii::$app->db->createCommand()
                    ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $id])
                    ->execute();

                if ($update) {
                    return 'unshort';
                }
            } else if ($status == 0) {
                $update = Yii::$app->db->createCommand()
                    ->update(ReviewedApplications::tableName(), ['review' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $id])
                    ->execute();

                if ($update) {
                    return 'short';
                }
            }
        }
    }
}
