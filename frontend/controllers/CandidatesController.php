<?php

namespace frontend\controllers;

use common\models\Cities;
use common\models\Users;
use common\models\UserSkills;
use common\models\UserTypes;
use common\models\UserWorkExperience;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class CandidatesController extends Controller
{

//    public function beforeAction($action)
//    {
//        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
//        return parent::beforeAction($action);
//    }

    public function actionFeatures()
    {
        return $this->render('features');
    }

    public function actionGitCandidate()
    {
        $users = Users::find()
            ->alias('a')
            ->select([
                'a.user_enc_id',
                'a.city_enc_id',
                'a.user_type_enc_id',
                'a.first_name',
                'a.last_name',
                'a.image',
                'a.image_location',
                'COUNT(DISTINCT(c.user_skill_enc_id)) as sk_count',
                'COUNT(DISTINCT(e.experience_enc_id)) as exp_count',
                'f.name city_name',
            ])
            ->joinWith(['userTypeEnc b'], false)
            ->joinWith(['userSkills c' => function ($c) {
                $c->select(['c.created_by', 'c.user_skill_enc_id', 'c.skill_enc_id', 'c1.skill']);
                $c->joinWith(['skillEnc c1'], false);
                $c->onCondition(['c.is_deleted' => 0]);
                $c->orderBy(['c.created_on' => SORT_DESC]);
            }])
            ->joinWith(['userWorkExperiences e' => function ($e) {
                $e->select(['e.created_by', 'e.experience_enc_id', 'e.company', 'e.title']);
                $e->onCondition(['not', [
                    'e.company' => null,
                    'e.title' => null,
                ]]);
                $e->onCondition(['not', ['e.id' => null]]);
                $e->orderBy(['e.created_on' => SORT_DESC]);
            }])
            ->joinWith(['cityEnc f'], false)
            ->andWhere(['or', ['a.organization_enc_id' => NULL], ['a.organization_enc_id' => '']])
            ->andWhere(['b.user_type' => 'Individual'])
            ->andWhere(['a.user_of' => 'EY'])
            ->andWhere(['a.is_deleted' => 0])
            ->groupBy('a.user_enc_id')
            ->orderBy(['exp_count' => SORT_DESC, 'sk_count' => SORT_DESC, 'e.company' => SORT_ASC, 'e.title' => SORT_ASC])
            ->distinct()
            ->asArray()
            ->all();

//        print_r($users);
//        exit();
//        print_r(count($users));exit();
        return $this->render('git-candidate', [
            'users' => $users
        ]);
    }

}