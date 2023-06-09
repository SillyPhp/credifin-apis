<?php

namespace api\modules\v4\controllers;

use common\models\extended\Organizations;
use common\models\extended\Payments;
use common\models\LoanPayments;
use http\Url;
use yii\filters\VerbFilter;
use Razorpay\Api\Api;
use Yii;

class PaymentsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-payment-link' => ['POST','OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetPaymentLink()
    {
//        if (!$user = $this->isAuthorized()) {
//            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
//        }
        $params = Yii::$app->request->post();
        if ($params) {
            try {
                $model = new Payments();
                $api_key = Yii::$app->params->razorPay->phfleasing->prod->apiKey;
                $api_secret = Yii::$app->params->razorPay->phfleasing->prod->apiSecret;
                $api = new Api($api_key, $api_secret);
                $options['name'] = $params['name'];
                $options['loan_app_id'] = $params['loan_app_id'];
                $options['amount'] = $params['amount'];
                $options['total'] = (int)($params['amount'] * 100);
                $options['description'] = $params['desc'];
                $options['loan_app_enc_id'] = $params['loan_app_id'];
                $options['method'] = $params['method'];
                if ($options['method'] == 0) {
                    $options['brand'] = $params['brand'];
                    if (empty($options['brand'])) {
                        $org_name = Organizations::findOne(['organization_enc_id' => $user->organization_enc_id])['name'];
                        $options['brand'] = $org_name;
                    }
                    $options['contact'] = $params['phone'];
                    $options['call_back_url'] = "http://www.ravinder.eygb.me/api/v4/payments/test";
                    $options['close_by'] = time() + 24 * 60 * 60 * 7;
                }
                if ($options['method'] == 1) {
                    $options['close_by'] = time() + 24 * 60 * 60;
                }

                $query = LoanPayments::find()
                    ->alias('a')
                    ->select(['a.payment_short_url surl'])
                    ->where(['a.loan_app_enc_id' => $options['loan_app_id']])
                    ->andWhere(['and',
                        ['or',
                            ['!=', 'a.payment_short_url', null],
                            ['!=', 'a.payment_short_url', '']
                        ],
                        ['or',
                            ['!=', 'a.payment_status', 'captured'],
                            ['!=', 'a.payment_status', 'created'],
                            ['a.payment_status' => null],
                            ['a.payment_status' => ''],
                        ],
                        ['a.payment_link_type' => $options['method']]]);
                if ($options['method'] == 1) {
                    $query->andWhere([
                            '>', 'a.close_by', date('Y-m-d H:i:s')]
                    );
                }
                $query = $query->asArray()
                    ->one();
                if ($query) {
                    return [
                        'surl' => $query['surl'],
                        'status' => true
                    ];
                }
            }
            catch (\Exception $exception){
                return [
                    'message'=>$exception->getMessage(),
                    'status'=>false
                ];
            }
            if ($options['method'] == 0) {
                return $model->createLink($api, $options);
            } else if ($params['method'] == 1) {
                return $model->createQr($api, $options);
            }
        } else {
            return [
                'message'=>'failed',
                'status'=>false
            ];
        }
    }

    public function actionTest()
    {
        $params = Yii::$app->request->get();
        $query = LoanPayments::findOne(['payment_token' => $params['razorpay_payment_link_id']]);
        $query->payment_status = $params['razorpay_payment_link_status'];
        $query->payment_id = $params['razorpay_payment_id'];
        $query->payment_signature = $params['razorpay_signature'];
        $query->payment_source = 'razorpay';
        if (!$query->update()) {
            throw new \Exception($query->getErrors());
        }
        return 'You have paid successfully.';
    }

    public function actionTest2()
    {
        $params = Yii::$app->request->post();
//        $name = $params['name'];
//        $description = $params['desc'];
        $api_key = 'rzp_test_UROrrJ1Z689b2z';
        $api_secret = '6JnrI7ZHk2fW3HFqkXEKREJD';
        $api = new Api($api_key, $api_secret);
        $id = $params['loan_app_id'];
        $email = $params['email'];
        $phone = $params['phone'];
        $name = $params['name'];

        $query = LoanPayments::find()
            ->alias('a')
            ->select(['a.payment_short_url surl'])
            ->where(['a.loan_app_enc_id' => $id])
            ->andWhere(['and',
                ['or',
                    ['!=', 'a.payment_short_url', null],
                    ['!=', 'a.payment_short_url', '']
                ],
                ['or',
                    ['!=', 'a.payment_status', 'captured'],
                    ['!=', 'a.payment_status', 'created'],
                    ['a.payment_status' => null],
                    ['a.payment_status' => ''],
                ]])
            ->asArray()
            ->one();
        $link = $api->qrCode->create(["type" => "upi_qr",
            "name" => $name,
            "usage" => "single_use",
            "fixed_amount" => 1,
            "payment_amount" => 30000,
            "description" => "For Store 1",
            "close_by" => time() + 900,
            "notes" => array("purpose" => "Test UPI QR code notes")]);

        return $link;
    }
}