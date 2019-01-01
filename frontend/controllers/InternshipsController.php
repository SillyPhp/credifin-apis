<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\UploadedFile;
use common\models\Organizations;
use frontend\models\CompanyLogoForm;
use frontend\models\CompanyCoverImageForm;
use frontend\models\AddEmployeeBenefitForm;
use common\models\OrganizationVideos;
use common\models\OrganizationLocations;
use common\models\States;
use common\models\Cities;
use common\models\Countries;
use common\models\EmployerApplications;
use common\models\ApplicationPlacementLocations;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\ApplicationTypes;
use common\models\Designations;
use common\models\Posts;
use common\models\ApplicationOptions;
use common\models\Industries;
use common\models\ShortlistedOrganizations;

class InternshipsController extends Controller {
    
    public function actionIndex() {
        $posts = Posts::find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $job_cards = EmployerApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id as id', 'g.name as application_type', 'a.last_date', 'a.created_on', 'a.slug as link', 'h.value as salary', 'f.name as city', 'a.experience', 'a.type', 'c.name as title', 'd.name as org_name', 'd.logo', 'd.logo_location'])
                    ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                    ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                    ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                    ->leftJoin(OrganizationLocations::tableName() . 'as e', 'e.organization_enc_id = a.organization_enc_id')
                    ->innerJoin(Cities::tableName() . 'as f', 'f.city_enc_id = e.city_enc_id')
                    ->innerJoin(ApplicationTypes::tableName() . 'as g', 'g.application_type_enc_id = a.application_type_enc_id')
                    ->innerJoin(ApplicationOptions::tableName() . 'as h', 'h.application_enc_id = a.application_enc_id')
                    ->where(['h.option_name' => 'salary'])
                    ->andWhere(['g.name' => 'Internships'])
                    ->orderBy(['a.id' => SORT_DESC])
                    ->groupBy('a.application_enc_id')
                    ->asArray()
                    ->limit(8)
                    ->all();

            $job_categories = Categories::find()
                    ->alias('a')
                    ->select(['a.name', 'a.slug', 'a.icon'])
                    ->innerJoin(AssignedCategories::tableName() . 'as b', 'a.category_enc_id = b.category_enc_id')
                    ->where(['b.parent_enc_id' => null])
                    ->orderBy(new Expression('rand()'))
                    ->asArray()
                    ->limit(8)
                    ->all();
            $companycards = Organizations::find()
                    ->alias('a')
                    ->select(['a.is_sponsored', 'a.name', 'a.slug organization_link', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo'])
                    ->where(['a.is_sponsored' => 1])
                    ->limit(10)
                    ->asArray()
                    ->all();

            if ($job_cards) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'job_cards' => $job_cards,
                    'job_categories' => $job_categories,
                    'companycards' => $companycards
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

    public function actionList() {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $parameters = Yii::$app->request->post();
            $options = [];
            $limit = 9;

            if($parameters['page'] && (int) $parameters['page'] >= 1) {
                $page = $parameters['page'];
            } else {
                $page = 1;
            }

            $options['limit'] = $limit;

            $options['offset'] = ($page - 1) * $limit;

            if($parameters['location'] && !empty($parameters['location'])) {
                $options['location'] = $parameters['location'];
            }

            if($parameters['keyword'] && !empty($parameters['keyword'])) {
                $options['keyword'] = $parameters['keyword'];
            }

            if($parameters['company'] && !empty($parameters['company'])) {
                $options['company'] = $parameters['company'];
            }

            if($parameters['type'] && !empty($parameters['type'])) {
                $options['type'] = $parameters['type'];
            } else {
                $options['type'] = 'Internships';
            }

            return $this->_getCardsFromJobs($options);
        }

        return $this->render('list');
    }

    public function actionDetail() {
        return $this->render('internship-details');
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
    private function _getCardsFromJobs($options = []) {
        $jobcards = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id application_id', 'f.location_enc_id location_id', 'a.created_on', 'i.name category', 'l.designation', 'a.slug link', 'd.initials_color color' , 'd.slug organization_link', 'a.experience', "g.name as city", 'a.type', 'c.name as title', 'd.name as organization_name', 'd.logo', 'd.logo_location'])
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
            ->where(['j.name' => $options['type'], 'a.is_deleted' => 0]);
        if(isset($options['company'])) {
            $jobcards->andWhere([
                'or',
                ($options['company']) ? ['like', 'd.name', $options['company']] : ''
            ]);
        }
        if (isset($options['location'])){
            $jobcards->andWhere([
                'or',
                ['g.name' => $options['location']]
            ]);
        }
        if(isset($options['keyword'])) {
            $jobcards->andWhere([
                'or',
                ['like', 'l.designation', $options['keyword']],
                ['like', 'a.type', $options['keyword']],
                ['like', 'c.name', $options['keyword']],
                ['like', 'h.industry', $options['keyword']],
                ['like', 'i.name', $options['keyword']],
            ]);
        }

        if(isset($options['limit'])) {
            $jobcards->limit = $options['limit'];
        }

        if(isset($options['offset'])) {
            $jobcards->offset = $options['offset'];
        }
//        $jobcards->andWhere([
//                'or',
//                ['g.name' => $locationParams],
//                ($companyParams) ? ['like', 'd.name', $companyParams] : '',
//                ($keyParams) ? ['like', 'l.designation', $keyParams] : '',
//                ($keyParams) ? ['like', 'a.type', $keyParams] : '',
//                ($keyParams) ? ['like', 'c.name', $keyParams] : '',
//                ($keyParams) ? ['like', 'h.industry', $keyParams] : '',
//                ($keyParams) ? ['like', 'i.name', $keyParams] : '',
//            ]);
        $cards = $jobcards->orderBy(['a.id' => SORT_DESC])->asArray()->all();

        if (count($cards) > 0) {
            $response = [
                'status' => 200,
                'title' => 'Success',
                'jobcards' => $cards,
//                'companycards' => $companycards,
            ];
        } else {
            $response = [
                'status' => 201,
            ];
        }
        return $response;
    }
}
