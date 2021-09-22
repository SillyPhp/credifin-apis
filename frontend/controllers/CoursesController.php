<?php

namespace frontend\controllers;

use common\models\extended\Subscribers;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\HttpException;
use common\models\LearningVideos;
use yii\db\Expression;

class CoursesController extends Controller
{
    public $cookieString = '__udmy_2_v57r=; ud_cache_price_country=IN;';

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $model = new Subscribers();
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $model->subscribe();
        }
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $url = "https://www.udemy.com/api-2.0/courses/?page=1&page_size=6";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookieString);
            $header = [
                'Accept: application/json, text/plain, */*',
                'Content-Type: application/json;charset=utf-8',
                'Authorization: Basic c09DMng2QWdMRUp2UE9rNUxxeXEzaGVjdHFZaHVJRVFZazRrc0xHazpLaHdxOEd1Uk9VTENmQW9PZTZjUWpvWWZ0b1hNWWdhQ1dzUG9MMWZLbVZsb3ViYlNlc1FSc3hTYVdSNm51M0UzMVUzM1BRTGs4enFiSDQzeDh0ZDhHR0ZrSWdSVHhHTmM0UWpKS25VVWpTU1ZXTm9sOEI1c2huR3ZENnBYWEFwMQ=='
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);

            return $result;
        }
        $popular_videos = LearningVideos::find()
            ->where([
                'is_deleted' => 0,
                'status' => 1
            ])
            ->orderBy(new Expression('rand()'))
            ->limit(6)
            ->asArray()
            ->all();
        return $this->render('index', [
            'popular_videos' => $popular_videos,
            'model' => $model,
        ]);
    }

    public function actionCoursesList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $cat = Yii::$app->request->post('cat');
            $keyword = Yii::$app->request->post('keyword');
            $page = Yii::$app->request->post('page');
            $page_size = Yii::$app->request->post('limit');

            if (!$page_size || $page_size == "") {
                $page_size = 21;
            }
            if ($keyword || $cat) {
                if ($cat) {
                    $keyword = $cat;
                }
                $url = "https://www.udemy.com/api-2.0/courses/?page=" . $page . "&page_size=" . $page_size . "&search=" . $keyword;
            } else {
                $url = "https://www.udemy.com/api-2.0/courses/?page=" . $page . "&page_size=" . $page_size . "";
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookieString);
            $header = [
                'Accept: application/json, text/plain, */*',
                'Content-Type: application/json;charset=utf-8',
                'Authorization: Basic c09DMng2QWdMRUp2UE9rNUxxeXEzaGVjdHFZaHVJRVFZazRrc0xHazpLaHdxOEd1Uk9VTENmQW9PZTZjUWpvWWZ0b1hNWWdhQ1dzUG9MMWZLbVZsb3ViYlNlc1FSc3hTYVdSNm51M0UzMVUzM1BRTGs4enFiSDQzeDh0ZDhHR0ZrSWdSVHhHTmM0UWpKS25VVWpTU1ZXTm9sOEI1c2huR3ZENnBYWEFwMQ=='
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);

            return $result;
        }
        return $this->render('courses-list-page');
    }

    public function actionDetail($uid)
    {
        $url = "https://www.udemy.com/api-2.0/courses/" . $uid . "?fields[course]=@all";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_COOKIE, $this->cookieString);
        $header = [
            'Accept: application/json, text/plain, */*',
            'Content-Type: application/json;charset=utf-8',
            'Authorization: Basic c09DMng2QWdMRUp2UE9rNUxxeXEzaGVjdHFZaHVJRVFZazRrc0xHazpLaHdxOEd1Uk9VTENmQW9PZTZjUWpvWWZ0b1hNWWdhQ1dzUG9MMWZLbVZsb3ViYlNlc1FSc3hTYVdSNm51M0UzMVUzM1BRTGs4enFiSDQzeDh0ZDhHR0ZrSWdSVHhHTmM0UWpKS25VVWpTU1ZXTm9sOEI1c2huR3ZENnBYWEFwMQ=='
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        if ($result['title']) {
            return $this->render('courses-detail-page', [
                'data' => $result
            ]);
        } else {
            throw new HttpException(404, Yii::t('frontend', 'Page not found.'));
        }
    }

    public function actionSearch($q = null)
    {
        if (Yii::$app->request->isAjax) {
            $url = "https://www.udemy.com/api-2.0/courses/?page=1&page_size=20&search=" . $q;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_COOKIE, $this->cookieString);
            $header = [
                'Accept: application/json, text/plain, */*',
                'Content-Type: application/json;charset=utf-8',
                'Authorization: Basic c09DMng2QWdMRUp2UE9rNUxxeXEzaGVjdHFZaHVJRVFZazRrc0xHazpLaHdxOEd1Uk9VTENmQW9PZTZjUWpvWWZ0b1hNWWdhQ1dzUG9MMWZLbVZsb3ViYlNlc1FSc3hTYVdSNm51M0UzMVUzM1BRTGs4enFiSDQzeDh0ZDhHR0ZrSWdSVHhHTmM0UWpKS25VVWpTU1ZXTm9sOEI1c2huR3ZENnBYWEFwMQ=='
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);

            return $result;
        }
    }
}