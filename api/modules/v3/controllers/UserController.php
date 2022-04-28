<?php

namespace api\modules\v3\controllers;

use yii\db\Query;
use common\models\UserEducation;
use common\models\Users;
use common\models\UserSkills;
use common\models\UserSpokenLanguages;
use common\models\UserTypes;
use common\models\Utilities;
use Yii;
use yii\web\Response;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

class UserController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'move-titles' => ['OPTIONS', 'GET'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }
    public function actionGetUncompletedProfileUsers($page = null, $limit = null, $permissionKey)
    {
        if ($permissionKey == Yii::$app->params->EmpowerYouth->permissionKey) {
            if (!$page) {
                $page = 1;
            }
            if (!$limit) {
                $limit = 10;
            }
            $offset = ($page - 1) * $limit;
            $users = Users::find()
                ->alias('a')
                ->distinct()
                ->select(['a.user_enc_id', 'a.email', 'CONCAT(a.first_name, " ", a.last_name) name', 'a.username', 'a.created_on'])
                ->joinWith(['userTypeEnc b'])
                ->joinWith(['userEducations c' => function ($c) {
                    $c->addSelect(['c.user_enc_id', 'c.education_enc_id']);
                }])
                ->joinWith(['userSkills d' => function ($d) {
                    $d->addSelect(['d.created_by', 'd.user_skill_enc_id']);
                }])
                ->joinWith(['userSpokenLanguages e' => function ($e) {
                    $e->addSelect(['e.created_by', 'e.user_language_enc_id']);
                }])
                ->andWhere(['a.is_deleted' => 0])
                ->offset($offset)
                ->limit($limit)
                ->orderBy(['a.created_on' => SORT_DESC])
                ->asArray()
                ->all();
            if ($users) {
                for ($i = 0; $i < count($users); $i++) {
                    if ($users[$i]['gender'] == '' || $users[$i]['description'] == '' || $users[$i]['image'] == '' || $users[$i]['city_enc_id'] == '' || $users[$i]['dob'] == '' || $users[$i]['experience'] == '' || $users[$i]['job_function'] == '' || empty($users[$i]['userEducations']) || empty($users[$i]['userSkills']) || empty($users[$i]['userSpokenLanguages'])) {
                        $percentage = self::getProfileCompleted($users[$i]['user_enc_id']);
                        $users[$i] += ['profile_percentage' => $percentage];
                    }
                }
                return $this->response(200, ['status' => 200, 'data' => $users]);
            } else {
                return $this->response(201, ['status' => 201, 'message' => 'Data Not Found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
    private function getProfileCompleted($key)
    {
        $d = (new Query())
            ->from(['a' => \common\models\Users::tableName()])
            ->select(['a.user_enc_id', 'a.email', 'CONCAT(a.first_name, " ", a.last_name) name', 'a.username', 'a.gender', 'a.description', 'a.image', 'a.city_enc_id', 'a.dob', 'a.experience', 'a.job_function', 'e.user_language_enc_id', 'd.user_skill_enc_id', 'c.education_enc_id'])
            ->leftJoin(UserTypes::tableName() . 'as b', 'b.user_type_enc_id = a.user_type_enc_id')
            ->leftJoin(UserEducation::tableName() . 'as c', 'c.user_enc_id = a.user_enc_id')
            ->leftJoin(UserSkills::tableName() . 'as d', 'd.created_by = a.user_enc_id')
            ->leftJoin(UserSpokenLanguages::tableName() . 'as e', 'e.created_by = a.user_enc_id')
            ->andWhere(['a.user_enc_id' => $key])
            ->one();
        $per = 0;
        $total = 10;
        $t = 100 / $total;
        if ($d['user_language_enc_id']) {
            $per += $t;
        }
        if ($d['user_skill_enc_id']) {
            $per += $t;
        }
        if ($d['education_enc_id']) {
            $per += $t;
        }
        if ($d['experience']) {
            $per += $t;
        }
        if ($d['image']) {
            $per += $t;
        }
        if ($d['job_function']) {
            $per += $t;
        }
        if ($d['description']) {
            $per += $t;
        }
        if ($d['gender']) {
            $per += $t;
        }
        if ($d['city_enc_id']) {
            $per += $t;
        }
        if ($d['dob']) {
            $per += $t;
        }
        return $per;
    }
}