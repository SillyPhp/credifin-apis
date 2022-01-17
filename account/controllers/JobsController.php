<?php

namespace account\controllers;

use account\models\applications\ApplicationDataProvider;
use account\models\applications\ApplicationForm;
use account\models\applications\ApplicationTemplateDataProvider;
use account\models\applications\ExtendsJob;
use account\models\applications\ShortJobs;
use account\models\applications\UserAppliedApplication;
use account\models\campus_placement\CollegePlacementForm;
use common\models\ApplicationTemplates;
use common\models\ApplicationUnclaimOptions;
use common\models\CandidateConsiderJobs;
use common\models\CandidateRejection;
use common\models\CandidateRejectionReasons;
use common\models\DropResumeApplications;
use common\models\ErexxCollaborators;
use common\models\ErexxEmployerApplications;
use common\models\FollowedOrganizations;
use common\models\RejectionReasons;
use common\models\ShortlistedApplicants;
use common\models\UnclaimedOrganizations;
use common\models\UserPreferences;
use common\models\UserSkills;
use frontend\models\applications\ApplicationCards;
use http\Params;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\UploadedFile;
use yii\db\Expression;
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
use common\models\ReviewedApplications;
use common\models\AppliedApplicationProcess;
use common\models\Utilities;
use account\models\jobs\JobApplied;
use common\models\InterviewProcessFields;
use common\models\UserCoachingTutorials;
use common\models\WidgetTutorials;


class JobsController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    private function reviewZero()
    {
        $update = Yii::$app->db->createCommand()
            ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app_id])
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

    private function __organizationJobs()
    {
        return $this->render('list/organization', [
            'applications' => $this->__jobs(),
        ]);
    }

    public function actionActiveJobs()
    {
        return $this->render('list/organization', [
            'applications' => $this->__jobs(),
            'type' => 'Active Jobs'
        ]);
    }

    public function actionActiveErexxJobs()
    {
        return $this->render('list/organization', [
            'applications' => $this->__erexxJobs(),
            'type' => 'Active Erexx Jobs'
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

    private function __jobss($limit = NULL)
    {
        $options = [
            'applicationType' => 'Jobs',
            'where' => [
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.status' => 'Active',
                'a.application_for' => 1
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

    private function __individualDashboard(){
//        $shortlist_jobs = ShortlistedApplications::find()
//            ->alias('a')
//            ->select(['a.application_enc_id', 'k.applied_application_enc_id', 'j.name type', 'a.id', 'a.created_on', 'a.shortlisted_enc_id', 'b.slug', 'd.name', 'e.name as org_name', 'f.icon', 'SUM(g.positions) as positions','b.unclaimed_organization_enc_id','e.logo','e.logo_location','e.initials_color',
//                'auo.positions as unclaim_positions',
//                'uo.name as unclaim_org_name',
//                'uo.logo as unclaim_org_logo',
//                'uo.logo_location as unclaim_org_logo_location',
//                'uo.initials_color as unclaim_org_initials_color',
//                ])
//            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.shortlisted' => 1])
//            ->joinWith(['applicationEnc b' => function ($a) {
//                $a->joinWith(['appliedApplications k' => function ($y) {
//                    $y->onCondition(['k.created_by' => Yii::$app->user->identity->user_enc_id, 'k.is_deleted' => 0]);
//                }], false);
//                $a->onCondition(['b.is_deleted' => 0, 'b.status' => 'ACTIVE', 'b.application_for' =>1]);
//            }], false)
//            ->innerJoin(EmployerApplications::tableName() . 'as ea', 'ea.application_enc_id = a.application_enc_id')
//            ->leftJoin(ApplicationUnclaimOptions::tableName() . 'as auo', 'auo.application_enc_id = a.application_enc_id')
//            ->leftJoin(UnclaimedOrganizations::tableName() . 'as uo', 'uo.organization_enc_id = ea.unclaimed_organization_enc_id')
//            ->leftJoin(AssignedCategories::tableName() . 'as c', 'c.assigned_category_enc_id = b.title')
//            ->leftJoin(Categories::tableName() . 'as d', 'd.category_enc_id = c.category_enc_id')
//            ->leftJoin(Organizations::tableName() . 'as e', 'e.organization_enc_id = b.organization_enc_id')
//            ->leftJoin(Categories::tableName() . 'as f', 'f.category_enc_id = c.parent_enc_id')
//            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as g', 'g.application_enc_id = a.application_enc_id')
//            ->leftJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
//            ->groupBy(['b.application_enc_id'])
//            ->having(['type' => 'Jobs'])
//            ->limit(6)
//            ->orderBy(['a.id' => SORT_DESC])
//            ->asArray()
//            ->all();

//        $total_shortlist = ShortlistedApplications::find()
//            ->alias('a')
//            ->select(['j.name type', 'a.shortlisted_enc_id'])
//            ->where(['a.created_by' => Yii::$app->user->identity->user_enc_id, 'a.shortlisted' => 1])
//            ->joinWith(['applicationEnc b' => function ($a) {
//                $a->joinWith(['appliedApplications k' => function ($y) {
//                    $y->onCondition(['k.created_by' => Yii::$app->user->identity->user_enc_id, 'k.is_deleted' => 0]);
//                }], false);
//                $a->onCondition(['b.is_deleted' => 0, 'b.status' => 'ACTIVE', 'b.application_for' =>1]);
//            }], false)
//            ->leftJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = b.application_type_enc_id')
//            ->groupBy(['b.application_enc_id'])
//            ->having(['type' => 'Jobs'])
//            ->count();
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
            ->having(['type' => 'Jobs'])
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
            ->having(['type' => 'Jobs'])
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
            ->having(['type' => 'Jobs'])
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
//                $b->groupBy(['h.application_enc_id']);
                $b->joinWith(['appliedApplications k' => function ($y) {
                    $y->onCondition(['k.created_by' => Yii::$app->user->identity->user_enc_id, 'k.is_deleted' => 0]);
                }], false);
                $b->onCondition(['b.is_deleted' => 0, 'b.status' => 'ACTIVE', 'b.application_for' =>1]);
            }], false)
            ->having(['type' => 'Jobs'])
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
            ->having(['type' => 'Jobs'])
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
            ->having(['type' => 'Jobs'])
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
            ->having(['type' => 'Jobs'])
            ->groupBy('a.applied_application_enc_id')
            ->count();

        $application_id = DropResumeApplications::find()
            ->alias('a')
            ->innerJoinWith(['dropResumeApplicationTitles b' => function ($x) {
                $x->joinWith(['title0 c'], false);
                $x->andWhere(['c.assigned_to' => 'Jobs']);
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
            ->select(['a.application_enc_id', 'a.organization_enc_id', 'a.title', 'b.name as org_name', 'a.slug', 'c.category_enc_id', 'd.name', 'd1.icon','b.logo','b.logo_location','b.initials_color'])
            ->joinWith(['appliedApplications e' => function ($y) {
                $y->onCondition(['e.created_by' => Yii::$app->user->identity->user_enc_id, 'e.is_deleted' => 0]);
            }], true)
            ->where(['IN', 'a.application_enc_id', $application_enc_id])
            ->andWhere(['a.status' => 'ACTIVE', 'a.is_deleted' => 0, 'a.application_for' =>1])
            ->joinWith(['title c' => function ($x) {
                $x->joinWith(['categoryEnc d'], false);
                $x->joinWith(['parentEnc d1'], false);
            }], false)
            ->joinWith(['organizationEnc b'], false)
            ->limit(6)
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
                'a.assigned_to' => 'Jobs'
            ])
            ->asArray()
            ->one();

        $locations = [];
        if($userLocation['userPreferredLocations']){
        foreach ($userLocation['userPreferredLocations'] as $location){
            array_push($locations, $location['name']);
        }
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
        if($userSkills) {
            foreach ($userSkills as $skill) {
                array_push($skills, $skill['skill']);
            }
        }
        $options['limit'] = 3;
        $options['location'] = implode(',', $locations);
        $options['skills'] = implode(',', $skills);
        $options['orderBy'] = new Expression('rand()');

        $jobsByLocation = ApplicationCards::jobs($options);
        unset($options['location']);
        $jobsBySkills = ApplicationCards::jobs($options);

        return $this->render('dashboard/individual', [
//            'shortlisted' => $shortlist_jobs,
            'applied' => $applied_applications,
            'shortlist_org' => $shortlist_org,
            'reviewlist' => $review_list,
            'total_reviews' => $total_reviews,
            'total_shortlist_org' => $total_shortlist_org,
            'total_applied' => $total_applied,
//            'total_shortlist' => $total_shortlist,
            'total_pending' => $total_pending,
            'accepted' => $accepted_jobs,
            'total_accepted' => $total_accepted,
            'shortlist1' => $shortlist1,
            'jobsByLocation' => $jobsByLocation,
            'preferredLocations' => implode(',', $locations),
            'jobsBySkills' => $jobsBySkills,
            'preferredSkills' => implode(',', $skills),
        ]);
    }

    public function actionGetFollowedCompaniesJobs(){
        if (Yii::$app->request->isAjax & Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $org_id = Yii::$app->request->post('organization_enc_id');
            $type = Yii::$app->request->post('type');
            $applications = EmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.slug', 'e2.name title', 'e1.name parent_category', 'e1.icon', 'ae.name type',
                    'CASE WHEN e1.icon IS NOT NULL THEN CONCAT("' . Url::to('@commonAssets/categories/') . '", e1.icon) ELSE NULL END icon'])
                ->joinWith(['title e' => function ($e) {
                    $e->joinWith(['parentEnc e1']);
                    $e->joinWith(['categoryEnc e2']);
                }], false)
                ->joinWith(['applicationTypeEnc ae'], false)
                ->where(['a.organization_enc_id' => $org_id,'a.status'=>'Active','a.is_deleted'=>0, 'a.application_for' => 1]);
                if($type != 'all'){
                    $applications->andWhere(['ae.name' => $type]);
                }
                $applications = $applications
                ->asArray()
                ->all();
                return ['status'=>200,'data'=>$applications];
        }
    }

    public function actionDashboard(){
        if (Yii::$app->user->identity->organization) {
            return $this->__organizationDashboard();
        } else {
            return $this->__individualDashboard();
        }
    }

    private function __organizationDashboard()
    {
        $coaching_category = new WidgetTutorials();
        $model = new ExtendsJob();
        $catModel = new ApplicationForm();
        $userApplied = new UserAppliedApplication();
        $tutorial_cat = $coaching_category->find()
            ->where(['name' => "organization_jobs_stats"])
            ->asArray()
            ->one();
        $user_viewed = new UserCoachingTutorials();
        $user_v = $user_viewed->find()
            ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'is_viewed' => 1, 'tutorial_enc_id' => $tutorial_cat["tutorial_enc_id"]])
            ->asArray()
            ->one();
        $colleges = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name'])
            ->joinWith(['businessActivityEnc b'], false)
            ->where(['a.has_placement_rights' => 1, 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere(['b.business_activity' => 'College'])
            ->asArray()
            ->all();
        $addedColleges = ErexxCollaborators::find()
            ->where(['status' => 'Active', 'is_deleted' => 0])
            ->asArray()
            ->all();
        $saveCollege = new CollegePlacementForm();
        if (empty($user_v)) {
            $viewed = 0;
        } else {
            $viewed = 1;
        }
        return $this->render('dashboard/organization', [
            'questionnaire' => $this->__questionnaire(4),
            'applications' => $this->__jobs(9),
            'erexx_applications' => $this->__erexxJobs(9),
            'closed_application' => $this->__closedjobs(8),
            'interview_processes' => $this->__interviewProcess(4),
            'applied_applications' => $userApplied->getUserDetails('Jobs', 10),
            'total_applied' => $userApplied->total_applied($type = 'Jobs'),
            'viewed' => $viewed,
            'model' => $model,
            'colleges' => $colleges,
            'addedColleges' => $addedColleges,
            'saveCollege' => $saveCollege,
            'jobs' => $this->__getApplications("Jobs"),
            'primary_fields' => $catModel->getPrimaryFields(),
            'shortlistedApplicants' => $this->shortlistedApplicants(3),
            'savedApplicants' => $this->savedApplicants(3),
            'blacklistedApplicants' => $this->blacklistedCandidates(3)
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
            ->limit(10)
            ->all();

        return $application;
    }

    private function __questionnaire($limit = NULL)
    {
        $options = [
            'questionnaireType' => 1,
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

    private function __erexxJobs($limit = NULL)
    {
        $options = [
            'applicationType' => 'Jobs',
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

    public function actionGetJobColleges()
    {
        if (Yii::$app->request->isAjax & Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $app_id = Yii::$app->request->post('app_id');

            $colleges = ErexxEmployerApplications::find()
                ->alias('a')
                ->select(['a.application_enc_id', 'a.college_enc_id', 'a.is_college_approved', 'b.name college_name', 'b.slug',
                    'CASE WHEN b.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END college_logo'
                ])
                ->joinWith(['collegeEnc b'], false)
                ->where(['a.employer_application_enc_id' => $app_id, 'a.is_deleted' => 0, 'a.status' => 'Active'])
                //->limit(10)
                ->asArray()
                ->all();

            if ($colleges) {
                return ['status' => 200, 'colleges' => $colleges];
            } else {
                return ['status' => 404];
            }
        }
    }

    private function __closedjobs($limit = NULL,$page = 1)
    {
        $options = [
            'applicationType' => 'Jobs',
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

    private function getCategories()
    {
        $primaryfields = Categories::find()
            ->alias('a')
            ->select(['a.name', 'a.category_enc_id', 'CONCAT("' . Url::to('@commonAssets/categories/svg/') . '", a.icon) icon'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['b.assigned_to' => 'Jobs', 'b.parent_enc_id' => NULL])
            ->asArray()
            ->all();
        return $primaryfields;
    }

    public function actionCreate($aidk = NULL)
    {
        if (Yii::$app->user->identity->organization) {
            $model = new ApplicationForm();
            $primary_cat = $model->getPrimaryFields();
            $array = ArrayHelper::getColumn($primary_cat, 'category_enc_id');
            if (in_array($aidk, $array)) {
                return $this->_renderCreateJob($aidk);
            } else {
                return $this->_renderProfileTemplates($primary_cat);
            }
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    private function _renderProfileTemplates($primary_cat, $type = 'jobs')
    {
        return $this->render('/widgets/employer-applications/temProfiles', ['primary_cat' => $primary_cat, 'type' => $type]);
    }

    private function _renderCreateJob($pidk)
    {
        $type = 'Jobs';
        $model = new ApplicationForm();
        $model->primaryfield = (($pidk) ? $pidk : null);
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
            $data = $model->saveValues($type);
            if ($data['status']) {
                $session = Yii::$app->session;
                if (!empty($session->get($session_token))) {
                    $session->remove($session_token);
                }
                return $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'app_id' => $data['id'],
                ];
            } else {
                 return $response = [
                    'status' => 500,
                    'title' => 'Error',
                    'message' => $data['message'],
                ];
            }
        } else {
            return $this->render('/employer-applications/form', ['model' => $model,
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
    }

    public function actionGetColleges()
    {
        if (Yii::$app->request->isAjax) {
            $colleges = ErexxCollaborators::find()
                ->alias('a')
                ->select(['a.college_enc_id', 'b.name'])
                ->joinWith(['collegeEnc b'], false)
                ->where(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'a.college_approvel' => 1, 'a.status' => 'Active', 'a.is_deleted' => 0])
                ->asArray()
                ->all();
            return $this->renderAjax('/employer-applications/college-list', [
                'colleges' => $colleges,
            ]);
        }
    }

    public function actionApproveCandidate()
    {
        if (Yii::$app->request->isPost) {
            $f_id = Yii::$app->request->post('field_id');
            $app_id = Yii::$app->request->post('app_id');
            $update = Yii::$app->db->createCommand()
                ->update(AppliedApplicationProcess::tableName(), ['is_completed' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['field_enc_id' => $f_id, 'applied_application_enc_id' => $app_id])
                ->execute();
            $count = AppliedApplicationProcess::find()
                ->select(['COUNT(CASE WHEN is_completed = 1 THEN 1 END) as active', 'status', 'COUNT(is_completed) as total'])
                ->where(['applied_application_enc_id' => $app_id])
                ->asArray()
                ->one();
            if ($update == 1) {
                Yii::$app->db->createCommand()
                    ->update(AppliedApplications::tableName(), ['current_round' => ($count['active'] + 1), 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $app_id])
                    ->execute();
                $response = [
                    'status' => true,
                    'active' => $count['active']
                ];
                if ($count['active'] >= 1) {
                    $obj = AppliedApplications::find()->where(['applied_application_enc_id' => $app_id])->one();
                    $obj->status = 'Accepted';
                    $obj->save();
                }
                if ($count['active'] == $count['total']) {
                    $update_status = Yii::$app->db->createCommand()
                        ->update(AppliedApplications::tableName(), ['status' => 'Hired', 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $app_id])
                        ->execute();
                }
                return json_encode($response);
            } else {
                return false;
            }
        }
    }

    public function actionApproveMultipleSteps()
    {
        if (Yii::$app->request->isPost) {
            $fields = Yii::$app->request->post('fields');
            $app_id = Yii::$app->request->post('app_id');

            $flag = 0;
            foreach ($fields as $field) {
                $f = AppliedApplicationProcess::findone(['field_enc_id' => $field, 'applied_application_enc_id' => $app_id]);
                if ($f->is_completed == 0) {
                    $update = Yii::$app->db->createCommand()
                        ->update(AppliedApplicationProcess::tableName(), ['is_completed' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['field_enc_id' => $field, 'applied_application_enc_id' => $app_id])
                        ->execute();
                    $count = AppliedApplicationProcess::find()
                        ->select(['COUNT(CASE WHEN is_completed = 1 THEN 1 END) as active', 'status', 'COUNT(is_completed) as total'])
                        ->where(['applied_application_enc_id' => $app_id])
                        ->asArray()
                        ->one();
                    if ($update == 1) {
                        Yii::$app->db->createCommand()
                            ->update(AppliedApplications::tableName(), ['current_round' => ($count['active'] + 1), 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $app_id])
                            ->execute();
                        $response = [
                            'status' => true,
                            'active' => $count['active']
                        ];
                        $flag = 1;
                        if ($count['active'] >= 1) {
                            $obj = AppliedApplications::find()->where(['applied_application_enc_id' => $app_id])->one();
                            $obj->status = 'Accepted';
                            $obj->save();
                        }
                        if ($count['active'] == $count['total']) {
                            $update_status = Yii::$app->db->createCommand()
                                ->update(AppliedApplications::tableName(), ['status' => 'Hired', 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $app_id])
                                ->execute();
                        }
                    } else {
                        return json_encode($response = [
                            'status' => false,
                        ]);
                    }
                }
            }
            if ($flag) {
                return json_encode($response);
            } else {
                return json_encode($response = [
                    'status' => false,
                ]);
            }
        }
    }

    public function actionCancelApplication()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');

            $update = Yii::$app->db->createCommand()
                ->update(AppliedApplications::tableName(), ['status' => 'Cancelled', 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $id])
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
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('app_id');
            $reasons = Yii::$app->request->post('reasons');
            $rejectionType = Yii::$app->request->post('rejectionType');
            $considerJobs = Yii::$app->request->post('considerJobs');
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $utilitiesModel = new Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model = new CandidateRejection();
                $model->candidate_rejection_enc_id = $utilitiesModel->encrypt();
                $model->applied_application_enc_id = $id;
                $model->rejection_type = $rejectionType;
                $model->created_on = date('Y-m-d H:i:s');
                $model->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$model->save()) {
                    $transaction->rollBack();
                    return ['status' => 500];
                }

                foreach ($reasons as $r) {
                    $utilitiesModel = new Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $rejection_reasons = new CandidateRejectionReasons();
                    $rejection_reasons->candidate_rejection_reasons_enc_id = $utilitiesModel->encrypt();
                    $rejection_reasons->candidate_rejection_enc_id = $model->candidate_rejection_enc_id;
                    $rejection_reasons->rejection_reasons_enc_id = $r;
                    $rejection_reasons->created_on = date('Y-m-d H:i:s');
                    $rejection_reasons->created_by = Yii::$app->user->identity->user_enc_id;
                    if (!$rejection_reasons->save()) {
                        $transaction->rollBack();
                        return ['status' => 501];
                    }
                }
                if ($considerJobs) {
                    foreach ($considerJobs as $c) {
                        $utilitiesModel = new Utilities();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $considerJobs = new CandidateConsiderJobs();
                        $considerJobs->consider_job_enc_id = $utilitiesModel->encrypt();
                        $considerJobs->candidate_rejection_enc_id = $model->candidate_rejection_enc_id;
                        $considerJobs->application_enc_id = $c;
                        $considerJobs->created_on = date('Y-m-d H:i:s');
                        $considerJobs->created_by = Yii::$app->user->identity->user_enc_id;
                        if (!$considerJobs->save()) {
                            $transaction->rollBack();
                            return ['status' => 502];
                        }
                    }
                }

                $update = Yii::$app->db->createCommand()
                    ->update(AppliedApplications::tableName(), ['status' => 'Rejected', 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['applied_application_enc_id' => $id])
                    ->execute();
                if ($update == 1) {
                    $transaction->commit();
                    return true;
                } else {
                    $transaction->rollBack();
                    return false;
                }
            } catch (Exception $e) {
                $transaction->rollBack();
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
            $type = 'Clone_Jobs';
            $model = new ApplicationForm();
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
                $data = $model->saveValues($type);
                if ($data['status']) {
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
                        'app_id' => $data['id'],
                    ];
                } else {
                    return $response = [
                        'status' => 500,
                        'title' => 'Error',
                        'message' => $data['message'],
                    ];
                }
            } else {
                $obj = new ApplicationDataProvider();
                $model = $obj->setValues($model, $aidk);
                return $this->render('/employer-applications/form', ['model' => $model,
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
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionCloneTemplate($aidk)
    {
        $application = ApplicationTemplates::find()
            ->alias('a')
            ->joinWith(['applicationTypeEnc f'], false)
            ->where(['a.application_enc_id' => $aidk, 'f.name' => 'Jobs'])
            ->asArray()
            ->one();
        if (Yii::$app->user->identity->organization && $application) {
            $model = new ApplicationForm();
            $type = 'Clone_Jobs';
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

    public function actionPreview()
    {
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

    public function actionEdit($aidk)
    {
        if (Yii::$app->user->identity->organization) {
            $type = 'Edit_Jobs';
            $model = new ApplicationForm();
            $obj = new ApplicationDataProvider();
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
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionDeleteApplication()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');
            $update = Yii::$app->db->createCommand()
                ->update(EmployerApplications::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $id])
                ->execute();
            if ($update) {
                Yii::$app->sitemap->generate();
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionCloseApplication()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');
            $update = Yii::$app->db->createCommand()
                ->update(EmployerApplications::tableName(), ['status' => 'Closed', 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $id])
                ->execute();
            if ($update) {
                Yii::$app->sitemap->generate();
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
            ->having(['type' => 'Jobs'])
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
            ->having(['type' => 'Jobs'])
            ->groupBy('a.applied_application_enc_id')
            ->asArray()
            ->all();


        return $this->render('individual/accepted-jobs', [
            'accepted' => $accepted_applications,
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
            ->having(['type' => 'Jobs'])
            ->groupBy(['b.application_enc_id'])
            ->orderBy(['a.id' => SORT_DESC])
            ->asArray()
            ->all();


        return $this->render('individual/pending-jobs', [
            'pending' => $pending_applications,
        ]);
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
            Yii::$app->response->format = Response::FORMAT_JSON;
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
                        return $response = [
                            'status' => 200,
                            'title' => 'Success',
                            'message' => 'Shortlisted',
                        ];
                    } else {
                        return false;
                    }
                } else if ($status == 1) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ShortlistedApplications::tableName(), ['shortlisted' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $app_id])
                        ->execute();
                    if ($update == 1) {
                        return $response = [
                            'status' => 200,
                            'title' => 'Success',
                            'message' => 'unshort',
                        ];
                    }
                } else if ($status == 0) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ShortlistedApplications::tableName(), ['shortlisted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $app_id])
                        ->execute();
                    if ($update == 1) {
                        return $response = [
                            'status' => 200,
                            'title' => 'Success',
                            'message' => 'Shortlisted',
                        ];
                    }
                }
            }
        }
    }

    public function actionSubmitColleges()
    {
        if (Yii::$app->request->isAjax) {
            $saveCollege = new CollegePlacementForm();
            if ($saveCollege->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($saveCollege->save()) {
                    return $response = [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Colleges Added.',
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

    public function actionQuickJob()
    {
        if (Yii::$app->user->identity->organization->organization_enc_id):
            $model = new ShortJobs();
            $type = 'Jobs';
            $data = new ApplicationForm();
            $primary_cat = $data->getPrimaryFields();
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

    public function actionImage()
    {
        $profile = AssignedCategories::find()
            ->alias('a')
            ->select(['b.name', 'CONCAT("' . Url::to('@commonAssetsDirectory/categories/png/') . '", b.icon_png) icon'])
            ->innerJoinWith(['parentEnc b' => function ($b) {
                $b->onCondition([
                    'or',
                    ['!=', 'b.icon', NULL],
                    ['!=', 'b.icon', ''],
                ])
                    ->groupBy(['b.category_enc_id']);
            }], false)
            ->where([
                'a.assigned_to' => ucfirst(Yii::$app->request->get('type')),
                'a.assigned_category_enc_id' => Yii::$app->request->get('category'),
            ])
            ->asArray()
            ->one();

        if (!$profile) {
            return false;
        }

        if (isset(Yii::$app->user->identity->organization->logo) && !empty(Yii::$app->user->identity->organization->logo)) {
            $organizationLogo = Yii::$app->params->upload_directories->organizations->logo_path . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo_location . DIRECTORY_SEPARATOR . Yii::$app->user->identity->organization->logo;
            $isUrl = 'false';
        } else {
            $organizationLogo = "https://ui-avatars.com/api/?name=" . Yii::$app->user->identity->organization->name . "&size=200&rounded=true&background=" . str_replace("#", "", Yii::$app->user->identity->organization->initials_color) . "&color=ffffff";
            $isUrl = 'true';
        }

        $pyscript = Url::to('@consoleDirectory/commands/applicationSharingImage/main.py');
        $backgroudImage = Url::to('@consoleDirectory/commands/applicationSharingImage/hiring.png');
        $fontPath = Url::to('@consoleDirectory/commands/applicationSharingImage/Lora-Regular.ttf');

        $sharingImagePath = Yii::$app->getSecurity()->generateRandomString();
        $sharingImage = Yii::$app->getSecurity()->generateRandomString() . '.png';
        $imagePath = Yii::$app->params->upload_directories->applications->image_path . $sharingImagePath . DIRECTORY_SEPARATOR . $sharingImage;

        $cmd = 'sudo python3 "' . $pyscript . '" "' . $backgroudImage . '" "' . $organizationLogo . '" "' . $imagePath . '" "' . $profile["name"] . '" "' . $profile["icon"] . '" "' . $fontPath . '" "' . $isUrl . '"';
        if (exec($cmd)) {
            return Url::to(Yii::$app->params->upload_directories->applications->image . $sharingImagePath . DIRECTORY_SEPARATOR . $sharingImage, 'https');
        }

        return false;
    }

    public function actionQuickJobClone($editid)
    {
        if (Yii::$app->user->identity->organization) {
            $typ = 'Jobs';
            $obj = new ShortJobs();
            $data = new ApplicationForm();
            $primary_cat = $data->getPrimaryFields();
            $model = $obj->setData($editid, $typ);
            $job_type = $data->getApplicationTypes();
            $placement_locations = $data->PlacementLocations();
            $currencies = $data->getCurrency();
            if ($obj->load(Yii::$app->request->post())) {
                if ($obj->save()) {
                    Yii::$app->session->setFlash('success', 'Your Information Has Been Successfully Submitted..');
                } else {
                    Yii::$app->session->setFlash('error', 'Something Went Wrong..');
                }
                return $this->refresh();
            }
            return $this->render('/employer-applications/one-click-job', ['skill' => $model['skill'], 'typ' => $typ, 'currencies' => $currencies, 'placement_locations' => $placement_locations, 'model' => $model['mod'], 'list' => $model['list'], 'primary_cat' => $primary_cat, 'job_type' => $job_type]);
        }
    }

    public function actionQuickJobEdit($editid)
    {
        if (Yii::$app->user->identity->organization) {
            $typ = 'Jobs';
            $obj = new ShortJobs();
            $data = new ApplicationForm();
            $primary_cat = $data->getPrimaryFields();
            $model = $obj->setData($editid, $typ);
            $job_type = $data->getApplicationTypes();
            $placement_locations = $data->PlacementLocations();
            $currencies = $data->getCurrency();
            if ($obj->load(Yii::$app->request->post())) {
                if ($obj->update($editid, $typ)) {
                    Yii::$app->session->setFlash('success', 'Your Information Has Been Updated Successfully');
                } else {
                    Yii::$app->session->setFlash('error', 'Something Went Wrong..');
                }
                return $this->refresh();
            }
            return $this->render('/employer-applications/one-click-job', ['skill' => $model['skill'], 'typ' => $typ, 'currencies' => $currencies, 'placement_locations' => $placement_locations, 'model' => $model['mod'], 'list' => $model['list'], 'primary_cat' => $primary_cat, 'job_type' => $job_type]);
        }
    }

    public function actionCampusPlacement()
    {
        if (Yii::$app->user->identity->businessActivity->business_activity != "College" && Yii::$app->user->identity->businessActivity->business_activity != "School" && Yii::$app->user->identity->organization->has_placement_rights == 1) {
            $colleges = Organizations::find()
                ->alias('a')
                ->distinct()
                ->select(['a.organization_enc_id', 'a.organization_enc_id college_enc_id', 'a.name', 'a.initials_color color',
                    'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END logo',
                    'e.name city'])
                ->innerJoinWith(['businessActivityEnc b' => function ($b) {
                    $b->onCondition(["b.business_activity" => "College"]);
                }], false)
                ->joinWith(['organizationOtherDetails c' => function ($c) {
                    $c->joinWith(['locationEnc e'], true);
                }], false)
                ->where([
                    "a.is_erexx_approved" => 1,
                    "a.status" => "Active",
                    "a.is_deleted" => 0,
                ])
                ->asArray()
                ->all();
            $type = 'jobs';
            return $this->render('/employer-applications/campus-placement', [
                'applications' => $this->__jobss(),
                'colleges' => $colleges,
                'type' => $type,
            ]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page Not Found.'));
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
                ->where(['f.name' => "Jobs"])
//            ->groupBy('zz.name')
                ->asArray()
                ->all();
            return $this->render('jobs-templates', [
                'jobs' => $application,
            ]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionStoreSession()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $session = Yii::$app->session;
            $session->set('campusPlacementData', $data);
            return [
                'status' => 200
            ];
        }
    }

    public function actionSubmitErexxApplications()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $model = new \common\models\extended\EmployerApplications();
            $app = $model->_cloneApplication($data['applications'], 2);
            if (!$app) {
                return $response = [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'An error has occured. Please Try again later.',
                ];
            }
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
            if ($data['subscribed-to-all']) {
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

    private function __updateApplicationFor($app, $for)
    {
        if ($for) {
            $update = Yii::$app->db->createCommand()
                ->update(EmployerApplications::tableName(), ['for_all_colleges' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $app])
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

    public function actionExtendsDate()
    {
        $model = new ExtendsJob();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    public function actionAppliedApplications()
    {
        if (!empty(Yii::$app->user->identity->organization)) {
            $userApplied = new UserAppliedApplication();
            $applied_users = $userApplied->getUserOtherDetails('Jobs');
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
            $applied_users = $this->getAllAppliedApplications($aidk, 'Jobs');
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
                $a->select(['a.applied_application_enc_id', 'a.rejection_window', 'a.created_on', 'a.application_enc_id', 'a.status', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'a.created_by', 'a.resume_enc_id', 'e.resume', 'e.resume_location', 'b.user_enc_id', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image',]);
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

    public function actionJobsOfCompany()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $params = Yii::$app->request->post();
            $app_id = AppliedApplications::find()
                ->andWhere(['applied_application_enc_id' => $params['app_id']])
                ->one();
            $app_id = $app_id->application_enc_id;
            $all_application = EmployerApplications::find()
                ->distinct()
                ->alias('a')
                ->select(['c.name job_title', 'a.slug', 'a.application_enc_id', 'ate.name application_type', 'pe.icon'])
                ->joinWith(['title b' => function ($b) {
                    $b->joinWith(['categoryEnc c'], false, 'INNER JOIN');
                    $b->joinWith(['parentEnc pe'], false, 'INNER JOIN');
                }], false, 'INNER JOIN')
                ->joinWith(['applicationTypeEnc ate'], false)
                ->joinWith(['applicationPlacementLocations o' => function ($b) {
                    $b->onCondition(['o.is_deleted' => 0]);
                    $b->joinWith(['locationEnc s' => function ($b) {
                        $b->joinWith(['cityEnc t'], false);
                    }], false);
                    $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 's.latitude', 's.longitude', 't.city_enc_id', 't.name']);
                    $b->distinct();
                }])
                ->joinWith(['applicationOptions ao'], false)
                ->where(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'a.is_deleted' => 0, 'ate.name' => $params['app_type']])
                ->andWhere(['not', ['a.application_enc_id' => $app_id]])
                ->andWhere(['not', ['a.status' => 'Closed']])
                ->groupBy(['a.application_enc_id'])
                ->asArray()
                ->all();
            return ['status' => 200, 'data' => $all_application];
        }
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
            ->where(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'a.is_deleted' => 0, 'f.name' => 'Jobs'])
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
                    'f.name' => 'Jobs'
                ])
                ->asArray()
                ->all();

            $shortlistedApplicants[$key]['skills'] = $skills;
            $shortlistedApplicants[$key]['applications'] = $applications;
        }

        return ['data' => $shortlistedApplicants, 'count' => $count];
    }

    public function actionSavedCandidates()
    {
        return $this->render('list/saved-candidates', [
              'savedApplicants' => $this->savedApplicants(),
        ]);

    }

    private function savedApplicants($limit = null){
        $savedCandidates = AppliedApplications::find()
            ->distinct()
            ->alias('a')
            ->select([
                'a.applied_application_enc_id', 'cr.candidate_rejection_enc_id',
                'a.status', 'b.username', 'b.initials_color', 'CONCAT(b.first_name, " ", b.last_name) name',
                'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image',
                'a.created_by', 'b3.name as city'])
            ->joinWith(['applicationEnc bb' => function($bb){
                $bb->joinWith(['applicationTypeEnc f'], false);
            }], false)
            ->joinWith(['candidateRejections cr'], false)
            ->joinWith(['createdBy b' => function ($b) {
                $b->select(['b.user_enc_id']);
                $b->joinWith(['userSkills b1' => function ($b1) {
                    $b1->groupBy(['b1.user_skill_enc_id']);
                    $b1->select(['b1.skill_enc_id', 'b1.user_skill_enc_id', 'b2.skill', 'b1.created_by']);
                    $b1->joinWith(['skillEnc b2'], false);
                    $b1->onCondition(['b1.is_deleted' => 0]);
                }]);
                $b->joinWith(['cityEnc b3'], false);
            }])
            ->where([
                'cr.rejection_type' => 3,
                'bb.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'f.name' => 'Jobs',
                'cr.is_deleted' => 0
            ])
            ->groupBy(['a.created_by']);
            $count = $savedCandidates->count();
            if($limit != null){
                $savedCandidates -> limit($limit);
            }
            $savedCandidates = $savedCandidates
            ->asArray()
            ->all();
            foreach ($savedCandidates as $key=>$sc){
                $applications = AppliedApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id', 'ee.name as title', 'bb.slug', 'cr.candidate_rejection_enc_id'])
                    ->joinWith(['applicationEnc bb' => function($bb){
                        $bb->joinWith(['applicationTypeEnc f'], false);
                        $bb->joinWith(['title d' => function ($d) {
                            $d->joinWith(['parentEnc e']);
                            $d->joinWith(['categoryEnc ee']);
                        }], false);
                    }], false)
                    ->joinWith(['candidateRejections cr'], false)
                    ->where([
                        'a.created_by'=>$sc['created_by'],
                        'cr.rejection_type' => 3,
                        'bb.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                        'f.name' => 'Jobs',
                        'cr.is_deleted' => 0
                    ])
                    ->asArray()
                    ->all();
                    $savedCandidates[$key]['applications'] = $applications;
            }
        return ['data' => $savedCandidates, 'count' => $count];
    }

    public function actionRemoveSavedCandidate(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $id = Yii::$app->request->post('candidate_rejection_enc_id');

            $success = [
                'status' => 200,
                'message' => 'successfully removed'
            ];
            $error = [
                'status' => 500,
                'message' => 'an error occurred'
            ];

            try {

                $savedCandidate = CandidateRejection::findone(['candidate_rejection_enc_id' => $id, 'created_by' => Yii::$app->user->identity->user_enc_id]);
                if ($savedCandidate) {
                    $savedCandidate->is_deleted = 1;
                    $savedCandidate->last_updated_by = Yii::$app->user->identity->user_enc_id;
                    $savedCandidate->last_updated_on = date('Y-m-d H:i:s');
                    if (!$savedCandidate->update()) {
                        return $error;
                    }
                    return $success;
                }

                return $error;

            } catch (\Exception $e) {
                return $error;
            }
        }
    }
    public function actionBlacklistedCandidates(){
        return $this->render('list/blacklisted-candidates', [
            'blacklistedApplicants' => $this->blacklistedCandidates()
        ]);
    }
    private function blacklistedCandidates($limit = null){
        $blockedCandidates = AppliedApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['a.applied_application_enc_id', 'cr.applied_application_enc_id as cr_applied_application_enc_id',
                'cr.candidate_rejection_enc_id', 'a.status','b.username', 'b.initials_color', 'CONCAT(b.first_name, " ", b.last_name) name',
                'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image',
                'a.created_by', 'b3.name as city', 'cr.rejection_type'])
            ->joinWith(['applicationEnc bb' => function($bb){
                $bb->joinWith(['applicationTypeEnc f'], false);
            }], false)
            ->joinWith(['candidateRejections cr'], false)
            ->joinWith(['createdBy b' => function ($b) {
                $b->select(['b.user_enc_id']);
                $b->joinWith(['userSkills b1' => function ($b1) {
                    $b1->groupBy(['b1.user_skill_enc_id']);
                    $b1->select(['b1.skill_enc_id', 'b1.user_skill_enc_id', 'b2.skill', 'b1.created_by']);
                    $b1->joinWith(['skillEnc b2'], false);
                    $b1->onCondition(['b1.is_deleted' => 0]);
                }]);
                $b->joinWith(['cityEnc b3'], false);
            }])
            ->where([
                'cr.rejection_type' => 1,
                'bb.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'f.name' => 'Jobs',
                'cr.is_deleted' => 0
            ])
            ->groupBy(['a.created_by']);
            $count = $blockedCandidates->count();
            if($limit != null){
                $blockedCandidates -> limit($limit);
            }
            $blockedCandidates = $blockedCandidates
            ->asArray()
            ->all();
//            print_r($blockedCandidates);
//            die();
            foreach ($blockedCandidates as $key=>$sc){
                $applications = AppliedApplications::find()
                    ->alias('a')
                    ->select(['a.application_enc_id', 'ee.name as title', 'bb.slug', 'cr.candidate_rejection_enc_id'])
                    ->joinWith(['applicationEnc bb' => function($bb){
                        $bb->joinWith(['applicationTypeEnc f'], false);
                        $bb->joinWith(['title d' => function ($d) {
                            $d->joinWith(['parentEnc e']);
                            $d->joinWith(['categoryEnc ee']);
                        }], false);
                    }], false)
                    ->joinWith(['candidateRejections cr'], false)
                    ->where([
                        'a.created_by'=>$sc['created_by'],
                        'cr.rejection_type' => 1,
                        'bb.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                        'f.name' => 'Jobs',
                        'cr.is_deleted' => 0
                    ])
                    ->asArray()
                    ->all();
                $blockedCandidates[$key]['applications'] = $applications;
            }
            return['data' => $blockedCandidates, 'count' => $count];
    }

    public function actionUnblockCandidate(){
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            Yii::$app->response->format = Response::FORMAT_JSON;

            $id = Yii::$app->request->post('id');
            $success = [
                'status' => 200,
                'message' => 'successfully unblocked'
            ];
            $error = [
                'status' => 500,
                'message' => 'an error occurred'
            ];
            try {
                $blockedCandidate = CandidateRejection::findOne(['candidate_rejection_enc_id' => $id, 'created_by' => Yii::$app->user->identity->user_enc_id]);
                if($blockedCandidate){
                    $blockedCandidate->rejection_type = 4;
                    $blockedCandidate->last_updated_by = Yii::$app->user->identity->user_enc_id;
                    $blockedCandidate->last_updated_on = date('Y-m-d H:i:s');
                    if(!$blockedCandidate->update()){
                        return $error;
                    }
                    return $success;
                }
                return $error;
            }catch (\Exception $e){
                return $error;
            }
        }
    }
    public function actionAllClosedJobs(){
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
            $data = $this->__closedjobs($limit, $page);
            if($data['total'] != 0){
                foreach ($data['data'] as $key => $val){
                    $data['data'][$key]['last_date'] = date("d-m-Y", strtotime($val['last_date']));
                }
                return['status' => 200, 'data' => $data];
            }
            else{
                return['status' => 404, 'message' => 'Page Not Found'];
            }
        }
        return $this->render('all-closed-jobs',[
            'model' => $model
        ]);
    }
}