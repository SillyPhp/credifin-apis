<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use account\models\applications\ApplicationForm;
use common\models\ApplicationTypes;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Cities;
use common\models\Organizations;
use common\models\TwitterJobs;
use common\models\TwitterPlacementCities;
use common\models\UnclaimedOrganizations;
use frontend\models\twitterjobs\TwitterJobsForm;

class TweetsController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->requestedRoute);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex($keywords = null, $location = null, $type = null, $limit = null, $offset = null)
    {
        return $this->_getTweets($keywords, $location, $type, $limit, $offset);
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
        return $this->render('create-twitter-post', ['type' => $type, 'primary_cat' => $primary_cat, 'model' => $model]);
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
        return $this->render('create-twitter-post', ['type' => $type, 'primary_cat' => $primary_cat, 'model' => $model]);
    }

    private function _getTweets($keywords = null, $location = null, $type = null, $limit = null, $offset = null)
    {
        $tweets1 = (new \yii\db\Query())
            ->distinct()
            ->select(['a.tweet_enc_id', 'a.job_type', 'a.created_on', 'c.name org_name', 'a.html_code', 'f.name profile', 'e.name job_title', 'c.initials_color color', 'CASE WHEN c.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",c.logo_location, "/", c.logo) END logo'])
            ->from(TwitterJobs::tableName() . 'as a')
            ->leftJoin(TwitterPlacementCities::tableName() . ' g', 'g.tweet_enc_id = a.tweet_enc_id')
            ->leftJoin(Cities::tableName() . 'as h', 'h.city_enc_id = g.city_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as d', 'd.assigned_category_enc_id = a.job_title')
            ->innerJoin(Categories::tableName() . 'as e', 'e.category_enc_id = d.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = d.parent_enc_id')
            ->innerJoin(UnclaimedOrganizations::tableName() . 'as c', 'c.organization_enc_id = a.unclaim_organization_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
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
            ->andFilterWhere(['like', 'j.name', $type])
            ->andWhere(['a.is_deleted'=>0]);

        $tweets2 = (new \yii\db\Query())
            ->distinct()
            ->select(['a.tweet_enc_id', 'a.job_type', 'a.created_on', 'c.name org_name', 'a.html_code', 'f.name profile', 'e.name job_title', 'c.initials_color color', 'CASE WHEN c.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '",c.logo_location, "/", c.logo) END logo'])
            ->from(TwitterJobs::tableName() . 'as a')
            ->leftJoin(TwitterPlacementCities::tableName() . ' g', 'g.tweet_enc_id = a.tweet_enc_id')
            ->leftJoin(Cities::tableName() . 'as h', 'h.city_enc_id = g.city_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as d', 'd.assigned_category_enc_id = a.job_title')
            ->innerJoin(Categories::tableName() . 'as e', 'e.category_enc_id = d.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as f', 'f.category_enc_id = d.parent_enc_id')
            ->innerJoin(Organizations::tableName() . 'as c', 'c.organization_enc_id = a.claim_organization_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
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
            ->andFilterWhere(['like', 'j.name', $type])
            ->andWhere(['a.is_deleted'=>0]);

        $result = (new \yii\db\Query())
            ->from([
                $tweets1->union($tweets2),
            ])
            ->limit($limit)
            ->offset($offset)
            ->groupBy('tweet_enc_id')
            ->orderBy(['created_on' => SORT_DESC])
            ->all();

        return $this->render('index', ['tweets' => $result, 'keywords' => $keywords, 'location' => $location, 'type' => $type]);
    }
}