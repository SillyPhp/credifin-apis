<?php

namespace frontend\controllers;

use common\models\ApplicationTypes;
use common\models\Cities;
use common\models\EmployerApplications;
use common\models\States;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;
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

    public function actionIndex()
    {
        $feedbackFormModel = new FeedbackForm();
        $partnerWithUsModel = new PartnerWithUsForm();
        return $this->render('index', [
            'feedbackFormModel' => $feedbackFormModel,
            'partnerWithUsModel' => $partnerWithUsModel,
        ]);
    }

    public function actionSendFeedback()
    {
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
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
            }

        }
    }

    public function actionPartnerWithUs()
    {
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
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occurred. Please try again.',
                ];
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

    public function actionEmployers()
    {
        return $this->render('employers');
    }
    public function actionCareerCompany($slug = null){
        $this->layout = 'without-header';
        $org = Organizations::find()
            ->select([
                'name',
                'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", logo_location, "/", logo) END logo'
                ])
            ->where([
                'slug' => $slug
            ])
            ->asArray()
            ->one();
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $options = Yii::$app->request->post();
            if(isset($options['type'])=='jobs'){
                $jobs = $this->getCareerInfo('Jobs', $options);
            }elseif (isset($options['type'])=='internships'){
                $internships = $this->getCareerInfo('Internships', $options);
            }else{
                $jobs = $this->getCareerInfo('Jobs', $options);
                $internships = $this->getCareerInfo('Internships', $options);
                $count = $jobs['count'] + $internships['count'];
            }
            return ['status'=>200,'jobs'=>$jobs['result'], 'internships'=>$internships['result'], 'count'=>$count];

        }
        return $this->render('career-company',[
            'org' => $org
        ]);
    }

    private function getCareerInfo($type, $options){
        if($options['limit']){
            $limit= $options['limit'];
            $offset= ($options['page'] -1)* $options['limit'];
        }
        $jobDetail = EmployerApplications::find()
            ->alias('a')
            ->select([
                'a.last_date',
                'a.type',
//                'CONCAT("'. Url::to('/internship/', true). '", a.slug) link',
                'a.slug',
                'dd.name category',
                'l.designation',
                'd.initials_color color',
                'CONCAT("' . Url::to('/', true) . '", d.slug) organization_link',
                "g.name as city",
                'c.name as title',
                'dd.icon',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=(230 B)
                https://ui-avatars.com/api/?name=
                ", d.name, "&size=200&rounded=false&background=", REPLACE(d.initials_color, "#", ""), "&color=ffffff") END logo',
                '(CASE
               WHEN a.experience = "0" THEN "No Experience"
               WHEN a.experience = "1" THEN "Less Than 1 Year Experience"
               WHEN a.experience = "2" THEN "1 Year Experience"
               WHEN a.experience = "3" THEN "2-3 Years Experience"
               WHEN a.experience = "3-5" THEN "3-5 Years Experience"
               WHEN a.experience = "5-10" THEN "5-10 Years Experience"
               WHEN a.experience = "10-20" THEN "10-20 Years Experience"
               WHEN a.experience = "20+" THEN "More Than 20 Years Experience"
               ELSE "No Experience"
               END) as experience',
            ])
            ->joinWith(['title b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false);
                $b->joinWith(['parentEnc dd'], false);
            }], false)
            ->joinWith(['organizationEnc d' => function ($a) {
                $a->where(['d.is_deleted' => 0]);
            }], false)
            ->joinWith(['applicationPlacementLocations e' => function ($x) {
                $x->joinWith(['locationEnc f' => function ($x) {
                    $x->joinWith(['cityEnc g' => function ($x) {
                        $x->joinWith(['stateEnc s'], false);
                    }], false);
                }], false);
            }], false)
            ->joinWith(['preferredIndustry h'], false)
            ->joinWith(['designationEnc l'], false)
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => $type, 'a.status' => 'Active', 'a.is_deleted' => 0, 'd.slug' => 'ajayjuneja']);
            $count = $jobDetail->count();
            $result = $jobDetail
            ->limit($limit)
            ->offset($offset)
            ->asArray()
            ->all();
            return ['count'=> $count, 'result' => $result];
    }


    public function actionCareerJobDetail($slug = null){
        $this->layout = 'without-header';
        $org = Organizations::find()
            ->select([
                'name',
                'email',
                'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", logo_location, "/", logo) END logo'
            ])
            ->where([
                'slug'=> $slug
            ])
            ->asArray()
            ->one();
        return $this->render('career-job-detail',[
           'org' => $org
        ]);
    }


    public function actionAddNewSubscriber()
    {
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

    public function actionCareers()
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