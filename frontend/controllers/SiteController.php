<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;
use common\models\EmployerApplications;
use common\models\Industries;
use common\models\ApplicationPlacementLocations;
use common\models\AppliedApplications;
use frontend\models\ContactForm;
use frontend\models\CareerForm;
use frontend\models\FreelancersForm;
use frontend\models\FreeForm;
use frontend\models\OrganizationVideoForm;
use frontend\models\CompanyAlertForm;
use common\models\Posts;
use common\models\Organizations;
use common\models\OrganizationLocations;
use common\models\States;
use common\models\Cities;
use common\models\Countries;
use common\models\Utilities;
use common\models\Categories;
use common\models\AssignedCategories;
use frontend\models\CompanyLogoForm;
use common\models\OrganizationVideos;
use frontend\models\WorkExpierenceForm;
use frontend\models\QualificationForm;
use frontend\models\SkillsAndLanguagesForm;
use frontend\models\PortfolioForm;
use frontend\models\PersonalProfileForm;
use frontend\models\ChangePasswordForm;
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
//testing records use start
use common\models\ApplicationTypes;

//testing records use end
/**
 * Site controller
 */
class SiteController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    public function actionIndex() {
        $feedbackFormModel = new FeedbackForm();
        $partnerWithUsModel = new PartnerWithUsForm();
        return $this->render('index', [
                    'feedbackFormModel' => $feedbackFormModel,
                    'partnerWithUsModel' => $partnerWithUsModel,
        ]);
    }
    
    public function actionSendFeedback() {
        $feedbackFormModel = new FeedbackForm();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $feedbackFormModel->load(Yii::$app->request->post());
            if ($feedbackFormModel->save()) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Feedback has been sent.',
                ];
            } else{
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
//                return $feedbackFormModel->save();
            }
            
        }
    }
    
    public function actionPartnerWithUs() {
        $partnerWithUsModel = new PartnerWithUsForm();
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $partnerWithUsModel->load(Yii::$app->request->post());
            if ($partnerWithUsModel->save()) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Request has been sent.',
                ];
            } else{
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
            
        }
    }

    public function actionAboutUs() {
        return $this->render('about-us');
    }

    public function actionContactUs() {
        $contactFormModel = new ContactForm();
        if ($contactFormModel->load(Yii::$app->request->post()) && $contactFormModel->validate()) {
            if ($contactFormModel->contact('jyoti@empoweryouth.in')) {
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

    public function actionTp() {
        return $this->actionTrainingProgram();
    }

    public function actionEducationalInstitute() {
        return $this->render('educational-institute');
    }

    public function actionJobsProvider() {
        $posts = Posts::find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        return $this->render('jobs-provider', [
                    'posts' => $posts,
        ]);
    }

    public function actionNgo() {
        return $this->render('ngo');
    }

    public function actionTrainer() {
        return $this->render('trainer');
    }
    public function actionEmployers() {
        return $this->render('employers');
    }
    public function actionCandidateList() {
        return $this->render('candidate-list');
    }
    public function actionCandidateGrid() {
        return $this->render('candidate-grid');
    }
    public function actionAddNewSubscriber() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->post()) {
            $userData = Yii::$app->request->post();
            $subscribersForm = new Subscribers();
            $utilitiesModel = new Utilities();
            $subscribersForm->first_name = $userData['first_name'];
            $subscribersForm->last_name = $userData['last_name'];
            $subscribersForm->email = $userData['email'];
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $subscribersForm->subscriber_enc_id = $utilitiesModel->encrypt();
            if ($subscribersForm->validate()) {
                if ($subscribersForm->save()) {
                    $response = [
                        'status' => 200,
                        'message' => Yii::t('empoweryouth', 'You are successfully subscribed.'),
                    ];
                } else {
                    $response = [
                        'status' => 201,
                        'message' => Yii::t('empoweryouth', 'An error has occurred. Please try again.'),
                    ];
                }
            } else {
                $response = [
                    'status' => 0,
                    'message' => Yii::t('empoweryouth', 'Please enter all the information correctly'),
                ];
            }
            return $response;
        }
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionFifaQuiz($s = NULL, $t = NULL) {
        $this->layout = 'quiz-main';
        return $this->render('fifa-quiz', [
                    'score' => $s,
                    'total' => $t,
        ]);
    }

    public function actionFifaQuiz2($s = NULL, $t = NULL) {
        $this->layout = 'quiz2-main';
        return $this->render('fifa-quiz-2', [
                    'score' => $s,
                    'total' => $t,
        ]);
    }

    public function actionCareers() {
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

    public function actionPopup() {
        return $this->render('popup');
    }

    public function actionCompanyProfile() {
        return $this->render('company-profile');
    }

    public function actionCompanyy($cpidk) {
        $organizationsModel = new Organizations();
        $organizationVideosModel = new OrganizationVideos();
        $companyLogoFormModel = new CompanyLogoForm();
        $organization = $organizationsModel->find()->alias('a')
                ->select(['a.*', 'b.*', 'c.name as city', 'd.name as state', 'e.name as country'])
                ->leftJoin(OrganizationLocations::tableName() . 'as b', 'b.organization_enc_id = a.organization_enc_id')
                ->innerJoin(Cities::tableName() . 'as c', 'c.city_enc_id = b.city_enc_id')
                ->innerJoin(States::tableName() . 'as d', 'd.state_enc_id = c.state_enc_id')
                ->innerJoin(Countries::tableName() . 'as e', 'e.country_enc_id = d.country_enc_id')
                ->where(['a.slug' => $cpidk, 'a.status' => 'Active', 'a.is_deleted' => 0])
                ->asArray()
                ->all();

        $organizationVideos = $organizationVideosModel->find()->alias('a')
                ->select(['a.*'])
                ->innerJoin(Organizations::tableName() . 'as b', 'b.organization_enc_id = a.organization_enc_id')
                ->where(['b.slug' => $cpidk, 'b.status' => 'Active', 'b.is_deleted' => 'false'])
                ->asArray()
                ->all();

        return $this->render('company-profileee', [
                    'organization' => $organization,
                    'videos' => $organizationVideos,
                    'companyLogoFormModel' => $companyLogoFormModel,
        ]);
    }

    public function actionCareerMove() {
        return $this->render('career-move');
    }
    public function actionNewCompanyProfile() {
        return $this->render('new-company-profile');
    }
    public function actionCompanyJobsIndex() {
        return $this->render('company-jobs-index');
    }
    public function actionCompanyInternshipsIndex() {
        return $this->render('company-internships-index');
    }
    public function actionReviewCompanyList() {
        return $this->render('review-company-list');
    }
    public function actionReviewCompany() {
        return $this->render('review-company');
    }
    public function actionReviewIndex() {
        return $this->render('review-index');
    }
    public function actionNewCandidateProfile() {
        return $this->render('new-candidate-profile');
    }
    public function actionCompanyProfileBeta() {
        return $this->render('company-profile-beta');
    }
    public function actionVideoDetailBeta(){
        return $this->render('video-detail-beta');
    }
    public function actionWalkInInterview() {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $limit = 3;
            $pagenum = Yii::$app->getRequest()->getQueryParam('pagenum');
            $offset = ($pagenum - 1) * $limit;
            $jobcards = EmployerApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id as id', 'a.slug link', 'a.experience', "GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') as city", 'a.type', 'c.name as title', 'd.name as organization_name', 'd.slug organization_link', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo'])
                    ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                    ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                    ->innerJoin(Organizations::tableName() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                    ->innerJoin(ApplicationPlacementLocations::tableName() . 'as e', 'e.application_enc_id = a.application_enc_id')
                    ->innerJoin(OrganizationLocations::tableName() . 'as f', 'f.location_enc_id = e.location_enc_id')
                    ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                    ->where(['a.is_deleted' => 0])
                    ->orderBy(['a.id' => SORT_DESC])
                    ->limit($limit)
                    ->offset($offset)
                    ->groupBy('a.application_enc_id')
                    ->asArray()
                    ->all();

            if ($jobcards) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'jobcards' => $jobcards,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        } else {

            return $this->render('walk-in-interview');
        }
    }

    public function actionExploreCompany() {
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

    public function actionJobsNearMe() {
        return $this->render('jobs-near-me');
    }

    public function actionCareerCoach() {
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

    public function actionVideoDetail() {
        return $this->render('video-detail');
    }

    public function actionCandidates() {
        return $this->render('candidates');
    }

    public function actionFreelancers() {
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

    public function actionFreeForm() {
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

    public function actionValidateForm() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $freeFormModel = new FreeForm();
        if ($freeFormModel->load(Yii::$app->request->post())) {
//            return $freeFormModel;
//            exit;
//            return $freeFormModel->save();
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
//                return $freeFormModel->getErrors();
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        }
    }

//    public function actionLearning() {
//        $this->layout = 'main-secondary';
//
//        $learningCornerFormModel = new OrganizationVideoForm();
//
//        if(!Yii::$app->user->isGuest) {
//            if ($learningCornerFormModel->load(Yii::$app->request->post()) && $learningCornerFormModel->validate()) {
//                if ($learningCornerFormModel->save()) {
//                    Yii::$app->session->setFlash('success', 'Your video is submitted successfully.');
//                } else {
//                    Yii::$app->session->setFlash('error', 'An error has occurred. Please try again later.');
//                }
//            }
//            return $this->render('learning-corner', [
//                        'learningCornerFormModel' => $learningCornerFormModel,
//            ]);
//        }else{
//            return $this->redirect('/login');
//        }
//    }

    public function actionCompanys1() {
        $organizationVideoForm = new OrganizationVideoForm();

        if ($organizationVideoForm->load(Yii::$app->request->post())) {
            $organizationVideoForm->link = $this->getYouTubeID($organizationVideoForm->link);
            if ($organizationVideoForm->add()) {
                return true;
            } else {
                return false;
            }
        }

        return $this->renderAjax('company-video-upload', [
                    'organizationVideoForm' => $organizationVideoForm,
        ]);
    }

    public function actionJobsByIndustry() {
        $params = Yii::$app->request->get('industry');

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
                ->where(['h.industry' => $params])
                ->orderBy(['a.id' => SORT_DESC])
                ->groupBy('a.application_enc_id')
                ->asArray()
                ->limit(50)
                ->all();

        $industry = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.preferred_industry', 'b.industry'])
                ->innerJoin(Industries::tableName() . 'as b', 'b.industry_enc_id = a.preferred_industry')
                ->orderBy(['a.id' => SORT_DESC])
                ->groupBy('b.industry')
                ->asArray()
                ->limit(50)
                ->all();

        return $this->render('', [
                    'cards' => $jobcards,
                    'industry' => $industry,
        ]);
    }

    public function actionJobsByRoles() {
        $params = Yii::$app->request->get('role');

        $jobcards = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.created_on', 'a.designation', 'a.slug', 'a.experience', "GROUP_CONCAT(DISTINCT g.name SEPARATOR ', ') as city", 'a.type', 'c.name as title', 'd.name as org_name', 'd.logo', 'd.logo_location'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
                ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
                ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                ->orderBy(['a.id' => SORT_DESC])
                ->where(['a.designation' => $params])
                ->groupBy('a.application_enc_id')
                ->asArray()
                ->limit(50)
                ->all();

        $designations = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.designation'])
                ->orderBy(['a.id' => SORT_DESC])
                ->groupBy('a.designation')
                ->asArray()
                ->limit(50)
                ->all();

        return $this->render('', [
                    'cards' => $jobcards,
                    'designations' => $designations,
        ]);
    }

    public function actionJobsByLocation() {
        $params = Yii::$app->request->get('location');

        $jobcards = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.created_on', 'a.slug', 'a.experience', "g.name as city", 'a.type', 'c.name as title', 'd.name as org_name', 'd.logo', 'd.logo_location'])
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
                ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
                ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
                ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
                ->where(['g.name' => $params])
                ->orderBy(['a.id' => SORT_DESC])
//                ->groupBy('a.application_enc_id')
                ->asArray()
                ->limit(50)
                ->all();

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

        return $this->render('', [
                    'cards' => $jobcards,
                    'locations' => $locations,
        ]);
    }

    public function actionStartUpJobs() {
        return $this->render('start-up-jobs');
    }

    public function actionStartUpInternships() {
        return $this->render('start-up-internships');
    }

    public function actionCorporateInternships() {
        return $this->render('corporate-internships');
    }

    public function actionCandidateProfile() {
        return $this->render('candidate-profile');
    }

    public function actionUniversitiesMain() {
        return $this->render('universities-main');
    }

    public function actionCandidateProfile1() {
        $usersModel = new Users();
        $companyLogoFormModel = new CompanyLogoForm();
        $user = $usersModel->find()
                ->where(['username' => 'sehdev', 'status' => 'Active', 'is_deleted' => 0])
                ->asArray()
                ->one();
        return $this->render('candidate-profile_1', [
                    'user' => $user,
                    'companyLogoFormModel' => $companyLogoFormModel,
        ]);
    }

    public function actionCategoryList() {
        return $this->render('category-list');
    }

    public function actionUploadCompanyLogo() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $companyLogoFormModel = new CompanyLogoForm();
            $companyLogoFormModel->logo = UploadedFile::getInstance($companyLogoFormModel, 'logo');
            if ($companyLogoFormModel->save()) {
                return[
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Logo successfully changed.',
                ];
            } else {
                return [
                    'status' => 'error',
                    'title' => 'Opps!!',
                    'message' => 'Something went wrong. Please try again.'
                ];
            }
        }
    }

    public function actionCandidateform() {
        $statesModel = new States();
        $organizationLocationFormModel = new OrganizationLocationForm();
        return $this->render('candidates/candidate_form', [
                    'statesModel' => $statesModel,
                    'organizationLocationFormModel' => $organizationLocationFormModel,
        ]);
    }

    public function actionWorkExperience() {
        $workExperienceFormModel = new WorkExpierenceForm();
        return $this->renderPartial('candidates/work_experience', [
                    'workExperienceFormModel' => $workExperienceFormModel,
        ]);
    }

    public function actionPersonalProfile() {
        $personalProfileFormModel = new PersonalProfileForm();
        return $this->renderPartial('candidates/personal_profile', [
                    'personalProfileFormModel' => $personalProfileFormModel,
        ]);
    }

    public function actionQualification() {
        $qualificationFormModel = new QualificationForm();
        return $this->renderPartial('candidates/qualification_form', [
                    'qualificationFormModel' => $qualificationFormModel,
        ]);
    }

    public function actionSkillAndLanguage() {
        $skillsAndLanguagesFormModel = new SkillsAndLanguagesForm();
        return $this->renderPartial('candidates/skills_form', [
                    'skillsAndLanguagesFormModel' => $skillsAndLanguagesFormModel,
        ]);
    }

    public function actionPortfolio() {
        $portfolioFormModel = new PortfolioForm();
        return $this->renderPartial('candidates/portfolio_form', [
                    'portfolioFormModel' => $portfolioFormModel,
        ]);
    }

    public function actionCompanyAlert() {
        $companyAlertForm = new CompanyAlertForm();
        return $this->renderAjax('companyalert', [
                    'companyAlertForm' => $companyAlertForm,
        ]);
    }

    public function actionTermsConditions() {
        return $this->render('terms-conditions');
    }

    public function actionPrivacyPolicy() {
        return $this->render('privacy-policy');
    }

    public function actionUpdateProfile() {
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

    public function actionTestCards() {
        return $this->render('testt');
    }

    public function actionJobDetailNew() {
        return $this->render('job-detail-new');
    }

    public function actionCandidateDetail() {
        return $this->render('candidate-detail');
    }

    public function actionViewQuestionnaire() {
        return $this->render('view-questionnaire');
    }

    public function actionTestJson() {
        return $this->render('test-JSON');
    }

    public function actionMain() {
        $this->layout = 'main_new';
        $postsModel = new Posts();
        $posts = $postsModel->find()
                ->where(['status' => 'Active', 'is_deleted' => 'false'])
                ->orderby(['created_on' => SORT_ASC])
                ->limit(4)
                ->asArray()
                ->all();
        $similar_posts = $postsModel->find()
                ->limit(4)
                ->orderBy(['created_on' => SORT_DESC])
                ->asArray()
                ->all();
        return $this->render('index_1', [
                    'posts' => $posts,
                    'similar_posts' => $similar_posts,
        ]);
    }

    public function actionQuestionnaire($qidk) {
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
//           foreach($field)
            $field['options'] = $field_option;
            $arr['fields'][] = $field;
        }

//        print_r($arr);
//        exit;
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

    private function getYouTubeID($URL) {
        $YouTubeCheck = preg_match('![?&]{1}v=([^&]+)!', $URL . '&', $Data);
        If ($YouTubeCheck) {
            $VideoID = $Data[1];
        }
        return $VideoID;
    }

    public function actionChangepass() {
        $ChangePasswordForm = new ChangePasswordForm();
        if ($ChangePasswordForm->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($ChangePasswordForm->changePassword()) {
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Password has been changed.',
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }
        }
        return $this->renderAjax('changepassword', [
                    'ChangePasswordForm' => $ChangePasswordForm
        ]);
    }

    public function actionDummy() {
        return $this->render('dummy');
    }

    public function actionSendEmail() {
        $mail = Yii::$app->mailer->compose()
                ->setFrom('tarandeep@dsbedutech.in')
                ->setTo('bansaladitya209@outlook.com')
                ->setSubject('Email from DSBEdutech.in')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<b>HTML content</b>');

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    public function actionMessage() {
        $this->layout = 'main-secondary';
        return $this->render('message');
    }

    public function actionHeader() {
        $this->layout = 'main_new';
        return $this->render('header');
    }

    public function actionTestLoader() {
        return $this->render('loaders');
    }

    public function actionTest() {  // created by nitesh  , this is testing data and will be remove after testing
        $accepted_applications = AppliedApplications::find()
                ->alias('a')
                ->select(['a.status', 'a.created_by', 'd.name as title', 'b.slug', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions'])
                ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['a.status' => 'Pending'])
                ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
                ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
                ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
                ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
                ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = b.application_enc_id')
                ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
                ->groupBy(['b.application_enc_id'])
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->all();


        print_r($accepted_applications);
        exit;

        return $this->render('pending-jobs', [
                    'pending' => $pending_applications,
        ]);
    }

}
