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
use yii\helpers\Url;

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

    public function actionIndex($offset = null)
    {
        $data = Users::find()
            ->alias('a')
            ->select([
                'a.user_enc_id',
                'a.city_enc_id',
                'a.user_type_enc_id',
                'CONCAT(a.first_name, " ", a.last_name) fullname',
                'a.image',
                'a.image_location',
                'a.initials_color',
                'a.username',
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
            ->limit(20)
            ->offset($offset)
            ->distinct()
            ->asArray()
            ->all();

        $users = [];
        $j = 0;
        foreach ($data as $u) {
            if($u['image']){
                $icon = '<a href="/'.$u['username'].'"><img src="'. Url::to(Yii::$app->params->upload_directories->users->image . $u['image_location'] . '/' . $u['image']) .'" alt="'.$u['fullname'].'"></a>';
            } else {
                $icon = '<canvas class="user-icon img-circle img-responsive" name="'.$u['fullname'].'" color="'.$u['initials_color'].'" width="140" height="140" font="70px"></canvas>';
            }
            array_push($users, [
                'fullname' => $u['fullname'],
                'image' => $u['image'],
                'image_location' => $u['image_location'],
                'initials_color' => $u['initials_color'],
                'username' => $u['username'],
                'sk_count' => $u['sk_count'],
                'exp_count' => $u['exp_count'],
                'city_name' => ($u['city_name']) ? $u['city_name'] : 'N/A',
                'userWorkExperiences' => ($u['userWorkExperiences']) ? [
                    'company' => $u['userWorkExperiences'][0]['company'],
                    'title' => $u['userWorkExperiences'][0]['title']
                ] : '',
                'icon' => $icon,
                'skills' => [],
            ]);
            if ($u['userSkills']) {
                $plus_count = '';
                if (count($u['userSkills']) > 3) {
                    $count = 3;
                    $c = count($u['userSkills']) - $count;
                    $plus_count = '<li class="more-skill bg-primary">+'.$c.'</li>';
                } else {
                    $count = count($u['userSkills']);
                }
                for ($i = 0; $i < $count; $i++) {
                    array_push($users[$j]['skills'], '<li>' . $u['userSkills'][$i]['skill'] . '</li>');
                }
                if ($plus_count) {
                    array_push($users[$j]['skills'], $plus_count);
                }
            }
            $j++;
        }

        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $users;
        } else {
            return $this->render('index', [
                'users' => $users
            ]);
        }
    }

}