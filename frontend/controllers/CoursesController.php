<?php

namespace frontend\controllers;

use common\models\Courses;
use common\models\extended\Subscribers;
use common\models\LearningVideos;
use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

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
            return self::_searchData(Yii::$app->request->post());
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
            $params = Yii::$app->request->post();
            $cat = Yii::$app->request->get('cat');
            if ($cat) {
                $params['cat'] = str_replace('-', ' ', $cat);
            }
            return self::_searchData($params);
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

    private function _searchData($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $limit = !empty($params['limit']) ? $params['limit'] : 21;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $query = \common\models\Courses::find()
            ->alias('a')
            ->select(['a.title', 'a.image', 'a.course_enc_id', 'a.price', 'a.is_paid', 'a.currency', 'c.name'])
            ->joinWith(['coursesAuthors b' => function ($b) {
                $b->joinWith(['authorEnc c'], false);
            }], false);

        if (!empty($params['keyword']) || !empty($params['cat'])) {
            $search = $params['keyword'] ?? $params['cat'];
            $query->andWhere(['like', 'a.title', '%' . $search . '%', false]);
        }
        $count = $query->count();
        $query = $query->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();
        return $response = [
            'status' => 200,
            'title' => 'Success',
            'count' => $count,
            'data' => $query,
        ];
    }

    public function actionDetail($uid)
    {
        $check = Courses::find()->where(['course_enc_id' => $uid])->exists();
        if (!$check) {
            return $this->render('/site/error', ['name' => "Course not found", 'message' => 'Course not found..']);
        }
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
            return self::_searchData(['keyword' => $q]);
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

    public function actionGodaddyAcademy()
    {
        return $this->render('godaddy-academy');
    }
}