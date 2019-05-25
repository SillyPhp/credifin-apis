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
            ]
        ];
        return $behaviors;
    }

    private function userId(){

        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        return $user;
    }

    public function actionAddReviewedApplication(){
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();
        $reviewed_application = new ReviewedApplications();

        if(isset($parameters['application_enc_id'])){
            
        }

    }

    public function actionShortlistedJobs(){

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

        return $this->response(200,$shortlist_jobs);
    }

    public function actionReviewList(){

        $candidate = $this->userId();

        $review_list = ReviewedApplications::find()
            ->alias('a')
            ->select(['a.id', 'a.review_enc_id', 'a.review', 'b.application_enc_id', 'c.name type', 'g.name as org_name', 'g.establishment_year', 'SUM(h.positions) as positions', 'd.parent_enc_id', 'd.category_enc_id', 'e.name title', 'f.name parent_category',
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
            ->having(['type' => 'Jobs'])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();

        return $this->response(200,$review_list);
    }

    public function actionAppliedApplications(){

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

        return $this->response(200,$applied_applications);
    }

    public function actionAcceptedApplications(){

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


        return $this->response(200,$accepted_jobs);
    }




}
