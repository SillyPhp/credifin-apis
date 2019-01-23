<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\UploadedFile;
use common\models\Organizations;
use common\models\OrganizationLocations;
use common\models\Cities;
use common\models\EmployerApplications;
use common\models\ApplicationPlacementLocations;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\ApplicationTypes;
use common\models\Designations;
use common\models\Posts;
use common\models\ApplicationOptions;
use common\models\Industries;
use common\models\EmployeeBenefits;
use common\models\AppliedApplications;
use common\models\UserResume;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;
use frontend\models\JobApplied;

class InternshipsController extends Controller
{

    public function actionIndex()
    {
        $posts = Posts::find()
            ->where(['status' => 'Active', 'is_deleted' => 'false'])
            ->orderby(['created_on' => SORT_ASC])
            ->limit(4)
            ->asArray()
            ->all();
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $type = Yii::$app->request->post('type');
            if ($type === 'Categories') {
                $categories = AssignedCategories::find()
                    ->select(['a.category_enc_id', 'b.name', 'b.slug', 'b.icon', 'c.name as sub', 'COUNT(d.id) as total', 'e.application_type_enc_id', 'e.name as type'])
                    ->alias('a')
                    ->joinWith(['parentEnc b'], false)
                    ->joinWith(['categoryEnc c'], false)
                    ->joinWith(['employerApplications d' => function ($b) {
                        $b->joinWith(['applicationTypeEnc e']);
                        $b->where(['e.name' => 'Internships']);
                    }], false)
                    ->groupBy(['a.parent_enc_id'])
                    ->orderBy(['total' => SORT_DESC])
                    ->limit(8)
                    ->asArray()
                    ->all();
            } elseif ($type === 'Categories') {
                $companycards = Organizations::find()
                    ->alias('a')
                    ->select(['a.is_sponsored', 'a.name', 'a.slug organization_link', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo'])
                    ->where(['a.is_sponsored' => 1])
                    ->limit(10)
                    ->asArray()
                    ->all();
            }
            $options = [];
            $limit = 3;
            $page = 1;
            $options['limit'] = $limit;
            $options['offset'] = ($page - 1) * $limit;
            $options['type'] = 'Internships';
            $cards = $this->_getCardsFromInternships($options);

            if ($cards) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'cards' => $cards['cards'],
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        } else {
            return $this->render('index', [
                'posts' => $posts,
            ]);
        }
    }

    public function actionInternshipPreview()
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

            return $this->render('internship-preview', [
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
                $options['type'] = 'Internships';
            }

            return $this->_getCardsFromInternships($options);
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
        if (empty($application_details)) {
            return 'Application Not found';
        }
        $object = new \account\models\jobs\JobApplicationForm;
        $org_details = $application_details->getOrganizationEnc()->select(['name org_name', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();

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

        if (!empty($application_details)) {
            $model = new JobApplied();
            return $this->render('internship-details', [
                'application_details' => $application_details,
                'data' => $object->getCloneData($application_details->application_enc_id),
                'org' => $org_details,
                'applied' => $applied_jobs,
                'model' => $model,
                'resume' => $resumes,
                'que' => $app_que,
            ]);
        } else {
            return 'Not Found';
        }
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

    private function _getCardsFromInternships($options = [])
    {
        $jobcards = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id application_id', 'f.location_enc_id location_id', 'a.created_on', 'i.name category', 'CONCAT("/internship/", a.slug) link', 'd.initials_color color', 'CONCAT("/company/", d.slug) organization_link', 'a.experience', "g.name as city", 'a.type', 'c.name as title', 'd.name as organization_name', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'i.category_enc_id = b.parent_enc_id')
            ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
            ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
            ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => $options['type'], 'a.status' => 'Active', 'a.is_deleted' => 0]);
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
                ['like', 'a.type', $options['keyword']],
                ['like', 'c.name', $options['keyword']],
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
                'cards' => $cards,
            ];
        } else {
            $response = [
                'status' => 201,
            ];
        }
        return $response;
    }
}
