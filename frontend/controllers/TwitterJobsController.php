<?php

namespace frontend\controllers;
use common\models\TwitterJobs;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TwitterJobsController extends Controller
{
    public function actionIndex()
    {
        //$this->layout = 'main-secondary';
        $tweets = TwitterJobs::find()
            ->alias('a')
            ->distinct()
            ->select(['a.job_type','c.name org_name','a.html_code','f.name profile','e.name job_title','c.initials_color color','CASE WHEN c.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",c.logo_location, "/", c.logo) END logo'])
            ->joinWith(['twitterJobSkills b'],false)
            ->joinWith(['unclaimOrganizationEnc c'],false)
            ->joinWith(['jobTitle d'=>function($b)
            {
                $b->joinWith(['categoryEnc e'],false);
                $b->joinWith(['parentEnc f'],false);
            }],false)
            ->asArray()
            ->all();
        return $this->render('index',['tweets'=>$tweets]);
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
            }
            else
            {
                return [
                    'status'=>201
                ];
            }
    }
   }
}