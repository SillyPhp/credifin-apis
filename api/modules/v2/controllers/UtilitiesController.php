<?php

namespace api\modules\v2\controllers;

use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Cities;
use common\models\CollegeCourses;
use common\models\Countries;
use common\models\EmailLogs;
use common\models\Organizations;
use common\models\Referral;
use common\models\States;
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
                ->select(['a.referral_enc_id', 'b.organization_enc_id','c.business_activity', 'b.name', '(CASE
                WHEN b.logo IS NULL OR b.logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", b.name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) END
                ) organization_logo'])
                ->joinWith(['organizationEnc b' => function ($b) {
                    $b->joinWith(['businessActivityEnc c'], false);
                }], false)
                ->where([
                    'b.is_erexx_registered' => 1,
                    'b.status' => 'Active',
                    'b.is_deleted' => 0,
                    'a.code' => $ref,
                    'c.business_activity' => ['College','School']
                ])
                ->asArray()
                ->one();

            $courses = CollegeCourses::find()
                ->alias('a')
                ->select(['a.college_course_enc_id', 'a.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.college_course_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $organization['organization_enc_id']])
                ->groupBy(['a.course_name'])
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
                CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", b.logo_location, "/", b.logo) END
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

            $courses = CollegeCourses::find()
                ->alias('a')
                ->select(['a.college_course_enc_id', 'a.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.college_course_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $organization['organization_enc_id']])
                ->groupBy(['a.course_name'])
                ->asArray()
                ->all();

            $organization['is_teacher'] = false;
            $organization['courses'] = $courses;

            return $organization;
        }
    }

    public function actionGetCompanies($search = null)
    {
        $organizations = Organizations::find()
            ->select([
                'organization_enc_id',
                'b.business_activity',
                'name',
                '(CASE
                WHEN logo IS NULL OR logo = "" THEN
                CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") ELSE
                CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) END
                ) organization_logo'
            ])
            ->joinWith(['businessActivityEnc b'],false)
            ->where([
                'is_erexx_registered' => 1,
                'status' => 'Active',
                'is_deleted' => 0,
                'b.business_activity' => ['College','School']
            ]);
        if ($search) {
            $organizations->
            andWhere([
                'or',
                ['like', 'name', $search],
                ['like', 'slug', $search]
            ]);
        }
        $organizations = $organizations->asArray()
            ->all();

        $i = 0;
        foreach ($organizations as $o) {
            $courses = CollegeCourses::find()
                ->alias('a')
                ->select(['a.college_course_enc_id', 'a.course_name', 'a.course_duration', 'a.type'])
                ->joinWith(['collegeSections b' => function ($b) {
                    $b->select(['b.college_course_enc_id', 'b.section_enc_id', 'b.section_name']);
                    $b->onCondition(['b.is_deleted' => 0]);
                }])
                ->where(['a.organization_enc_id' => $o['organization_enc_id']])
                ->groupBy(['a.course_name'])
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

}