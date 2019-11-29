<?php

namespace frontend\controllers;

use common\models\ApplicationPlacementCities;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\CareerAdvisePosts;
use common\models\Cities;
use common\models\EmployerApplications;
use common\models\OrganizationLocations;
use common\models\Quiz;
use common\models\States;
use frontend\models\SubscribeNewsletterForm;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;
use frontend\models\applications\ApplicationCards;
use common\models\AppliedApplications;
use frontend\models\ContactForm;
use frontend\models\CareerForm;
use frontend\models\FreelancersForm;
use frontend\models\FreeForm;
use common\models\Posts;
use common\models\Organizations;
use common\models\Utilities;
use common\models\Categories;
use common\models\AssignedCategories;
use frontend\models\SkillsAndLanguagesForm;
use frontend\models\PortfolioForm;
use frontend\models\PersonalProfileForm;
use frontend\models\FeedbackForm;
use frontend\models\PartnerWithUsForm;
use common\models\OrganizationQuestionnaire;
use common\models\QuestionnaireFields;
use common\models\QuestionnaireFieldOptions;
use common\models\AnsweredQuestionnaire;
use common\models\AnsweredQuestionnaireFields;
use common\models\Users;
use yii\web\UploadedFile;
use frontend\models\account\locations\OrganizationLocationForm;
use frontend\models\questionnaire\QuestionnaireForm;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        $route = ltrim(Yii::$app->request->url, '/');
        if ($route === "") {
            $route = "/";
        }
        Yii::$app->seo->setSeoByRoute($route, $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
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
            ->select(['d.name', 'COUNT(c.city_enc_id) as total', 'c.city_enc_id', 'CONCAT("/", LOWER(e.name), "/list?location=", d.name) as link'])
            ->innerJoinWith(['applicationPlacementLocations b' => function ($x) {
                $x->joinWith(['locationEnc c' => function ($x) {
                    $x->joinWith(['cityEnc d']);
                }], false);
            }], false)
            ->joinWith(['applicationTypeEnc e'], false)
            ->where([
                'a.is_deleted' => 0
            ])
            ->orderBy(['total' => SORT_DESC])
            ->groupBy(['c.city_enc_id'])
            ->asArray()
            ->all();

        $featured_jobs = ApplicationCards::jobs([
            "page" => 1,
            "limit" => 6
        ]);

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
            ->select(['city_name', 'SUM(job_count) as jobs', 'SUM(internship_count) as internships'])
            ->groupBy('city_enc_id')
            ->orderBy(['jobs' => SORT_DESC])
            ->limit(4)
            ->all();

        $a = $this->_getTweets(null, null, "Jobs", 4, "");
        $b = $this->_getTweets(null, null, "Internships", 4, "");
        $tweets = array_merge($a, $b);

        return $this->render('index', [
            'job_profiles' => $job_profiles,
            'internship_profiles' => $internship_profiles,
            'search_words' => $search_words,
            'cities' => $cities,
            'tweets' => $tweets,
            'cities_jobs' => $cities_jobs,
            'featured_jobs' => $featured_jobs
        ]);
    }

    private function _getTweets($keywords = null, $location = null, $type = null, $limit = null, $offset = null)
    {
        $tweets1 = (new \yii\db\Query())
            ->distinct()
            ->select(['a.tweet_enc_id', 'a.job_type', 'a.created_on', 'j.name application_type', 'c.name org_name', 'a.html_code', 'f.name profile', 'e.name job_title', 'c.initials_color color', 'CASE WHEN c.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",c.logo_location, "/", c.logo) END logo'])
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
            ->select(['a.tweet_enc_id', 'a.job_type', 'a.created_on', 'j.name application_type', 'c.name org_name', 'a.html_code', 'f.name profile', 'e.name job_title', 'c.initials_color color', 'CASE WHEN c.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '",c.logo_location, "/", c.logo) END logo'])
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

    public function actionSendFeedback()
    {
        if (Yii::$app->request->isAjax) {
            $feedbackFormModel = new FeedbackForm();
            if (Yii::$app->request->isPost) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $feedbackFormModel->load(Yii::$app->request->post());
                if ($feedbackFormModel->save()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Feedback has been sent.',
                    ];
                } else {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'An error has occurred. Please try again.',
                    ];
                }
            }else{
                return $this->renderAjax("/widgets/feedback-form",[
                    "feedbackFormModel" => $feedbackFormModel,
                ]);
            }
        }
    }
    public function actionPartnerWithUs()
    {
        if (Yii::$app->request->isAjax) {
            $partnerWithUsModel = new PartnerWithUsForm();
            if (Yii::$app->request->isPost) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $partnerWithUsModel->load(Yii::$app->request->post());
                if ($partnerWithUsModel->save()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Request has been sent.',
                    ];
                } else {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'An error has occurred. Please try again.',
                    ];
                }
            } else {
                return $this->renderAjax("/widgets/partner-with-us", [
                    "partnerWithUsModel" => $partnerWithUsModel,
                ]);
            }
        }
    }

    public function actionAboutUs()
    {
        return $this->render('about-us');
    }

    public function actionContactUs()
    {
        $contactFormModel = new ContactForm();
        if ($contactFormModel->load(Yii::$app->request->post()) && $contactFormModel->validate()) {
            if ($contactFormModel->contact(Yii::$app->params->contact_email)) {
                Yii::$app->getSession()->setFlash('success', 'Your response has been recorded with us');
                $contactFormModel = new ContactForm();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Something went wrong');
            }
        }
        return $this->render('contact-us', [
            'contactFormModel' => $contactFormModel,
        ]);
    }

    public function actionTweetDetail()
    {
        return $this->render('tweet-detail');
    }

    public function actionAllQuiz()
    {
        $quizes = Quiz::find()
            ->alias('a')
            ->select(['a.sharing_image', 'a.sharing_image_location', 'a.name', 'a.quiz_enc_id', 'CONCAT("' . Url::to("/", true) . '", "quiz", "/", a.slug) slug', 'COUNT(b.quiz_question_enc_id) cnt'])
            ->joinWith(['quizQuestions b' => function ($x) {
                $x->onCondition([
                    'b.is_deleted' => 0
                ]);
                $x->groupBy(['b.quiz_enc_id']);
            }], false)
            ->where([
                'a.display' => 1,
                'a.is_deleted' => 0
            ])
            ->asArray()
            ->all();
        return $this->render('all-quizzes', [
            'data' => $quizes
        ]);
    }

    public function actionAddNewSubscriber()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $subscribersForm = new SubscribeNewsletterForm();
            if ($subscribersForm->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($subscribersForm->save()) {
                    $response = [
                        'status' => 200,
                        'message' => Yii::t('frontend', 'You are successfully subscribed.'),
                    ];
                } else {
                    $response = [
                        'status' => 201,
                        'message' => Yii::t('frontend', 'An error has occurred. Please try again.'),
                    ];
                }
                return $response;
            }
        }
    }

    public function actionSalarySubmitter()
    {
        $this->layout = 'main-secondary';
        $careerFormModel = new CareerForm();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $careerFormModel->load(Yii::$app->request->post());
            return ActiveForm::validate($careerFormModel);
        } elseif ($careerFormModel->load(Yii::$app->request->post())) {
            if ($careerFormModel->save()) {
                $careerFormModel = new CareerForm();
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'An error has occurred. Please try again later.');
            }
        }
        return $this->render('careers', [
            'careerFormModel' => $careerFormModel,
        ]);
    }

    public function actionExploreCompany()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $companycards = Organizations::find()
                ->alias('a')
                ->select(['a.is_sponsored', 'a.tag_line', 'a.name org_name', 'a.description', 'a.slug organization_link', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo', 'CASE WHEN a.cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image) . '", a.cover_image_location, "/", a.cover_image) ELSE NULL END cover_image'])
                ->where(['a.is_sponsored' => 0])
                ->limit(8)
                ->asArray()
                ->all();

            $featured_companycards = Organizations::find()
                ->alias('a')
                ->select(['a.is_sponsored', 'a.tag_line', 'a.name org_name', 'a.description', 'a.slug organization_link', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo', 'CASE WHEN a.cover_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->cover_image) . '", a.cover_image_location, "/", a.cover_image) ELSE NULL END cover_image'])
                ->where(['a.is_sponsored' => 1])
                ->limit(4)
                ->asArray()
                ->all();
            if ($companycards) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'featured_companycards' => $featured_companycards,
                    'companycards' => $companycards
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        } else {

            return $this->render('explore-companies');
        }
    }

    public function actionCareerCoach()
    {
        $posts = Posts::find()
            ->where(['status' => 'Active', 'is_deleted' => 'false'])
            ->orderby(['created_on' => SORT_ASC])
            ->limit(4)
            ->asArray()
            ->all();
        return $this->render('career-coach', [
            'posts' => $posts,
        ]);
    }

    public function actionFreelancers()
    {
        $this->layout = 'main-secondary';
        $freelancersFormModel = new FreelancersForm();

        if ($freelancersFormModel->load(Yii::$app->request->post())) {
            if ($freelancersFormModel->save()) {
                $freelancersFormModel = new FreelancersForm();
                Yii::$app->session->setFlash('success', 'Your application is submitting successfully. We will get back to you soon.');
            } else {
                Yii::$app->session->setFlash('error', 'An error has occurred. Please try again later.');
            }
        }
        return $this->render('freelancers', [
            'freelancersFormModel' => $freelancersFormModel,
        ]);
    }

    public function actionFreeForm()
    {
        $this->layout = 'main-secondary';
        $freeFormModel = new FreeForm();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $freeFormModel->load(Yii::$app->request->post());
            return ActiveForm::validate($freeFormModel);
        }
        $primaryfields = Categories::find()
            ->alias('a')
            ->select(['a.name', 'a.category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['b.assigned_to' => 'Jobs', 'b.parent_enc_id' => NULL])
            ->asArray()
            ->all();
        return $this->render('form', [
            'freeFormModel' => $freeFormModel,
            'primaryfields' => $primaryfields,
        ]);
    }

    public function actionValidateForm()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $freeFormModel = new FreeForm();
        if ($freeFormModel->load(Yii::$app->request->post())) {
            if ($freeFormModel->save()) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Sign up has been successfull.',
                    'data' => [
                        'username' => $freeFormModel->username,
                        'phone' => $freeFormModel->phone,
                        'email' => $freeFormModel->email,
                    ],
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        }
    }

    public function actionTermsConditions()
    {
        return $this->render('terms-conditions');
    }

    public function actionPrivacyPolicy()
    {
        return $this->render('privacy-policy');
    }

    public function actionUpdateProfile()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->post()) {
            $userData = Yii::$app->request->post();
            $usersModel = new Users();
            $user = $usersModel->findOne([
                'user_enc_id' => Yii::$app->user->identity->user_enc_id,
                'status' => 'Active',
                'is_deleted' => 0,
            ]);
            $field = $userData['name'];
            $user->$field = $userData['value'];
            if ($usersModel->validate()) {
                if ($usersModel->save()) {
                    $response = [
                        'status' => 200,
                        'message' => Yii::t('frontend', 'You are successfully subscribed.'),
                    ];
                } else {
                    $response = [
                        'status' => 201,
                        'message' => Yii::t('frontend', 'An error has occurred. Please try again.'),
                    ];
                }
            } else {
                $response = [
                    'status' => 0,
                    'message' => Yii::t('frontend', 'Please enter all the information correctly'),
                ];
            }
            return $response;
        }
    }

    public function actionWorkingProfiles()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            // $jobCategories = \frontend\models\profiles\ProfileCards::getProfiles();
            $jobCategories = AssignedCategories::find()
                ->select(['b.name', 'b.slug', 'CASE WHEN b.icon IS NULL OR b.icon = "" THEN "" ELSE CONCAT("' . Url::to("@commonAssets/categories/svg/") . '", "/", b.icon) END icon'])
                ->alias('a')
                ->joinWith(['parentEnc b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->where(['a.assigned_to' => 'Jobs'])
                ->andWhere(['!=', 'a.parent_enc_id', ''])
                ->groupBy(['a.parent_enc_id'])
                ->orderBy(['b.name' => SORT_ASC])
                ->asArray()
                ->all();
            $internshipCategories = AssignedCategories::find()
                ->select(['b.name', 'CASE WHEN b.icon IS NULL OR b.icon = "" THEN "" ELSE CONCAT("' . Url::to("@commonAssets/categories/svg/") . '", "/", b.icon) END icon'])
                ->alias('a')
                ->joinWith(['parentEnc b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->where(['a.assigned_to' => 'Internships'])
                ->andWhere(['!=', 'a.parent_enc_id', ''])
                ->groupBy(['a.parent_enc_id'])
                ->orderBy(['b.name' => SORT_ASC])
                ->asArray()
                ->all();
            //$internshipCategories = \frontend\models\profiles\ProfileCards::getProfiles('Internships');
            if ($jobCategories || $internshipCategories) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'categories' => [
                        'jobs' => $jobCategories,
                        'internships' => $internshipCategories,
                    ],
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
        return $this->render('working-profiles');
    }

    public function actionQuestionnaire($qidk)
    {
        $result = OrganizationQuestionnaire::find()
            ->select(['questionnaire_enc_id', 'questionnaire_name'])
            ->where(['questionnaire_enc_id' => $qidk])
            ->asArray()
            ->one();

        $fields = QuestionnaireFields::find()
            ->alias('a')
            ->select(['a.field_enc_id', 'a.field_name', 'a.field_label', 'a.sequence', 'a.field_type', 'a.placeholder', 'a.is_required'])
            ->where(['a.questionnaire_enc_id' => $result['questionnaire_enc_id']])
            ->asArray()
            ->all();

        foreach ($fields as $field) {
            $field_option = QuestionnaireFieldOptions::find()
                ->select(['field_option_enc_id', 'field_option'])
                ->where(['field_enc_id' => $field['field_enc_id']])
                ->asArray()
                ->all();
            $field['options'] = $field_option;
            $arr['fields'][] = $field;
        }

        if ($arr) {
            $model = new QuestionnaireForm;
            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post('data');
                $applied_id = Yii::$app->getRequest()->getQueryParam('aaid');
                $arr = json_decode($data);
                $utilitiesModel = new Utilities();
                $answeredModel = new AnsweredQuestionnaire();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $answeredModel->answered_questionnaire_enc_id = $utilitiesModel->encrypt();
                $answeredModel->applied_application_enc_id = $applied_id;
                $answeredModel->questionnaire_enc_id = $qidk;
                $answeredModel->created_on = date('Y-m-d H:i:s');
                $answeredModel->created_by = Yii::$app->user->identity->user_enc_id;
                if ($answeredModel->save()) {
                    foreach ($arr as $array) {
                        if ($array->type == 'checkbox') {
                            foreach ($array->option as $option) {
                                $utilitiesModel = new Utilities();
                                $fieldsModel = new AnsweredQuestionnaireFields;
                                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                                $fieldsModel->answer_enc_id = $utilitiesModel->encrypt();
                                $fieldsModel->answered_questionnaire_enc_id = $answeredModel->answered_questionnaire_enc_id;
                                $fieldsModel->field_enc_id = $array->id;
                                $fieldsModel->field_option_enc_id = $option;
                                $fieldsModel->created_on = date('Y-m-d H:i:s');
                                $fieldsModel->created_by = Yii::$app->user->identity->user_enc_id;
                                if (!$fieldsModel->save()) {
                                    return false;
                                }
                            }
                        }

                        if ($array->type == 'select' || $array->type == 'radio') {
                            $utilitiesModel = new Utilities();
                            $fieldsModel = new AnsweredQuestionnaireFields;
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $fieldsModel->answer_enc_id = $utilitiesModel->encrypt();
                            $fieldsModel->answered_questionnaire_enc_id = $answeredModel->answered_questionnaire_enc_id;
                            $fieldsModel->field_enc_id = $array->id;
                            $fieldsModel->field_option_enc_id = $array->option;
                            $fieldsModel->created_on = date('Y-m-d H:i:s');
                            $fieldsModel->created_by = Yii::$app->user->identity->user_enc_id;
                            if (!$fieldsModel->save()) {
                                return false;
                            }
                        }
                        if ($array->type == 'text' || $array->type == 'textarea' || $array->type == 'number' || $array->type == 'date' || $array->type == 'time') {

                            $utilitiesModel = new Utilities();
                            $fieldsModel = new AnsweredQuestionnaireFields;
                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                            $fieldsModel->answer_enc_id = $utilitiesModel->encrypt();
                            $fieldsModel->answered_questionnaire_enc_id = $answeredModel->answered_questionnaire_enc_id;
                            $fieldsModel->field_enc_id = $array->id;
                            $fieldsModel->answer = $array->answer;
                            $fieldsModel->created_on = date('Y-m-d H:i:s');
                            $fieldsModel->created_by = Yii::$app->user->identity->user_enc_id;
                            if (!$fieldsModel->save()) {
                                print_r($fieldsModel->getErrors());
                            }
                        }
                    }
                } else {
                    return false;
                }

                $update = Yii::$app->db->createCommand()
                    ->update(AppliedApplications::tableName(), ['status' => 'Pending', 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $applied_id])
                    ->execute();
                if ($update) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return $this->renderAjax('questionnaire-ui', [
                    'fields' => $arr,
                    'model' => $model,
                ]);
            }
        }
    }

}