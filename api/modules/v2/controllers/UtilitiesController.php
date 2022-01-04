<?php

namespace api\modules\v2\controllers;

use common\models\AssignedCategories;
use common\models\AssignedCollegeCourses;
use common\models\Categories;
use common\models\Cities;
use common\models\CollegeCoursesPool;
use common\models\Countries;
use common\models\EmailLogs;
use common\models\Organizations;
use common\models\Referral;
use common\models\Speakers;
use common\models\States;
use common\models\UserOtherDetails;
use common\models\WebinarSpeakers;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class UtilitiesController extends ApiBaseController
{

    public function actionGetCompany($ref = null, $invitation = null)
    {
        if ($ref != null && $invitation != null) {
            $organization = Referral::find()
                ->alias('a')
                ->select(['a.referral_enc_id', 'b.organization_enc_id', 'c.business_activity', 'b.name', '(CASE
                WHEN b.logo IS NULL OR b.logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) END
                ) organization_logo'])
                ->joinWith(['organizationEnc b' => function ($b) {
                    $b->joinWith(['businessActivityEnc c'], false);
                }], false)
                ->where([
                    'b.is_erexx_registered' => 1,
                    'b.status' => 'Active',
                    'b.is_deleted' => 0,
                    'a.code' => $ref,
                    'c.business_activity' => ['College', 'School']
                ])
                ->asArray()
                ->one();

            $courses = AssignedCollegeCourses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['courseEnc c'], false)
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $organization['organization_enc_id'], 'a.is_deleted' => 0])
//                ->groupBy(['a.course_name'])
                ->asArray()
                ->all();

            $invi = EmailLogs::find()
                ->where(['email_log_enc_id' => $invitation])
                ->asArray()
                ->one();

            if ($invi && $invi['type'] == 2) {
                $organization['is_teacher'] = true;
            } else {
                $organization['is_teacher'] = false;
            }

            $organization[0]['courses'] = $courses;

            return $organization;
        } elseif ($ref != null) {
            $organization = Referral::find()
                ->alias('a')
                ->select(['a.referral_enc_id', 'b.organization_enc_id', 'b.name', '(CASE
                WHEN b.logo IS NULL OR b.logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) END
                ) organization_logo'])
                ->joinWith(['organizationEnc b' => function ($b) {
                    $b->joinWith(['businessActivityEnc c'], false);
                }], false)
                ->where([
                    'b.is_erexx_registered' => 1,
                    'b.status' => 'Active',
                    'b.is_deleted' => 0,
                    'a.code' => $ref,
                    'c.business_activity' => 'College'
                ])
                ->asArray()
                ->one();

            $courses = AssignedCollegeCourses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['courseEnc c'], false)
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $organization['organization_enc_id'], 'a.is_deleted' => 0])
//                ->groupBy(['a.course_name'])
                ->asArray()
                ->all();

            $organization['is_teacher'] = false;
            $organization['courses'] = $courses;

            return $organization;
        }
    }

    public function actionGetStates($search = null)
    {
        $states = States::find()
            ->select(['state_enc_id', 'name'])
            ->where(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09']);
        if ($search != null && $search != '') {
            $states->andWhere(['like', 'name', $search]);
        }
        $states = $states->limit(10)->asArray()
            ->all();

        return $states;
    }

    public function actionGetCities($search = null)
    {
        $cities = Cities::find()
            ->alias('a')
            ->select(['a.city_enc_id', 'a.name'])
            ->joinWith(['stateEnc b'], false)
            ->where(['b.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09']);
        if ($search != null && $search != '') {
            $cities->andWhere(['like', 'a.name', $search]);
        }
        $cities = $cities->limit(10)->asArray()
            ->all();

        return $cities;
    }

    public function actionGetCompanies($search = null, $filterby = null, $limit = null)
    {
        $l = 20;
        if ($limit) {
            $l = $limit;
        }
        $organizations = Organizations::find()
            ->select([
                'organization_enc_id',
                'b.business_activity',
                'name',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) END
                ) organization_logo'
            ])
            ->joinWith(['businessActivityEnc b'], false)
            ->where([
                'is_erexx_registered' => 1,
                'status' => 'Active',
                'is_deleted' => 0,
                'b.business_activity' => ['College', 'School']
            ]);
        if ($search) {
            $organizations->
            andWhere([
                'or',
                ['like', 'name', $search],
                ['like', 'slug', $search]
            ]);
        }
        if ($filterby) {
            $organizations->andWhere(['like', 'name', $filterby . '%', false]);
        }
        $organizations = $organizations->limit($l)->asArray()
            ->all();

        $i = 0;
        foreach ($organizations as $o) {
            $courses = AssignedCollegeCourses::find()
                ->distinct()
                ->alias('a')
                ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['courseEnc c'], false)
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.assigned_college_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $o['organization_enc_id'], 'a.is_deleted' => 0])
//                ->groupBy(['a.course_name'])
                ->asArray()
                ->all();

            $organizations[$i]['courses'] = $courses;
            $i++;
        }

        return $organizations;
    }

    public function actionProfiles($type)
    {
        $q = Categories::find()
            ->distinct()
            ->alias('a')
            ->select(['a.name', 'a.category_enc_id'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.category_enc_id = a.category_enc_id')
            ->where(['b.assigned_to' => $type, 'b.status' => 'Approved'])
            ->asArray()
            ->all();

        return $this->response(200, $q);
    }

    public function actionStates()
    {
        $statesModel = new States();
        $states = ArrayHelper::map($statesModel->find()->select(['state_enc_id', 'name'])->where(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMoGM2K3loZz09'])->orderBy(['name' => SORT_ASC])->asArray()->all(), 'name', 'state_enc_id');
        $states = ['select' => 'default'] + $states;
        return $this->response(200, $states);
    }

    public function actionCities($n = null, $id = null)
    {
        $cities = Cities::find()
            ->alias('a')
            ->select(['a.city_enc_id AS id', 'a.name AS name'])
            ->innerJoin(States::tableName() . ' as b', 'b.state_enc_id = a.state_enc_id')
            ->innerJoin(Countries::tableName() . ' as c', 'c.country_enc_id = b.country_enc_id')
            ->where(['c.country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
            ->andFilterWhere(['like', 'a.name', $n])
            ->andFilterWhere(['like', 'a.city_enc_id', $id])
            ->asArray()
            ->all();
        return $this->response(200, $cities);
    }

    public function actionFeaturedCompanies()
    {
        $org = Organizations::find()
            ->select(['name', '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) END
                ) organization_logo'])
            ->where(['is_deleted' => 0, 'status' => 'Active', 'is_featured' => 1])
            ->limit(12)
            ->asArray()
            ->all();

        if ($org) {
            return $this->response(200, ['status' => 200, 'org' => $org]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionPoolCourses($keyword = null)
    {
        $courses = CollegeCoursesPool::find()
            ->select(['course_enc_id', 'course_name']);
        if ($keyword != null) {
            $courses->andFilterWhere(['like', 'course_name', $keyword]);
            $courses->limit(10);
        } else {
            $courses->limit(35);
            $courses->orderBy(['course_name' => SORT_ASC]);
        }
        $courses = $courses->asArray()
            ->all();

        return $courses;
    }

    public function actionWebinarSpeakers($keyword = null)
    {
        $speakers = Speakers::find()
            ->alias('a')
            ->select(['a.speaker_enc_id', 'a.user_enc_id', 'CONCAT(b.first_name, " ", b.last_name) full_name',])
            ->joinWith(['userEnc b'], false)
            ->where(['a.is_deleted' => 0]);
        if ($keyword != null) {
            $speakers->andFilterWhere(['like', 'CONCAT(b.first_name, " ", b.last_name)', $keyword]);
        }
        $speakers = $speakers->limit(10)
            ->asArray()
            ->all();

        if ($speakers) {
            return $this->response(200, ['status' => 200, 'speakers' => $speakers]);
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionUnapprovedMail()
    {
        $colleges = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name', 'COUNT(CASE WHEN b.college_actions IS NULL Then 1 END) as unapproved_count'])
            ->joinWith(['userOtherDetails b'], false)
            ->groupBy(['b.organization_enc_id'])
            ->where(['b.is_deleted' => 0])
            ->having(['>', 'unapproved_count', 10])
            ->asArray()
            ->all();

        return $colleges;
    }

    public function actionAppliedStudents()
    {

        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $currentDate = $dt->format('Y-m');

        $params = Yii::$app->request->post();

        if (!isset($params['college_id']) && empty($params['college_id'])) {
            return $this->response(400, ['status' => 400, 'message' => 'missing information "college_id"']);
        }

        $signed_up_students = UserOtherDetails::find()
            ->where(['organization_enc_id' => $params['college_id'], 'is_deleted' => 0, 'college_actions' => 0])
            ->andWhere(['like', 'updated_on', $currentDate])
            ->count();

        return (int)$signed_up_students;

    }

}