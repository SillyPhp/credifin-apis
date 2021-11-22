<?php

namespace common\models\extended;

use common\models\QuizRegistration;
use common\models\Quizzes;
use yii\helpers\Url;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;

class Quiz extends Quizzes
{
    public static function getQuizData($options = null)
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
                'a.title', 'a.slug', 'c1.name category', 'c2.name parent_category', 'DATE_FORMAT(a.quiz_start_datetime, "%d/%m/%Y") quiz_start_datetime', 'DATE_FORMAT(a.quiz_end_datetime, "%d/%m/%Y") quiz_end_datetime', 'a.duration', 'a.description', 'a.registration_start_datetime', 'a.registration_end_datetime',
                'a.num_of_ques',
                'CASE WHEN a.sharing_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->quiz->sharing->image, 'https') . '", a.sharing_image_location, "/", a.sharing_image) ELSE NULL END sharing_image',
                "CASE WHEN a.quiz_start_datetime IS NOT NULL THEN DATEDIFF(a.quiz_start_datetime, CONVERT_TZ(Now(),@@session.time_zone,'+05:30')) ELSE NULL END days_left",
                "CASE 
                    WHEN a.quiz_end_datetime IS NULL THEN NULL
                    WHEN TIMESTAMPDIFF(SECOND, CONVERT_TZ(Now(),@@session.time_zone,'+05:30'),a.quiz_end_datetime) < 0 THEN 'true'
                 ELSE 'false' END is_expired",
                "CASE 
                    WHEN a.registration_end_datetime IS NULL THEN NULL
                    WHEN TIMESTAMPDIFF(SECOND, CONVERT_TZ(Now(),@@session.time_zone,'+05:30'),a.registration_end_datetime) > 0 THEN a.registration_end_datetime
                 ELSE NULL END is_live",
            ])
            ->joinWith(['currencyEnc b'], false)
            ->joinWith(['assignedCategoryEnc c' => function ($c) {
                $c->joinWith(['categoryEnc c1']);
                $c->joinWith(['parentEnc c2']);
            }], false)
            ->joinWith(['quizRewards d' => function ($d) {
                $d->select(['d.quiz_reward_enc_id', 'd.quiz_enc_id', 'd.position_enc_id', 'd1.name position_name', 'd.price', 'd.amount']);
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
                $q->having(['is_expired' => 'true']);
            } elseif ($options['status'] == 'live') {
                $q->having(['or',
                    ['is_expired' => 'false'],
                    ['is_expired' => null],
                ]);
            }
        }

        if (isset($options['quiz_id']) && !empty($options['quiz_id'])) {
            $q->andWhere(['!=', 'a.quiz_enc_id', $options['quiz_id']]);
        }

        $q = $q
            ->groupBy(['a.quiz_enc_id'])
            ->orderBy([new \yii\db\Expression('-is_live DESC')])
//            ->orderBy(['is_expired' => SORT_ASC])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($q) {
            foreach ($q as $key => $val) {
                $q[$key]['registered_count'] = QuizRegistration::find()->where(['quiz_enc_id' => $val['quiz_enc_id'], 'is_deleted' => 0, 'status' => 1])->count();
            }
        }

        return $q;
    }

    public function detail($options = null)
    {
        $q = Quizzes::find()
            ->alias('a')
            ->select(['a.quiz_enc_id', 'a.name', 'a.price', 'a.is_paid', 'b.name currency_name', 'b.code currency_code', 'b.html_code currency_html_code',
                'a.title', 'a.slug', 'c1.name category', 'c2.name parent_category','DATE_FORMAT(a.quiz_start_datetime, "%m/%d/%Y %H:%i:%s") quiz_start_datetime', 'DATE_FORMAT(a.quiz_end_datetime, "%m/%d/%Y %H:%i:%s") quiz_end_datetime', 'a.duration', 'a.description', 'DATE_FORMAT(a.registration_start_datetime, "%m/%d/%Y %H:%i:%s") registration_start_datetime', 'DATE_FORMAT(a.registration_end_datetime, "%m/%d/%Y %H:%i:%s") registration_end_datetime',
                'a.num_of_ques',
                'CASE WHEN a.sharing_image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->quiz->sharing->image, 'https') . '", a.sharing_image_location, "/", a.sharing_image) ELSE NULL END sharing_image',
                "CASE WHEN a.quiz_start_datetime IS NOT NULL THEN DATEDIFF(a.quiz_start_datetime, CONVERT_TZ(Now(),@@session.time_zone,'+05:30')) ELSE NULL END days_left",
                "CASE 
                    WHEN a.quiz_end_datetime IS NULL THEN NULL
                    WHEN TIMESTAMPDIFF(SECOND, CONVERT_TZ(Now(),@@session.time_zone,'+05:30'),a.quiz_end_datetime) < 0 THEN 'true'
                 ELSE 'false' END is_expired",
                "TIMESTAMPDIFF(SECOND, CONVERT_TZ(Now(),@@session.time_zone,'+05:30'),a.quiz_end_datetime) s",
            ])
            ->joinWith(['currencyEnc b'], false)
            ->joinWith(['assignedCategoryEnc c' => function ($c) {
                $c->joinWith(['categoryEnc c1']);
                $c->joinWith(['parentEnc c2']);
            }], false)
            ->joinWith(['quizRewards d' => function ($d) {
                $d->select(['d.quiz_reward_enc_id', 'd.quiz_enc_id', 'd.position_enc_id', 'd1.name position_name', 'd.price', 'd.amount']);
                $d->joinWith(['positionEnc d1'], false);
                $d->joinWith(['quizRewardCertificates d2' => function ($d2) {
                    $d2->select(['d2.reward_certificate_enc_id', 'd2.quiz_reward_enc_id', 'd2.name']);
                    $d2->onCondition(['d2.is_deleted' => 0]);
                }]);
                $d->onCondition(['d.is_deleted' => 0]);
            }])
            ->where(['a.is_deleted' => 0])
            ->andWhere(['a.slug' => $options['slug']])
            ->asArray()
            ->one();

        if ($q) {
            $q['is_registered'] = false;
            if (isset($options['user_id']) && !empty($options['user_id'])) {
                $registered = QuizRegistration::findOne(['quiz_enc_id' => $q['quiz_enc_id'], 'created_by' => $options['user_id'], 'status' => 1, 'is_deleted' => 0]);
                if ($registered) {
                    $q['is_registered'] = true;
                }
            }
            $q['registered_count'] = QuizRegistration::find()->where(['quiz_enc_id' => $q['quiz_enc_id'], 'is_deleted' => 0, 'status' => 1])->count();
            $q['registered_users'] = $this->__getRegisteredUsers($q['quiz_enc_id']);
        }

        return $q;
    }

    public function registerUser($options = null)
    {
        $quiz = Quizzes::findOne(['quiz_enc_id' => $options['quiz_id']]);

        if ($quiz->is_paid == 0) {

            $transaction = Yii::$app->db->beginTransaction();
            try {

                $quizRegister = new QuizRegistration();
                $quizRegister->register_enc_id = Yii::$app->getSecurity()->generateRandomString();
                $quizRegister->quiz_enc_id = $options['quiz_id'];
                $quizRegister->status = 1;
                $quizRegister->created_by = $options['user_id'];
                $quizRegister->created_on = date('Y-m-d H:i:s');
                if (!$quizRegister->save()) {
                    $transaction->rollback();
                    return false;
                }

                $transaction->commit();
                return ['status' => 201, 'message' => 'success', 'data' => []];

            } catch (\Exception $e) {
                return false;
            }

        } else {

            $data = $this->checkout($options);

            if ($data) {
                return $data;
            }

            return false;

        }
    }

    private function checkout($options)
    {
        $quiz_amount = Quizzes::find()
            ->where(['quiz_enc_id' => $options['quiz_id']])
            ->asArray()
            ->one();

        if (!empty($quiz_amount)) {
            $total_amount = $quiz_amount['price'];
//            $gst = $quiz_amount['gst'];
//            $percentage = ($total_amount * $gst) / 100;
//            $total_amount = $total_amount + $percentage;
            $args = [];
            $args['amount'] = $this->floatPaisa($total_amount); //for inr float to paisa format for razor pay payments
            $args['currency'] = "INR";
            $args['accessKey'] = Yii::$app->params->EmpowerYouth->permissionKey;
            $response = PaymentsModule::_authPayToken($args);

        } else {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $quizRegister = new QuizRegistration();
            $quizRegister->register_enc_id = Yii::$app->getSecurity()->generateRandomString();
            $quizRegister->quiz_enc_id = $options['quiz_id'];
            $quizRegister->created_by = $options['user_id'];
            $quizRegister->created_on = date('Y-m-d H:i:s');
            if (!$quizRegister->save()) {
                $transaction->rollBack();
                return false;
            }

            if (isset($response['status']) && $response['status'] == 'created') {
                $token = $response['id'];
                $payment = new \common\models\QuizPayments();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $payment->payment_enc_id = $utilitiesModel->encrypt();
                $payment->quiz_enc_id = $options['quiz_id'];
                $payment->registration_enc_id = $quizRegister->register_enc_id;
                $payment->created_by = $options['user_id'];
                $payment->payment_token = $token;
                $payment->payment_amount = $quiz_amount['price'];
                $payment->created_on = date('Y-m-d H:i:s');
                if (!$payment->save()) {
                    $transaction->rollBack();
                    return false;
                }
            } else {
                return false;
            }

            $transaction->commit();

            $data = [];
            $data['quiz_enc_id'] = $options['quiz_id'];
            $data['payment_enc_id'] = $payment->payment_enc_id;
            $data['payment_token'] = $payment->payment_token;
            $data['registration_enc_id'] = $quizRegister->register_enc_id;
            return ['status' => 200, 'message' => 'success', 'data' => $data];

        } catch (\Exception $exception) {
            $transaction->rollBack();
            return false;
        }
    }

    public function updateStatus($args)
    {
        $payment_model = \common\models\QuizPayments::findOne(['payment_enc_id' => $args['payment_enc_id']]);
        $payment_model->payment_status = $args['status'];
        $payment_model->payment_id = $args['payment_id'];
        $payment_model->payment_signature = $args['signature'];
        $payment_model->updated_on = date('Y-m-d H:i:s');
        $payment_model->updated_by = $args['user_id'];
        if (!$payment_model->update()) {
            return false;
        }

        if ($payment_model->payment_status == 'captured' || $payment_model->payment_status == 'created') {
            $registration = QuizRegistration::findOne(['register_enc_id' => $payment_model->registration_enc_id]);
            $registration->status = 1;
            $registration->last_updated_on = date('Y-m-d H:i:s');
            $registration->last_updated_by = $args['user_id'];
            if (!$registration->update()) {
                return false;
            }
        }

        return true;

    }

    private function floatPaisa($amount)
    {
        $c = $amount * 100;
        return (int)$c;
    }

    private function __getRegisteredUsers($quiz_id)
    {
        return QuizRegistration::find()
            ->alias('z')
            ->select(['z.quiz_enc_id', 'z.register_enc_id', 'z.created_by',
                'CASE WHEN c.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", c.image_location, "/", c.image) END image',])
            ->joinWith(['createdBy c'], false)
            ->where(['z.quiz_enc_id' => $quiz_id, 'z.is_deleted' => 0, 'z.status' => 1])
            ->andWhere(['not', ['c.image' => null]])
            ->andWhere(['not', ['c.image' => '']])
            ->orderBy(['z.created_on' => SORT_DESC])
            ->limit(6)
            ->asArray()
            ->all();

    }
}