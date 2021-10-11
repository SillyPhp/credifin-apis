<?php

namespace account\controllers;

use account\models\applications\ApplicationDataProvider;
use account\models\applications\ApplicationForm;
use account\models\applications\ApplicationTemplateDataProvider;
use account\models\applications\ExtendsJob;
use account\models\applications\ShortJobs;
use account\models\applications\UserAppliedApplication;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTemplates;
use common\models\ApplicationTypes;
use common\models\ApplicationUnclaimOptions;
use common\models\AppliedApplicationProcess;
use common\models\AppliedApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\DropResumeApplications;
use common\models\EmployerApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\FollowedOrganizations;
use common\models\Industries;
use common\models\InterviewProcessFields;
use common\models\Organizations;
use common\models\RejectionReasons;
use common\models\ReviewedApplications;
use common\models\ShortlistedApplicants;
use common\models\ShortlistedApplications;
use common\models\UnclaimedOrganizations;
use common\models\UserCoachingTutorials;
use common\models\UserPreferences;
use common\models\Users;
use common\models\UserSkills;
use common\models\Utilities;
use common\models\WidgetTutorials;
use frontend\models\applications\ApplicationCards;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class InternshipsController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionQuickInternship()
    {
        if (Yii::$app->user->identity->organization->organization_enc_id):
            $model = new ShortJobs();
            $type = 'Internships';
            $data = new ApplicationForm();
            $primary_cat = $data->getPrimaryFields($type);
            $job_type = $data->getApplicationTypes();
            $placement_locations = $data->PlacementLocations();
            $currencies = $data->getCurrency();
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save($type)) {
                    Yii::$app->session->setFlash('success', 'Your Information Has Been Successfully Submitted..');
                } else {
                    Yii::$app->session->setFlash('error', 'Something Went Wrong..');
                }
                return $this->refresh();
            }
            return $this->render('/employer-applications/one-click-job', ['type' => $type, 'currencies' => $currencies, 'placement_locations' => $placement_locations, 'model' => $model, 'primary_cat' => $primary_cat, 'job_type' => $job_type]);
        else:
            return $this->redirect('/');
        endif;
    }

    public function actionIndex()
    {
        if (Yii::$app->user->identity->organization) {
            return $this->__organizationJobs();
        } else {
            return $this->__individualDashboard();
        }
    }

    public function actionDashboard()
    {
        if (Yii::$app->user->identity->organization) {
            return $this->__organizationDashboard();
        } else {
            return $this->__individualDashboard();
        }
    }

    public function actionApproveCandidate()
    {
        if (Yii::$app->user->identity->organization) {
            if (Yii::$app->request->isPost) {
                $f_id = Yii::$app->request->post('field_id');
                $app_id = Yii::$app->request->post('app_id');
                $update = Yii::$app->db->createCommand()
                    ->update(AppliedApplicationProcess::tableName(), ['is_completed' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['field_enc_id' => $f_id, 'applied_application_enc_id' => $app_id])
                    ->execute();
                if ($update == 1) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function actionCreate($aidk = NULL)
    {
        if (Yii::$app->user->identity->organization) {
            $model = new ApplicationForm();
            $primary_cat = $model->getPrimaryFields('Internships');
            $array = ArrayHelper::getColumn($primary_cat, 'category_enc_id');
            if (in_array($aidk, $array)) {
                return $this->_renderCreateInternships($aidk);
            } else {
                return $this->_renderProfileTemplates($primary_cat, 'internships');
            }
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    private function _renderProfileTemplates($primary_cat, $type = 'jobs')
    {
        return $this->render('/widgets/employer-applications/temProfiles', ['primary_cat' => $primary_cat, 'type' => $type]);
    }


    private function _renderCreateInternships($pidk)
    {
        $type = 'Internships';
        $model = new ApplicationForm();
        $primary_cat = $model->getPrimaryFields('Internships');
        $model->primaryfield = (($pidk) ? $pidk : null);
        $questionnaire = $model->getQuestionnnaireList(2);
        $benefits = $model->getBenefits();
        $process = $model->getInterviewProcess();
        $placement_locations = $model->getOrganizationLocations();
        $interview_locations = $model->getOrganizationLocations(2);
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $session_token = Yii::$app->request->post('n');
            if ($application_id = $model->saveValues($type)) {
                $session = Yii::$app->session;
                if (!empty($session->get($session_token))) {
                    $session->remove($session_token);
                }
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'app_id' => $application_id,
                ];
            } else {
                return false;
            }
        } else {
            return $this->render('/employer-applications/form', ['model' => $model,
                'primary_cat' => $primary_cat,
                'placement_locations' => $placement_locations,
                'interview_locations' => $interview_locations,
                'benefits' => $benefits,
                'process' => $process,
                'questionnaire' => $questionnaire,
                'type' => $type,
            ]);
        }
    }

    public function actionPreview()
    {
        if (Yii::$app->user->identity->organization) {
            $model = new ApplicationForm();
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $var = Yii::$app->request->post('n');
                $session = Yii::$app->session;
                $session->set($var, $model);
                return $var;
            } else {
                return false;
            }
        }
    }

    public function actionEmpBenefits()
    {
        $BenefitsModel = new Benefits();

        if ($BenefitsModel->load(Yii::$app->request->post()) && $BenefitsModel->validate()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($BenefitsModel->Add()) {
                return [
                    'status' => 'success',
                    'title' => 'Success',
                    'message' => 'Benifits successfully added.'
                ];
            } else {
                return [
                    'status' => 'error',
                    'title' => 'Opps!!',
                    'message' => 'Something went wrong. Please try again.'
                ];
            }
        } else {
            return $this->renderAjax('benefitsform', [
                'BenefitsModel' => $BenefitsModel,
            ]);
        }
    }

    public function actionClone($aidk)
    {
        if (Yii::$app->user->identity->organization) {
            $type = 'Clone_Internships';
            $model = new ApplicationForm();
            $primary_cat = $model->getPrimaryFields('Internships');
            $questionnaire = $model->getQuestionnnaireList(2);
            $benefits = $model->getBenefits();
            $process = $model->getInterviewProcess();
            $placement_locations = $model->getOrganizationLocations();
            $interview_locations = $model->getOrganizationLocations(2);
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $session_token = Yii::$app->request->post('n');
                if ($application_id = $model->saveValues($type)) {
                    $session = Yii::$app->session;
                    if (!empty($session->get($session_token))) {
                        $session->remove($session_token);
                    }
                    if ($session->has('campusPlacementData')){
                        $session->remove('campusPlacementData');
                    }
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'app_id' => $application_id,
                    ];
                } else {
                    return false;
                }
            } else {
                $obj = new ApplicationDataProvider();
                $model = $obj->setValues($model, $aidk);
                return $this->render('/employer-applications/form', ['model' => $model,
                    'primary_cat' => $primary_cat,
                    'placement_locations' => $placement_locations,
                    'interview_locations' => $interview_locations,
                    'benefits' => $benefits,
                    'process' => $process,
                    'questionnaire' => $questionnaire,
                    'type' => $type,
                ]);
            }
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionCloneTemplate($aidk)
    {
        $application = ApplicationTemplates::find()
            ->alias('a')
            ->joinWith(['applicationTypeEnc f'], false)
            ->where(['a.application_enc_id' => $aidk, 'f.name' => 'Internships'])
            ->asArray()
            ->one();
        if (Yii::$app->user->identity->organization && $application) {
            $model = new ApplicationForm();
            $type = 'Clone_Internships';
            $primary_cat = $model->getPrimaryFields();
            $questionnaire = $model->getQuestionnnaireList();
            $industry = $model->getndustry();
            $benefits = $model->getBenefits();
            $process = $model->getInterviewProcess();
            $placement_locations = $model->getOrganizationLocations();
            $interview_locations = $model->getOrganizationLocations(2);
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $session_token = Yii::$app->request->post('n');
                if ($application_id = $model->saveValues($type)) {
                    $session = Yii::$app->session;
                    if (!empty($session->get($session_token))) {
                        $session->remove($session_token);
                    }
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'app_id' => $application_id,
                    ];
                } else {
                    return false;
                }
            } else {
                $obj = new ApplicationTemplateDataProvider();
                $model = $obj->setValues($model, $aidk);
                return $this->render('/employer-applications/form', [
                    'model' => $model,
                    'primary_cat' => $primary_cat,
                    'industry' => $industry,
                    'placement_locations' => $placement_locations,
                    'interview_locations' => $interview_locations,
                    'benefits' => $benefits,
                    'process' => $process,
                    'questionnaire' => $questionnaire,
                    'type' => $type,
                ]);
            }
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found'));
        }
    }

    public function actionEdit($aidk)
    {
        if (Yii::$app->user->identity->organization) {
            $type = 'Edit_Internships';
            $model = new ApplicationForm();
            $obj = new ApplicationDataProvider();
            $primary_cat = $model->getPrimaryFields('Internships');
            $questionnaire = $model->getQuestionnnaireList(2);
            $benefits = $model->getBenefits();
            $process = $model->getInterviewProcess();
            $placement_locations = $model->getOrganizationLocations();
            $interview_locations = $model->getOrganizationLocations(2);
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $session_token = Yii::$app->request->post('n');
                if ($obj->update($model, $aidk, $type)) {
                    $session = Yii::$app->session;
                    if (!empty($session->get($session_token))) {
                        $session->remove($session_token);
                    }
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                    ];
                } else {
                    return false;
                }
            } else {
                $model = $obj->setValues($model, $aidk);
                return $this->render('/employer-applications/form', ['model' => $model,
                    'primary_cat' => $primary_cat,
                    'placement_locations' => $placement_locations,
                    'interview_locations' => $interview_locations,
                    'benefits' => $benefits,
                    'process' => $process,
                    'questionnaire' => $questionnaire,
                    'type' => $type,
                ]);
            }
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionDeleteApplication()
    {
        if (Yii::$app->user->identity->organization) {
            if (Yii::$app->request->isPost) {
                $id = Yii::$app->request->post('data');
                $update = Yii::$app->db->createCommand()
                    ->update(EmployerApplications::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $id])
                    ->execute();
                if ($update) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function actionReviewed()
    {
        $review_list = ReviewedApplications::find()
            ->alias('a')
            ->select(['a.id', 'a.review_enc_id', 'k.applied_application_enc_id', 'a.review', 'b.application_enc_id', 'c.name type', 'g.name as org_name', 'g.establishment_year', 'SUM(h.positions) as positions', 'd.parent_enc_id', 'd.category_enc_id', 'e.name title', 'b.slug', 'f.name parent_category', 'f.icon', 'f.icon_png','b.unclaimed_organization_enc_id','g.logo','g.logo_location','g.initials_color','auo.positions as unclaim_positions','uo.name as unclaim_org_name'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.review' => 1])
            ->joinWith(['applicationEnc b' => function ($b) {
//                $b->distinct();
                $b->joinWith(['applicationTypeEnc c']);
                $b->joinWith(['title d' => function ($c) {
                    $c->joinWith(['categoryEnc e']);
                    $c->joinWith(['parentEnc f']);
                }]);
                $b->joinWith(['applicationUnclaimOptions auo']);
                $b->joinWith(['organizationEnc g']);
                $b->joinWith(['unclaimedOrganizationEnc as uo']);
                $b->joinWith(['applicationPlacementLocations h']);
                $b->joinWith(['appliedApplications k' => function ($y) {
                    $y->onCondition(['k.created_by' => Yii::$app->user->identity->user_enc_id, 'k.is_deleted' => 0]);
                }], false);
//                $b->groupBy(['h.application_enc_id']);
                $b->onCondition(['b.is_deleted' => 0, 'b.status' => 'ACTIVE', 'b.application_for' =>1]);
            }], false)
            ->having(['type' => 'Internships'])
            ->orderBy(['a.id' => SORT_DESC])
            ->groupBy(['b.application_enc_id'])
            ->asArray()
            ->all();
        return $this->render('individual/review-jobs', [
            'reviewlist' => $review_list,
        ]);
    }

    public function actionSaved()
    {
        $shortlist_jobs = ShortlistedApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'j.name type', 'a.id', 'a.created_on', 'k.applied_application_enc_id', 'a.shortlisted_enc_id', 'b.slug', 'd.name', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions','b.unclaimed_organization_enc_id','e.logo','e.logo_location','e.initials_color',
                'auo.positions as unclaim_positions',
                'uo.name as unclaim_org_name',
                'uo.logo as unclaim_org_logo',
                'uo.logo_location as unclaim_org_logo_location',
                'uo.initials_color as unclaim_org_initials_color',
                'ea.unclaimed_organization_enc_id'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.shortlisted' => 1])
            ->joinWith(['applicationEnc b' => function ($a) {
                $a->joinWith(['appliedApplications k' => function ($y) {
                    $y->onCondition(['k.created_by' => Yii::$app->user->identity->user_enc_id, 'k.is_deleted' => 0]);
                }], false);
                $a->onCondition(['b.is_deleted' => 0, 'b.status' => 'ACTIVE', 'b.application_for' =>1]);
            }], false)
            ->innerJoin(EmployerApplications::tableName() . 'as ea', 'ea.application_enc_id = a.application_enc_id')
            ->leftJoin(ApplicationUnclaimOptions::tableName() . 'as auo', 'auo.application_enc_id = a.application_enc_id')
            ->leftJoin(UnclaimedOrganizations::tableName() . 'as uo', 'uo.organization_enc_id = ea.unclaimed_organization_enc_id')
            ->leftJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->leftJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->leftJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->leftJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = a.application_enc_id')
            ->leftJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->groupBy(['b.application_enc_id'])
            ->having(['type' => 'Internships'])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();
        return $this->render('individual/shortlist-jobs', [
            'shortlisted' => $shortlist_jobs,
        ]);
    }

    public function actionApplied()
    {
        $users = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'g.slug as org_slug', 'h.icon as job_icon', 'c.slug', 'g.name as org_name', 'a.status', 'f.name as title', 'a.applied_application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as g', 'g.organization_enc_id = c.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->where(['or',
                ['a.status' => 'Pending'],
                ['a.status' => 'Accepted']
            ])
            ->andWhere(['b.user_enc_id' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->andWhere(['c.status' => 'ACTIVE', 'c.is_deleted' => 0, 'c.application_for' =>1])
            ->having(['type' => 'Internships'])
            ->groupBy('a.applied_application_enc_id')
            ->asArray()
            ->all();

        foreach ($users as $user) {
            $process_fields = InterviewProcessFields::find()
                ->select(['field_name', 'field_enc_id', 'icon'])
                ->where(['interview_process_enc_id' => $user['interview_process_enc_id']])
                ->asArray()
                ->all();

            $user['process'] = $process_fields;
            $arr['fields'][] = $user;
        }
        return $this->render('individual/applied-jobs', [
            'users' => $users,
            'fields' => $arr
        ]);
    }

    public function actionAccepted()
    {
        $accepted_applications = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'g.slug as org_slug', 'h.icon as job_icon', 'c.slug', 'g.name as org_name', 'a.status', 'f.name as title', 'a.application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active', 'SUM(k.positions) as positions','g.logo','g.logo_location','g.initials_color'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as g', 'g.organization_enc_id = c.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as k', 'k.application_enc_id = c.application_enc_id')
            ->where(['b.user_enc_id' => Yii::$app->user->identity->user_enc_id, 'a.status' => 'Accepted', 'a.is_deleted' => 0])
            ->andWhere(['c.status' => 'ACTIVE', 'c.is_deleted' => 0, 'c.application_for' =>1])
            ->having(['type' => 'Internships'])
            ->groupBy('a.applied_application_enc_id')
            ->asArray()
            ->all();

        return $this->render('individual/accepted-jobs', [
            'accepted' => $accepted_applications,
        ]);
    }

    public function actionPending()
    {
        $pending_applications = AppliedApplications::find()
            ->alias('a')
            ->select(['b.application_enc_id', 'j.name type', 'a.id', 'a.status', 'a.created_by', 'd.name as title', 'b.slug', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions', 'a.is_deleted'])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.status' => 'Pending', 'a.is_deleted' => 0])
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = b.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
            ->andWhere(['b.status' => 'ACTIVE', 'b.is_deleted' => 0, 'b.application_for' =>1])
            ->having(['type' => 'Internships'])
            ->groupBy(['b.application_enc_id'])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();


        return $this->render('individual/pending-jobs', [
            'pending' => $pending_applications,
        ]);
    }

    public function actionReviewDelete()
    {
        if (Yii::$app->request->isPost) {
            $rmv_id = Yii::$app->request->post('rmv_id');
            $update = Yii::$app->db->createCommand()
                ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $rmv_id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionPendingDelete()
    {
        if (Yii::$app->request->isPost) {
            $rmv_id = Yii::$app->request->post('rmv_id');
            $update = Yii::$app->db->createCommand()
                ->update(AppliedApplications::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $rmv_id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionCancelApplication()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');
            $update = Yii::$app->db->createCommand()
                ->update(AppliedApplications::tableName(), ['status' => 'Cancelled', 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionShortlistDelete()
    {
        if (Yii::$app->request->isPost) {
            $rmv_id = Yii::$app->request->post('rmv_id');
            $update = Yii::$app->db->createCommand()
                ->update(ShortlistedApplications::tableName(), ['shortlisted' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $rmv_id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionReviewShortlist()
    {

        if (Yii::$app->request->isPost) {
            if (!Yii::$app->user->isGuest) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $app_id = Yii::$app->request->post('rmv_id');
                $chkuser = ShortlistedApplications::find()
                    ->select('shortlisted')
                    ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $app_id])
                    ->asArray()
                    ->one();
                $status = $chkuser['shortlisted'];
                if (empty($chkuser)) {
                    $shortlist = new ShortlistedApplications();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $shortlist->shortlisted_enc_id = $utilitiesModel->encrypt();
                    $shortlist->application_enc_id = $app_id;
                    $shortlist->shortlisted = 1;
                    $shortlist->created_on = date('Y-m-d H:i:s');
                    $shortlist->created_by = Yii::$app->user->identity->user_enc_id;
                    $shortlist->last_updated_on = date('Y-m-d H:i:s');
                    $shortlist->last_updated_by = Yii::$app->user->identity->user_enc_id;
                    if ($shortlist->save()) {
                        $update = Yii::$app->db->createCommand()
                            ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app_id, 'review' => 1])
                            ->execute();
                        if ($update == 1) {
                            $response = [
                                'status' => 'true',
                                'title' => 'Success',
                                'message' => 'Successfully Created',
                            ];
                            return $response;
                        } else {
                            $response = [
                                'status' => 'false',
                                'title' => 'Error',
                                'message' => 'Something went wrong in creating new shortlist.',
                            ];
                            return $response;
                        }
                    } else {
                        $response = [
                            'status' => 'false',
                            'title' => 'Error',
                            'message' => 'Something went wrong in saveing new entry.',
                        ];
                        return $response;
                    }
                } else if ($status == 0) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ShortlistedApplications::tableName(), ['shortlisted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $app_id])
                        ->execute();
                    if ($update == 1) {
                        $update1 = Yii::$app->db->createCommand()
                            ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app_id, 'review' => 1])
                            ->execute();
                        if ($update1 == 1) {
                            $response = [
                                'status' => 'true',
                                'title' => 'Success',
                                'message' => 'Successfully Updated Review and shortlist status',
                            ];
                            return $response;
                        } else {
                            $response = [
                                'status' => 'false',
                                'title' => 'Error',
                                'message' => 'Something went wrong. review status not update.',
                            ];
                            return $response;
                        }
                    } else {
                        $response = [
                            'status' => 'false',
                            'title' => 'Error',
                            'message' => 'Something went wrong. review and shortlist status not update.',
                        ];
                        return $response;
                    }
                } else if ($status == 1) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app_id, 'review' => 1])
                        ->execute();
                    if ($update == 1) {
                        $response = [
                            'status' => 'true',
                            'title' => 'Success',
                            'message' => 'Successfully Updated review status',
                        ];
                        return $response;
                    } else {
                        $response = [
                            'status' => 'false',
                            'title' => 'Error',
                            'message' => 'Something went wrong while review updating.',
                        ];
                        return $response;
                    }
                } else {
                    $response = [
                        'status' => 'false',
                        'title' => 'Error',
                        'message' => 'Shortlisted but something went wrong while review updating.',
                    ];
                    return $response;
                }
            }
        }

    }

    public function actionOrgDelete()
    {
        if (Yii::$app->request->isPost) {
            $rmv_id = Yii::$app->request->post('rmv_id');
            $update = Yii::$app->db->createCommand()
                ->update(FollowedOrganizations::tableName(), ['followed' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['followed_enc_id' => $rmv_id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionShortlistJob()
    {
        if (Yii::$app->request->isPost) {
            if (!Yii::$app->user->isGuest) {
                $app_id = Yii::$app->request->post("app_id");
                $chkuser = ShortlistedApplications::find()
                    ->select('shortlisted')
                    ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $app_id])
                    ->asArray()
                    ->one();

                $status = $chkuser['shortlisted'];
                if (empty($chkuser)) {
                    $shortlist = new ShortlistedApplications();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $shortlist->shortlisted_enc_id = $utilitiesModel->encrypt();
                    $shortlist->application_enc_id = $app_id;
                    $shortlist->shortlisted = 1;
                    $shortlist->created_on = date('Y-m-d H:i:s');
                    $shortlist->created_by = Yii::$app->user->identity->user_enc_id;
                    $shortlist->last_updated_on = date('Y-m-d H:i:s');
                    $shortlist->last_updated_by = Yii::$app->user->identity->user_enc_id;
                    if ($shortlist->save()) {
                        return 'short';
                    } else {
                        return false;
                    }
                } else if ($status == 1) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ShortlistedApplications::tableName(), ['shortlisted' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $app_id])
                        ->execute();
                    if ($update == 1) {
                        return 'unshort';
                    }
                } else if ($status == 0) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ShortlistedApplications::tableName(), ['shortlisted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $app_id])
                        ->execute();
                    if ($update == 1) {
                        return 'short';
                    }
                }
            }
        }
    }

    private function __individualDashboard()
    {
        $shortlist_jobs = ShortlistedApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'k.applied_application_enc_id', 'j.name type', 'a.id', 'a.created_on', 'a.shortlisted_enc_id', 'b.slug', 'd.name', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions','b.unclaimed_organization_enc_id','e.logo','e.logo_location','e.initials_color',
                'auo.positions as unclaim_positions',
                'uo.name as unclaim_org_name',
                'uo.logo as unclaim_org_logo',
                'uo.logo_location as unclaim_org_logo_location',
                'uo.initials_color as unclaim_org_initials_color',
            ])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.shortlisted' => 1])
            ->joinWith(['applicationEnc b' => function ($a) {
                $a->joinWith(['appliedApplications k' => function ($y) {
                    $y->onCondition(['k.created_by' => Yii::$app->user->identity->user_enc_id, 'k.is_deleted' => 0]);
                }], false);
                $a->onCondition(['b.is_deleted' => 0, 'b.status' => 'ACTIVE', 'b.application_for' =>1]);
            }], false)
            ->innerJoin(EmployerApplications::tableName() . 'as ea', 'ea.application_enc_id = a.application_enc_id')
            ->leftJoin(ApplicationUnclaimOptions::tableName() . 'as auo', 'auo.application_enc_id = a.application_enc_id')
            ->leftJoin(UnclaimedOrganizations::tableName() . 'as uo', 'uo.organization_enc_id = ea.unclaimed_organization_enc_id')
            ->leftJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->leftJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->leftJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->leftJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = a.application_enc_id')
            ->leftJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->groupBy(['b.application_enc_id'])
            ->having(['type' => 'Internships'])
            ->limit(6)
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $total_shortlist = ShortlistedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'a.shortlisted_enc_id'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.shortlisted' => 1])
            ->joinWith(['applicationEnc b' => function ($a) {
                $a->joinWith(['appliedApplications k' => function ($y) {
                    $y->onCondition(['k.created_by' => Yii::$app->user->identity->user_enc_id, 'k.is_deleted' => 0]);
                }], false);
                $a->onCondition(['b.is_deleted' => 0, 'b.status' => 'ACTIVE', 'b.application_for' =>1]);
            }], false)
            ->leftJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->groupBy(['b.application_enc_id'])
            ->having(['type' => 'Internships'])
            ->count();
        $applied_applications = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'a.id', 'a.application_enc_id as app_id', 'a.status', 'a.created_by', 'd.name as title', 'b.slug', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions','b.unclaimed_organization_enc_id','e.logo','e.logo_location','e.initials_color'])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['or',
                ['a.status' => 'Pending'],
                ['a.status' => 'Accepted']
            ])
            ->andwhere(['b.is_deleted' => 0, 'b.application_for' =>1, 'b.status' => 'Active'])
            ->andwhere(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = b.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
            ->having(['type' => 'Internships'])
            ->groupBy(['b.application_enc_id'])
            ->limit(6)
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $total_applied = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'a.id', 'a.status', 'a.created_by', 'd.name as title', 'b.slug', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions'])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['or',
                ['a.status' => 'Pending'],
                ['a.status' => 'Accepted']
            ])
            ->andwhere(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0])
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = b.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
//            ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
            ->andWhere(['b.status' => 'ACTIVE', 'b.is_deleted' => 0, 'b.application_for' =>1])
            ->having(['type' => 'Internships'])
            ->groupBy(['b.application_enc_id'])
            ->count();

        $total_pending = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'a.id', 'a.status', 'a.created_by', 'd.name as title', 'b.slug', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions', 'a.is_deleted'])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.status' => 'Pending', 'a.is_deleted' => 0])
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = b.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->andWhere(['b.status' => 'ACTIVE', 'b.is_deleted' => 0, 'b.application_for' =>1])
//            ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
            ->having(['type' => 'Internships'])
            ->groupBy(['b.application_enc_id'])
            ->count();

        $shortlist_org = FollowedOrganizations::find()
            ->alias('a')
            ->select(['az.organization_enc_id', 'a.organization_enc_id', 'az.establishment_year', 'a.followed_enc_id', 'az.name as org_name', 'c.industry', 'az.logo', 'az.logo_location', 'az.slug'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.followed' => 1])
            ->joinWith(['organizationEnc az'=> function($az){
                $az->joinWith(['employerApplications b' => function ($x) {
                    $x->select(['b.organization_enc_id', 'b.application_type_enc_id', 'h.name', 'COUNT(distinct b.application_enc_id) as total_application']);
                    $x->joinWith(['applicationTypeEnc h' => function ($x2) {
                        $x2->distinct();
                        $x2->groupBy(['h.name']);
                        $x2->orderBy([new \yii\db\Expression('FIELD (h.name, "Jobs") DESC, h.name DESC')]);
                    }], true);
                    $x->groupBy(['b.application_enc_id']);
                    $x->onCondition(['b.is_deleted' => 0, 'b.application_for' => 1, 'b.status' => 'ACTIVE']);
                }], true);
                $az->groupBy(['az.organization_enc_id']);
                $az->distinct();
            }])
            ->leftJoin(Industries::tableName() . 'as c', 'c.industry_enc_id = az.industry_enc_id')
            ->groupBy(['a.followed_enc_id'])
            ->distinct()
            ->orderBy(['a.id' => SORT_DESC])
            ->limit(6)
            ->asArray()
            ->all();

        $total_shortlist_org = FollowedOrganizations::find()
            ->alias('a')
            ->select(['b.establishment_year', 'a.followed_enc_id', 'b.name as org_name', 'c.industry', 'b.logo', 'b.logo_location', 'b.slug'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.followed' => 1])
            ->innerJoin(Organizations::tableName() . 'as b', 'b.organization_enc_id = a.organization_enc_id')
            ->leftJoin(Industries::tableName() . 'as c', 'c.industry_enc_id = b.industry_enc_id')
            ->orderBy(['a.id' => SORT_DESC])
            ->count();

        $review_list = ReviewedApplications::find()
            ->alias('a')
            ->select(['a.id', 'a.review_enc_id', 'k.applied_application_enc_id','b.unclaimed_organization_enc_id','a.review', 'b.application_enc_id', 'c.name type', 'g.name as org_name', 'g.establishment_year', 'SUM(h.positions) as positions', 'd.parent_enc_id', 'd.category_enc_id', 'e.name title', 'b.slug', 'f.name parent_category', 'f.icon', 'f.icon_png','g.logo','g.logo_location','g.initials_color','auo.positions as unclaim_positions','uo.name as unclaim_org_name'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.review' => 1])
            ->joinWith(['applicationEnc b' => function ($b) {
                $b->distinct();
                $b->joinWith(['applicationTypeEnc c']);
                $b->joinWith(['title d' => function ($c) {
                    $c->joinWith(['categoryEnc e']);
                    $c->joinWith(['parentEnc f']);
                }]);
                $b->joinWith(['applicationUnclaimOptions auo']);
                $b->joinWith(['organizationEnc g']);
                $b->joinWith(['unclaimedOrganizationEnc as uo']);
                $b->joinWith(['applicationPlacementLocations h']);
//                $b->groupBy(['h.application_enc_id']);
                $b->joinWith(['appliedApplications k' => function ($y) {
                    $y->onCondition(['k.created_by' => Yii::$app->user->identity->user_enc_id, 'k.is_deleted' => 0]);
                }], false);
                $b->onCondition(['b.is_deleted' => 0, 'b.status' => 'ACTIVE', 'b.application_for' =>1]);
            }], false)
            ->having(['type' => 'Internships'])
            ->limit(6)
            ->orderBy(['a.id' => SORT_DESC])
            ->groupBy(['b.application_enc_id'])
            ->asArray()
            ->all();


        $total_reviews = ReviewedApplications::find()
            ->alias('a')
            ->select(['a.review_enc_id', 'b.application_enc_id', 'c.name type'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.review' => 1])
            ->joinWith(['applicationEnc b' => function ($b) {
                $b->onCondition(['b.is_deleted' => 0]);
                $b->joinWith(['applicationTypeEnc c']);
            }], false)
            ->having(['type' => 'Internships'])
            ->groupBy(['b.application_enc_id'])
            ->count();

        $accepted_jobs = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'g.slug as org_slug', 'h.icon as job_icon', 'c.slug', 'g.name as org_name', 'a.status', 'f.name as title', 'a.application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active', 'SUM(k.positions) as positions','g.logo','g.logo_location','g.initials_color'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as g', 'g.organization_enc_id = c.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as k', 'k.application_enc_id = c.application_enc_id')
            ->where(['b.user_enc_id' => Yii::$app->user->identity->user_enc_id, 'a.status' => 'Accepted', 'a.is_deleted' => 0])
            ->andWhere(['c.status' => 'ACTIVE', 'c.is_deleted' => 0, 'c.application_for' =>1])
            ->having(['type' => 'Internships'])
            ->groupBy('a.applied_application_enc_id')
            ->limit(6)
            ->asArray()
            ->all();
        $total_accepted = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'g.slug as org_slug', 'h.icon as job_icon', 'c.slug', 'g.name as org_name', 'a.status', 'f.name as title', 'a.applied_application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active', 'SUM(k.positions) as positions'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as g', 'g.organization_enc_id = c.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as k', 'k.application_enc_id = c.application_enc_id')
            ->where(['b.user_enc_id' => Yii::$app->user->identity->user_enc_id, 'a.status' => 'Accepted', 'a.is_deleted' => 0])
            ->having(['type' => 'Internships'])
            ->groupBy('a.applied_application_enc_id')
            ->count();

        $application_id = DropResumeApplications::find()
            ->alias('a')
            ->innerJoinWith(['dropResumeApplicationTitles b' => function ($x) {
                $x->joinWith(['title0 c'], false);
                $x->andWhere(['c.assigned_to' => 'Internships']);
            }], false)
            ->where(['a.user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->andWhere(['a.status' => 1])
            ->asArray()
            ->all();


        $application_enc_id = [];
        foreach ($application_id as $app) {
            array_push($application_enc_id, $app['application_enc_id']);
        }

        $shortlist1 = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.organization_enc_id', 'a.title', 'b.name as org_name', 'a.slug', 'c.category_enc_id', 'd.name', 'd.icon','b.logo','b.logo_location','b.initials_color'])
            ->joinWith(['appliedApplications e' => function ($y) {
                $y->onCondition(['e.created_by' => Yii::$app->user->identity->user_enc_id, 'e.is_deleted' => 0]);
            }], true)
            ->where(['IN', 'a.application_enc_id', $application_enc_id])
            ->andWhere(['a.status' => 'ACTIVE', 'a.is_deleted' => 0, 'a.application_for' =>1])
            ->joinWith(['title c' => function ($x) {
                $x->joinWith(['categoryEnc d'], false);
            }], false)
            ->joinWith(['organizationEnc b'], false)
            ->asArray()
            ->all();

        $userLocation = UserPreferences::find()
            ->alias('a')
            ->select(['a.preference_enc_id'])
            ->joinWith(['userPreferredLocations pl' => function($pl){
                $pl->select(['pl.preference_enc_id','pl.preferred_location_enc_id', 'pl.city_enc_id', 'c.name']);
                $pl->joinWith(['cityEnc c'], false);
                $pl->onCondition(['pl.is_deleted' => 0]);
            }])
            ->where([
                'a.created_by' => Yii::$app->user->identity->user_enc_id,
                'a.assigned_to' => 'Internships'
            ])
            ->asArray()
            ->one();

        $locations = [];
        foreach ($userLocation['userPreferredLocations'] as $location){
            array_push($locations, $location['name']);
        }

        $userSkills = UserSkills::find()
            ->alias('a')
            ->select(['a.user_skill_enc_id', 'a.skill_enc_id', 'se.skill'])
            ->joinWith(['skillEnc se'], false)
            ->where([
                'a.created_by' => Yii::$app->user->identity->user_enc_id,
                'a.is_deleted' => 0,
            ])
            ->asArray()
            ->all();

        $skills = [];
        foreach ($userSkills as $skill){
            array_push($skills, $skill['skill']);
        }
        $options['limit'] = 3;
        $options['location'] = implode(',', $locations);
        $options['skills'] = implode(',', $skills);
//        $options['orderBy'] = new Expression('rand()');

        $internshipsByLocation = ApplicationCards::internships($options);
        unset($options['location']);
        $internshipsBySkills = ApplicationCards::internships($options);


        return $this->render('dashboard/individual', [
            'shortlisted' => $shortlist_jobs,
            'applied' => $applied_applications,
            'shortlist_org' => $shortlist_org,
            'reviewlist' => $review_list,
            'total_reviews' => $total_reviews,
            'total_shortlist_org' => $total_shortlist_org,
            'total_applied' => $total_applied,
            'total_shortlist' => $total_shortlist,
            'total_pending' => $total_pending,
            'accepted_jobs' => $accepted_jobs,
            'total_accepted' => $total_accepted,
            'shortlist1' => $shortlist1,
            'internshipsByLocation' => $internshipsByLocation,
            'preferredLocations' => implode(',', $locations),
            'internshipsBySkills' => $internshipsBySkills,
            'preferredSkills' => implode(',', $skills),
        ]);
    }

    public function actionShortlistedResume()
    {

        $application_id = DropResumeApplications::find()
            ->alias('a')
            ->innerJoinWith(['dropResumeApplicationTitles b' => function ($x) {
                $x->joinWith(['title0 c'], false);
                $x->andWhere(['c.assigned_to' => 'Internships']);
            }], false)
            ->where(['a.user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->andWhere(['a.status' => 1])
            ->asArray()
            ->all();


        $application_enc_id = [];
        foreach ($application_id as $app) {
            array_push($application_enc_id, $app['application_enc_id']);
        }

        $shortlist1 = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.organization_enc_id', 'a.title', 'b.name as org_name', 'a.slug', 'c.category_enc_id', 'd.name', 'd.icon'])
            ->joinWith(['appliedApplications e' => function ($y) {
                $y->onCondition(['e.created_by' => Yii::$app->user->identity->user_enc_id, 'e.is_deleted' => 0]);
            }], true)
            ->where(['IN', 'a.application_enc_id', $application_enc_id])
            ->andWhere(['a.status' => 'ACTIVE', 'a.is_deleted' => 0, 'a.application_for' =>1])
            ->joinWith(['title c' => function ($x) {
                $x->joinWith(['categoryEnc d'], false);
            }], false)
            ->joinWith(['organizationEnc b'], false)
            ->asArray()
            ->all();

        return $this->render('individual/shortlist-resume', [
            'shortlisted_resume' => $shortlist1,
        ]);
    }

    public function actionExtendsDate()
    {
        $model = new ExtendsJob();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    private function __organizationDashboard()
    {

        $coaching_category = new WidgetTutorials();
        $userApplied = new UserAppliedApplication();
        $model = new ExtendsJob();
        $catModel = new ApplicationForm();
        $tutorial_cat = $coaching_category->find()
            ->where(['name' => "organization_internships_stats "])
            ->asArray()
            ->one();
        $user_viewed = new UserCoachingTutorials();
        $user_v = $user_viewed->find()
            ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'is_viewed' => 1, 'tutorial_enc_id' => $tutorial_cat["tutorial_enc_id"]])
            ->asArray()
            ->one();
        if (empty($user_v)) {
            $viewed = 0;
        } else {
            $viewed = 1;
        }
        return $this->render('dashboard/organization', [
            'questionnaire' => $this->__questionnaire(4),
            'applications' => $this->__internships(9),
            'erexx_applications' => $this->__erexxInternships(9),
            'closed_application' => $this->__closedinternships(8),
            'interview_processes' => $this->__interviewProcess(4),
            'applied_applications' => $userApplied->getUserDetails('Internships', 10),
            'total_applied' => $userApplied->total_applied($type = 'Internships'),
            'primary_fields' => $catModel->getPrimaryFields('Internships'),
            'model' => $model,
            'internships' => $this->__getApplications("Internships"),
            'viewed' => $viewed,
            'shortlistedApplicants' => $this->shortlistedApplicants(3)
        ]);
    }

    private function __getApplications($type)
    {
        $application = \common\models\ApplicationTemplates::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.title', 'zz.name as cat_name', 'z1.icon_png'])
            ->joinWith(['title0 z' => function ($z) {
                $z->joinWith(['categoryEnc zz']);
                $z->joinWith(['parentEnc z1']);
            }], false)
            ->joinWith(['applicationTypeEnc f'], false)
            ->where(['f.name' => $type, 'a.is_deleted' => 0, 'a.status' => "Active"])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->limit(4)
            ->all();

        return $application;
    }

    private function getCategories()
    {
        $primaryfields = Categories::find()
            ->alias('a')
            ->select(['a.name', 'a.category_enc_id', 'CONCAT("' . Url::to('@commonAssets/categories/svg/') . '", a.icon) icon'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['b.assigned_to' => 'Internships', 'b.parent_enc_id' => NULL])
            ->asArray()
            ->all();
        return $primaryfields;
    }

    private function __organizationJobs()
    {
        return $this->render('list/organization', [
            'applications' => $this->__internships(),
        ]);
    }

    public function actionActiveInternships()
    {
        return $this->render('list/organization', [
            'applications' => $this->__internships(),
        ]);
    }

    public function actionActiveErexxInternships()
    {
        return $this->render('list/organization', [
            'applications' => $this->__erexxInternships(),
        ]);
    }

    private function __internships($limit = NULL)
    {
        $options = [
            'applicationType' => 'internships',
            'where' => [
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.status' => 'Active',
//                'a.application_for' => 1,
            ],
            'andWhere' => ['or',
                ['a.application_for' => 0],
                ['a.application_for' => 1]
            ],
//            'having' => [
//                '>=', 'a.last_date', date('Y-m-d')
//            ],
            'orderBy' => [
                'a.published_on' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $applications = new \account\models\applications\Applications();
        return $applications->getApplications($options);
    }

    private function __internshipss($limit = NULL)
    {
        $options = [
            'applicationType' => 'internships',
            'where' => [
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.status' => 'Active',
                'a.application_for' => 1,
            ],
//            'having' => [
//                '>=', 'a.last_date', date('Y-m-d')
//            ],
            'orderBy' => [
                'a.published_on' => SORT_DESC,
            ],
            'limit' => $limit,
            'options' => [
                'placement_locations' => true,
            ],
        ];

        $applications = new \account\models\applications\Applications();
        return $applications->getApplications($options);
    }

    private function __erexxInternships($limit = NULL)
    {
        $options = [
            'applicationType' => 'internships',
            'where' => [
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.status' => 'Active',
            ],
            'andWhere' => ['or',
                ['a.application_for' => 0],
                ['a.application_for' => 2]
            ],
//            'having' => [
//                '>=', 'a.last_date', date('Y-m-d')
//            ],
            'orderBy' => [
                'a.published_on' => SORT_DESC,
            ],
            'errex' => true,
            'limit' => $limit,
        ];

        $applications = new \account\models\applications\Applications();
        return $applications->getApplications($options);
    }

    private function __closedinternships($limit = NULL,$page = 1)
    {
        $options = [
            'applicationType' => 'Internships',
            'where' => [
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.status' => 'Closed',
            ],
//            'having' => [
//                '<', 'a.last_date', date('Y-m-d')
//            ],
            'orderBy' => [
                'a.published_on' => SORT_DESC,
            ],
            'limit' => $limit,
            'pageNumber' => $page,
        ];

        $applications = new \account\models\applications\Applications();
        return $applications->getApplications($options);
    }

    private function __interviewProcess($limit = NULL)
    {
        $options = [
            'where' => [
                'organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
            ],
            'orderBy' => [
                'created_on' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $processess = new \account\models\processes\OrganizationInterviewProcesses();
        return $processess->getProcesses($options);
    }

    private function __questionnaire($limit = NULL)
    {
        $options = [
            'questionnaireType' => 2,
            'where' => [
                'organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
            ],
            'orderBy' => [
                'created_on' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $questionnaire = new \account\models\questionnaire\OrganizationQuestionnaire();
        return $questionnaire->getQuestionnaire($options);
    }

    private function __candidateApplications($limit = NULL)
    {
        $candidate_applications = AppliedApplications::find()
            ->alias('a')
            ->select(['COUNT(CASE WHEN g.is_completed = 1 THEN 1 END) as active', 'COUNT(g.is_completed) as total', 'f.first_name', 'a.applied_application_enc_id', 'a.created_by', 'a.application_enc_id', 'b.title', 'f.username', 'd.name', 'e.icon', 'f.first_name', 'f.last_name', 'f.image', 'f.image_location'])
            ->joinWith(['applicationEnc b' => function ($b) {
                $b->andWhere(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]);
                $b->joinWith(['title c' => function ($c) {
                    $c->joinWith(['categoryEnc d'], false);
                    $c->joinWith(['parentEnc e'], false);
                }], false);
            }], false)
            ->joinWith(['createdBy f'], false)
            ->joinWith(['appliedApplicationProcesses g'])
            ->where(['a.status' => 'Pending', 'a.status' => 'Incomplete'])
            ->having(['active' => 0])
            ->groupBy('a.applied_application_enc_id')
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        $total_applications = AppliedApplications::find()
            ->alias('a')
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as f', 'f.application_type_enc_id = b.application_type_enc_id')
            ->where(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
            ->andWhere(['b.is_deleted' => 0])
            ->andWhere(['f.name' => 'Internships'])
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Users::tableName() . 'as e', 'e.user_enc_id = a.created_by')
            ->groupBy(['a.applied_application_enc_id'])
            ->count();

        return [
            'total' => $total_applications,
            'list' => $candidate_applications,
        ];
    }

    public function actionCampusPlacement()
    {
        if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {

            $colleges = Organizations::find()
                ->alias('a')
                ->distinct()
                ->select(['a.organization_enc_id', 'a.organization_enc_id college_enc_id', 'a.name', 'a.initials_color color', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo', 'e.name city'])
                ->innerJoinWith(['businessActivityEnc b' => function ($b) {
                    $b->onCondition(["b.business_activity" => "College"]);
                }], false)
                ->joinWith(['organizationOtherDetails c' => function ($c) {
                    $c->joinWith(['locationEnc e'], true);
                }], false)
                ->where([
                    "a.is_erexx_approved" => 1,
                    "a.has_placement_rights" => 1,
                    "a.status" => "Active",
                    "a.is_deleted" => 0,
                ])
                ->asArray()
                ->all();
            $type = 'internships';
            return $this->render('/employer-applications/campus-placement', [
                'applications' => $this->__internshipss(),
                'colleges' => $colleges,
                'type' => $type,
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page Not Found.'));
        }
    }


    public function actionViewTemplates()
    {
        if (!empty(Yii::$app->user->identity->organization)) {
            $application = \common\models\ApplicationTemplates::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.title', 'zz.name as cat_name', 'z1.icon_png'])
                ->joinWith(['title0 z' => function ($z) {
                    $z->joinWith(['categoryEnc zz']);
                    $z->joinWith(['parentEnc z1']);
                }], false)
                ->joinWith(['applicationTypeEnc f'], false)
                ->where(['f.name' => "Internships"])
//            ->groupBy('zz.name')
                ->asArray()
                ->all();
            return $this->render('internships-templates', [
                'jobs' => $application,
            ]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionSubmitErexxApplications()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            foreach ($data['applications'] as $app) {
                foreach ($data['colleges'] as $clg) {
                    $utilitiesModel = new Utilities();
                    $errexApplication = new ErexxEmployerApplications();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $errexApplication->application_enc_id = $utilitiesModel->encrypt();
                    $errexApplication->employer_application_enc_id = $app;
                    $errexApplication->college_enc_id = $clg;
                    $errexApplication->created_on = date('Y-m-d H:i:s');
                    $errexApplication->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$errexApplication->save()) {
                        return $response = [
                            'status' => 201,
                            'title' => 'Error',
                            'message' => 'An error has occured. Please Try again later.',
                        ];
                    }
                }
                if (!$this->__updateApplicationFor($app, $data['subscribed-to-all'])) {
                    return $response = [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'An error has occured. Please Try again later.',
                    ];
                }
            }

            $this->__addCollege($data['colleges']);

            return $response = [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Application added for Campus Placement',
            ];
        }
    }

    public function actionApplicationCollegesSubmit()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $application = EmployerApplications::find()
                ->where(['application_enc_id' => $data['app_id']])
                ->one();
            $application->application_for = 0;
            $application->last_updated_by = Yii::$app->user->identity->user_enc_id;
            if ($data['college'] == 1) {
                $application->for_all_colleges = 1;
                if ($application->update()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Application added for Campus Placement',
                    ];
                }
            }
            if ($data['college'] == 0) {
                $application->update();
                foreach ($data['colleges'] as $clg) {
                    $utilitiesModel = new Utilities();
                    $errex_application = new ErexxEmployerApplications();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $errex_application->application_enc_id = $utilitiesModel->encrypt();
                    $errex_application->employer_application_enc_id = $data['app_id'];
                    $errex_application->college_enc_id = $clg;
                    $errex_application->created_on = date('Y-m-d H:i:s');
                    $errex_application->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$errex_application->save()) {
                        return $response = [
                            'status' => 201,
                            'title' => 'Error',
                            'message' => 'An error has occured. Please Try again later.',
                        ];
                    }
                }
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Application added for Campus Placement',
                ];
            } else {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occured. Please Try again later.',
                ];
            }
        }
    }

    private function __updateApplicationFor($app, $for)
    {
        if ($for) {
            $update = Yii::$app->db->createCommand()
                ->update(EmployerApplications::tableName(), ['application_for' => 0, 'for_all_colleges' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app])
                ->execute();
        } else {
            $update = Yii::$app->db->createCommand()
                ->update(EmployerApplications::tableName(), ['application_for' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app])
                ->execute();
        }
        if ($update) {
            return true;
        } else {
            return false;
        }
    }

    private function __addCollege($colleges)
    {

        foreach ($colleges as $clg) {
            $erexx_collab = ErexxCollaborators::find()
                ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'college_enc_id' => $clg, 'status' => 'Active', 'is_deleted' => 0])
                ->one();

            if (empty($erexx_collab)) {
                $utilitiesModel = new Utilities();
                $erexxCollaboratorsModel = new ErexxCollaborators();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $erexxCollaboratorsModel->collaboration_enc_id = $utilitiesModel->encrypt();
                $erexxCollaboratorsModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                $erexxCollaboratorsModel->college_enc_id = $clg;
                $erexxCollaboratorsModel->created_on = date('Y-m-d H:i:s');
                $erexxCollaboratorsModel->created_by = Yii::$app->user->identity->user_enc_id;
                $erexxCollaboratorsModel->save();
            }
        }
    }

    public function actionAppliedApplications()
    {
        if (!empty(Yii::$app->user->identity->organization)) {
            $userApplied = new UserAppliedApplication();
            $applied_users = $userApplied->getUserOtherDetails('Internships');
            $reasons = RejectionReasons::find()
                ->select(['rejection_reason_enc_id', 'reason'])
                ->where(['reason_by' => 1, 'is_deleted' => 0, 'status' => 'Approved'])
                ->asArray()
                ->all();
            return $this->render('applied-applications', [
                'applied_user' => $applied_users,
                'reasons' => $reasons,
            ]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionAllAppliedApplications($aidk)
    {
        if (!empty(Yii::$app->user->identity->organization)) {
            $applied_users = $this->getAllAppliedApplications($aidk, 'Internships');
            $reasons = RejectionReasons::find()
                ->select(['rejection_reason_enc_id', 'reason'])
                ->where(['reason_by' => 1, 'is_deleted' => 0, 'status' => 'Approved'])
                ->asArray()
                ->all();
            return $this->render('all-applied-applications', [
                'fields' => $applied_users,
                'reasons' => $reasons,
            ]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    private function getAllAppliedApplications($aidk, $type)
    {
        $application_id = $aidk;
        $applied_users = EmployerApplications::find()
            ->distinct()
            ->alias('z')
            ->select(['y1.name job_title', 'z.organization_enc_id', 'z.application_enc_id', 'z.slug', 'x2.name type'])
            ->joinWith(['appliedApplications a' => function ($a) use ($type) {
                $a->select(['a.applied_application_enc_id', 'a.rejection_window', 'a.created_on', 'a.application_enc_id', 'a.status', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'a.created_by', 'a.resume_enc_id', 'e.resume', 'e.resume_location', 'b.user_enc_id', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image',]);
                $a->andWhere(['a.is_deleted' => 0]);
                $a->orderBy(['a.created_on' => SORT_DESC]);
                $a->groupBy(['a.applied_application_enc_id']);
                $a->joinWith(['resumeEnc e'], false);
                $a->joinWith(['appliedApplicationProcesses c' => function ($c) {
                    $c->joinWith(['fieldEnc d'], false);
                    $c->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon']);
                }]);
                $a->joinWith(['createdBy b' => function ($b) {
                    $b->joinWith(['userSkills b1' => function ($b1) {
                        $b1->select(['b1.skill_enc_id', 'b1.user_skill_enc_id', 'b2.skill', 'b1.created_by']);
                        $b1->joinWith(['skillEnc b2'], false);
                        $b1->onCondition(['b1.is_deleted' => 0]);
                    }]);
                    $b->joinWith(['userWorkExperiences b11' => function ($b11) {
                        $b11->select(['b11.created_by', 'b11.company', 'b11.is_current', 'b11.title']);
                    }]);
                    $b->joinWith(['userEducations b21' => function ($b21) {
                        $b21->select(['b21.user_enc_id', 'b21.institute', 'b21.degree']);
                    }]);
                    $b->joinWith(['userPreferredIndustries b31' => function ($b31) {
                        $b31->select(['b31.industry_enc_id', 'b32.industry', 'b31.created_by']);
                        $b31->joinWith(['industryEnc b32'], false);
                        $b31->onCondition(['b31.is_deleted' => 0]);
                    }]);
                }]);
                $a->joinWith(['candidateRejections cr' => function ($cr) {
                    $cr->select(['cr.rejection_type', 'cr.applied_application_enc_id', 'cr.candidate_rejection_enc_id']);
                    $cr->joinWith(['candidateConsiderJobs ccj' => function ($ccj) {
                        $ccj->select(['ccj.consider_job_enc_id', 'ccj.candidate_rejection_enc_id', 'ccj.application_enc_id']);
                        $ccj->joinWith(['applicationEnc ae' => function ($ae) {
                            $ae->select(['ae.application_enc_id', 'ae.slug', 'cc.name job_title', 'pe.icon']);
                            $ae->joinWith(['title bae' => function ($bae) {
                                $bae->joinWith(['categoryEnc cc'], false);
                                $bae->joinWith(['parentEnc pe'], false);
                            }], false);
                        }]);
                    }]);
                    $cr->groupBy(['cr.candidate_rejection_enc_id']);
                }]);
            }])
            ->joinWith(['applicationInterviewQuestionnaires aiq' => function ($a1) {
                $a1->groupBy(['aiq.interview_questionnaire_enc_id']);
                $a1->select(['aiq.application_enc_id', 'aiq.field_enc_id', 'aiq.interview_questionnaire_enc_id as id', 'aiq.questionnaire_enc_id as qid', 'aiq1.questionnaire_name as name', 'aiq2.field_label']);
                $a1->joinWith(['questionnaireEnc aiq1'], false);
                $a1->joinWith(['fieldEnc aiq2'], false);
            }])
            ->joinWith(['applicationTypeEnc x2' => function ($x2) use ($type) {
                $x2->andWhere(['x2.name' => $type], false);
            }], false)
            ->joinWith(['title0 y' => function ($y) {
                $y->joinWith(['categoryEnc y1'], false);
            }], false)
            ->andWhere(['z.application_enc_id' => $application_id, 'z.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'z.is_deleted' => 0])
            ->groupBy(['z.application_enc_id'])
            ->asArray()
            ->one();
//        print_r($applied_users);
//        exit();
        return $applied_users;
    }

    public function actionShortlistedCandidates()
    {
        return $this->render('list/shortlisted-candidates', [
            'shortlistedApplicants' => $this->shortlistedApplicants()
        ]);

    }

    private function shortlistedApplicants($limit = null)
    {
        $shortlistedApplicants = ShortlistedApplicants::find()
            ->alias('a')
            ->select(['a.shortlisted_applicant_enc_id', 'a.candidate_enc_id', 'a.application_enc_id',
                'CONCAT(b.first_name," ",b.last_name) name', 'b.initials_color', 'b.image', 'b.image_location',
                'b3.name city', 'b.username'
            ])
            ->joinWith(['candidateEnc b' => function ($b) {
                $b->joinWith(['cityEnc b3'], false);
            }], false)
            ->joinWith(['applicationEnc c' => function ($c) {
                $c->joinWith(['applicationTypeEnc f'], false);
            }], false)
            ->where(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'a.is_deleted' => 0, 'f.name' => 'Internships'])
            ->groupBy(['a.candidate_enc_id']);
        $count = $shortlistedApplicants->count();
        if ($limit != null) {
            $shortlistedApplicants->limit($limit);
        }
        $shortlistedApplicants = $shortlistedApplicants->asArray()
            ->all();

        foreach ($shortlistedApplicants as $key => $val) {
            $skills = UserSkills::find()
                ->alias('a')
                ->select(['b.skill'])
                ->joinWith(['skillEnc b'], false)
                ->where(['a.created_by' => $val['candidate_enc_id'], 'a.is_deleted' => 0])
                ->asArray()
                ->all();

            $applications = ShortlistedApplicants::find()
                ->alias('a')
                ->select(['ee.name title', 'a.application_enc_id', 'b.slug'])
                ->joinWith(['applicationEnc b' => function ($b) {
                    $b->joinWith(['title d' => function ($d) {
                        $d->joinWith(['parentEnc e']);
                        $d->joinWith(['categoryEnc ee']);
                    }], false);
                    $b->joinWith(['applicationTypeEnc f'], false);
                }], false)
                ->where([
                    'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                    'a.candidate_enc_id' => $val['candidate_enc_id'],
                    'a.is_deleted' => 0,
                    'f.name' => 'Internships'
                ])
                ->asArray()
                ->all();

            $shortlistedApplicants[$key]['skills'] = $skills;
            $shortlistedApplicants[$key]['applications'] = $applications;

        }

        return ['data' => $shortlistedApplicants, 'count' => $count];
    }
    public function actionAllClosedInternships(){
        $model = new ExtendsJob();
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;
            $params = Yii::$app->request->post();
            $limit = 10;
            $page = 1;
            if(isset($params['limit'])){
                $limit = $params['limit'];
            }
            if(isset($params['page'])){
                $page = $params['page'];
            }
            $data = $this->__closedinternships($limit, $page);
            if($data['total'] != 0){
                return['status' => 200, 'data' => $data];
            }
            else{
                return['status' => 404, 'message' => 'Page Not Found'];
            }
        }
        return $this->render('all-closed-internships',[
            'model' => $model
        ]);
    }
}
