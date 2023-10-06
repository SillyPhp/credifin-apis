<?php

namespace api\modules\v4\controllers;

use api\modules\v4\utilities\UserUtilities;
use common\models\EmiPaymentIssues;
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
                'emi-payment-issues' => ['POST', 'OPTIONS']
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
            $Payment_issues = new EmiPaymentIssues();
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

}
