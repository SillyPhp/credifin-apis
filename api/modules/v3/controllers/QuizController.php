<?php

namespace api\modules\v3\controllers;

use common\models\Quizzes;
use yii\filters\VerbFilter;
use Yii;
use yii\helpers\Url;

class QuizController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'list' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionList()
    {

        $options = Yii::$app->request->post();

        $quizzes = $this->__getQuizData($options);

        if ($quizzes) {
            return $this->response(200, ['status' => 200, 'message' => 'success', 'data' => $quizzes]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    private function __getQuizData($options = null)
    {

        $limit = 10;
        $page = 1;

        if (isset($options['limit']) && !empty($options['limit'])) {
            $limit = $options['limit'];
        }

        if (isset($options['page']) && !empty($options['page'])) {
            $page = $options['page'];
        }

        $q = Quizzes::find()
            ->alias('a')
            ->select(['a.quiz_enc_id', 'a.name', 'a.price', 'a.is_paid', 'b.name currency_name', 'b.code currency_code', 'b.html_code currency_html_code',
                'a.title', 'a.slug', 'c1.name category', 'c2.name parent_category', 'a.quiz_start_datetime', 'a.quiz_end_datetime', 'a.duration', 'a.description', 'a.registration_start_datetime', 'a.registration_end_datetime',
                'a.num_of_ques',
                'CASE WHEN a.sharing_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->quiz->sharing->image, 'https') . '", a.sharing_image_location, "/", a.sharing_image) ELSE NULL END sharing_image',
                "CASE WHEN a.registration_end_datetime IS NOT NULL THEN DATEDIFF(a.registration_end_datetime, CONVERT_TZ(Now(),'+00:00','+10:30')) ELSE NULL END days_left",
                "CASE 
                    WHEN a.registration_end_datetime IS NULL THEN NULL
                    WHEN DATEDIFF(a.registration_end_datetime, CONVERT_TZ(Now(),'+00:00','+10:30')) < 0 THEN 'true'
                 ELSE 'false' END is_expired",
            ])
            ->joinWith(['currencyEnc b'], false)
            ->joinWith(['assignedCategoryEnc c' => function ($c) {
                $c->joinWith(['categoryEnc c1']);
                $c->joinWith(['parentEnc c2']);
            }], false)
            ->joinWith(['quizRewards d' => function ($d) {
                $d->select(['d.quiz_reward_enc_id', 'd.quiz_enc_id', 'd.position_enc_id', 'd1.name position_name', 'd.price']);
                $d->joinWith(['positionEnc d1'], false);
                $d->joinWith(['quizRewardCertificates d2' => function ($d2) {
                    $d2->select(['d2.reward_certificate_enc_id', 'd2.quiz_reward_enc_id', 'd2.name']);
                    $d2->onCondition(['d2.is_deleted' => 0]);
                }]);
                $d->onCondition(['d.is_deleted' => 0]);
            }])
            ->where(['a.is_deleted' => 0]);

        // checking quiz categories
        if (isset($options['category']) && !empty($options['category'])) {
            $q->andFilterWhere(['c1.name' => $options['category']]);
        }

        // paid or free
        if (isset($options['payment']) && !empty($options['payment'])) {
            if ($options['payment'] == 'paid') {
                $q->andWhere(['a.is_paid' => 1]);
            } elseif ($options['payment'] == 'free') {
                $q->andWhere(['a.is_paid' => 0]);
            }
        }

        // expired or live
        if (isset($options['status']) && !empty($options['status'])) {
            if ($options['status'] == 'expired') {
                $q->having(['<', 'days_left', 0]);
            } elseif ($options['live'] == 'live') {
                $q->having(['>=', 'days_left', 0]);
            }
        }

        $q->orderBy(['a.created_on' => SORT_DESC])
            ->limit($limit)
            ->offset = ($page - 1) * $limit;


        if (isset($options['slug']) && !empty($options['slug'])) {
            $q = $q->andWhere(['a.slug' => $options['slug']])->asArray()->one();
        } else {
            $q = $q->asArray()->all();
        }

        return $q;
    }

    public function actionDetail()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "slug"']);
        }

        $options['slug'] = $params['slug'];

        $detail = $this->__getQuizData($options);
        unset($options['slug']);

        $options['category'] = $detail['category'];
        $options['limit'] = 3;
        $related = $this->__getQuizData($options);

        if ($detail) {
            return $this->response(200, ['status' => 200, 'message' => 'quiz detail', 'detail' => $detail, 'related' => $related]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }
}
