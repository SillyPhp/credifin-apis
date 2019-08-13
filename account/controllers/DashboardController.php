<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Response;
use common\models\EmployerApplications;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Organizations;
use common\models\AppliedApplications;
use common\models\AppliedApplicationProcess;
use account\models\organization\CompanyLogoForm;
use account\models\user\UserProfilePictureEdit;
use account\models\applications\Applied;
use common\models\ApplicationTypes;
use common\models\UserCoachingTutorials;
use common\models\Users;
use common\models\WidgetTutorials;

class DashboardController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    private $_condition;

    private function hasViewed()
    {
        $user_viewed = new UserCoachingTutorials();
        $user_v = $user_viewed->find()
            ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'is_viewed' => 1])
            ->asArray()
            ->one();
        if (empty($user_v)) {
            return 0;
        } else {
            return 1;
        }
    }

    public function actionIndex()
    {
        if (Yii::$app->user->identity->organization->organization_enc_id && !Yii::$app->user->identity->organization->business_activity_enc_id) {
            return $this->_businessActivity();
        }

        if (!Yii::$app->user->identity->services['selected_services']) {
            return $this->_services();
        }

        if (Yii::$app->user->identity->organization) {
            $viewed = $this->hasViewed();
            $this->_condition = ['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id];
            $applications = [
                'jobs' => $this->_applications(3),
                'internships' => $this->_applications(3, 'Internships'),
            ];
        } else {
            $viewed = $this->hasViewed();
            $this->_condition = ['b.created_by' => Yii::$app->user->identity->user_enc_id];
        }

        $applied_app = NULL;
        if (empty(Yii::$app->user->identity->organization)) {
            $applied_app = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id application_id', 'i.name type', 'c.name as title', 'b.assigned_category_enc_id', 'f.applied_application_enc_id applied_id', 'f.status', 'd.icon', 'g.name as org_name', 'COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) as active', 'COUNT(h.is_completed) as total', 'ROUND((COUNT(CASE WHEN h.is_completed = 1 THEN 1 END) / COUNT(h.is_completed)) * 100, 0) AS per'])
                ->innerJoin(ApplicationTypes::tableName() . 'as i', 'i.application_type_enc_id = a.application_type_enc_id')
                ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
                ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
                ->innerJoin(Categories::tableName() . 'as d', 'd.category_enc_id = b.parent_enc_id')
                ->innerJoin(Organizations::tablename() . 'as g', 'g.organization_enc_id = a.organization_enc_id')
                ->leftJoin(AppliedApplications::tableName() . 'as f', 'f.application_enc_id = a.application_enc_id')
                ->where(['f.created_by' => Yii::$app->user->identity->user_enc_id])
                ->leftJoin(AppliedApplicationProcess::tableName() . 'as h', 'h.applied_application_enc_id = f.applied_application_enc_id')
                ->groupBy(['h.applied_application_enc_id'])
                ->orderBy(['f.id' => SORT_DESC])
                ->asArray()
                ->all();

            $applications_applied = AppliedApplications::find()
                ->select(['applied_application_enc_id id', 'current_round'])
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->orderBy(['id' => SORT_DESC])
                ->asArray()
                ->all();
            $object = new Applied();
            $question = [];
            foreach ($applications_applied as $v) {
                $array = $object->getCurrentQuestions($v['id'], $v['current_round']);
                if (!empty($array)) {
                    $question[] = $array;
                }
            }
        }

        $services = \common\models\Services::find()
            ->alias('a')
            ->select(['a.service_enc_id', 'a.name', 'b.selected_service_enc_id', 'b.is_selected'])
            ->joinWith(['selectedServices b' => function ($b) {
                $b->onCondition($this->_condition);
            }], false)
            ->where(['a.is_always_visible' => 0])
            ->orderBy(['a.sequence' => SORT_ASC])
            ->asArray()
            ->all();

        $servicesModel = new \account\models\services\ServiceSelectionForm();

        return $this->render('index', [
            'applied' => $applied_app,
            'services' => $services,
            'model' => $servicesModel,
            'applications' => $applications,
            'question_list' => $question,
            'viewed' => $viewed,
        ]);
    }

    private function _applications($limit = NULL, $type = 'Jobs')
    {
        $options = [
            'applicationType' => $type,
            'where' => [
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.status' => 'Active',
            ],
            'having' => [
                '>', 'a.last_date', date('Y-m-d')
            ],
            'orderBy' => [
                'a.published_on' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $applications = new \account\models\applications\Applications();
        return $applications->getApplications($options);
    }

    public function actionCoaching()
    {
        if (Yii::$app->request->isAjax) {

            $data = Yii::$app->request->post('dat');
            $coaching_category = new WidgetTutorials();
            $tutorial_cat = $coaching_category->find()
                ->where(['name' => $data])
                ->asArray()
                ->one();
            $coaching = new UserCoachingTutorials();
            $coaching->user_coaching_tutorial_enc_id = Yii::$app->security->generateRandomString(12);
            $coaching->tutorial_enc_id = $tutorial_cat["tutorial_enc_id"];
            $coaching->created_by = Yii::$app->user->identity->user_enc_id;
            $coaching->last_updated_by = Yii::$app->user->identity->user_enc_id;
            $coaching->is_viewed = 1;
            $coaching->save();
        }
    }

    public function actionUpdateProfile()
    {
        if (Yii::$app->user->identity->organization) {
            $organization = Organizations::find()
                ->select(['logo', 'logo_location', 'initials_color'])
                ->where(['slug' => Yii::$app->user->identity->organization->slug, 'status' => 'Active', 'is_deleted' => 0])
                ->asArray()
                ->one();
            $companyLogoFormModel = new CompanyLogoForm();
            return $this->render('logo-modal', [
                'companyLogoFormModel' => $companyLogoFormModel,
                'organization' => $organization,
            ]);
        } else {
            $userProfilePicture = new UserProfilePictureEdit();
            $user = Users::find()
                ->select(['image', 'image_location', 'initials_color'])
                ->where(['username' => Yii::$app->user->identity->username, 'status' => 'Active', 'is_deleted' => 0])
                ->asArray()
                ->one();

            return $this->render('user-image-modal', [
                'userProfilePicture' => $userProfilePicture,
                'user' => $user,
            ]);
        }
    }

    private function _businessActivity()
    {

        $model = new \account\models\businessActivities\BusinessActivitySelectionForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->businessActivity = $model->businessActivity[0];
            if ($model->add()) {
                return $this->redirect("/account/dashboard");
            }
        }

        $business_activities = \common\models\extended\BusinessActivities::find()
            ->select(['business_activity_enc_id', 'business_activity', 'CONCAT("' . Url::to('@commonAssets/business_activities/') . '", icon_png) icon'])
            ->orderBy('business_activity ASC')
            ->asArray()
            ->all();
        return $this->render('organizations/business-activity', [
            "model" => $model,
            "business_activities" => $business_activities,
        ]);
    }

    private function _services()
    {
        $model = new \account\models\services\ServiceSelectionForm();

        if ($model->load(Yii::$app->request->post()) && $model->add()) {
            return $this->redirect("/account/dashboard");
        }

        if (!Yii::$app->user->identity->services['selected_services']) {
            $services = \common\models\Services::find()
                ->select(['service_enc_id', 'name'])
                ->where(['is_always_visible' => 0])
                ->orderBy(['sequence' => SORT_ASC])
                ->asArray()
                ->all();

            return $this->render('services', [
                'model' => $model,
                'services' => $services,
            ]);
        }
    }

    private function _uploadImage()
    {
        return $this->render("user-image-modal");
    }

    private function _uploadLogo()
    {
        return $this->render("logo-modal");
    }

    public function actionSkipBusinessActivity()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost && Yii::$app->user->identity->organization->organization_enc_id) {
            $business_activities = \common\models\extended\BusinessActivities::find()
                ->select(['business_activity_enc_id', 'business_activity', 'CONCAT("' . Url::to('@commonAssets/business_activities/') . '", icon_png) icon'])
                ->where(["business_activity" => "Others"])
                ->orderBy('business_activity ASC')
                ->one();

            if (!$business_activities) {
                return [
                    "status" => 201,
                    "title" => "Error",
                    "message" => Yii::t('frontend', 'An error has occurred. Please try again.')
                ];
            }

            $organization = Organizations::findOne([
                "organization_enc_id" => Yii::$app->user->identity->organization->organization_enc_id,
                "status" => "Active",
                "is_deleted" => 0,
            ]);

            if (!$organization) {
                return [
                    "status" => 201,
                    "title" => "Error",
                    "message" => Yii::t('frontend', 'An error has occurred. Please try again.')
                ];
            }

            $organization->business_activity_enc_id = $business_activities->business_activity_enc_id;
            if ($organization->validate() && $organization->update()) {
                return [
                    "status" => 200,
                ];
            } else {
                return [
                    "status" => 201,
                    "title" => "Error",
                    "message" => Yii::t('frontend', 'An error has occurred. Please try again.')
                ];
            }
        } else {
            return [
                "status" => 202,
                "title" => "Error",
                "message" => Yii::t('frontend', 'Invalid request')
            ];
        }
    }
}