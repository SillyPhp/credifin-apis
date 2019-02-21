<?php

namespace account\controllers;

use common\models\Cities;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\UploadedFile;
use common\models\Industries;
use common\models\Organizations;
use common\models\EmployerApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Users;
use common\models\AppliedApplications;
use common\models\ShortlistedApplications;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\ShortlistedOrganizations;
use common\models\ReviewedApplications;
use common\models\AppliedApplicationProcess;
use common\models\Utilities;
use account\models\jobs\JobApplicationForm;
use account\models\jobs\JobApplicationFormEdit;
use account\models\jobs\JobApplied;
use common\models\InterviewProcessFields;
use common\models\OrganizationEmployeeBenefits;


class JobsController extends Controller
{

    private function reviewZero(){
        $update = Yii::$app->db->createCommand()
            ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app_id])
            ->execute();
        if ($update) {
            return true;
        } else {
            return false;
        }
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

    public function actionCreate()
    {
        if (Yii::$app->user->identity->organization) {
            $model = new JobApplicationForm();
            $que = $model->getQuestionnnaireList();
            $loc_list = $model->getOrganizationLocationOffice();
            $int_list = $model->getOrganizationLocationInterview();
            $primary_cat = $model->getPrimaryFields();
            $industry = $model->getndustry();
            $process = $model->getInterviewProcess();
            $benefits = $model->getBenefits();
            if ($model->load(Yii::$app->request->post())) {
                $session_token = Yii::$app->request->post('n');
                if ($model->saveValues()) {
                    $session = Yii::$app->session;
                    if (!empty($session->get($session_token))) {
                        $session->remove($session_token);
                    }
                    return true;
                } else {
                    return false;
                }
            } else {
                return $this->render('application', [
                    'model' => $model, 'loc_list' => $loc_list,
                    'que' => $que,
                    'primary_cat' => $primary_cat,
                    'int_list' => $int_list,
                    'industry' => $industry,
                    'process' => $process,
                    'benefits' => $benefits,
                ]);
            }
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionApproveCandidate()
    {
        if (Yii::$app->request->isPost) {
            $f_id = Yii::$app->request->post('field_id');
            $app_id = Yii::$app->request->post('app_id');
            $update = Yii::$app->db->createCommand()
                ->update(AppliedApplicationProcess::tableName(), ['is_completed' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['field_enc_id' => $f_id, 'applied_application_enc_id' => $app_id])
                ->execute();
            $count = AppliedApplicationProcess::find()
                ->select(['COUNT(CASE WHEN is_completed = 1 THEN 1 END) as active', 'COUNT(is_completed) as total'])
                ->where(['applied_application_enc_id' => $app_id])
                ->asArray()
                ->one();
            if ($update == 1) {
                Yii::$app->db->createCommand()
                    ->update(AppliedApplications::tableName(), ['current_round' => ($count['active']+1), 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $app_id])
                    ->execute();
                $response = [
                    'status' => true,
                    'active' => $count['active']
                ];
                if ($count['active'] == $count['total']) {
                    $update_status = Yii::$app->db->createCommand()
                        ->update(AppliedApplications::tableName(), ['status' => 'Hired', 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $app_id])
                        ->execute();
                }
                return json_encode($response);
            } else {
                return false;
            }
        }
    }

    public function actionCancelApplication() {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');
            $update = Yii::$app->db->createCommand()
                ->update(AppliedApplications::tableName(), ['status' => 'Cancelled', 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionRejectCandidate()
    {
        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('app_id');
            $update = Yii::$app->db->createCommand()
                ->update(AppliedApplications::tableName(), ['status' => 'Rejected', 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $id])
                ->execute();
            if ($update == 1) {
                return true;
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
        $model = new JobApplicationForm();
        $questions_list = $model->getQuestionnnaireList();
        $p_list = $model->getOrganizationLocationOffice();
        $l_list = $model->getOrganizationLocationInterview();
        $primaryfields = $model->getPrimaryFields();
        $industries = $model->getndustry();
        $interview_process = $model->getInterviewProcess();
        $benefits = $model->getBenefits();
        if ($model->load(Yii::$app->request->post())) {
            $session_token = Yii::$app->request->post('n');
            if ($model->saveValues()) {
                $session = Yii::$app->session;
                if (!empty($session->get($session_token))) {
                    $session->remove($session_token);
                }
                return true;
            } else {
                return false;
            }
        } else {
            $application = $model->getCloneData($aidk);
            return $this->render('clone', ['data' => $application,
                'model' => $model, 'location_list' => $p_list,
                'questions_list' => $questions_list,
                'primaryfields' => $primaryfields,
                'inter_loc' => $l_list,
                'industries' => $industries,
                'process_list' => $interview_process,
                'benefit' => $benefits,
            ]);
        }
    }

    public function actionPreview()
    {
        $model = new JobApplicationForm();
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

    public function actionEdit($aidk)
    { // this is in progress will update soon
        $model = new JobApplicationFormEdit();
        $object = new JobApplicationForm();
        if ($model->load(Yii::$app->request->post())) {
            return json_encode($model->updateValues($aidk));

        } else {
            $application = $object->getCloneData($aidk);
            $questions_list = $object->getQuestionnnaireList();
            $p_list = $object->getOrganizationLocationOffice();
            $l_list = $object->getOrganizationLocationInterview();
            $primaryfields = $object->getPrimaryFields();
            $industries = $object->getndustry();
            $interview_process = $object->getInterviewProcess();
            $benefits = $object->getBenefits();
            return $this->render('application_edit', ['data' => $application,
                'model' => $model, 'location_list' => $p_list,
                'questions_list' => $questions_list,
                'primaryfields' => $primaryfields,
                'inter_loc' => $l_list,
                'industries' => $industries,
                'process_list' => $interview_process,
                'benefit' => $benefits,
            ]);
        }
    }

    public function actionDeleteApplication()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');
            $update = Yii::$app->db->createCommand()
                ->update(EmployerApplications::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionReviewed()
    {
        $review_list = ReviewedApplications::find()
            ->alias('a')
            ->select(['a.id','a.review_enc_id','a.review','b.application_enc_id','c.name type','g.name as org_name','g.establishment_year','SUM(h.positions) as positions','d.parent_enc_id','d.category_enc_id','e.name title','e.slug','f.name parent_category','f.icon','f.icon_png'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.review' => 1 ])
            ->joinWith(['applicationEnc b' => function($b){
                $b->distinct();
                $b->joinWith(['applicationTypeEnc c']);
                $b->joinWith(['title d' => function($c){
                    $c->joinWith(['categoryEnc e']);
                    $c->joinWith(['parentEnc f']);
                }]);
                $b->joinWith(['organizationEnc g']);
                $b->joinWith(['applicationPlacementLocations h']);
                $b->groupBy(['h.application_enc_id']);
            }],false)
            ->having(['type' => 'Jobs'])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        return $this->render('individual/review-jobs', [
            'reviewlist' => $review_list,
        ]);
    }

    public function actionShortlisted()
    {
        $shortlist_jobs = ShortlistedApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id','j.name type','a.id','a.created_on','a.shortlisted_enc_id', 'b.slug', 'd.name', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.shortlisted' => 1])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = a.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->groupBy(['b.application_enc_id'])
            ->having(['type' => 'Jobs'])
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
            ->select(['j.name type','g.slug as org_slug', 'h.icon as job_icon', 'c.slug', 'g.name as org_name', 'a.status', 'f.name as title', 'a.applied_application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active'])
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
            ->andWhere(['b.user_enc_id' => Yii::$app->user->identity->user_enc_id])
            ->having(['type' => 'Jobs'])
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
            ->select(['j.name type','g.slug as org_slug', 'h.icon as job_icon', 'c.slug', 'g.name as org_name', 'a.status', 'f.name as title', 'a.applied_application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active','SUM(k.positions) as positions'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as g', 'g.organization_enc_id = c.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as k', 'k.application_enc_id = c.application_enc_id')
            ->where(['b.user_enc_id' => Yii::$app->user->identity->user_enc_id, 'a.status' => 'Accepted'])
            ->having(['type' => 'Jobs'])
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
            ->select(['b.application_enc_id','j.name type','a.id','a.status','a.created_by', 'd.name as title', 'b.slug', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions','a.is_deleted'])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.status' => 'Pending', 'a.is_deleted' => 0])
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = b.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
            ->having(['type' => 'Jobs'])
            ->groupBy(['b.application_enc_id'])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();


        return $this->render('individual/pending-jobs', [
            'pending' => $pending_applications,
        ]);
    }

    public function actionPendingDelete(){
        if (Yii::$app->request->isPost) {
            $rmv_id = Yii::$app->request->post('rmv_id');
            $update = Yii::$app->db->createCommand()
                ->update(AppliedApplications::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $rmv_id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionJobsApply()
    {
        $model = new JobApplied();
        if (Yii::$app->request->isPost) {
            if (!Yii::$app->user->isGuest) {
                if (Yii::$app->request->post("check") == 1) {
                    $arr_loc = Yii::$app->request->post("json_loc");
                    $model->id = Yii::$app->request->post("application_enc_id");
                    $model->resume_list = Yii::$app->request->post("resume_enc_id");
                    $model->location_pref = $arr_loc;
                    $model->status = Yii::$app->request->post("status");
                    if ($res = $model->saveValues()) {
                        return json_encode($res);
                    } else {
                         $status = [
                            'status' => false,
                        ];
                        return json_encode($status);
                    }
                } else if (Yii::$app->request->post("check") == 0) {
                    $arr_loc = Yii::$app->request->post("json_loc");
                    $model->resume_file = UploadedFile::getInstance($model, 'resume_file');
                    $model->id = Yii::$app->request->post("id");
                    $model->location_pref = $arr_loc;
                    $model->status = Yii::$app->request->post("status");
                    if ($res = $model->upload()) {
                        return json_encode($res);
                    } else {
                        $status = [
                            'status' => false,
                        ];
                        return json_encode($status);
                    }
                }
            }
        }
    }

    public function actionReviewDelete()
    {
        if (Yii::$app->request->isPost) {
            $rmv_id = Yii::$app->request->post('rmv_id');
            $update = Yii::$app->db->createCommand()
                ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $rmv_id, 'created_by' => Yii::$app->user->identity->user_enc_id])
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
                ->update(ShortlistedApplications::tableName(), ['shortlisted' => 0, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $rmv_id])
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
                    $shortlist->created_on = date('Y-m-d h:i:s');
                    $shortlist->created_by = Yii::$app->user->identity->user_enc_id;
                    $shortlist->last_updated_on = date('Y-m-d h:i:s');
                    $shortlist->last_updated_by = Yii::$app->user->identity->user_enc_id;
                    if ($shortlist->save()) {
                        $update = Yii::$app->db->createCommand()
                            ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app_id, 'review' => 1])
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
                        ->update(ShortlistedApplications::tableName(), ['shortlisted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $app_id])
                        ->execute();
                    if ($update == 1) {
                        $update1 = Yii::$app->db->createCommand()
                        ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app_id, 'review' => 1])
                        ->execute();
                        if($update1 == 1) {
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
                        ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app_id, 'review' => 1])
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
                ->update(ShortlistedOrganizations::tableName(), ['shortlisted' => 0, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['shortlisted_enc_id' => $rmv_id])
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
                    $shortlist->created_on = date('Y-m-d h:i:s');
                    $shortlist->created_by = Yii::$app->user->identity->user_enc_id;
                    $shortlist->last_updated_on = date('Y-m-d h:i:s');
                    $shortlist->last_updated_by = Yii::$app->user->identity->user_enc_id;
                    if ($shortlist->save()) {
                        return 'short';
                    } else {
                        return false;
                    }
                } else if ($status == 1) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ShortlistedApplications::tableName(), ['shortlisted' => 0, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $app_id])
                        ->execute();
                    if ($update == 1) {
                        return 'unshort';
                    }
                } else if ($status == 0) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ShortlistedApplications::tableName(), ['shortlisted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $app_id])
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
            ->select(['a.application_enc_id','j.name type','a.id','a.created_on','a.shortlisted_enc_id', 'b.slug', 'd.name', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.shortlisted' => 1])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = a.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->groupBy(['b.application_enc_id'])
            ->having(['type' => 'Jobs'])
            ->limit(8)
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $total_shortlist = ShortlistedApplications::find()
            ->alias('a')
            ->select(['j.name type','a.id','a.created_on','a.shortlisted_enc_id', 'b.slug', 'd.name', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.shortlisted' => 1])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = a.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->groupBy(['b.application_enc_id'])
            ->having(['type' => 'Jobs'])
            ->count();
        $applied_applications = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type','a.id','a.application_enc_id as app_id','a.status','a.created_by', 'd.name as title', 'b.slug', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions'])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['or',
                ['a.status' => 'Pending'],
                ['a.status' => 'Accepted']
            ])
            ->andwhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = b.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
            ->having(['type' => 'Jobs'])
            ->groupBy(['b.application_enc_id'])
            ->limit(8)
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $total_applied = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type','a.id','a.status','a.created_by', 'd.name as title', 'b.slug', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions'])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['or',
                ['a.status' => 'Pending'],
                ['a.status' => 'Accepted']
            ])
            ->andwhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = b.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
            ->having(['type' => 'Jobs'])
            ->groupBy(['b.application_enc_id'])
            ->count();

        $total_pending = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type','a.id','a.status','a.created_by', 'd.name as title', 'b.slug', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions', 'a.is_deleted'])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.status' => 'Pending', 'a.is_deleted' => 0])
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = b.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
            ->having(['type' => 'Jobs'])
            ->groupBy(['b.application_enc_id'])
            ->count();

        $shortlist_org = ShortlistedOrganizations::find()
            ->alias('a')
            ->select(['b.establishment_year','a.shortlisted_enc_id', 'b.name as org_name', 'c.industry', 'b.logo', 'b.logo_location', 'b.slug'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.shortlisted' => 1])
            ->innerJoin(Organizations::tableName() . 'as b', 'b.organization_enc_id = a.organization_enc_id')
            ->innerJoin(Industries::tableName() . 'as c', 'c.industry_enc_id = b.industry_enc_id')
            ->orderBy(['a.id' => SORT_DESC])
            ->limit(8)
            ->asArray()
            ->all();
        $total_shortlist_org = ShortlistedOrganizations::find()
            ->alias('a')
            ->select(['b.establishment_year','a.shortlisted_enc_id', 'b.name as org_name', 'c.industry', 'b.logo', 'b.logo_location', 'b.slug'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.shortlisted' => 1])
            ->innerJoin(Organizations::tableName() . 'as b', 'b.organization_enc_id = a.organization_enc_id')
            ->innerJoin(Industries::tableName() . 'as c', 'c.industry_enc_id = b.industry_enc_id')
            ->orderBy(['a.id' => SORT_DESC])
            ->count();

        $review_list = ReviewedApplications::find()
            ->alias('a')
            ->select(['a.id','a.review_enc_id','a.review','b.application_enc_id','c.name type','g.name as org_name','g.establishment_year','SUM(h.positions) as positions','d.parent_enc_id','d.category_enc_id','e.name title','b.slug','f.name parent_category','f.icon','f.icon_png'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.review' => 1 ])
            ->joinWith(['applicationEnc b' => function($b){
                $b->distinct();
                $b->joinWith(['applicationTypeEnc c']);
                $b->joinWith(['title d' => function($c){
                    $c->joinWith(['categoryEnc e']);
                    $c->joinWith(['parentEnc f']);
                }]);
                $b->joinWith(['organizationEnc g']);
                $b->joinWith(['applicationPlacementLocations h']);
                $b->groupBy(['h.application_enc_id']);
            }],false)
            ->having(['type' => 'Jobs'])
            ->limit(8)
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        $total_reviews = ReviewedApplications::find()
            ->alias('a')
            ->select(['a.id','a.review_enc_id','a.review','b.application_enc_id','c.name type','g.name as org_name','g.establishment_year','SUM(h.positions) as positions','d.parent_enc_id','d.category_enc_id','e.name title','e.slug','f.name parent_category','f.icon','f.icon_png'])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.review' => 1 ])
            ->joinWith(['applicationEnc b' => function($b){
                $b->distinct();
                $b->joinWith(['applicationTypeEnc c']);
                $b->joinWith(['title d' => function($c){
                    $c->joinWith(['categoryEnc e']);
                    $c->joinWith(['parentEnc f']);
                }]);
                $b->joinWith(['organizationEnc g']);
                $b->joinWith(['applicationPlacementLocations h']);
                $b->groupBy(['h.application_enc_id']);
            }],false)
            ->having(['type' => 'Jobs'])
            ->count();

        $accepted_jobs = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type','g.slug as org_slug', 'h.icon as job_icon', 'c.slug', 'g.name as org_name', 'a.status', 'f.name as title', 'a.applied_application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active','SUM(k.positions) as positions'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as g', 'g.organization_enc_id = c.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as k', 'k.application_enc_id = c.application_enc_id')
            ->where(['b.user_enc_id' => Yii::$app->user->identity->user_enc_id, 'a.status' => 'Accepted'])
            ->having(['type' => 'Jobs'])
            ->groupBy('a.applied_application_enc_id')
            ->limit(8)
            ->asArray()
            ->all();
        $total_accepted = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type','g.slug as org_slug', 'h.icon as job_icon', 'c.slug', 'g.name as org_name', 'a.status', 'f.name as title', 'a.applied_application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active','SUM(k.positions) as positions'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as g', 'g.organization_enc_id = c.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as k', 'k.application_enc_id = c.application_enc_id')
            ->where(['b.user_enc_id' => Yii::$app->user->identity->user_enc_id, 'a.status' => 'Accepted'])
            ->having(['type' => 'Jobs'])
            ->groupBy('a.applied_application_enc_id')
            ->count();
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
            'accepted' => $accepted_jobs,
            'total_accepted' => $total_accepted,
        ]);
    }

    private function __organizationDashboard()
    {
        return $this->render('dashboard/organization', [
            'questionnaire' => $this->__questionnaire(4),
            'applications' => $this->__jobs(8),
            'interview_processes' => $this->__interviewProcess(4),
            'applied_applications' => $this->__candidateApplications(10),
            'primary_fields' => $this->getCategories(),
        ]);
    }

    private function getCategories()
    {
        $primaryfields = Categories::find()
            ->alias('a')
            ->select(['a.name', 'a.category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['b.assigned_to' => 'Jobs', 'b.parent_enc_id' => NULL])
            ->asArray()
            ->all();
        return $primaryfields;
    }

    private function __organizationJobs()
    {
        return $this->render('list/organization', [
            'applications' => $this->__jobs(),
        ]);
    }

    private function __jobs($limit = NULL)
    {
        $options = [
            'applicationType' => 'Jobs',
            'where' => [
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.status' => 'Active',
            ],
            'orderBy' => [
                'a.published_on' => SORT_DESC,
            ],
            'limit' => $limit,
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
                'id' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $processess = new \account\models\processes\OrganizationInterviewProcesses();
        return $processess->getProcesses($options);
    }

    private function __questionnaire($limit = NULL)
    {
        $options = [
            'questionnaireType' => 1,
            'where' => [
                'organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
            ],
            'orderBy' => [
                'id' => SORT_DESC,
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
            ->asArray()
            ->all();

        $total_applications = AppliedApplications::find()
            ->alias('a')
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as f', 'f.application_type_enc_id = b.application_type_enc_id')
            ->where(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
            ->andWhere(['b.is_deleted' => 0])
            ->andWhere(['f.name' => 'Jobs'])
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

    public function actionJobCard($cidk)
    {

        $category = AssignedCategories::find()
            ->alias('a')
            ->select(['b.name',
                'CONCAT("' . Url::to('@commonAssets/categories/png/') . '", c.icon_png) icon'
            ])
            ->innerJoin(Categories::tableName() . ' b', 'b.category_enc_id = a.category_enc_id')
            ->innerJoin(Categories::tableName() . ' c', 'c.category_enc_id = a.parent_enc_id')
            ->where(['a.assigned_category_enc_id' => $cidk])
            ->asArray()
            ->one();

        if ($category) {
//            if (Yii::$app->request->post('image')) {
//                Yii::$app->response->format = Response::FORMAT_JSON;
//                $image = Yii::$app->request->post('image');
//                $image_parts = explode(";base64,", $image);
//                $image_base64 = base64_decode($image_parts[1]);
//                $utilitiesModel = new Utilities();
//                $image_location = Yii::$app->getSecurity()->generateRandomString();
//                $base_path = Yii::$app->params->upload_directories->employer_application->image_path . $image_location;
//                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
//                $image = $utilitiesModel->encrypt() . '.png';
//                if (!is_dir($base_path)) {
//                    if (!mkdir($base_path, 0755, true)) {
//                        return [
//                            'status' => 201,
//                        ];
//                    }
//                }
//
//                if (file_put_contents($base_path . DIRECTORY_SEPARATOR . $image, $image_base64)) {
//                    return [
//                        'status' => 200,
//                        'image_location' => $image_location,
//                        'image' => $image,
//                    ];
//                }
//            }
            return $this->renderPartial('og-image', [
                'category' => $category,
            ]);
        } else {
            return [
                'status' => 201,
            ];
        }
    }

}