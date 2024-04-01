<?php

namespace api\modules\v4\controllers;

use api\modules\v4\models\EmiCollectionForm;
use api\modules\v4\models\PaymentModel;
use common\models\AssignedLoanPayments;
use common\models\EmiCollection;
use common\models\extended\AssignedLoanProviderExtended;
use common\models\extended\EmiCollectionExtended;
use common\models\extended\LoanApplicationsExtended;
use common\models\extended\Organizations;
use common\models\FinancerLoanProductLoginFeeStructure;
use common\models\LoanAccountPtps;
use common\models\LoanAccounts;
use common\models\LoanApplications;
use common\models\LoanPayments;
use common\models\UserRoles;
use common\models\Utilities;
use Razorpay\Api\Api;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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
                'get-manual-payment' => ['POST', 'OPTIONS'],
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
        $post = file_get_contents('php://input');
        $post = json_decode($post, true);
        if (isset($post['event'])) {
            if (in_array("payment_link", $post["contains"])) {
                $this->handleLinkWebhook($post);
            } else if (in_array("qr_code", $post["contains"])) {
                $this->handleQrWebhook($post);
            }
        }
    }

    private function closeAllModes($id)
    {
        $model = LoanPayments::find()
            ->select(['loan_payments_enc_id'])
            ->where(['reference_id' => $id])
            ->asArray()->all();
        if ($model) {
            foreach ($model as $key => $mod) {
                $data = LoanPayments::findOne(['loan_payments_enc_id' => $mod['loan_payments_enc_id']]);
                $data->payment_mode_status = 'closed';
                $data->save();
            }
            self::updateStatus($model[0]['loan_payments_enc_id']);
        }
    }

    public static function updateStatus($id)
    {
        $query = AssignedLoanPayments::find()
            ->alias('a')
            ->select(['c.assigned_loan_provider_enc_id', 'a.loan_app_enc_id', 'a.updated_by'])
            ->joinWith(['loanAppEnc b' => function ($b) {
                $b->joinWith(['assignedLoanProviders c'], false, 'INNER JOIN');
            }], false, 'INNER JOIN')
            ->andWhere(['and', ['a.loan_payments_enc_id' => $id], ['<=', 'c.status', 4]])
            ->asArray()
            ->one();

        if ($query) {
            Yii::$app->db->createCommand()
                ->update(
                    LoanApplicationsExtended::tableName(),
                    ['login_date' => date('Y-m-d H:i:s')],
                    ['loan_app_enc_id' => $query['loan_app_enc_id']]
                )
                ->execute();
            Yii::$app->db->createCommand()
                ->update(AssignedLoanProviderExtended::tableName(), ['status' => 4, 'loan_status_updated_on' => date('Y-m-d H:i:s'), 'updated_by' => $query['updated_by']], ['assigned_loan_provider_enc_id' => $query['assigned_loan_provider_enc_id']])
                ->execute();
        }
    }

    private function updateEmi($id)
    {
        $model = EmiCollectionExtended::find()
            ->alias('a')
            ->select(['a.emi_collection_enc_id', 'a.loan_account_enc_id', 'a.amount', 'a.emi_payment_status', 'd.proposed_amount', 'c.payment_amount', 'a.emi_payment_method'])
            ->joinWith(['assignedLoanPayments b' => function ($b) {
                $b->joinWith(['loanPaymentsEnc c'], false);
            }], false)
            ->joinWith(['loanAccountPtps d'])
            ->andWhere(['c.reference_id' => $id])
            ->asArray()
            ->one();


        if ($model && $model['emi_payment_status'] != 'paid') {
            $update['collection_date'] = date('Y-m-d');
            $update['emi_payment_status'] = 'paid';
            if ($model['emi_payment_method'] == 0) {
                Yii::$app->db->createCommand()->update(
                    LoanAccountPtps::tableName(),
                    ['status' => 3], // updating
                    ['emi_collection_enc_id' => $model['emi_collection_enc_id'], 'proposed_payment_method' => 2] // where
                )->execute();
                $update['amount'] = $model['payment_amount'];
            }
            $where = [
                "AND",
                ["emi_collection_enc_id" => $model['emi_collection_enc_id']],
                [
                    "NOT",
                    [
                        "emi_payment_status" => "paid"
                    ]
                ]
            ];
            $check = Yii::$app->db->createCommand()->update(EmiCollectionExtended::tableName(), $update, $where)->execute();
            if ($check) {
                EmiCollectionForm::updateOverdue($model["loan_account_enc_id"], $model['amount']);
            }
        }
    }


    private function handleQrWebhook($post)
    {
        if ($post['event'] == 'qr_code.credited') {
            $id = $post['payload']['qr_code']['entity']['id'];
            $payment_id = $post['payload']['payment']['entity']['id'];
            $status = $post['payload']['payment']['entity']['status'];
            $model = LoanPayments::findOne(['payment_token' => $id]);
            $ref_id = $model->reference_id;
            $method = json_encode($post['payload']['payment']['entity']['upi']);
            $model->payment_id = $payment_id;
            $model->payment_status = $status;
            $model->remarks = $method;
            $model->updated_on = date('Y-m-d H:i:s');
            if ($model->save()) {
                if ($status == 'paid' || $status == 'captured') {
                    if (!empty($ref_id)) :
                        $this->closeAllModes($ref_id);
                        $this->updateEmi($ref_id);
                    endif;
                }
                return $this->response(200, ['status' => 200, 'message' => 'success']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'Unable To Store Payment Information']);
            }
        }
    }

    private function handleLinkWebhook($post)
    {
        if ($post['event'] == 'payment_link.paid') {
            $id = $post['payload']['payment_link']['entity']['id'];
            $payment_id = $post['payload']['payment']['entity']['id'];
            $status = $post['payload']['payment']['entity']['status'];
            $model = LoanPayments::findOne(['payment_token' => $id]);
            $ref_id = $model->reference_id;
            $method = $post['payload']['payment']['entity']['method'];
            $model->payment_id = $payment_id;
            $model->payment_status = $status;
            $model->remarks = $method;
            $model->updated_on = date('Y-m-d H:i:s');
            if ($model->save()) {
                if ($status == 'paid' || $status == 'captured') {
                    if (!empty($ref_id)) :
                        $this->closeAllModes($ref_id);
                        $this->updateEmi($ref_id);
                        $this->createEmi($model);
                    endif;
                }
                return $this->response(200, ['status' => 200, 'message' => 'success']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'Unable To Store Payment Information']);
            }
        }
    }

    private function createEmi($loan_payment)
    {
        $id = $loan_payment->loan_payments_enc_id;
        $loan_account = LoanAccounts::find()
            ->alias('a')
            ->innerJoinWith(['assignedLoanPayments AS b' => function ($b) use ($id) {
                $b->andOnCondition(['b.loan_payments_enc_id' => $id]);
            }], false)
            ->asArray()
            ->one();
        $loan_id = $loan_account['loan_account_enc_id'];
        $emi = EmiCollection::findOne([
            'loan_account_enc_id' => $loan_id,
            'amount' => $loan_payment->payment_amount,
            'created_on' => $loan_payment->created_on,
            'emi_payment_method' => 2,
            'is_deleted' => 0
        ]);

        if ($loan_account && empty($emi)) {
            $emi = new EmiCollectionExtended();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $emi->emi_collection_enc_id = $utilitiesModel->encrypt();
            $emi->loan_account_enc_id = $loan_id;
            $emi->branch_enc_id = $loan_account['branch_enc_id'];
            $emi->customer_name = $loan_account['name'];
            $emi->company_id = $loan_account['company_id'];
            $emi->case_no = $loan_account['case_no'];
            $emi->collection_date = date('Y-m-d');
            $emi->loan_account_number = $loan_account['loan_account_number'];
            $emi->phone = $loan_account['phone'];
            $emi->amount = $loan_payment->payment_amount;
            $emi->loan_type = $loan_account['loan_type'];
            $emi->transaction_initiated_date = date('Y-m-d', strtotime($loan_payment->created_on));
            $emi->emi_payment_method = 2;
            $emi->emi_payment_mode = 1;
            $emi->emi_payment_status = 'paid';
            $emi->created_on = $loan_payment->created_on;
            $emi->updated_on = date('Y-m-d H:i:s');
            $emi->created_by = $emi->updated_by = $loan_payment->created_by;
            $emi->save();
            $assigned_loan_payment = AssignedLoanPayments::findOne(['loan_payments_enc_id' => $id]);
            if ($assigned_loan_payment) {
                $assigned_loan_payment->emi_collection_enc_id = $emi->emi_collection_enc_id;
                $assigned_loan_payment->save();
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
            return $this->response(500, ['status' => 500, 'message' => 'params not found']);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new PaymentModel();
            if ($model->load(Yii::$app->request->post()) && !$model->validate()) {
                return $this->response(422, ['status' => 422, 'message' => \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)]);
            }

            $amount = 0;
            $desc = $amount_enc_ids = $options = [];
            foreach ($model->amount as $value) {
                $nodues = FinancerLoanProductLoginFeeStructure::findOne(['financer_loan_product_login_fee_structure_enc_id' => $value]);
                if (!empty($nodues)) {
                    $amount += (float)$nodues['amount'];
                    $desc[] = $nodues['name'];
                    $amount_enc_ids[] = ['id' => $value, 'name' => $nodues['name'], 'amount' => (float)$nodues['amount']];
                }
            }
            if (isset($user->organization_enc_id) || !empty($user->organization_enc_id)) {
                $options['org_id'] = $user->organization_enc_id;
            } else {
                $options['org_id'] = UserRoles::findOne(['user_enc_id' => $user->user_enc_id])->organization_enc_id;
            }
            $keys = \common\models\credentials\Credentials::getrazorpayKey($options);
            if (!$keys) {
                return ['status' => 500, 'message' => 'an error occurred while fetching razorpay credentials'];
            }
            $api_key = $keys['api_key'];
            $api_secret = $keys['api_secret'];
            $api = new Api($api_key, $api_secret);
            $options['name'] = $params['name'];
            $options['loan_app_enc_id'] = $params['loan_app_id'];
            $options['user_id'] = $user->user_enc_id;
            $options['amount'] = $amount;
            $options['amount_enc_ids'] = $amount_enc_ids;
            $options['description'] = 'Payment for ' . implode(', ', $desc);
            $org_name = Organizations::findOne(['organization_enc_id' => $options['org_id']])['name'];
            $options['brand'] = $org_name;
            $options['contact'] = $params['phone'];
            $options['call_back_url'] = Yii::$app->params->EmpowerYouth->callBack . "/payment/transaction";
            $options['purpose'] = 'Payment for ' . implode(', ', $desc);;
            $options['ref_id'] = 'EMPL-' . Yii::$app->security->generateRandomString(8);
            $res['qr'] = $this->existRazorCheck($options, 1);
            if ($options['loan_app_enc_id']) {
                $app_number = LoanApplications::findOne(['loan_app_enc_id' => $options['loan_app_enc_id']])->application_number;
                if (!empty($app_number) || $app_number == '') {
                    $options['description'] = $options['description'] . ' Case Number ' . $app_number;
                }
            }
            if (!$res['qr']) {
                $options['close_by'] = time() + 24 * 60 * 60 * 30;
                $qr = \common\models\payments\Payments::createQr($api, $options);
                if (!$qr) {
                    $transaction->rollback();
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
                $res['qr'] = $qr;
            }
            $res['link'] = $this->existRazorCheck($options);
            if (!$res['link']) {
                $options['close_by'] = time() + 24 * 60 * 60 * 30;
                $link = \common\models\payments\Payments::createLink($api, $options);
                if (!$link) {
                    $transaction->rollback();
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
                }
                $res['link'] = $link;
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

    public function actionGetManualPayment()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        //        if (UserUtilities::getUserType($user->user_enc_id) != 'Financer'){
        //            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        //        }
        $params = Yii::$app->request->post();
        $amount = 0;
        if (!empty($params['amount'])) {
            foreach ($params['amount'] as $value) {
                $check = FinancerLoanProductLoginFeeStructure::findOne(['financer_loan_product_login_fee_structure_enc_id' => $value]);
                if (!empty($check)) {
                    $amount += (float)$check['amount'];
                    $amount_enc_ids[] = ['id' => $value, 'name' => $check['name'], 'amount' => (float)$check['amount']];
                }
            }
        }
        $options['user_id'] = $user->user_enc_id;
        $options['loan_app_enc_id'] = $params['loan_app_id'];
        $options['status'] = 'captured';
        $options['amount_enc_ids'] = $amount_enc_ids;
        $options['amount'] = $amount;
        $options['remarks'] = $params['remarks'];
        $options['payment_mode'] = $params['payment_mode'];
        $options['reference_number'] = $params['reference_number'];
        $options['image'] = UploadedFile::getInstanceByName('image');
        $options['type'] = 'manual';

        $transaction = Yii::$app->db->beginTransaction();
        $save = \common\models\extended\Payments::saveLoanPayment($options);
        if (!$save) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred'];
        }
        $transaction->commit();
        return $this->response(200, ['status' => 200, 'message' => 'saved succesfully']);
    }

    private function existRazorCheck($data, $method = 0)
    {
        $query = LoanPayments::find()
            ->alias('a')
            ->select(['a.loan_payments_enc_id', 'a.payment_short_url surl'])
            ->joinWith(['assignedLoanPayments b'], false)
            ->joinWith(['loanPaymentsDetails c' => function ($c) {
                $c->select(['c.loan_payments_enc_id', 'c.financer_loan_product_login_fee_structure_enc_id']);
            }])
            ->andWhere([
                'and',
                [
                    'not',
                    [
                        'in',
                        'a.payment_status', ['captured', 'created', 'cancelled', 'paid', '', null]
                    ]
                ],
                [
                    'not',
                    [
                        'in',
                        'a.payment_short_url', ['', null]
                    ]
                ],
                ['b.loan_app_enc_id' => $data['loan_app_enc_id']],
                ['a.payment_amount' => $data['amount']],
                ['a.payment_link_type' => $method],
                ['a.payment_mode_status' => 'active'],
                ['not', ['a.close_by' => null]],
                ['>', 'a.close_by', date('Y-m-d H:i:s')]
            ])
            ->asArray()
            ->one();
        if ($query) {
            $encs = [];
            if (is_array($query['loanPaymentsDetails']) and !empty($query['loanPaymentsDetails'])) {
                foreach ($query['loanPaymentsDetails'] as $loanPaymentsDetail) {
                    $encs[] = $loanPaymentsDetail['financer_loan_product_login_fee_structure_enc_id'];
                }
                $amount_enc_ids = array_map(function ($subarray) {
                    return $subarray["id"];
                }, $data['amount_enc_ids']);
                if ($encs == $amount_enc_ids) {
                    return $query['surl'];
                }
            }
        }
        return false;
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
