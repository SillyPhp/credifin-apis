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

    public function actionGetNews()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $limit = Yii::$app->request->post('limit');
            $offset = Yii::$app->request->post('offset');
            $newsDetail = ExternalNewsUpdate::find()
                ->alias('z')
                ->select(['z.news_enc_id', 'z.title', 'z.link', 'z.downvote', 'z.upvote', 'z.created_on', 'z.slug', 'z.description', 'z.image', 'z.image_location', 'z.status', 'z.is_deleted'])
                ->where(['z.is_deleted' => 0, 'z.status' => 1])
                ->joinWith(['newsTags a' => function ($a) {
                    $a->select(['a.news_tag_enc_id', 'a.news_enc_id', 'a.assigned_tag_enc_id', 'c.name tag_name']);
                    $a->andWhere(['a.is_deleted' => 0]);
                    $a->joinWith(['assignedTagEnc b' => function ($b) {
                        $b->joinWith(['tagEnc c' => function ($c) {
                        }], false);
                    }], false);
                }])
                ->asArray()
                ->distinct()
                ->orderBy(['z.created_on' => SORT_DESC]);
            $totalNewsCount = $newsDetail->count();
            $dataDetail = $newsDetail->limit($limit)
                ->offset($offset)
                ->all();
            if ($dataDetail) {
                array_walk($dataDetail, function (&$item) {
                    $item['rand_upvote'] = rand(40, 100) + $item['upvote'];
                    $item['rand_downvote'] = rand(0, 40) + $item['downvote'];
                    $item['news_slug'] = Url::to('/news/' . $item['slug']);
                    $item['news_time'] = date('d M Y', strtotime($item['created_on']));
                    $item['news_title'] = Url::to('/news/' . $item['title']);
                    $item['news_description'] = strip_tags($item['description']);
                    $item['sharing_link'] = Url::base(true) . '/news/' . $item['slug'];
                    $item['news_image'] = Url::to(Yii::$app->params->upload_directories->posts->featured_image . $item['image_location'] . '/' . $item['image']);
                    unset($item['upvote']);
                    unset($item['image']);
                    unset($item['image_location']);
                    unset($item['slug']);
                    unset($item['description']);
                    unset($item['created_on']);
                    unset($item['link']);
                });
            }
            return [
                'status' => 200,
                'cards' => $dataDetail,
                'total' => $totalNewsCount,
                'count' => sizeof($dataDetail)
            ];
        }
    }

    public function actionIndex()
    {
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
        return $this->render('index');
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
            ->andWhere(['z.is_deleted' => 0, 'z.is_visible' => 1])
            ->groupBy('z.news_enc_id')
            ->limit(5)
            ->all();
        $latestNews = ExternalNewsUpdate::find()
            ->where(['is_deleted' => 0, 'status' => 1, 'is_visible' => 1])
            ->orderBy(['created_on' => SORT_DESC])
            ->limit(5)
            ->all();

        $newsletterForm = new SubscribeNewsletterForm();
        return $this->render('news-detail', [
            'newsDetail' => $newsDetail,
            'relatedNews' => $relatedNews,
            'latestNews' => $latestNews,
            'newsletterForm' => $newsletterForm,
        ]);
    }

}