<?php

namespace account\controllers;

use account\models\applications\ApplicationReminderForm;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationReminder;
use common\models\DropResumeApplications;
use common\models\Interviewers;
use common\models\LoanApplications;
use common\models\OrganizationAssignedCategories;
use common\models\ReviewedApplications;
use common\models\ShortlistedApplicants;
use common\models\ShortlistedApplications;
use common\models\InterviewCandidates;
use common\models\InterviewDates;
use common\models\InterviewDateTimings;
use common\models\InterviewOptions;
use common\models\InterviewProcessFields;
use common\models\ScheduledInterview;
use common\models\UserPreferences;
use common\models\UserSkills;
use frontend\models\script\scriptModel;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\HttpException;
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

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
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
            return $this->actionServices();
        }

        if (Yii::$app->user->identity->organization) {
            $scriptModel = new scriptModel();
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
                ->orderBy([new \yii\db\Expression("FIELD (f.status,'Hired','Accepted','Incomplete','Pending','Rejected','Cancelled')")])
                ->asArray()
                ->all();

            $shortlist_org = FollowedOrganizations::find()
                ->alias('a')
                ->select(['az.organization_enc_id', 'a.organization_enc_id', 'az.establishment_year', 'a.followed_enc_id', 'az.name as org_name', 'az.initials_color', 'c.industry', 'az.logo', 'az.logo_location', 'az.slug'])
                ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.followed' => 1])
                ->joinWith(['organizationEnc az' => function ($az) {
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

            $loan = LoanApplications::find()
                ->select(['loan_app_enc_id','loan_status'])
                ->where([
                    'created_by'=>Yii::$app->user->identity->user_enc_id,
                    'loan_status'=>6,
                    'parent_application_enc_id' => null,
                    'is_deleted' => 0
                ])
                ->asArray()
                ->all();

            $app_reminder_form = new ApplicationReminderForm();
            $app_reminder = ApplicationReminder::find()
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'is_deleted' => 0])
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

        $loanApplication = Yii::$app->userData->loanApplicationObj();
        if ($loanApplication) {
            $loanApplication = $loanApplication
                ->andWhere(['not', ['alp.status' => 10]])
                ->andWhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->one();
        }
        return $this->render('index', [
            'loanApplication' => $loanApplication,
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
            'scriptModel' => $scriptModel,
            'userValues' => $this->_CompleteProfile(),
            'userPref' => $this->_CompletePreference(),
            'loan' => $loan,
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
            'andWhere' => ['or',
                ['a.application_for' => 0],
                ['a.application_for' => 1]
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

    public function actionUpdateReminder()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $field = Yii::$app->request->post('field');
            $id = Yii::$app->request->post('id');
            $val = Yii::$app->request->post('value');
            $rm = ApplicationReminder::find()
                ->where(['reminder_enc_id' => $id])
                ->asArray()
                ->one();
            if ($rm) {
                $update = Yii::$app->db->createCommand()
                    ->update(ApplicationReminder::tableName(), [$field => $val], ['reminder_enc_id' => $id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                    ->execute();
                if ($update) {
                    return [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Reminder Updated successfully.'
                    ];
                } else {
                    return [
                        'status' => 201,
                        'message' => 'Something went wrong. Please try again.',
                        'title' => 'Opps!!',
                    ];
                }
            } else {
                return [
                    'status' => 400,
                    'message' => 'Something went wrong. Please try again.',
                    'title' => 'Opps!!',
                ];
            }
        }
    }

    public function actionDeleteReminder()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            $rm = ApplicationReminder::find()
                ->where(['reminder_enc_id' => $id])
                ->asArray()
                ->one();
            if ($rm) {
                $update = Yii::$app->db->createCommand()
                    ->update(ApplicationReminder::tableName(), ['is_deleted' => 1], ['reminder_enc_id' => $id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                    ->execute();
                if ($update) {
                    return [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Reminder Deleted successfully.'
                    ];
                } else {
                    return [
                        'status' => 201,
                        'message' => 'Something went wrong. Please try again.',
                        'title' => 'Opps!!',
                    ];
                }
            } else {
                return [
                    'status' => 400,
                    'message' => 'Something went wrong. Please try again.',
                    'title' => 'Opps!!',
                ];
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

    public function actionServices()
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

    private function _CompleteProfile()
    {
        $user = Users::find()
            ->alias('a')
            ->select([
                'a.user_enc_id', 'a.dob', 'a.experience', 'a.gender', 'a.city_enc_id',
                'a.image', 'a.job_function', 'a.asigned_job_function', 'a.description', 'a.is_available'
            ])
            ->joinWith(['userSkills b' => function ($b) {
                $b->onCondition(['b.is_deleted' => 0]);
            }])
            ->joinWith(['userSpokenLanguages c' => function ($c) {
                $c->onCondition(['c.is_deleted' => 0]);
            }])
            ->where([
                'a.user_enc_id' => Yii::$app->user->identity->user_enc_id,
                'a.is_deleted' => 0
            ])
            ->asArray()
            ->one();

        $is_complete = 1;
        foreach ($user as $val) {
            if ($val == '' || $val == null) {
                $is_complete = 0;
                break;
            }
        }
        return ['is_complete' => $is_complete, 'userVal' => $user];
    }

    private function _CompletePreference()
    {
        $userPref = UserPreferences::find()
            ->alias('a')
            ->select(['a.preference_enc_id', 'a.assigned_to'])
            ->joinWith(['userPreferredJobProfiles b' => function ($b) {
                $b->select(['b.preferred_job_profile_enc_id', 'b.preference_enc_id']);
                $b->onCondition(['b.is_deleted' => 0]);
            }])
            ->joinWith(['userPreferredLocations c' => function ($c) {
                $c->select(['c.preferred_location_enc_id', 'c.preference_enc_id']);
                $c->onCondition(['c.is_deleted' => 0]);
            }])
            ->joinWith(['userPreferredIndustries d' => function ($d) {
                $d->select(['d.preferred_industry_enc_id', 'd.preference_enc_id']);
                $d->onCondition(['d.is_deleted' => 0]);
            }])
            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.is_deleted' => 0, 'a.assigned_to' => 'Jobs'])
            ->asArray()
            ->one();

        $is_complete = 1;
        if (empty($userPref['userPreferredJobProfiles'])) {
            $is_complete = 0;
        }
        if (empty($userPref['userPreferredLocations'])) {
            $is_complete = 0;
        }
        if (empty($userPref['userPreferredIndustries'])) {
            $is_complete = 0;
        }
        return ['is_complete' => $is_complete, 'userPref' => $userPref];
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

    public function actionCalendar()
    {
        if (!Yii::$app->user->identity->organization->organization_enc_id) {
            return $this->render('scheduled-interviews');
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }

    }

//    private function FixedInterview()
//    {
//        $fixed_interview = AppliedApplicationProcess::find()
//            ->alias('a')
//            ->distinct()
//            ->select([
//                'a.field_enc_id',
////                'j.scheduled_interview_enc_id',
//                'f.name company_name',
//                'h.name job_title',
//                'i.name profile',
////                '(CASE
////                    WHEN j.interview_mode = 1 THEN "online"
////                    WHEN j.interview_mode = 2 THEN m.name
////                    END) as interview_at',
//                'o.interview_date',
////                'p.from',
////                'p.to',
////                'p.interview_date_timing_enc_id',
////                'q.name interview_type',
//                'b.applied_application_enc_id',
////                'b.application_enc_id app_id',
////                'j.application_enc_id app_enc_id',
////                'c.sequence',
//                'b.current_round',
//                'z.designation',
////                'd.process_field_enc_id'
//            ])
//            ->innerJoinWith(['appliedApplicationEnc b' => function ($b) {
//                $b->innerJoinWith(['createdBy y'], false);
//                $b->innerJoinWith(['applicationEnc e' => function ($e) {
//                    $e->innerJoinWith(['designationEnc z']);
//                    $e->innerJoinWith(['organizationEnc f']);
//                    $e->innerJoinWith(['title g' => function ($g) {
//                        $g->innerJoinWith(['categoryEnc h']);
//                        $g->innerJoinWith(['parentEnc i'], false);
//                    }]);
//                }], false);
//                $b->andWhere(['b.created_by' => Yii::$app->user->identity->user_enc_id]);
//            }], false)
//            ->innerJoinWith(['fieldEnc c' => function ($c) {
//                $c->innerJoinWith(['interviewOptions d' => function ($d) use ($c) {
//                    $d->innerJoinWith(['scheduledInterviewEnc j' => function ($j) use ($c, $d) {
//                        $j->innerJoinWith(['interviewDates o' => function ($o) use ($c, $d, $j) {
//                            $c->select([
//                                'c.field_enc_id', 'd.process_field_enc_id',
//                                'j.scheduled_interview_enc_id',
//                                'o.interview_date_enc_id',
//                                'p.interview_date_timing_enc_id',
//                                '(CASE
//                                WHEN j.interview_mode = 1 THEN "online"
//                                WHEN j.interview_mode = 2 THEN m.name
//                                END) as interview_at', 'q.name interview_type', 'd.process_field_enc_id'
//                            ]);
//                            $o->innerJoinWith(['interviewDateTimings p']);
//                        }]);
//                        $j->innerJoinWith(['scheduledInterviewTypeEnc q'], false);
//                        $j->innerJoinWith(['interviewLocationEnc k' => function ($k) {
//                            $k->innerJoinWith(['locationEnc l' => function ($l) {
//                                $l->innerJoinWith(['cityEnc m'], false);
//                            }], false);
//                        }], false);
//                    }]);
//                }]);
//            }])
//            ->where(new \yii\db\Expression('`b`.`current_round` = `c`.`sequence`'))
//            ->andWhere(new \yii\db\Expression('`e`.`application_enc_id` = `j`.`application_enc_id`'))
//            ->asArray()
//            ->all();
//
//        $all = InterviewCandidates::find()
//            ->select(['status', 'process_field_enc_id', 'applied_application_enc_id'])
//            ->where(['type' => 'fixed'])
//            ->asArray()
//            ->all();
//
//        $num = count($fixed_interview);
//        $num2 = count($all);
//
//        for ($i = 0; $i < $num; $i++) {
//            for ($j = 0; $j < $num2; $j++) {
//                if ($fixed_interview[$i]['fieldEnc']['process_field_enc_id'] == $all[$j]['process_field_enc_id'] && $fixed_interview[$i]['applied_application_enc_id'] == $all[$j]['applied_application_enc_id']) {
//                    $fixed_interview[$i]['status'] = $all[$j]['status'];
//                }
//            }
//        }
//
//        return $fixed_interview;
//
//    }

    private function FixedInterview()
    {
        $fixed_interview = ScheduledInterview::find()
            ->alias('a')
            ->distinct()
            ->select([
                'a.scheduled_interview_enc_id',
                'f.name company_name',
                'h.name job_title',
                'i.name profile',
                'e.applied_application_enc_id',
                'e.current_round',
                'z.designation',
                'o.interview_date',
                'b.process_field_enc_id',
                '(CASE
                    WHEN a.interview_mode = 1 THEN "online"
                    WHEN a.interview_mode = 2 THEN m.name
                    END) as interview_at',
                'q.name interview_type',
                'c.field_name round'
            ])
            ->innerJoinWith(['interviewOptions b' => function ($b) {
                $b->innerJoinWith(['processFieldEnc c' => function ($c) {
                    $c->joinWith(['appliedApplicationProcesses d' => function ($d) {
                        $d->joinWith(['appliedApplicationEnc e' => function ($e) {
                            $e->joinWith(['applicationEnc ee' => function ($e) {
                                $e->joinWith(['designationEnc z']);
                                $e->joinWith(['organizationEnc f']);
                                $e->joinWith(['title g' => function ($g) {
                                    $g->joinWith(['categoryEnc h']);
                                    $g->joinWith(['parentEnc i'], false);
                                }]);
                            }], false);
                        }]);
                    }]);
                }]);
            }], false)
            ->joinWith(['interviewDates o' => function ($aa) {
                $aa->joinWith(['interviewDateTimings p']);
            }])
            ->joinWith(['scheduledInterviewTypeEnc q'], false)
            ->joinWith(['interviewLocationEnc k' => function ($k) {
                $k->joinWith(['locationEnc l' => function ($l) {
                    $l->joinWith(['cityEnc m'], false);
                }], false);
            }], false)
            ->joinWith(['interviewers rr' => function ($r) {
                $r->select(['rr.interviewer_enc_id', 'rr.scheduled_interview_enc_id', 'r1.name', 'r1.email', 'r1.phone']);
                $r->joinWith(['interviewerDetails r1'], false);
            }])
            ->joinWith(['interviewCandidates q1'], false)
            ->where(new \yii\db\Expression('`e`.`current_round` = `c`.`sequence`'))
            ->andWhere(new \yii\db\Expression('`e`.`application_enc_id` = `a`.`application_enc_id`'))
            ->andWhere(new \yii\db\Expression('`q1`.`applied_application_enc_id` != `e`.`applied_application_enc_id`'))
            ->andWhere(['e.created_by' => Yii::$app->user->identity->user_enc_id])
            ->asArray()
            ->all();


        $all = InterviewCandidates::find()
            ->select(['status', 'process_field_enc_id', 'applied_application_enc_id'])
            ->where(['type' => 'fixed'])
            ->asArray()
            ->all();

        $num = count($fixed_interview);
        $num2 = count($all);

        for ($i = 0; $i < $num; $i++) {
            for ($j = 0; $j < $num2; $j++) {
                if ($fixed_interview[$i]['process_field_enc_id'] == $all[$j]['process_field_enc_id'] && $fixed_interview[$i]['applied_application_enc_id'] == $all[$j]['applied_application_enc_id']) {
                    $fixed_interview[$i]['status'] = $all[$j]['status'];
                }
            }
        }

        return $fixed_interview;

    }

    private function FlexibleInterview()
    {
        $flexible_interview = InterviewCandidates::find()
            ->alias('a')
            ->select([
                'e.name job_title',
                'm.name profile',
                'a.scheduled_interview_enc_id',
                'f.name company_name',
                '(CASE
                    WHEN g.interview_mode = 1 THEN "online"
                    WHEN g.interview_mode = 2 THEN j.name
                    END) as interview_at',
                'o.interview_date',
                'q.name interview_type',
                'a.applied_application_enc_id',
                'a.interview_candidate_enc_id',
                'a.status',
                'z.designation',
                'g2.field_name round'
            ])
            ->joinWith(['appliedApplicationEnc b' => function ($b) {
                $b->andWhere(['b.created_by' => Yii::$app->user->identity->user_enc_id]);
                $b->joinWith(['applicationEnc c' => function ($c) {
                    $c->joinWith(['designationEnc z']);
                    $c->joinWith(['organizationEnc f']);
                    $c->joinWith(['title d' => function ($d) {
                        $d->joinWith(['categoryEnc e']);
                        $d->joinWith(['parentEnc m'], false);
                    }]);
                }]);
            }], false)
            ->joinWith(['scheduledInterviewEnc g' => function ($g) {
                $g->joinWith(['interviewDates o' => function ($aa) {
                    $aa->joinWith(['interviewDateTimings p']);
                }]);
                $g->joinWith(['scheduledInterviewTypeEnc q'], false);
                $g->joinWith(['interviewLocationEnc h' => function ($h) {
                    $h->joinWith(['locationEnc i' => function ($i) {
                        $i->joinWith(['cityEnc j']);
                    }]);
                }], false);
                $g->joinWith(['interviewOptions g1' => function ($g1) {
                    $g1->joinWith(['processFieldEnc g2']);
                }], false);
            }], true)
            ->where(['q.name' => 'flexible'])
            ->asArray()
            ->all();

        return $flexible_interview;
    }

    public function actionGetEvents()
    {
        if (Yii::$app->request->isAjax) {

            $fixed_interview = $this->FixedInterview();
            $flexible_interview = $this->FlexibleInterview();


            $all = InterviewCandidates::find()
                ->select(['interview_date_timing_enc_id'])
                ->where(['type' => 'fixed'])
                ->asArray()
                ->all();

            $select_time = [];
            foreach ($all as $a) {
                array_push($select_time, $a['interview_date_timing_enc_id']);
            }

            $data = [];
            $i = 0;
            $old_id = null;
            $date = [];
            $d = [];
            $time_from_to = [];
            $time = [];
            $fixed_result = [];
            $fixed_data = [];
            foreach ($fixed_interview as $f) {
                if ($f['status'] == 3) {
                    $fixed_data['ThemeColor'] = 'red';
                } elseif ($f['status'] == 2) {
                    $fixed_data['ThemeColor'] = 'green';
                } else {
                    $fixed_data['ThemeColor'] = 'blue';
                }
                $fixed_data['EventId'] = $f['scheduled_interview_enc_id'];
                $fixed_data['Subject'] = $f['job_title'];
                $fixed_data['Profile'] = $f['profile'];
                $fixed_data['designation'] = $f['designation'];
                $fixed_data['type'] = $f['interview_type'];
                $interview_date = $f['interview_date'];
                $fixed_data['Start'] = $interview_date;
                $fixed_data['End'] = $interview_date;
                $fixed_data['applied_application_enc_id'] = $f['applied_application_enc_id'];
                $fixed_data['process_field_enc_id'] = $f['process_field_enc_id'];
                $fixed_data['status'] = $f['status'];
                $fixed_data['round'] = $f['round'];
                $fixed_data['interview_at'] = $f['interview_at'];
                $fixed_data['interviewers'] = $f['interviewers'];
                foreach ($f['interviewDates'] as $dd) {
                    $d['date'] = $dd['interview_date'];
                    foreach ($dd['interviewDateTimings'] as $t) {
                        if (!in_array($t['interview_date_timing_enc_id'], $select_time)) {
                            $time_from_to['interview_date_timing_enc_id'] = $t['interview_date_timing_enc_id'];
                            $time_from_to['from'] = date("g:i a", strtotime($t['from']));
                            $time_from_to['to'] = date("g:i a", strtotime($t['to']));
                            array_push($time, $time_from_to);
                        }
                    }
                    $d['time'] = $time;
                    array_push($date, $d);
                    $d = [];
                    $time = [];
                }
                $fixed_data['time'] = $date;
                $time = [];
                $date = [];

                array_push($fixed_result, $fixed_data);
            }

            $time_from_to = [];
            $time = [];
            $date = [];
            $result = [];
            $data = [];
            foreach ($flexible_interview as $f) {
                if ($f['status'] == 3) {
                    $data['ThemeColor'] = 'red';
                } elseif ($f['status'] == 2) {
                    $data['ThemeColor'] = 'green';
                } else {
                    $data['ThemeColor'] = 'blue';
                }
                $data['EventId'] = $f['scheduled_interview_enc_id'];
                $data['Subject'] = $f['job_title'];
                $data['Profile'] = $f['profile'];
                $data['designation'] = $f['designation'];
                $interview_date = $f['interview_date'];
                $data['Start'] = $interview_date;
                $data['End'] = $interview_date;
                $data['type'] = $f['interview_type'];
                $data['applied_application_enc_id'] = $f['applied_application_enc_id'];
                $data['interview_c_enc_id'] = $f['interview_candidate_enc_id'];
                $data['process_field_enc_id'] = $f['process_field_enc_id'];
                $data['status'] = $f['status'];
                $data['round'] = $f['round'];
                $data['interview_at'] = $f['interview_at'];
                $interviewers = Interviewers::find()
                    ->alias('a')
                    ->select(['a.interviewer_enc_id', 'a.scheduled_interview_enc_id', 'b.name', 'b.email', 'b.phone'])
                    ->joinWith(['interviewerDetails b'], false)
                    ->where(['a.scheduled_interview_enc_id' => $f['scheduled_interview_enc_id']])
                    ->asArray()
                    ->all();
                $data['interviewers'] = $interviewers;
                foreach ($f['scheduledInterviewEnc']['interviewDates'] as $dd) {
                    $d['date'] = $dd['interview_date'];
                    foreach ($dd['interviewDateTimings'] as $t) {
                        $time_from_to['interview_date_timing_enc_id'] = $t['interview_date_timing_enc_id'];
                        $time_from_to['from'] = date("g:i a", strtotime($t['from']));
                        $time_from_to['to'] = date("g:i a", strtotime($t['to']));
                        array_push($time, $time_from_to);
                    }
                    $d['time'] = $time;
                    array_push($date, $d);
                    $d = [];
                    $time = [];
                }
                $data['time'] = $date;
                $date = [];
                array_push($result, $data);
            }

            $data = array_merge($fixed_result, $result);

            return json_encode($data);
        }

    }

    public function actionChangeStatus()
    {

        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $date_enc_id = Yii::$app->request->post('date_enc_id');
            $process_id = Yii::$app->request->post('process_id');
            $interview_candidate_id = Yii::$app->request->post('candidate_interview_id');
            $scheduled_interview_enc_id = Yii::$app->request->post('scheduled_interview_enc_id');
            $applied_app_enc_id = Yii::$app->request->post('applied_app_id');
            $type = Yii::$app->request->post('type');
            $status = Yii::$app->request->post('status');

            $resonse = [
                'status' => 200,
                'message' => 'already exists'
            ];

            if ($type == 'flexible') {

                $interview_candidates = InterviewCandidates::find()
                    ->select('status')
                    ->where(['interview_candidate_enc_id' => $interview_candidate_id])
                    ->asArray()
                    ->one();

                if ($interview_candidates['status'] == 2) {
                    return $resonse;
                } else {

                    $interview_candidates = InterviewCandidates::find()
                        ->where(['interview_candidate_enc_id' => $interview_candidate_id, 'type' => 'flexible'])
                        ->one();

                    $interview_candidates->status = $status;
                    $interview_candidates->interview_date_timing_enc_id = $date_enc_id;

                    if ($interview_candidates->update()) {
                        $this->sendCandidateStatus($applied_app_enc_id, $status);
                        if ($status == 2) {
                            return [
                                'status' => 200,
                                'message' => 'accepted'
                            ];
                        } elseif ($status == 3) {
                            return [
                                'status' => 200,
                                'message' => 'Rejected'
                            ];
                        }
                    } else {
                        return [
                            'status' => 201,
                            'message' => 'There is an error'
                        ];
                    }
                }
            } elseif ($type == 'fixed') {

                $interview_candidates = InterviewCandidates::find()
                    ->select(['status'])
                    ->where([
                        'scheduled_interview_enc_id' => $scheduled_interview_enc_id,
                        'applied_application_enc_id' => $applied_app_enc_id,
                        'process_field_enc_id' => $process_id,
                        'type' => 'fixed',
                    ])
                    ->asArray()
                    ->one();

                if ($interview_candidates['status'] == 2) {
                    return $resonse;
                }

                $number_of_candidates = $this->checkNumbers($scheduled_interview_enc_id);
                $count = $this->countApplications($scheduled_interview_enc_id);

                if ($count < $number_of_candidates) {

                    if (empty($interview_candidates)) {
                        $save_fixed_user_acceptance = new InterviewCandidates();

                        $utilitiesModel = new \common\models\Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $save_fixed_user_acceptance->interview_candidate_enc_id = $utilitiesModel->encrypt();
                        $save_fixed_user_acceptance->scheduled_interview_enc_id = $scheduled_interview_enc_id;
                        $save_fixed_user_acceptance->interview_date_timing_enc_id = $date_enc_id;
                        $save_fixed_user_acceptance->process_field_enc_id = $process_id;
                        $save_fixed_user_acceptance->type = $type;
                        $save_fixed_user_acceptance->applied_application_enc_id = $applied_app_enc_id;
                        $save_fixed_user_acceptance->status = $status;
                        if ($save_fixed_user_acceptance->save()) {
                            $this->sendCandidateStatus($applied_app_enc_id, $status);
                            if ($status == 2) {
                                return [
                                    'status' => 200,
                                    'message' => 'accepted'
                                ];
                            } elseif ($status == 3) {
                                return [
                                    'status' => 200,
                                    'message' => 'Rejected'
                                ];
                            }
                        }
                    }

                } else {
                    return [
                        'status' => 201,
                        'message' => 'This slot is full.try next time'
                    ];
                }
            } else {
                return [
                    'status' => 201,
                    'message' => 'an error occured'
                ];
            }

        }

    }

    //send candidate status to company
    private function sendCandidateStatus($applied_application_enc_id, $status)
    {

        if ($status == 2) {
            $status = 'Accepted';
        } elseif ($status == 3) {
            $status = 'Rejected';
        }

        $org_detail = AppliedApplications::find()
            ->alias('a')
            ->select(['a.applied_application_enc_id', 'c.name', 'c.email', 'CONCAT(d.first_name, " ", d.last_name) name'])
            ->joinWith(['applicationEnc b' => function ($b) {
                $b->joinWith(['organizationEnc c']);
            }], false)
            ->joinWith(['createdBy d'])
            ->where(['a.applied_application_enc_id' => $applied_application_enc_id])
            ->asArray()
            ->one();

        if (!empty($org_detail)) {
            $mail = Yii::$app->mail;
            $mail->receivers = [];
            $mail->receivers[] = [
                'name' => $org_detail['name'],
                'email' => $org_detail['email']
            ];
            $mail->subject = 'candidate status';
            $mail->data = ['job' => $status];
            $mail->template = 'interview-schedular';
            if ($mail->send()) {

            }
        }
    }

    private function checkNumbers($s_id)
    {

        $number = InterviewOptions::find()
            ->select(['number_of_candidates'])
            ->where(['scheduled_interview_enc_id' => $s_id])
            ->asArray()
            ->one();

        return $number['number_of_candidates'];
    }

    private function countApplications($s_id)
    {
        $count = InterviewCandidates::find()
            ->select(['count(scheduled_interview_enc_id) total_applications'])
            ->where(['scheduled_interview_enc_id' => $s_id])
            ->asArray()
            ->all();

        return $count[0]['total_applications'];
    }

    public function actionSafetyPosters()
    {
        return $this->render('safety-posters');
    }
//    public function actionError(){
//        $error = Yii::$app->errorHandler->exception;
//        return $this->render('error',[
//            'error' => $error
//        ]);
//    }

}