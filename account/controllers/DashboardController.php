<?php

namespace account\controllers;

use account\models\applications\ApplicationReminderForm;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationReminder;
use common\models\DropResumeApplications;
use common\models\OrganizationAssignedCategories;
use common\models\ReviewedApplications;
use common\models\ShortlistedApplications;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Response;
use common\models\EmployerApplications;
use common\models\AssignedCategories;
use common\models\Industries;
use common\models\FollowedOrganizations;
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

//    public function beforeAction($action)
//    {
//        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->requestedRoute,2);
//        return parent::beforeAction($action);
//    }

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

            $shortlist_org = FollowedOrganizations::find()
                ->alias('a')
                ->select(['b.establishment_year', 'a.followed_enc_id', 'b.name as org_name', 'b.initials_color', 'c.industry', 'b.logo', 'b.logo_location', 'b.slug'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.followed' => 1])
                ->innerJoin(Organizations::tableName() . 'as b', 'b.organization_enc_id = a.organization_enc_id')
                ->leftJoin(Industries::tableName() . 'as c', 'c.industry_enc_id = b.industry_enc_id')
                ->orderBy(['a.id' => SORT_DESC])
                ->limit(8)
                ->asArray()
                ->all();

            $applications_applied = AppliedApplications::find()
                ->select(['applied_application_enc_id id', 'current_round'])
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->orderBy(['id' => SORT_DESC])
                ->asArray()
                ->all();

            $total_shortlist = ShortlistedApplications::find()
                ->alias('a')
                ->select(['j.name type', 'a.id', 'a.created_on', 'a.shortlisted_enc_id', 'b.slug', 'd.name', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions'])
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
                ->orHaving(['type' => 'Internships'])
                ->count();

            $total_reviews = ReviewedApplications::find()
                ->alias('a')
                ->select(['a.id', 'a.review_enc_id', 'a.review', 'b.application_enc_id', 'c.name type', 'g.name as org_name', 'g.establishment_year', 'SUM(h.positions) as positions', 'd.parent_enc_id', 'd.category_enc_id', 'e.name title', 'e.slug', 'f.name parent_category', 'f.icon', 'f.icon_png'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.review' => 1])
                ->joinWith(['applicationEnc b' => function ($b) {
                    $b->distinct();
                    $b->onCondition(['b.is_deleted' => 0]);
                    $b->joinWith(['applicationTypeEnc c']);
                    $b->joinWith(['title d' => function ($c) {
                        $c->joinWith(['categoryEnc e']);
                        $c->joinWith(['parentEnc f']);
                    }]);
                    $b->joinWith(['organizationEnc g' => function ($d) {
                        $d->onCondition(['g.is_deleted' => 0]);
                    }]);
                    $b->joinWith(['applicationPlacementLocations h']);
                    $b->groupBy(['h.application_enc_id']);
                }], false)
                ->having(['type' => 'Jobs'])
                ->orHaving(['type' => 'Internships'])
                ->count();

            $total_accepted = AppliedApplications::find()
                ->alias('a')
                ->select(['j.name type', 'g.slug as org_slug', 'h.icon as job_icon', 'c.slug', 'g.name as org_name', 'a.status', 'f.name as title', 'a.applied_application_enc_id app_id, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'c.interview_process_enc_id', 'COUNT(CASE WHEN d.is_completed = 1 THEN 1 END) as active', 'SUM(k.positions) as positions'])
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
                ->having(['type' => 'Jobs'])
                ->orHaving(['type' => 'Internships'])
                ->groupBy('a.applied_application_enc_id')
                ->count();

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
                ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
                ->having(['type' => 'Jobs'])
                ->orHaving(['type' => 'Internships'])
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
                ->innerJoin(EmployerApplications::tableName() . 'as k', 'k.application_enc_id = a.application_enc_id')
                ->having(['type' => 'Jobs'])
                ->orHaving(['type' => 'Internships'])
                ->groupBy(['b.application_enc_id'])
                ->count();

            $total_shortlist_org = FollowedOrganizations::find()
                ->alias('a')
                ->select(['b.establishment_year', 'a.followed_enc_id', 'b.name as org_name', 'c.industry', 'b.logo', 'b.logo_location', 'b.slug'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.followed' => 1])
                ->innerJoin(Organizations::tableName() . 'as b', 'b.organization_enc_id = a.organization_enc_id')
                ->leftJoin(Industries::tableName() . 'as c', 'c.industry_enc_id = b.industry_enc_id')
                ->orderBy(['a.id' => SORT_DESC])
                ->count();

            $object = new Applied();
            $question = [];
            foreach ($applications_applied as $v) {
                $array = $object->getCurrentQuestions($v['id'], $v['current_round']);
                if (!empty($array)) {
                    $question[] = $array;
                }
            }
            $app_reminder_form = new ApplicationReminderForm();
            $app_reminder = ApplicationReminder::find()
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->all();
        } else {
            $childs = OrganizationAssignedCategories::find()
                ->select(['assigned_category_enc_id'])
                ->andWhere(['organization_enc_id' => Yii::$app->user->identity->organization_enc_id])
                ->asArray()
                ->all();
            $titles = [];
            foreach ($childs as $c) {
                array_push($titles, $c["assigned_category_enc_id"]);
            }
            $dropResume = DropResumeApplications::find()
                ->alias('a')
                ->joinWith(['userEnc b'], false)
                ->joinWith(['dropResumeApplicationTitles h'], false)
                ->where(['in', 'h.title', $titles])
                ->andWhere([
                    'or',
                    ['a.status' => 0],
                    ['a.status' => 1]
                ])
                ->asArray()
                ->count();
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
            'shortlist_org' => $shortlist_org,
            'applications' => $applications,
            'total_shortlist' => $total_shortlist,
            'total_reviews' => $total_reviews,
            'total_accepted' => $total_accepted,
            'total_applied' => $total_applied,
            'total_pending' => $total_pending,
            'total_shortlist_org' => $total_shortlist_org,
            'app_reminder' => $app_reminder,
            'app_reminder_form' => $app_reminder_form,
            'question_list' => $question,
            'dropResume' => $dropResume,
            'org_applications' => $this->__jobs(8),
            'total_org_applied' => $this->total_applied(),
            'viewed' => $viewed,
        ]);
    }

    private function __jobs($limit = NULL)
    {
        if (!empty(Yii::$app->user->identity->organization)) {
            $options = [
                'applicationType' => NULL,
                'where' => [
                    'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                    'a.status' => 'Active',
                ],
                'having' => [
                    '>=', 'a.last_date', date('Y-m-d')
                ],
                'orderBy' => [
                    'a.published_on' => SORT_DESC,
                ],
                'limit' => $limit,
            ];

            $applications = new \account\models\applications\Applications();
            return $applications->getApplications($options);
        }
        return false;
    }

    public function total_applied($type = null)
    {
        if (!empty(Yii::$app->user->identity->organization)) {
            $total_applications = AppliedApplications::find()
                ->alias('a')
                ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
                ->innerJoin(ApplicationTypes::tableName() . 'as f', 'f.application_type_enc_id = b.application_type_enc_id')
                ->where(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->andWhere(['b.is_deleted' => 0])
//                ->andWhere(['f.name' => $type])
                ->innerJoin(Users::tableName() . 'as e', 'e.user_enc_id = a.created_by')
                ->groupBy(['a.applied_application_enc_id'])
                ->count();
            return $total_applications;
        }
        return false;
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
                ->select(['name', 'logo', 'logo_location', 'initials_color'])
                ->where(['slug' => Yii::$app->user->identity->organization->slug, 'status' => 'Active', 'is_deleted' => 0])
                ->asArray()
                ->one();
            $companyLogoFormModel = new CompanyLogoForm();
            return $this->renderAjax('logo-modal', [
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

            return $this->renderAjax('user-image-modal', [
                'userProfilePicture' => $userProfilePicture,
                'user' => $user,
            ]);
        }
    }

    public function actionAddReminder()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $app_reminder = new ApplicationReminderForm();
            if ($app_reminder->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($app_reminder->save()) {
                    return [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Reminder added successfully.'
                    ];
                } else {
                    return [
                        'status' => 201,
                        'message' => 'Something went wrong. Please try again.',
                        'title' => 'Opps!!',
                    ];
                }
            }
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