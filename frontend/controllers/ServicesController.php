<?php

namespace frontend\controllers;

use Yii;
use yii\db\Command;
use yii\web\Controller;
use yii\db\Expression;
use yii\web\Response;
use common\models\Posts;
use common\models\EmployerApplications;
use common\models\Organizations;
use common\models\Categories;
use common\models\AssignedCategories;
use common\models\SubmittedVideos;
use common\models\OrganizationLocations;
use common\models\ApplicationPlacementLocations;
use common\models\Industries;
use common\models\ApplicationTypes;
use common\models\States;
use common\models\Cities;
use common\models\Countries;
use yii\sphinx\Query;
use yii\sphinx\MatchExpression;

class ServicesController extends Controller {

    public function actionInternships() {
        $posts = Posts::find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        return $this->render('internships', [
                    'posts' => $posts,
        ]);
    }

    public function actionTrainingPrograms() {
        $posts = Posts::find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        return $this->render('training-programs', [
                    'posts' => $posts,
        ]);
    }

    public function actionNotes() {
        $posts = Posts::find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        return $this->render('notes', [
                    'posts' => $posts,
        ]);
    }

    public function actionFreelancers() {
        $posts = Posts::find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        return $this->render('freelancers', [
                    'posts' => $posts,
        ]);
    }

    public function actionQuestionPapers() {
        return $this->render('question-papers');
    }

    public function actionEducationLoans() {
        $posts = Posts::find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        return $this->render('education-loans', [
                    'posts' => $posts,
        ]);
    }

    public function actionJobs() {
        $posts = Posts::find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();

        $job_cards = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id as id', 'a.created_on', 'h.value as salary', 'a.slug', 'f.name as city', 'a.experience', 'a.type', 'c.name as title', 'd.name as org_name', 'd.logo', 'd.logo_location'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                ->leftJoin(OrganizationLocations::tableName() . 'as e', 'e.organization_enc_id = a.organization_enc_id')
                ->innerJoin(Cities::tableName() . 'as f', 'f.city_enc_id = e.city_enc_id')
                ->innerJoin(ApplicationTypes::tableName() . 'as g', 'g.application_type_enc_id = a.application_type_enc_id')
                ->innerJoin(ApplicationOptions::tableName() . 'as h', 'h.application_enc_id = a.application_enc_id')
                ->where(['g.name' => 'Jobs'])
                ->andWhere(['h.option_name' => 'salary'])
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

        return $this->render('jobs', [
                    'posts' => $posts,
                    'job_cards' => $job_cards,
                    'job_categories' => $job_categories,
        ]);
    }

    public function actionSearchedResults() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $locationParams = Yii::$app->request->get('location');
            $companyParams = Yii::$app->request->get('company');
            $keyParams = Yii::$app->request->get('keyword');
            $typeParams = Yii::$app->request->get('type');
            
            $companycards = Organizations::find()
                    ->alias('a')
                    ->select(['a.is_sponsored', 'a.name', 'a.slug organization_link', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo'])
                    ->where(['a.is_sponsored' => 1])
                    ->limit(10)
                    ->asArray()
                    ->all();

            if ($typeParams == 'industry' || $typeParams == 'location' || $typeParams == 'role') {
                $industryParams = Yii::$app->request->get('industry');
                $locParams = Yii::$app->request->get('location');
                $roleParams = Yii::$app->request->get('role');
                $jobcards = EmployerApplications::find()
                        ->alias('a')
                        ->select(['a.application_enc_id', 'a.created_on', 'h.industry', 'a.slug', 'a.experience', "GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') as city", 'a.type', 'c.name as title', 'd.name as organization_name', 'd.logo', 'd.logo_location'])
                        ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                        ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                        ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                        ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
                        ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
                        ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                        ->innerJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
                        ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
                        ->innerJoin(Designations::tableName() . 'as l', 'l.designation_enc_id = a.designation_enc_id')
                        ->where(['j.name' => 'Jobs']);
                $arr = [];

                if ($typeParams == 'industry') {
                    if($industryParams != null){
                        foreach ($industryParams as $indust) {
                            $jobcards->where(['h.industry' => $indust])
                                    ->orderBy(['a.id' => SORT_DESC])
                                    ->groupBy('a.application_enc_id')
                                    ->limit(1, 3)
                                    ->asArray();
                            $arr[] = $jobcards->all();
                        }
                    }
                    $options = EmployerApplications::find()
                            ->alias('a')
                            ->select(['a.application_enc_id', 'a.preferred_industry', 'b.industry as option'])
                            ->innerJoin(Industries::tableName() . 'as b', 'b.industry_enc_id = a.preferred_industry')
                            ->orderBy(['a.id' => SORT_DESC])
                            ->groupBy('b.industry')
                            ->asArray()
                            ->limit(50)
                            ->all();
                } else if ($typeParams == 'location') {
                    if($locParams != null){
                        foreach ($locParams as $loc) {
                            $jobcards->where(['g.name' => $loc])
                                    ->orderBy(['a.id' => SORT_DESC])
                                    ->groupBy('a.application_enc_id')
                                    ->limit(1, 3)
                                    ->asArray();
                            $arr[] = $jobcards->all();
                        }
                    }
                    $options = EmployerApplications::find()
                            ->alias('a')
                            ->select(['a.application_enc_id', "g.name as option"])
                            ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
                            ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
                            ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                            ->orderBy(['a.id' => SORT_DESC])
                            ->groupBy('g.name')
                            ->asArray()
                            ->limit(50)
                            ->all();
                } else if ($typeParams == 'role') {
                    if($roleParams != null){
                        foreach ($roleParams as $rol) {
                        $jobcards->where(['l.designation' => $rol])
                                ->orderBy(['a.id' => SORT_DESC])
                                ->groupBy('a.application_enc_id')
                                ->limit(1, 3)
                                ->asArray();
                        $arr[] = $jobcards->all();
                        }
                    }
                    
                    $options = EmployerApplications::find()
                            ->alias('a')
                            ->select(['a.application_enc_id', 'l.designation as option'])
                            ->innerJoin(Designations::tableName() . 'as l', 'l.designation_enc_id = a.designation_enc_id')
                            ->orderBy(['a.id' => SORT_DESC])
                            ->groupBy('l.designation')
                            ->asArray()
                            ->limit(50)
                            ->all();
                }

                if ($options) {
                    $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'options' => $options,
                        'cards' => $arr,
                        'companycards' => $companycards,
                    ];
                } else {
                    $response = [
                        'status' => 202,
                    ];
                }
                return $response;
            } else {
                $jobcards = EmployerApplications::find()
                        ->alias('a')
                        ->select(['a.application_enc_id', 'a.created_on', 'i.name as category', 'l.designation', 'a.slug', 'a.experience', "g.name as city", 'a.type', 'c.name as title', 'd.name as organization_name', 'd.logo', 'd.logo_location'])
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
                        ->where(['j.name' => 'Jobs'])
                        ->andWhere([
                            'or',
                            ['g.name' => $locationParams],
                            ($companyParams) ? ['like', 'd.name', $companyParams] : '',
                            ($keyParams) ? ['like', 'l.designation', $keyParams] : '',
                            ($keyParams) ? ['like', 'a.type', $keyParams] : '',
                            ($keyParams) ? ['like', 'c.name', $keyParams] : '',
                            ($keyParams) ? ['like', 'h.industry', $keyParams] : '',
                            ($keyParams) ? ['like', 'i.name', $keyParams] : '',
                        ])
                        ->orderBy(['a.id' => SORT_DESC])
                        ->asArray()
                        ->limit(50)
                        ->all();

                if ($jobcards) {
                    $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'cards' => $jobcards,
                        'companycards' => $companycards,
                    ];
                } else {
                    $response = [
                        'status' => 201,
                    ];
                }
                return $response;
            }
        } else {
            return $this->render('jobs-by-industry');
        }
    }

    public function actionSearchedResults1() {
//        $locationParams = Yii::$app->request->get('location');
//        $companyParams = Yii::$app->request->get('company');
//        $keyParams = Yii::$app->request->get('keyword');
        $typeParams = Yii::$app->request->get('type');
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;


            $pageParams = Yii::$app->request->post('page');

            $jobcards = EmployerApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id', 'a.created_on', 'h.industry', 'a.slug', 'a.experience', "GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') as city", 'a.type', 'c.name as title', 'd.name as org_name', 'd.logo', 'd.logo_location'])
                    ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                    ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                    ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                    ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
                    ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
                    ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                    ->innerJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
                    ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
                    ->where(['j.name' => 'Jobs']);

            if ($typeParams == 'industry') {
                $jobcards->andWhere(['h.industry' => $typeParams]);
            } else if ($typeParams == 'location') {
                $jobcards->andWhere(['g.name' => $typeParams]);
            } else if ($typeParams == 'role') {
                $jobcards->andWhere(['a.designation' => $typeParams]);
            }

            $jobcards->orderBy(['a.id' => SORT_DESC])
                    ->groupBy('a.application_enc_id')
                    ->asArray()
                    ->limit(50);
            return $this->render('searched-results', [
                        'cards' => $jobcards,
            ]);
        } else if ($typeParams == 'industry') {

            $industry = EmployerApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id', 'a.preferred_industry', 'b.industry'])
                    ->innerJoin(Industries::tableName() . 'as b', 'b.industry_enc_id = a.preferred_industry')
                    ->orderBy(['a.id' => SORT_DESC])
                    ->groupBy('b.industry')
                    ->asArray()
                    ->limit(50)
                    ->all();

            return $this->render('jobs-by-industry', [
                        'industry' => $industry,
            ]);
        } else if ($typeParams == 'location') {

            $locations = EmployerApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id', "g.name as city"])
                    ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
                    ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
                    ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                    ->orderBy(['a.id' => SORT_DESC])
                    ->groupBy('g.name')
                    ->asArray()
                    ->limit(50)
                    ->all();

            return $this->render('jobs-by-location', [
                        'locations' => $locations,
            ]);
        } else if ($typeParams == 'role') {

            $designations = EmployerApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id', 'a.designation'])
                    ->orderBy(['a.id' => SORT_DESC])
                    ->groupBy('a.designation')
                    ->asArray()
                    ->limit(50)
                    ->all();
            return $this->render('jobs-by-roles', [
                        'designations' => $designations,
            ]);
        }
    }

    public function actionSearchedThroughAjax() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $typeParams = Yii::$app->request->get('type');
        $industryParams = Yii::$app->request->get('industry');
        $locParams = Yii::$app->request->get('location');
        $roleParams = Yii::$app->request->get('role');
//        $roleParams = Yii::$app->request->post('role');

        $jobcards = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.created_on', 'h.industry', 'a.slug', 'a.experience', "GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') as city", 'a.type', 'c.name as title', 'd.name as org_name', 'd.logo', 'd.logo_location'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
                ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
                ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                ->innerJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
                ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
                ->where(['j.name' => 'Jobs']);

        if ($typeParams == 'industry') {
            $jobcards->andWhere(['h.industry' => $industryParams]);
        } else if ($typeParams == 'location') {
            $jobcards->andWhere(['g.name' => $locParams]);
        } else if ($typeParams == 'role') {
            $jobcards->andWhere(['a.designation' => $roleParams]);
        }

        $jobcards->orderBy(['a.id' => SORT_DESC])
                ->groupBy('a.application_enc_id')
                ->asArray()
                ->limit(1,3);
        
//        if (Yii::$app->request->isAjax) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//        }

        return $response = [
            'cards' => $jobcards->all(),
            'status' => 200,
            'title' => 'Success',
            'message' => 'Your Experience has been added.',
        ];
    }

    public function actionSearchedResultsInternship() {
        $locationParams = Yii::$app->request->get('location');
        $companyParams = Yii::$app->request->get('company');
        $keyParams = Yii::$app->request->get('keyword');
//        $keyParams = Yii::$app->request->get('type');

        $jobcards = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.created_on', 'i.name as category', 'a.designation', 'a.slug', 'a.experience', "g.name as city", 'a.type', 'c.name as title', 'd.name as org_name', 'd.logo', 'd.logo_location'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(Categories::tableName() . 'as i', 'i.category_enc_id = b.parent_enc_id')
                ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
                ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
                ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                ->innerJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
                ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
                ->andWhere(['j.name' => 'Internships'])
                ->andWhere([
                    'or',
                    ['g.name' => $locationParams],
                    ($companyParams) ? ['like', 'd.name', $companyParams] : '',
                    ($keyParams) ? ['like', 'a.designation', $keyParams] : '',
                    ($keyParams) ? ['like', 'a.type', $keyParams] : '',
                    ($keyParams) ? ['like', 'c.name', $keyParams] : '',
                    ($keyParams) ? ['like', 'h.industry', $keyParams] : '',
                    ($keyParams) ? ['like', 'i.name', $keyParams] : '',
                ])
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->limit(50)
                ->all();

        return $this->render('searched-results-internship', [
                    'cards' => $jobcards,
        ]);
    }

    public function actionMockInterviews() {
        return $this->render('mock-interviews');
    }

    public function actionResume() {
        return $this->render('resume');
    }

    public function actionResumeTestPoll() {
        return $this->render('resume_1');
    }

    public function actionEmployerPage() {
        return $this->render('employer-page');
    }

    public function actionInternshipPage() {
        return $this->render('internship-page');
    }

    public function actionStartupSupport() {
        $posts = Posts::find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        return $this->render('startup-support', [
                    'posts' => $posts,
        ]);
    }

    public function actionLearningCorner() {
        $submittedVideos = SubmittedVideos::find()
                ->select(['id', 'name', 'cover_image', 'slug'])
                ->limit(6)
                ->all();
        $job_categories = SubmittedVideos::find()
                ->distinct()
                ->select(['category'])
                ->limit(8)
                ->asArray()
                ->all();
        return $this->render('learning-corner', [
                    'submittedVideos' => $submittedVideos,
                    'job_categories' => $job_categories,
        ]);
    }

    public function actionScholarships() {
        return $this->render('scholarships');
    }

}
