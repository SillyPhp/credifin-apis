<?php

namespace api\modules\v3\controllers;

use common\models\Categories;
use common\models\extended\Quiz;
use common\models\QuizPayments;
use common\models\QuizRegistration;
use yii\filters\Cors;
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
                'detail' => ['POST', 'OPTIONS'],
                'register' => ['POST', 'OPTIONS'],
                'update-payment-status' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionList()
    {

        $options = Yii::$app->request->post();

        $quizzes = Quiz::getQuizData($options);

        if ($quizzes) {
            return $this->response(200, ['status' => 200, 'message' => 'success', 'data' => $quizzes]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionDetail()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "slug"']);
        }

        if (isset($params['user_id']) && !empty($params['user_id'])) {
            $options['user_id'] = $params['user_id'];
        }

        $options['slug'] = $params['slug'];

        $quizModel = new Quiz();
        $detail = $quizModel->detail($options);
        unset($options['slug']);

        $options['category'] = $detail['category'];
        $options['limit'] = 3;
        $options['quiz_id'] = $detail['quiz_enc_id'];
        $options['status'] = 'live';
        $related = Quiz::getQuizData($options);

        if ($detail) {
            return $this->response(200, ['status' => 200, 'message' => 'quiz detail', 'detail' => $detail, 'related' => $related]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionCategories()
    {

        $params = Yii::$app->request->post();

        $status = null;

        if (isset($params['status']) && !empty($params['status'])) {
            $status = $params['status'];
        }


        $categories = Categories::find()
            ->alias('a')
            ->select(['a.category_enc_id', 'a.name', "CASE 
                    WHEN b1.quiz_end_datetime IS NULL THEN NULL
                    WHEN TIMESTAMPDIFF(SECOND, CONVERT_TZ(Now(),@@session.time_zone,'+05:30'),b1.quiz_end_datetime) < 0 THEN 'true'
                 ELSE 'false' END is_expired"])
            ->innerJoinWith(['assignedCategories b' => function ($b) {
                $b->innerJoinWith(['quizzes b1']);
                $b->andWhere(['b1.is_deleted' => 0]);
            }], false);

        // expired or live
        if ($status != null) {
            if ($status == 'expired') {
                $categories->having(['is_expired' => 'true']);
            } elseif ($status == 'live') {
                $categories->having(['or',
                    ['is_expired' => 'false'],
                    ['is_expired' => null],
                ]);
            }
        }

        $categories = $categories
            ->groupBy('a.name')
            ->asArray()
            ->all();

        if ($categories) {
            return $this->response(200, ['status' => 200, 'categories' => $categories]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionRegister()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['quiz_id']) && empty($params['quiz_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "quiz_id"']);
        }

        if (!isset($params['user_id']) && empty($params['user_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "user_id"']);
        }

        $paid = QuizPayments::findOne(['quiz_enc_id' => $params['quiz_id'], 'payment_status' => 'captured', 'created_by' => $params['user_id']]);
        $registered = QuizRegistration::findOne(['quiz_enc_id' => $params['quiz_id'], 'created_by' => $params['user_id'], 'is_deleted' => 0, 'status' => 1]);

        if ($paid) {
            return $this->response(422, ['status' => 422, 'message' => 'User Already Paid The Amount and Registered']);
        }

        if ($registered) {
            return $this->response(422, ['status' => 422, 'message' => 'User Already Registered']);
        }

        $quizModel = new Quiz();
        $register = $quizModel->registerUser($params);

        if ($register) {
            return $this->response(200, $register);
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'some error occurred']);
        }

    }

    public function actionUpdatePaymentStatus()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['user_id']) && empty($params['user_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "user_id"']);
        }

        $quizModel = new Quiz();
        $update = $quizModel->updateStatus($params);

        if ($update) {
            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'some error occurred']);
        }
    }

}
