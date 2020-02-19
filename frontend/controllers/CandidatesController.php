<?php

namespace frontend\controllers;

use common\models\Cities;
use common\models\DropResumeApplications;
use common\models\EmployerApplications;
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


    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

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
            if ($u['image']) {
                $icon = '<a href="/' . $u['username'] . '"><img src="' . Url::to(Yii::$app->params->upload_directories->users->image . $u['image_location'] . '/' . $u['image']) . '" alt="' . $u['fullname'] . '"></a>';
            } else {
                $icon = '<canvas class="user-icon img-circle img-responsive" name="' . $u['fullname'] . '" color="' . $u['initials_color'] . '" width="140" height="140" font="70px"></canvas>';
            }
            array_push($users, [
                'user_enc_id' => $u['user_enc_id'],
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
                    $plus_count = '<li class="more-skill bg-primary">+' . $c . '</li>';
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
                'users' => $users,
                'available_applications' => $this->getApplications(),
            ]);
        }
    }

    public function actionShortlist()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $user_id = Yii::$app->request->post('user_id');
            $app_id = Yii::$app->request->post('app_id');

            $success = ['status' => 200];
            $failure = ['status' => 201];


            if (!$this->setShortlist($user_id, $app_id)) {
                return json_encode($failure);
            } else {
                return json_encode($success);
            }

//            foreach ($applied_app_enc_id as $c) {
//                if (!$this->setShortList($c, $application_id)) {
//                    return json_encode($failure);
//                }
//            }
//            return json_encode($success);

        }
    }

    public function actionGetData()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $user_id = Yii::$app->request->post('user_id');

            $failure = ['status' => 404];

            $selected_applications = DropResumeApplications::find()
                ->alias('a')
                ->select(['a.applied_application_enc_id','a.user_enc_id','a.application_enc_id'])
                ->joinWith(['applicationEnc b'],false)
                ->where(['a.user_enc_id' => $user_id, 'b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->asArray()
                ->all();

            if(!empty($selected_applications)){
                return json_encode($selected_applications);
            }else{
                return json_encode($failure);
            }
        }
    }

    private function setShortlist($user_id, $app_id)
    {
        $shortlist = new DropResumeApplications();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $shortlist->applied_application_enc_id = $utilitiesModel->encrypt();
        $shortlist->user_enc_id = $user_id;
        $shortlist->application_enc_id = $app_id;
        $shortlist->created_by = Yii::$app->user->identity->user_enc_id;
        $shortlist->last_updated_by = Yii::$app->user->identity->user_enc_id;
        $shortlist->status = 1;
        if ($shortlist->save()) {
            return true;
        }
    }

    private function getApplications()
    {
        $employer_applications = EmployerApplications::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.title', 'c.category_enc_id', 'd.name'])
            ->joinWith(['title c' => function ($x) {
                $x->joinWith(['categoryEnc d'], false);
            }], false)
            ->joinWith(['organizationEnc b'], false)
            ->where(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'a.is_deleted' => 0, 'a.status' => 'Active'])
//            ->andWhere(['c.assigned_to' => $type])
            ->asArray()
            ->all();

        return $employer_applications;
    }

}