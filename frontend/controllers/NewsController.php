<?php

namespace frontend\controllers;

use common\models\ExternalNewsUpdate;
use frontend\models\SubscribeNewsletterForm;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class NewsController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        $route = ltrim(Yii::$app->request->url, '/');
        if ($route === "") {
            $route = "/";
        }
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute($route, $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $news = ExternalNewsUpdate::findAll(['is_deleted' => 0, 'status' => 1]); // status 1 as published
        if (Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            $key = Yii::$app->request->post('key');
            $model = ExternalNewsUpdate::findOne(['news_enc_id' => $key]);
            switch ($id) {
                case 'upvoteBtn' :
                    $model->upvote += 1;
                    break;
                case 'downvoteBtn' :
                    $model->downvote += 1;
                    break;
                default :
                    return [
                        'status' => 201,
                        'title' => 'Error',
                        'message' => 'Please try again later..',
                    ];
            }
            if ($model->save()) {
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Vote submitted..',
                ];
            } else {
                return [
                    'status' => 201,
                    'title' => 'Technical Issue',
                    'message' => 'Something went wrong...',
                ];
            }
        }
        return $this->render('index', [
            'news' => $news
        ]);
    }

    public function actionDetail($slug)
    {
        $newsDetail = ExternalNewsUpdate::findOne(['slug' => $slug]);
        $tags = ArrayHelper::getColumn($newsDetail->newsTags, 'assignedTagEnc.tagEnc.name');
        $relatedNews = ExternalNewsUpdate::find()
            ->alias('z')
            ->joinWith(['newsTags a' => function ($a) use ($tags) {
                $a->joinWith(['assignedTagEnc a1' => function ($a1) use ($tags) {
                    $a1->joinWith(['tagEnc a2' => function ($a2) use ($tags) {
                        $a2->where(['in', 'a2.name', $tags]);
                    }]);
                }]);
                $a->andWhere(['a.is_deleted' => 0]);
            }])
            ->andWhere(['not', ['in', 'z.slug', $slug]])
            ->andWhere(['z.is_deleted' => 0])
            ->groupBy('z.news_enc_id')
            ->all();

        $newsletterForm = new SubscribeNewsletterForm();
        return $this->render('news-detail', [
            'newsDetail' => $newsDetail,
            'relatedNews' => $relatedNews,
            'newsletterForm' => $newsletterForm,
        ]);
    }

}