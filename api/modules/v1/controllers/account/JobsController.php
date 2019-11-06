<?php

namespace api\modules\v1\controllers\account;


use api\modules\v1\controllers\ApiBaseController;
use api\modules\v1\models\Applied;
use api\modules\v1\models\Candidates;
use common\models\AnsweredQuestionnaire;
use common\models\AnsweredQuestionnaireFields;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\AppliedApplicationProcess;
use common\models\AppliedApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\DropResumeApplications;
use common\models\EmployerApplications;
use common\models\FollowedOrganizations;
use common\models\OrganizationQuestionnaire;
use common\models\Organizations;
use common\models\QuestionnaireFields;
use common\models\ReviewedApplications;
use common\models\ShortlistedApplications;
use common\models\UserAccessTokens;
use common\models\UserPreferences;
use common\models\Utilities;
use common\models\Users;
use MongoDB\Driver\Query;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use Yii;
use yii\web\UploadedFile;
use yii\filters\auth\HttpBearerAuth;


class JobsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'shortlisted-jobs' => ['POST'],
                'review-list' => ['POST'],
                'applied-applications' => ['POST'],
                'accepted-applications' => ['POST'],
                'add-reviewed-application' => ['POST'],
                'remove-reviewed-application' => ['POST'],
                'prefered-applications' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    private function userId()
    {

        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        return $user;
    }

    public function actionAddReviewedApplication()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (!empty($parameters['application_enc_id']) && isset($parameters['application_enc_id'])) {
            $id = $parameters['application_enc_id'];
            $chkshort = ShortlistedApplications::find()
                ->select(['shortlisted'])
                ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                ->asArray()
                ->one();
            $short_status = $chkshort['shortlisted'];

            if ($short_status == 1) {
//                return $this->response(409, 'Can not add, it is already shortlisted.');
                $shortlisted = ShortlistedApplications::find()
                    ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                    ->one();
                $shortlisted->shortlisted = 0;
                $shortlisted->last_updated_on = date('Y-m-d H:i:s');
                $shortlisted->last_updated_by = $candidate->user_enc_id;
                if (!$shortlisted->update()) {
                    return $this->response(500, "did'nt unshortlist");
                }
            }

            $chkuser = ReviewedApplications::find()
                ->select(['review'])
                ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
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
                $model->created_by = $candidate->user_enc_id;
                if ($model->validate() && $model->save()) {
                    return $this->response(201, 'Job successfully created in review list.');
                } else {
                    return $this->response(500, 'Job is not created in review list');
                }
            } else if ($status == 0) {
                $update_reviewed_applications = ReviewedApplications::find()
                    ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                    ->one();
                $update_reviewed_applications->review = 1;
                $update_reviewed_applications->last_updated_by = $candidate->user_enc_id;
                $update_reviewed_applications->last_updated_on = date('Y-m-d H:i:s');
                if ($update_reviewed_applications->update()) {
                    return $this->response(201, 'Job successfully created in review list.');
                } else {
                    return $this->response(500, 'Job is not created in review list');
                }
            } else if ($status == 1) {
                $this->response(409, 'already exists');
            }

        } else {
            return $this->response(422, 'Missing information');
        }

    }

    public function actionRemoveReviewedApplication()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['application_enc_id']) && !empty($parameters['application_enc_id'])) {
            $id = $parameters['application_enc_id'];
            $chkuser = ReviewedApplications::find()
                ->select(['review'])
                ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                ->asArray()
                ->one();
            $status = $chkuser['review'];
            if ($status == 1) {
                $delete_application = ReviewedApplications::find()
                    ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                    ->one();
                $delete_application->review = 0;
                $delete_application->last_updated_by = $candidate->user_enc_id;
                $delete_application->last_updated_on = date('Y-m-d H:i:s');
                if ($delete_application->update()) {
                    return $this->response(200, 'deleted successfully');
                } else {
                    return $this->response(500, 'Job is not deleted in review list');
                }
            } else {
                return $this->response(409, 'already deleted or not found');
            }
        } else {
            return $this->response(422, 'Missing information');
        }
    }

    public function actionReviewList()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (!empty($parameters['type']) && isset($parameters['type'])) {
            $review_list = ReviewedApplications::find()
                ->alias('a')
                ->select([
                    'a.review_enc_id',
                    'a.review',
                    'c.name type',
                    'b.application_enc_id',
                    'g.name as org_name',
                    'SUM(h.positions) as positions',
                    'e.name title',
                    'f.name parent_category',
                    'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", f.icon) icon',
                    'f.icon_png',
                    'CASE WHEN g.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", g.logo_location, "/", g.logo) ELSE NULL END logo',
                    'g.initials_color',
                    '(CASE
                    WHEN b.experience = "0" THEN "No Experience"
                    WHEN b.experience = "1" THEN "Less Than 1 Year"
                    WHEN b.experience = "2" THEN "1 Year"
                    WHEN b.experience = "3" THEN "2 - 3 Years"
                    WHEN b.experience = "3 - 5" THEN "3 - 5 Years"
                    WHEN b.experience = "5 - 10" THEN "5 - 10 Years"
                    WHEN b.experience = "10 - 20" THEN "10 - 20 Years"
                    WHEN b.experience = "20 + " THEN "More Than 20 Years"
                    ELSE "No Experience"
                    END) as experience',
                    'b.type job_type',
                    'b.last_date',
                    'j.city_enc_id',
                    'j.name city_name'
                ])
                ->where(['a.created_by' => $candidate->user_enc_id, 'a.review' => 1])
                ->joinWith(['applicationEnc b' => function ($b) {
                    $b->distinct();
                    $b->where(['b.is_deleted' => 0]);
                    $b->joinWith(['applicationTypeEnc c']);
                    $b->joinWith(['title d' => function ($c) {
                        $c->joinWith(['categoryEnc e']);
                        $c->joinWith(['parentEnc f']);
                    }]);
                    $b->joinWith(['organizationEnc g' => function ($d) {
                        $d->where(['g.is_deleted' => 0]);
                    }]);
                    $b->joinWith(['applicationPlacementLocations h' => function ($x) {
                        $x->joinWith(['locationEnc i' => function ($x) {
                            $x->joinWith(['cityEnc j'], false);
                        }], false);
                    }], false);
                    $b->groupBy(['h.application_enc_id']);
                }], false)
                ->having(['type' => $parameters['type']])
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->all();

            if ($review_list == null || $review_list == '') {
                return $this->response(404, 'Not found');
            } else {
                return $this->response(200, $review_list);
            }

        } else {
            return $this->response(422, "Missing information");
        }
    }

    public function actionAddShortlisted()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (!empty($parameters['application_enc_id']) && isset($parameters['application_enc_id'])) {
            $id = $parameters['application_enc_id'];
            $chkshort = ShortlistedApplications::find()
                ->select(['shortlisted'])
                ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                ->asArray()
                ->one();
            $short_status = $chkshort['shortlisted'];
            if (empty($chkshort)) {
                $shortlist_application = new ShortlistedApplications();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $shortlist_application->shortlisted_enc_id = $utilitiesModel->encrypt();
                $shortlist_application->application_enc_id = $id;
                $shortlist_application->shortlisted = 1;
                $shortlist_application->created_by = $candidate->user_enc_id;
                $shortlist_application->created_on = date('Y-m-d H:i:s');
                if ($shortlist_application->validate() && $shortlist_application->save()) {

                    $chkuser = ReviewedApplications::find()
                        ->select(['review'])
                        ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                        ->asArray()
                        ->one();
                    $status = $chkuser['review'];

                    if ($status == 1) {
                        $delete_application = ReviewedApplications::find()
                            ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                            ->one();
                        $delete_application->review = 0;
                        $delete_application->last_updated_by = $candidate->user_enc_id;
                        $delete_application->last_updated_on = date('Y-m-d H:i:s');
                        if(!$delete_application->update()){
                            return $this->response(500,'not unreviewed');
                        }
                    }
                    return $this->response(201, 'successfully shortlisted.');
                } else {
                    return $this->response(500, 'not shortlisted');
                }
            } elseif ($short_status == 0) {
                $update_shortlisted = ShortlistedApplications::find()
                    ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                    ->one();

                $update_shortlisted->shortlisted = 1;
                $update_shortlisted->last_updated_by = $candidate->user_enc_id;
                $update_shortlisted->last_updated_on = date('Y-m-d H:i:s');
                if ($update_shortlisted->update()) {
                    $chkuser = ReviewedApplications::find()
                        ->select(['review'])
                        ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                        ->asArray()
                        ->one();
                    $status = $chkuser['review'];

                    if ($status == 1) {
                        $delete_application = ReviewedApplications::find()
                            ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                            ->one();
                        $delete_application->review = 0;
                        $delete_application->last_updated_by = $candidate->user_enc_id;
                        $delete_application->last_updated_on = date('Y-m-d H:i:s');
                        if(!$delete_application->update()){
                            return $this->response(500,'not unreviewed');
                        }
                    }
                    return $this->response(201, 'successfully shortlisted.');
                } else {
                    return $this->response(500, 'not shorlisted');
                }
            } elseif ($short_status == 1) {
                return $this->response(409, 'already exists');
            }
        } else {
            return $this->response(422, 'Missing information');
        }
    }

    public function actionRemoveShortlisted()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (!empty($parameters['application_enc_id']) && isset($parameters['application_enc_id'])) {
            $id = $parameters['application_enc_id'];
            $chkshort = ShortlistedApplications::find()
                ->select(['shortlisted'])
                ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                ->asArray()
                ->one();
            $short_status = $chkshort['shortlisted'];
            if ($short_status == 1) {
                $delete_shortlisted = ShortlistedApplications::find()
                    ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                    ->one();
                $delete_shortlisted->shortlisted = 0;
                $delete_shortlisted->last_updated_by = $candidate->user_enc_id;
                $delete_shortlisted->last_updated_on = date('Y-m-d H:i:s');
                if ($delete_shortlisted->update()) {
                    return $this->response(200, 'deleted successfully');
                } else {
                    return $this->response(500, 'Job is not deleted in shortlist');
                }
            } else {
                return $this->response(409, 'already deleted or not found');
            }
        } else {
            return $this->response(422, 'Missing information');
        }
    }

    public function actionShortlistedApplications()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (!empty($parameters['type']) && isset($parameters['type'])) {
            $shortlist_jobs = ShortlistedApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'j.name type', 'd.name', 'e.name as org_name',
                    'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", f.icon) icon',
                    'SUM(g.positions) as positions'])
                ->where(['a.created_by' => $candidate->user_enc_id, 'a.shortlisted' => 1, 'e.is_deleted' => 0, 'b.is_deleted' => 0])
                ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
                ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
                ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
                ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
                ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
                ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = a.application_enc_id')
                ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
                ->groupBy(['b.application_enc_id'])
                ->having(['type' => $parameters['type']])
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->all();

            if ($shortlist_jobs == null || $shortlist_jobs == '') {
                return $this->response(404, 'Not found');
            } else {
                return $this->response(200, $shortlist_jobs);
            }

        } else {
            return $this->response(422, 'Missing information');
        }
    }

    public function actionAppliedApplications()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['type']) && !empty($parameters['type'])) {
            $type = $parameters['type'];
        } else {
            return $this->response(422, 'Missing information');
        }

        $applied_applications = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'a.application_enc_id', 'a.status', 'd.name as title', 'e.name as org_name',
                'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", f.icon) icon',
                'SUM(g.positions) as positions'])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['or',
                ['a.status' => 'Pending'],
                ['a.status' => 'Accepted']
            ])
            ->andwhere(['a.created_by' => $candidate->user_enc_id, 'a.is_deleted' => 0, 'e.is_deleted' => 0, 'k.is_deleted' => 0])
            ->innerJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
            ->innerJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = b.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
            ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
            ->having(['type' => $type])
            ->groupBy(['b.application_enc_id'])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        if (!empty($applied_applications)) {
            return $this->response(200, $applied_applications);
        } else {
            return $this->response(404, 'Nor found');
        }

    }

    public function actionAcceptedApplications()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['type']) && !empty($parameters['type'])) {
            $type = $parameters['type'];
        } else {
            return $this->response(422, 'Missing information');
        }

        $accepted_jobs = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type',
                'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", h.icon) icon',
                'g.name as org_name', 'a.status', 'f.name as title', 'a.application_enc_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active', 'SUM(k.positions) as positions'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as g', 'g.organization_enc_id = c.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as k', 'k.application_enc_id = c.application_enc_id')
            ->where(['b.user_enc_id' => $candidate->user_enc_id, 'a.status' => 'Accepted', 'a.is_deleted' => 0, 'c.is_deleted' => 0, 'g.is_deleted' => 0])
            ->having(['type' => $type])
            ->groupBy('a.applied_application_enc_id')
            ->asArray()
            ->all();


        if (!empty($accepted_jobs)) {
            return $this->response(200, $accepted_jobs);
        } else {
            return $this->response(404, 'Nor found');
        }
    }

    public function actionPendingApplications()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['type']) && !empty($parameters['type'])) {
            $type = $parameters['type'];
        } else {
            return $this->response(422, 'Missing information');
        }

        $pending_jobs = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type',
                'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", h.icon) icon',
                'g.name as org_name', 'a.status', 'f.name as title', 'a.application_enc_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active', 'SUM(k.positions) as positions'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as g', 'g.organization_enc_id = c.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as k', 'k.application_enc_id = c.application_enc_id')
            ->where(['b.user_enc_id' => $candidate->user_enc_id, 'a.status' => 'Pending', 'a.is_deleted' => 0, 'c.is_deleted' => 0, 'g.is_deleted' => 0])
            ->having(['type' => $type])
            ->groupBy('a.applied_application_enc_id')
            ->asArray()
            ->all();


        if (!empty($pending_jobs)) {
            return $this->response(200, $pending_jobs);
        } else {
            return $this->response(404, 'Not found');
        }
    }

    public function actionFollowedCompanies()
    {

        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();


        $followedCompanies = FollowedOrganizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id',
                'b.name',
                'b.initials_color',
                'c.industry',
                'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE NULL END logo',])
            ->innerJoinWith(['organizationEnc b' => function ($a) {
                $a->joinWith(['industryEnc c']);
                $a->where(['b.is_deleted' => 0, 'b.status' => 'Active']);
            }], false)
            ->where(['a.followed' => 1, 'a.created_by' => $candidate->user_enc_id])
            ->asArray()
            ->all();

        if (!empty($followedCompanies)) {
            return $this->response(200, $followedCompanies);
        } else {
            return $this->response(404, 'Not found');
        }

    }

    public function actionQuestionnaire()
    {

        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        $applications_applied = AppliedApplications::find()
            ->select(['applied_application_enc_id id', 'current_round'])
            ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        $user_id = $candidate->user_enc_id;
        $object = new Applied();
        $question = [];
        foreach ($applications_applied as $v) {
            $array = $object->getCurrentQuestions($v['id'], $v['current_round'], $user_id);
            if (!empty($array)) {
                $question[] = $array;
            }
        }

        if (!empty($question)) {
            return $this->response(200, $question);
        } else {
            return $this->response(404, 'Not found');
        }

    }

    public function actionShortlistedResume()
    {

        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['type']) && !empty($parameters['type'])) {
            $type = $parameters['type'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        $application_id = DropResumeApplications::find()
            ->alias('a')
            ->innerJoinWith(['dropResumeApplicationTitles b' => function ($x) use ($type) {
                $x->joinWith(['title0 c'], false);
                $x->andWhere(['c.assigned_to' => $type]);
            }], false)
            ->where(['a.user_enc_id' => $candidate->user_enc_id])
            ->andWhere(['a.status' => 1])
            ->asArray()
            ->all();


        $application_enc_id = [];
        foreach ($application_id as $app) {
            array_push($application_enc_id, $app['application_enc_id']);
        }

        $shortlist1 = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.organization_enc_id', 'b.name as org_name', 'd.name',
                'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", f.icon) icon'])
            ->joinWith(['appliedApplications e' => function ($y) use ($candidate) {
                $y->onCondition(['e.created_by' => $candidate->user_enc_id, 'e.is_deleted' => 0]);
            }], false)
            ->where(['IN', 'a.application_enc_id', $application_enc_id])
            ->joinWith(['title c' => function ($x) {
                $x->joinWith(['categoryEnc d'], false);
                $x->joinWith(['parentEnc f'], false);
            }], false)
            ->joinWith(['organizationEnc b'], false)
            ->asArray()
            ->all();

        if (!empty($shortlist1)) {
            return $this->response(200, $shortlist1);
        } else {
            return $this->response(404, 'Not found');
        }
    }

    public function actionAllAppliedApplications()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        $applied_app = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id',
                'SUBSTRING(i.name,1,CHAR_LENGTH(i.name) - 1) AS type',
                'c.name as title', 'b.assigned_category_enc_id', 'f.applied_application_enc_id', 'f.status', 'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", d.icon) icon', 'g.name as org_name',
//                'COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) as active',
//                'COUNT(h.is_completed) as total',
                'ROUND((COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) / COUNT(h.is_completed)) * 100, 0) AS per'])
            ->innerJoin(ApplicationTypes::tableName() . 'as i', 'i.application_type_enc_id = a.application_type_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = b.parent_enc_id')
            ->innerJoin(Organizations::tablename() . 'as g', 'g.organization_enc_id = a.organization_enc_id')
            ->leftJoin(AppliedApplications::tableName() . 'as f', 'f.application_enc_id = a.application_enc_id')
            ->where(['f.created_by' => $candidate->user_enc_id])
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as h', 'h.applied_application_enc_id = f.applied_application_enc_id')
            ->groupBy(['h.applied_application_enc_id'])
            ->orderBy(['f.id' => SORT_DESC])
            ->asArray()
            ->all();

        if (!empty($applied_app)) {
            return $this->response(200, $applied_app);
        } else {
            return $this->response(404, 'Not found');
        }

    }

    public function actionCancelApplication()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if ($parameters['application_enc_id'] && !empty($parameters['application_enc_id'])) {
            $application_enc_id = $parameters['application_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        $cancel_application = AppliedApplications::find()
            ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $application_enc_id, 'is_deleted' => 0])
            ->one();

        if ($cancel_application['status'] == 'Pending' || $cancel_application['status'] == 'Incomplete') {
            $cancel_application->status = 'Cancelled';
            $cancel_application->last_updated_by = $candidate->user_enc_id;
            $cancel_application->last_updated_on = date('Y-m-d H:i:s');
            if ($cancel_application->update()) {
                return $this->response(200, 'Application Canceled');
            } else {
                return $this->response(500, "Did'nt updated");
            }
        } else {
            return $this->response(500, 'Information cant be processes');
        }

    }

    public function actionQuestionnaireFields()
    {

        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['questionnaire_enc_id']) && !empty($parameters['questionnaire_enc_id'])) {
            $q_enc_id = $parameters['questionnaire_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        if (isset($parameters['applied_application_enc_id']) && !empty($parameters['applied_application_enc_id'])) {
            $applied_application_enc_id = $parameters['applied_application_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        $chk = AnsweredQuestionnaire::find()
            ->where([
                'applied_application_enc_id' => $applied_application_enc_id,
                'questionnaire_enc_id' => $q_enc_id,
                'created_by' => $candidate->user_enc_id,
            ])
            ->asArray()
            ->one();

        if ($chk) {
            return $this->response(409, 'already filled');
        }

        $questions = OrganizationQuestionnaire::find()
            ->select(['questionnaire_enc_id', 'questionnaire_name'])
            ->where(['questionnaire_enc_id' => $q_enc_id])
            ->asArray()
            ->all();

        $fields = QuestionnaireFields::find()
            ->alias('a')
            ->select(['a.field_enc_id', 'a.field_name', 'a.field_label', 'a.sequence', 'a.field_type', 'a.placeholder', 'a.is_required'])
            ->joinWith(['questionnaireFieldOptions b' => function ($a) {
                $a->select(['b.field_option_enc_id', 'b.field_enc_id', 'b.field_option']);
            }], true)
            ->where(['a.questionnaire_enc_id' => $questions[0]['questionnaire_enc_id']])
            ->groupBy(['a.field_enc_id'])
            ->orderBy('a.sequence')
            ->asArray()
            ->all();

        if (!empty($fields)) {
            return $this->response(200, $fields);
        } else {
            return $this->response(404, 'Not Found');
        }
    }

    public function actionFillQuestionnaire()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['questionnaire_enc_id']) && !empty($parameters['questionnaire_enc_id'])) {
            $questionnaire_id = $parameters['questionnaire_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        if (isset($parameters['applied_application_enc_id']) && !empty($parameters['applied_application_enc_id'])) {
            $applied_application_id = $parameters['applied_application_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        $data = json_decode($parameters['data'], true);
        $data = $data['response'];

        $answered_model = new AnsweredQuestionnaire();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $answered_model->answered_questionnaire_enc_id = $utilitiesModel->encrypt();
        $answered_model->applied_application_enc_id = $applied_application_id;
        $answered_model->questionnaire_enc_id = $questionnaire_id;
        $answered_model->created_by = $candidate->user_enc_id;
        $answered_model->created_on = date('Y-m-d H:i:s');
        if ($answered_model->save()) {
            foreach ($data as $d) {

                if ($d['field_type'] == 'text' || $d['field_type'] == 'textarea' || $d['field_type'] == 'number' || $d['field_type'] == 'date' || $d['field_type'] == 'time') {
                    $field_model = new AnsweredQuestionnaireFields();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $field_model->answer_enc_id = $utilitiesModel->encrypt();
                    $field_model->answered_questionnaire_enc_id = $answered_model->answered_questionnaire_enc_id;
                    $field_model->field_enc_id = $d['field_enc_id'];
                    $field_model->answer = $d['answer'];
                    $field_model->created_on = date('Y-m-d H:i:s');
                    $field_model->created_by = $candidate->user_enc_id;
                    if (!$field_model->save()) {
                        return $this->response(500, "don't saved");
                    }
                }

                if ($d['field_type'] == 'select' || $d['field_type'] == 'radio') {
                    $field_model = new AnsweredQuestionnaireFields();
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $field_model->answer_enc_id = $utilitiesModel->encrypt();
                    $field_model->answered_questionnaire_enc_id = $answered_model->answered_questionnaire_enc_id;
                    $field_model->field_enc_id = $d['field_enc_id'];
                    $field_model->field_option_enc_id = $d['option_enc_id'];
                    $field_model->created_on = date('Y-m-d H:i:s');
                    $field_model->created_by = $candidate->user_enc_id;
                    if (!$field_model->save()) {
                        return $this->response(500, "don't saved");
                    }
                }

                if ($d['field_type'] == 'checkbox') {
                    foreach ($d['options'] as $option) {
                        $utilitiesModel = new Utilities();
                        $fieldsModel = new AnsweredQuestionnaireFields;
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $fieldsModel->answer_enc_id = $utilitiesModel->encrypt();
                        $fieldsModel->answered_questionnaire_enc_id = $answered_model->answered_questionnaire_enc_id;
                        $fieldsModel->field_enc_id = $d['field_enc_id'];
                        $fieldsModel->field_option_enc_id = $option['option_enc_id'];
                        $fieldsModel->created_on = date('Y-m-d H:i:s');
                        $fieldsModel->created_by = $candidate->user_enc_id;
                        if (!$fieldsModel->save()) {
                            return $this->response(500, "don't saved");
                        }
                    }
                }
            }
        } else {
            return $this->response(500, 'problem in saving questionnaire');
        }

        $update = Yii::$app->db->createCommand()
            ->update(AppliedApplications::tableName(), ['status' => 'Pending', 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => $candidate->user_enc_id], ['applied_application_enc_id' => $applied_application_id])
            ->execute();
        if ($update) {
            return $this->response(201, 'data saved');
        } else {
            return $this->response(500, 'error occured while updating applied applications');
        }

    }

    public function actionProcessApplication()
    {

        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['application_enc_id']) && !empty($parameters['application_enc_id'])) {
            $app_id = $parameters['application_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        $applied_user = AppliedApplications::find()
            ->distinct()
            ->alias('a')
            ->where(['a.application_enc_id' => $app_id, 'a.created_by' => $candidate->user_enc_id])
            ->select(['a.applied_application_enc_id', 'a.status',
                'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", i.icon) icon',
                'h.name org_name', 'g.name title', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'COUNT(c.is_completed) total'])
            ->joinWith(['applicationEnc b' => function ($b) {
                $b->joinWith(['organizationEnc h'], false);
                $b->joinWith(['title f' => function ($b) {
                    $b->joinWith(['parentEnc i'], false);
                    $b->joinWith(['categoryEnc g'], false);
                }], false);

            }], false)
            ->joinWith(['appliedApplicationProcesses c' => function ($b) {
                $b->joinWith(['fieldEnc d'], false);
                $b->select(['c.applied_application_enc_id',
                    'TRIM(REPLACE(d.field_name, "\n", " ")) as field_name',
                    '(CASE
                        WHEN d.icon = "fa fa-sitemap" THEN "f0e8"
                        WHEN d.icon = "fa fa-phone" THEN "f095"
                        WHEN d.icon = "fa fa-user" THEN "f007"
                        WHEN d.icon = "fa fa-cogs" THEN "f085"
                        WHEN d.icon = "fa fa-user-circle" THEN "f2bd"
                        WHEN d.icon = "fa fa-users" THEN "f0c0"
                        WHEN d.icon = "fa fa-video-camera" THEN "f03d"
                        WHEN d.icon = "fa fa-check" THEN "f00c"
                        WHEN d.icon = "fa fa-pencil-square-o" THEN "f044"
                        WHEN d.icon = "fa fa-envelope" THEN "f0e0"
                        WHEN d.icon = "fa fa-question" THEN "f128"
                        WHEN d.icon = "fa fa-paper-plane" THEN "f1d8"
                        ELSE "f067"
                        END) as icon',
                ]);
            }])
            ->groupBy(['a.applied_application_enc_id'])
            ->asArray()
            ->one();

        if (!empty($applied_user)) {
            return $this->response(200, $applied_user);
        } else {
            return $this->response(404, 'Not Found');
        }

    }


//    public function actionPreferedApplications()
//    {
//        $parameters = \Yii::$app->request->post();
//        $candidate = $this->userId();
//
//        if (!empty($parameters['value'])) {
//            $val = $parameters['value'];
//        } else {
//            $val = 0;
//        }
//
//        if (isset($parameters['type']) && !empty($parameters['type'])) {
//            $type = $parameters['type'];
//        } else {
//            return $this->response(422);
//        }
//
//        if ($type == 'jobs' || $type == 'Jobs') {
//
//            $user_pref_exist = UserPreferences::find()
//                ->where([
//                    'created_by' => $candidate->user_enc_id,
//                    'assigned_to' => $type,
//                    'is_deleted' => 0
//                ])
//                ->exists();
//
//        } elseif ($type == 'internships' || $type == "Internships") {
//
//            $user_pref_exist = UserPreferences::find()
//                ->where([
//                    'created_by' => $candidate->user_enc_id,
//                    'assigned_to' => $type,
//                    'is_deleted' => 0
//                ])
//                ->exists();
//        }
//
//        $user_keyword = [];
//
//        if ($user_pref_exist) {
//            $prefs = UserPreferences::find()
//                ->alias('a')
//                ->joinWith(['userPreferredSkills b' => function ($x) {
//                    $x->select(['b.preference_enc_id', 'f.skill_enc_id', 'f.skill']);
//                    $x->andWhere(['b.is_deleted' => 0]);
//                    $x->joinWith(['skillEnc f'], false);
//                }])
//                ->joinWith(['userPreferredLocations c' => function ($x) {
//                    $x->select(['c.preference_enc_id', 'g.city_enc_id', 'g.name']);
//                    $x->andWhere(['c.is_deleted' => 0]);
//                    $x->joinWith(['cityEnc g'], false);
//                }])
//                ->joinWith(['userPreferredJobProfiles d' => function ($x) {
//                    $x->select(['d.preference_enc_id', 'i.category_enc_id', 'i.name']);
//                    $x->andWhere(['d.is_deleted' => 0]);
//                    $x->joinWith(['jobProfileEnc i'], false);
//                }])
//                ->joinWith(['userPreferredIndustries e' => function ($x) {
//                    $x->select(['e.preference_enc_id', 'h.industry_enc_id', 'h.industry']);
//                    $x->andWhere(['e.is_deleted' => 0]);
//                    $x->joinWith(['industryEnc h'], false);
//                }])
//                ->where([
//                    'a.created_by' => $candidate->user_enc_id,
//                    'assigned_to' => $type,
//                    'a.is_deleted' => 0,
//                ])
//                ->asArray()
//                ->all();
//
//            foreach ($prefs as $pref) {
//                array_push($user_keyword, $pref['type']);
//                foreach ($pref['userPreferredSkills'] as $s) {
//                    array_push($user_keyword, $s['skill']);
//                }
//                foreach ($pref['userPreferredLocations'] as $l) {
//                    array_push($user_keyword, $l['name']);
//                }
//                foreach ($pref['userPreferredIndustries'] as $i) {
//                    array_push($user_keyword, $i['industry']);
//                }
//                foreach ($pref['userPreferredJobProfiles'] as $j) {
//                    array_push($user_keyword, $j['name']);
//                }
//            }
//        } else {
//            $user_prefs = Users::find()
//                ->alias('a')
//                ->joinWith(['cityEnc b'])
//                ->joinWith(['userSkills c' => function ($x) {
//                    $x->select(['c.created_by', 'e.skill_enc_id', 'e.skill']);
//                    $x->andWhere(['c.is_deleted' => 0]);
//                    $x->joinWith(['skillEnc e'], false);
//                }])
//                ->joinWith(['jobFunction d'])
//                ->where([
//                    'a.status' => 'Active',
//                    'a.user_enc_id' => $candidate->user_enc_id,
//                    'a.is_deleted' => 0,
//                ])
//                ->asArray()
//                ->all();
//            if (empty($user_prefs)) {
//                return $this->response(404);
//            } else {
//                foreach ($user_prefs as $u) {
//                    array_push($user_keyword, $u['cityEnc']['name']);
//                    array_push($user_keyword, $u['jobFunction']['name']);
//                    foreach ($u['userSkills'] as $user_skill) {
//                        array_push($user_keyword, $user_skill['skill']);
//                    }
//                }
//            }
//
//        }
//
//        if ($val == 1) {
//            $prefered_applications = $this->findJobs1($user_keyword, $type);
//
//            return $this->response(200, $prefered_applications);
//        } elseif ($val == 2) {
//            $prefered_applications = $this->findJobs2($user_keyword, $type);
//
//            return $this->response(200, $prefered_applications);
//        } else {
//            return $this->response(422);
//        }
//
//
//    }

//    private function findJobs1($keyword, $type)
//    {
//        $results = [];
//        foreach ($keyword as $k) {
//            if (!empty($k)) {
//                $result = EmployerApplications::find()
//                    ->alias('a')
//                    ->distinct()
//                    ->select([
//                        'a.application_enc_id application_id',
//                    ])
//                    ->joinWith(['title b' => function ($x) {
//                        $x->joinWith(['categoryEnc c'], false);
//                        $x->joinWith(['parentEnc i'], false);
//                    }], false)
//                    ->joinWith(['organizationEnc d'], false)
//                    ->joinWith(['applicationPlacementLocations e' => function ($x) {
//                        $x->joinWith(['locationEnc f' => function ($x) {
//                            $x->joinWith(['cityEnc g'], false);
//                        }], false);
//                    }], false)
//                    ->joinWith(['preferredIndustry h'], false)
//                    ->joinWith(['designationEnc l'], false)
//                    ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
//                    ->joinWith(['applicationOptions m'], false)
//                    ->where(['j.name' => $type, 'a.status' => 'Active', 'a.is_deleted' => 0, 'a.for_careers' => 0])
//                    ->andWhere([
//                        'or',
//                        ['like', 'l.designation', $k],
//                        ['like', 'c.name', $k],
//                        ['like', 'g.name', $k],
////                        ['like', 'a.type', $k],
//                        ['like', 'h.industry', $k],
//                        ['like', 'i.name', $k],
//                        ['like', 'd.name', $k],
//                    ])
//                    ->orderBy(['a.id' => SORT_ASC])->asArray()->all();
//                foreach ($result as $r) {
////                    array_push($results,$r);
//                    array_push($results, $r['application_id']);
//                }
//            }
//        }
//        return array_unique($results);
//    }

//    private function findJobs2($keyword, $type)
//    {
//
//        $result = EmployerApplications::find()
//            ->alias('a')
//            ->distinct()
//            ->select([
//                'a.id',
//                'a.application_enc_id application_id',
//                'a.slug',
//                'j.name application_type',
//                'l.designation',
//                'c.name category_name',
//                'i.name profile_name',
//                'h.industry',
//                'a.type',
//                'd.name org_name'
//            ])
//            ->joinWith(['title b' => function ($x) {
//                $x->joinWith(['categoryEnc c'], false);
//                $x->joinWith(['parentEnc i'], false);
//            }], false)
//            ->joinWith(['organizationEnc d'], false)
//            ->joinWith(['applicationPlacementLocations e' => function ($x) {
//                $x->joinWith(['locationEnc f' => function ($x) {
//                    $x->joinWith(['cityEnc g'], false);
//                }], false);
//            }], false)
//            ->joinWith(['preferredIndustry h'], false)
//            ->joinWith(['designationEnc l'], false)
//            ->innerJoinWith(['applicationTypeEnc j' => function ($j) use ($type) {
//                $j->andOnCondition([
//                    'j.name' => $type
//                ]);
//            }], false)
//            ->joinWith(['applicationOptions m'], false)
//            ->where(['a.status' => 'Active', 'a.is_deleted' => 0, 'a.for_careers' => 0]);
//
//        foreach ($keyword as $k) {
//            if (!empty($k)) {
//                $result->orWhere([
//                    'or',
//                    ['like', 'l.designation', $k],
//                    ['like', 'c.name', $k],
//                    ['like', 'g.name', $k],
////                    ['IN', 'a.type', $k],
//                    ['like', 'h.industry', $k],
//                    ['like', 'i.name', $k],
//                    ['like', 'd.name', $k],
//                ]);
//            }
//        }
//
//        return $result->orderBy(['a.id' => SORT_ASC])
//            ->asArray()
//            ->all();
//    }

}
