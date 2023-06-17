<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\PaymentModal;
use api\modules\v4\models\PaymentModel;
use common\models\extended\Organizations;
use common\models\extended\Payments;
use common\models\LoanApplications;
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
                'razor-pay-webhook' => ['POST','OPTIONS'],
                'update-payment' => ['GET'],
            ]
        ];
        return $behaviors;
    }

    public function actionRazorPayWebhook(){
        $data = Yii::$app->request->post();
        if (isset($data['event'])) {
            if ($data['contains'][0]=='qr_code'){
                $entity = $data['payload']['qr_code']['entity'];
                $order_id = $entity['id'];
            }
            if ($data['contains'][0]=='payment'){
                $entity = $data['payload']['payment']['entity'];
            }
            if ($data['contains'][0]=='payment_link'){
                $entity = $data['payload']['payment_link']['entity'];
            }
            $payment_id = $entity['id'];
            $status = $entity['status'];
            $model = LoanPayments::findOne(['payment_token'=>$order_id]);
            $method = $entity['method'];
            if ($data['event'] == "payment.failed") {
                $method .= $entity['error_code'];
                $method .= " ";
                $method .= $entity['error_description'];
                $method .= " ";
                $method .= $entity['error_source'];
                $method .= " ";
                $method .= $entity['error_step'];
                $method .= " ";
                $method .= $entity['error_reason'];
            }
            $model->payment_id = $payment_id;
            $model->payment_status = $status;
            $model->remarks = $method;

            if ($model->save()) {
                return $this->response(200, ['status' => 200, 'message' => 'success']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'Unable To Store Payment Information']);
            }
        }
    }
    public function actionGetPaymentLink()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if ($params) {
            try {
                $url =  \yii\helpers\Url::base('https');
                $model = new PaymentModel();
                if ($model->load(Yii::$app->request->post())&&!$model->validate()){
                    return $this->response(422, ['status' => 422, 'message' => \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)]);
                }
                $model = new Payments();
                $api_key = Yii::$app->params->razorPay->phfleasing->prod->apiKey;
                $api_secret = Yii::$app->params->razorPay->phfleasing->prod->apiSecret;
                $api = new Api($api_key, $api_secret);
                $options['name'] = $params['name'];
                $options['loan_app_id'] = $params['loan_app_id'];
                $options['amount'] = $params['amount'];
                $options['total'] = (int)($params['amount'] * 100);
                $options['description'] = $params['desc'];
                $options['method'] = $params['method'];
                if ($options['method'] == 0) {
                    $options['brand'] = $params['brand'];
                    if (empty($options['brand'])) {
                        $org_name = Organizations::findOne(['organization_enc_id' => $user->organization_enc_id])['name'];
                        $options['brand'] = $org_name;
                    }
                    $options['contact'] = $params['phone'];
                    $options['call_back_url'] = $url."/v4/payments/update-payment";
                    $options['close_by'] = time() + 24 * 60 * 60 * 7;
                }
                if ($options['method'] == 1) {
                    $options['purpose'] = $params['purpose'];
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

    public function actionUpdatePayment()
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