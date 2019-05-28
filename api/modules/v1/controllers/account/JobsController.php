<?php

namespace api\modules\v1\controllers\account;


use api\modules\v1\controllers\ApiBaseController;
use api\modules\v1\models\Candidates;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\AppliedApplicationProcess;
use common\models\AppliedApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\EmployerApplications;
use common\models\Organizations;
use common\models\ReviewedApplications;
use common\models\ShortlistedApplications;
use common\models\UserAccessTokens;
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

        if (isset($parameters['application_enc_id'])) {
            $id = $parameters['application_enc_id'];
            $chkshort = ShortlistedApplications::find()
                ->select(['shortlisted'])
                ->where(['created_by' => $candidate->user_enc_id, 'application_enc_id' => $id])
                ->asArray()
                ->one();
            $short_status = $chkshort['shortlisted'];
            if ($short_status == 1) {
                return $this->response(409, 'Can not add, it is already shortlisted.');
            } else {
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
                    if ($update_reviewed_applications->update()) {
                        return $this->response(201, 'Job successfully created in review list.');
                    } else {
                        return $this->response(500, 'Job is not created in review list');
                    }
                } else if ($status == 1) {
                    $this->response(409, 'already exists');
                }
            }
        } else {
            return $this->response(422);
        }

    }

    public function actionRemoveReviewedApplication()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['application_enc_id'])) {
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
                if ($delete_application->update()) {
                    return $this->response(200, 'deleted successfully');
                } else {
                    return $this->response(500, 'Job is not deleted in review list');
                }
            } else {
                return $this->response(409, 'already deleted or not found');
            }
        } else {
            return $this->response(422);
        }
    }

    public function actionReviewList()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if(isset($parameters['type'])) {
            $review_list = ReviewedApplications::find()
                ->alias('a')
                ->select(['a.review_enc_id', 'a.review', 'c.name type', 'b.application_enc_id', 'g.name as org_name', 'SUM(h.positions) as positions', 'e.name title', 'f.name parent_category',
                    'CASE WHEN g.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo,'https') . '", g.logo_location, "/", g.logo) ELSE NULL END logo',
                    'g.initials_color color',
                    'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", f.icon) icon',
                    'f.icon_png'])
                ->where(['a.created_by' => $candidate->user_enc_id, 'a.review' => 1])
                ->joinWith(['applicationEnc b' => function ($b) {
                    $b->distinct();
                    $b->joinWith(['applicationTypeEnc c']);
                    $b->joinWith(['title d' => function ($c) {
                        $c->joinWith(['categoryEnc e']);
                        $c->joinWith(['parentEnc f']);
                    }]);
                    $b->joinWith(['organizationEnc g']);
                    $b->joinWith(['applicationPlacementLocations h']);
                    $b->groupBy(['h.application_enc_id']);
                }], false)
                ->having(['type' => $parameters['type']])
                ->orderBy(['a.id' => SORT_DESC])
                ->asArray()
                ->all();

            if($review_list == null || $review_list == ''){
                return $this->response(404);
            }else{
                return $this->response(200, $review_list);
            }

        }else{
            return $this->response(422);
        }
    }

    public function actionShortlistedJobs()
    {

        $candidate = $this->userId();

        $shortlist_jobs = ShortlistedApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'j.name type', 'a.id', 'a.created_on', 'a.shortlisted_enc_id', 'd.name', 'e.name as org_name',
                'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", f.icon) icon',
                'SUM(g.positions) as positions'])
            ->where(['a.created_by' => $candidate->user_enc_id, 'a.shortlisted' => 1])
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

        return $this->response(200, $shortlist_jobs);
    }

    public function actionAppliedApplications()
    {

        $candidate = $this->userId();

        $applied_applications = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'a.id', 'a.application_enc_id as app_id', 'a.status', 'a.created_by', 'd.name as title', 'b.slug', 'e.name as org_name',
                'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", f.icon) icon',
                'SUM(g.positions) as positions'])
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->where(['or',
                ['a.status' => 'Pending'],
                ['a.status' => 'Accepted']
            ])
            ->andwhere(['a.created_by' => $candidate->user_enc_id])
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

        return $this->response(200, $applied_applications);
    }

    public function actionAcceptedApplications()
    {

        $candidate = $this->userId();

        $accepted_jobs = AppliedApplications::find()
            ->alias('a')
            ->select(['j.name type', 'g.slug as org_slug',
                'CONCAT("' . Url::to('@commonAssets/categories/svg/', 'https') . '", h.icon) icon',
                'c.slug', 'g.name as org_name', 'a.status', 'f.name as title', 'a.applied_application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active', 'SUM(k.positions) as positions'])
            ->innerJoin(Users::tableName() . 'as b', 'b.user_enc_id=a.created_by')
            ->innerJoin(EmployerApplications::tableName() . 'as c', 'c.application_enc_id = a.application_enc_id')
            ->leftJoin(AppliedApplicationProcess::tableName() . 'as d', 'd.applied_application_enc_id = a.applied_application_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as e', 'e.assigned_category_enc_id = c.title')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = e.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as g', 'g.organization_enc_id = c.organization_enc_id')
            ->innerJoin(Categories::tableName() . 'as h', 'h.category_enc_id = e.parent_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = c.application_type_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tableName() . 'as k', 'k.application_enc_id = c.application_enc_id')
            ->where(['b.user_enc_id' => $candidate->user_enc_id, 'a.status' => 'Accepted'])
            ->having(['type' => 'Jobs'])
            ->groupBy('a.applied_application_enc_id')
            ->limit(8)
            ->asArray()
            ->all();


        return $this->response(200, $accepted_jobs);
    }


}
