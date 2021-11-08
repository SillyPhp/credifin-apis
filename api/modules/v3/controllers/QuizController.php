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
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $currentTime = $dt->format('Y-m-d H:i:s');

        $quizzes = $this->__getQuizData();

        if ($quizzes) {
            return $this->response(200, ['status' => 200, 'message' => 'success', 'data' => $quizzes]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    private function __getQuizData($options = null)
    {
        $q = Quizzes::find()
            ->alias('a')
            ->select(['a.quiz_enc_id', 'a.name', 'a.price', 'a.is_paid', 'b.name currency_name', 'b.code currency_code', 'b.html_code currency_html_code',
                'a.title', 'a.slug', 'c1.name category', 'c2.name parent_category', 'a.quiz_start_datetime', 'a.quiz_end_datetime', 'a.duration', 'a.description', 'a.registration_start_datetime', 'a.registration_end_datetime',
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
                $d->onCondition(['d.is_deleted' => 0]);
            }])
            ->where(['a.is_deleted' => 0])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->limit(10)
            ->asArray();
        if (isset($options['slug']) && !empty($options['slug'])) {
            $q = $q->one();
        } else {
            $q = $q->all();
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

        if ($detail) {
            return $this->response(200, ['status' => 200, 'message' => 'quiz detail', 'data' => $detail]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }
}
