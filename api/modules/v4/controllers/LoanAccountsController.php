<?php

namespace api\modules\v4\controllers;

use api\modules\v4\utilities\UserUtilities;
use common\models\EmiCollection;
use common\models\EmiPaymentIssues;
use common\models\extended\EmiPaymentIssuesExtended;
use common\models\LoanAccounts;
use common\models\Utilities;
use Yii;
use yii\filters\Cors;
use yii\filters\VerbFilter;


class LoanAccountsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'loan-accounts-upload' => ['POST', 'OPTIONS'],
                'emi-payment-issues' => ['POST', 'OPTIONS'],
                'emi-account-details' => ['POST', 'OPTIONS']
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

    public function actionLoanAccountsUpload()
    {
        $user = $this->isAuthorized();
        if (!$user && !UserUtilities::getUserType($user->user_enc_id) != 'Financer') {
            return $this->response(500, 'Not Authorized');
        }
        $file = $_FILES['file'];
        if (($handle = fopen($file['tmp_name'], "r")) !== FALSE) {
            $count = 1;
            $transaction = Yii::$app->db->beginTransaction();
            $utilitiesModel = new Utilities();
            while (($data = fgetcsv($handle, 1000)) !== FALSE) {
                if ($count == 1) {
                    $count++;
                    continue;
                }
                $save = 'update';
                $loan = LoanAccounts::findOne(['loan_account_number' => trim($data[1])]);
                if (!$loan) {
                    $loan = new LoanAccounts();
                    $utilitiesModel->variables['string'] = time() . rand(100, 10000000);
                    $loan->loan_account_enc_id = $utilitiesModel->encrypt();
                    $loan->lms_loan_account_number = $data[0];
                    $loan->loan_account_number = trim($data[1]);
                    $loan->name = $data[2];
                    if (!empty($data[3])) {
                        $loan->phone = $data[3];
                    }
                    $loan->loan_type = $data[6];
                    $loan->created_on = date('Y-m-d h:i:s');
                    $loan->created_by = $user->user_enc_id;
                    $save = 'save';
                }
                $loan->emi_date = date('Y-m-d', strtotime($data[5]));
                $loan->emi_amount = $data[4];
                if (!empty($data[7])) {
                    $loan->overdue_amount = $data[7];
                }
                if (!empty($data[8])) {
                    $loan->ledger_amount = $data[8];
                }
                if (!empty($data[9])) {
                    $loan->last_emi_received_amount = $data[9];
                }
                if (!empty($data[10])) {
                    $loan->last_emi_received_date = date('Y-m-d', strtotime($data[10]));
                }
                $loan->updated_on = date('Y-m-d h:i:s');
                $loan->updated_by = $user->user_enc_id;
                if (!$loan->$save()) {
                    $transaction->rollBack();
                    return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $loan->getErrors()]);
                }
            }
            fclose($handle);
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
        }
    }

    public function actionEmiPaymentIssues()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'Unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_account_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_account_enc_id']);
        }
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $Payment_issues = new EmiPaymentIssuesExtended();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $Payment_issues->emi_payment_issues_enc_id = $utilitiesModel->encrypt();
            $Payment_issues->loan_account_enc_id = $params['loan_account_enc_id'];
            $Payment_issues->loan_app_enc_id = !empty($params['loan_app_enc_id']) ? $params['loan_app_enc_id'] : null;
            $Payment_issues->reasons = $params['reasons'];
            $Payment_issues->remarks = $params['remarks'];
            $Payment_issues->created_by = $Payment_issues->updated_by = $user->user_enc_id;
            $Payment_issues->created_on = $Payment_issues->updated_on = date('Y-m-d H:i:s');

            if (!$Payment_issues->save()) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'An error occurred while saving the data.', 'error' => $Payment_issues->getErrors()]);
            }
            $transaction->commit();
            return $this->response(200, ['status' => 200, 'issues' => $Payment_issues]);

        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'An error occurred', 'error' => json_decode($exception->getMessage(), true)];
        }
    }

    public function actionEmiAccountDetails()
    {
        if (!$this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
        $params = Yii::$app->request->post();
        if (empty($params['loan_account_enc_id'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information "loan_account_enc_id"']);
        }

        $lac = LoanAccounts::findOne(['loan_account_enc_id' => $params['loan_account_enc_id']]);
        $model = $this->_emiAccData($params, $lac)['data'];
        if (!$model) {
            return $this->response(404, ['status' => 404, 'message' => 'Data not found']);
        }

        $data = LoanAccounts::find()
            ->select(['loan_account_enc_id', 'loan_account_number', 'COUNT(CASE WHEN is_deleted = 0 THEN loan_account_number END) as total_emis', 'name', 'phone', 'emi_amount', 'overdue_amount', 'ledger_amount', 'loan_type', 'emi_date', 'created_on', 'last_emi_received_amount', 'last_emi_received_date'])
            ->andWhere(['is_deleted' => 0, 'loan_account_enc_id' => $params['loan_account_enc_id']])
            ->asArray()
            ->one();


        if ($data) {
            return $this->response(200, ['status' => 200, 'data' => $data, 'display_data' => $model]);
        }
        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    private function _emiAccData($params, $lac)
    {
        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        $page = !empty($params['page']) ? $params['page'] : 1;
        $model = EmiCollection::find()
            ->alias('a')
            ->select([
                'a.customer_name', 'a.collection_date', 'a.amount', 'a.emi_payment_method', 'CONCAT(b.first_name , " ", b.last_name) as collected_by',
                'CASE WHEN a.other_delay_reason IS NOT NULL THEN CONCAT(a.delay_reason, ",",a.other_delay_reason) ELSE a.delay_reason END AS delay_reason',
                'CASE WHEN a.pr_receipt_image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->pr_receipt_image->image . '",a.pr_receipt_image_location, "/", a.pr_receipt_image) ELSE NULL END as pr_receipt_image',
                'CASE WHEN a.other_doc_image IS NOT NULL THEN  CONCAT("' . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->emi_collection->other_doc_image->image . '",a.other_doc_image_location, "/", a.other_doc_image) ELSE NULL END as other_doc_image',
                'a.created_on', 'a.emi_payment_status', 'a.reference_number'
            ])
            ->joinWith(['createdBy b'], false)
            ->orderBy(['a.created_on' => SORT_DESC]);
//            ->andWhere(['a.is_deleted' => 0,'loan_account_enc_id' => $lac['loan_account_enc_id']]);

        $model = $model
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();
        return ['data' => $model];

    }
}
