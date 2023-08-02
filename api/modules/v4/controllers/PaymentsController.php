<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\PaymentModel;
use common\models\extended\Organizations;
use common\models\extended\Payments;
use common\models\FinancerLoanProductLoginFeeStructure;
use common\models\LoanPayments;
use Razorpay\Api\Api;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;

class PaymentsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-payment-link' => ['POST', 'OPTIONS'],
                'razor-pay-webhook' => ['POST', 'OPTIONS'],
                'update-payment' => ['GET'],
            ]
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];
        return $behaviors;
    }

    public function actionRazorPayWebhook()
    {
        $data = Yii::$app->request->post();
        if (isset($data['event'])) {
            if ($data['contains'][0] == 'qr_code') {
                $entity = $data['payload']['qr_code']['entity'];
                $order_id = $entity['id'];
            }
            if ($data['contains'][0] == 'payment') {
                $entity = $data['payload']['payment']['entity'];
            }
            if ($data['contains'][0] == 'payment_link') {
                $entity = $data['payload']['payment_link']['entity'];
            }
            $payment_id = $entity['id'];
            $status = $entity['status'];
            $model = LoanPayments::findOne(['payment_token' => $order_id]);
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
        if (!$params) {
            return $this->response(401, ['status' => 401, 'message' => 'params not found']);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new PaymentModel();
            if ($model->load(Yii::$app->request->post()) && !$model->validate()) {
                return $this->response(422, ['status' => 422, 'message' => \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)]);
            }

            $amount = 0;
            $amount_enc_ids = $model->amount;
            foreach ($amount_enc_ids as $value) {
                $nodues = FinancerLoanProductLoginFeeStructure::findOne(['financer_loan_product_login_fee_structure_enc_id' => $value])['amount'];
                if (!empty($nodues)) {
                    $amount += (float)$nodues;
                }
            }
            $res['amount'] = number_format($amount, 2);
            $model = new Payments();
            $options = [];
            $options['org_id'] = $user->organization_enc_id;
            $keys = \common\models\credentials\Credentials::getrazorpayKey($options);
            if (!$keys){
                return false;
            }
            $api_key = $keys['api_key'];
            $api_secret = $keys['api_secret'];
            $api = new Api($api_key, $api_secret);
            $options['name'] = $params['name'];
            $options['loan_app_id'] = $params['loan_app_id'];
            $options['user_id'] = $user->user_enc_id;
            $options['amount'] = $amount;
            $options['amount_enc_ids'] = $amount_enc_ids;
            $options['total'] = (int)($amount * 100);
            $options['description'] = $params['desc'];
            $options['brand'] = $params['brand'];
            if (empty($options['brand'])) {
                $org_name = Organizations::findOne(['organization_enc_id' => $user->organization_enc_id])['name'];
                $options['brand'] = $org_name;
            }
            $options['contact'] = $params['phone'];
            $options['call_back_url'] = Yii::$app->params->EmpowerYouth->callBack."/payment/transaction";

            $options['purpose'] = $params['purpose'];

            $res['qr'] = $this->existRazorCheck($options['loan_app_id'], 1);
            if (!$res['qr']) {
                $options['close_by'] = time() + 24 * 60 * 60;
                $qr = $model->createQr($api, $options);
                if ($qr['status'] != 200) {
                    $transaction->rollback();
                    return $this->response($qr['status'], $qr);
                }
                $res['qr'] = $qr['surl'];
            }
            $res['link'] = $this->existRazorCheck($options['loan_app_id']);
            if (!$res['link']) {
                $options['close_by'] = time() + 24 * 60 * 60 * 7;
                $link = $model->createLink($api, $options);
                if ($link['status'] != 200) {
                    $transaction->rollback();
                    return $this->response($link['status'], $link);
                }
                $res['amount'] = number_format($link['amount'], 2);
                $res ['link'] = $link['surl'];
            }
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'data' => $res]);
        } catch (\Exception $exception) {
            return [
                'message' => $exception->getMessage(),
                'status' => false
            ];
        }
    }

    private function existRazorCheck($loan_id, $method = 0)
    {
        $query = LoanPayments::find()
            ->alias('a')
            ->select(['a.payment_short_url surl'])
            ->where(['a.loan_app_enc_id' => $loan_id])
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
                ['a.payment_link_type' => $method]]);
        if ($method == 1) {
            $query->andWhere([
                    '>', 'a.close_by', date('Y-m-d H:i:s')]
            );
        }
        $query = $query->asArray()
            ->one();
        if ($query) {
            return $query['surl'];
        } else {
            return false;
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
}