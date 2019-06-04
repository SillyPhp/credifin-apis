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
use common\models\UserPreferences;
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
            }
        } else {
            return $this->response(422);
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
            return $this->response(422);
        }
    }

    public function actionReviewList()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (!empty($parameters['type']) && isset($parameters['type'])) {
            $review_list = ReviewedApplications::find()
                ->alias('a')
                ->select(['a.review_enc_id', 'a.review', 'c.name type', 'b.application_enc_id', 'g.name as org_name', 'SUM(h.positions) as positions', 'e.name title', 'f.name parent_category',
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

            if ($review_list == null || $review_list == '') {
                return $this->response(404);
            } else {
                return $this->response(200, $review_list);
            }

        } else {
            return $this->response(422);
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
                        $delete_application->update();
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
                    return $this->response(201, 'successfully shortlisted.');
                } else {
                    return $this->response(500, 'not shorlisted');
                }
            } elseif ($short_status == 1) {
                return $this->response(409, 'already exists');
            }
        } else {
            return $this->response(422);
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
            return $this->response(422);
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
                ->where(['a.created_by' => $candidate->user_enc_id, 'a.shortlisted' => 1])
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
                return $this->response(404);
            } else {
                return $this->response(200, $shortlist_jobs);
            }

        } else {
            return $this->response(422);
        }
    }

    public function actionAppliedApplications()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['type']) && !empty($parameters['type'])) {
            $type = $parameters['type'];
        } else {
            return $this->response(422);
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
            ->andwhere(['a.created_by' => $candidate->user_enc_id, 'a.is_deleted'=>0])
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
        }else{
            return $this->response(404);
        }

    }

    public function actionAcceptedApplications()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['type']) && !empty($parameters['type'])) {
            $type = $parameters['type'];
        } else {
            return $this->response(422);
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
            ->where(['b.user_enc_id' => $candidate->user_enc_id, 'a.status' => 'Accepted','a.is_deleted' => 0])
            ->having(['type' => $type])
            ->groupBy('a.applied_application_enc_id')
            ->asArray()
            ->all();


        if (!empty($accepted_jobs)) {
            return $this->response(200, $accepted_jobs);
        }else{
            return $this->response(404);
        }
    }

    public function actionPendingApplications()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['type']) && !empty($parameters['type'])) {
            $type = $parameters['type'];
        } else {
            return $this->response(422);
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
            ->where(['b.user_enc_id' => $candidate->user_enc_id, 'a.status' => 'Pending','a.is_deleted' => 0])
            ->having(['type' => $type])
            ->groupBy('a.applied_application_enc_id')
            ->asArray()
            ->all();


        if (!empty($pending_jobs)) {
            return $this->response(200, $pending_jobs);
        }else{
            return $this->response(404);
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
