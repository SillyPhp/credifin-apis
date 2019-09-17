<?php

namespace frontend\controllers;

use account\models\applications\ApplicationForm;
use common\models\TwitterJobs;
use frontend\models\twitterjobs\TwitterJobsForm;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TwitterJobsController extends Controller
{
    public function actionIndex($keywords = null, $location = null)
    {
        $tweets = TwitterJobs::find()
            ->alias('a')
            ->distinct()
            ->select(['a.job_type', 'c.name org_name', 'a.html_code', 'f.name profile', 'e.name job_title', 'c.initials_color color', 'CASE WHEN c.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",c.logo_location, "/", c.logo) END logo'])
            ->FilterWhere([
                'or',
                ['like', 'a.job_type', $keywords],
                ['like', 'c.name', $keywords],
                ['like', 'f.name', $keywords],
                ['like', 'e.name', $keywords],
                ['like', 'a.html_code', $keywords],
                ['like', 'h.name', $keywords],
            ])
            ->andFilterWhere(['like', 'h.name', $location])
            ->joinWith(['twitterPlacementCities g' => function ($b) {
                $b->joinWith(['cityEnc h'], false);
            }], false)
            ->joinWith(['twitterJobSkills b'], false)
            ->joinWith(['unclaimOrganizationEnc c'], false)
            ->joinWith(['jobTitle d' => function ($b) {
                $b->joinWith(['categoryEnc e'], false);
                $b->joinWith(['parentEnc f'], false);
            }], false)
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();
        return $this->render('index', ['tweets' => $tweets, 'keywords' => $keywords, 'location' => $location]);
    }

    public function actionFetchTweetsCards()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $tweets = TwitterJobs::find()
                ->alias('a')
                ->distinct()
                ->select(['a.job_type', 'c.name org_name', 'a.html_code', 'f.name profile', 'e.name job_title', 'c.initials_color color', 'CASE WHEN c.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",c.logo_location, "/", c.logo) END logo'])
                ->joinWith(['twitterJobSkills b'], false)
                ->joinWith(['unclaimOrganizationEnc c'], false)
                ->joinWith(['jobTitle d' => function ($b) {
                    $b->joinWith(['categoryEnc e'], false);
                    $b->joinWith(['parentEnc f'], false);
                }], false)
                ->asArray()
                ->all();
            if (!empty($tweets)) {
                return [
                    'cards' => $tweets,
                    'status' => 200
                ];
            } else {
                return [
                    'status' => 201
                ];
            }
        }
    }

    public function actionJob()
    {
        $this->layout = 'main-secondary';
        $model = new TwitterJobsForm();
        $data = new ApplicationForm();
        $type = 'Jobs';
        $primary_cat = $data->getPrimaryFields();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save($type)) {
                return [
                    'status' => true,
                ];
            } else {
                return [
                    'status' => false,
                ];
            }
        }
        return $this->render('create-twitter-post.php', ['type' => $type, 'primary_cat' => $primary_cat, 'model' => $model]);
    }

    public function actionInternship()
    {
        $this->layout = 'main-secondary';
        $model = new TwitterJobsForm();
        $data = new ApplicationForm();
        $type = 'Internships';
        $primary_cat = $data->getPrimaryFields();
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save($type)) {
                return [
                    'status' => true,
                ];
            } else {
                return [
                    'status' => false,
                ];
            }
        }
        return $this->render('create-twitter-post.php', ['type' => $type, 'primary_cat' => $primary_cat, 'model' => $model]);
    }

}