<?php


namespace account\models\loanApplications;

use common\models\AssignedLoanProvider;
use common\models\CollectedDocuments;
use common\models\LoanApplicationLogs;
use common\models\LoanApplications;
use common\models\LoanSanctionReports;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class LoanSanctionedForm extends LoanApplications
{
    public $file_number;
    public $loan_amount;
    public $processing_fee;
    public $total_installments;
    public $discounting;
    public $approved_by;
    public $fldg;
    public $documents;
    public $loan_app_id;
    public $rate_of_interest;
    public $_flag;

    public function rules()
    {
        return [
            [['rate_of_interest', 'loan_app_id', 'file_number', 'loan_amount', 'processing_fee'], 'required'],
            [['total_installments', 'discounting', 'approved_by', 'fldg', 'documents'], 'safe'],
        ];
    }

    public function updateReport()
    {
        if (!$this->validate()) {
            return false;
        }
        $transactions = Yii::$app->db->beginTransaction();
        try {
            $model = new LoanSanctionReports();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->report_enc_id = $utilitiesModel->encrypt();
            $model->loan_app_enc_id = $this->loan_app_id;
            $model->loan_provider_id = Yii::$app->user->identity->organization_enc_id;
            $model->file_number = $this->file_number;
            $model->loan_amount = $this->loan_amount;
            $model->processing_fee = $this->processing_fee;
            $model->rate_of_interest = $this->rate_of_interest;
            $model->total_installments = $this->total_installments;
            $model->discounting = $this->discounting;
            $model->approved_by = $this->approved_by;
            $model->fldg = $this->fldg;
            $model->created_by = Yii::$app->user->identity->user_enc_id;
            if (!$model->save()) {
                $transactions->rollback();
                return false;
            }
            foreach ($this->documents as $key => $val) {
                $documentModel = new CollectedDocuments();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $documentModel->collect_document_enc_id = $utilitiesModel->encrypt();
                $documentModel->sanctioned_report_id = $model->report_enc_id;
                $documentModel->document_enc_id = $key;
                $documentModel->is_collected = $val;
                $documentModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!$documentModel->save()) {
                    $transactions->rollback();
                    return false;
                }
            }
            $_flag = self::updateStatus($this->loan_app_id, 4, 0, $model->report_enc_id);
            if ($_flag['status'] == 201) {
                $transactions->rollback();
                return false;
            }
            $transactions->commit();
            return true;
        } catch (yii\db\Exception $exception) {
            $transactions->rollback();
            return false;
        }
    }

    function updateStatus($id, $status, $reconsider, $report_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = AssignedLoanProvider::findOne(['loan_application_enc_id' => $id, 'provider_enc_id' => Yii::$app->user->identity->organization->organization_enc_id]);
            $model->status = $status;
            $model->updated_by = Yii::$app->user->identity->user_enc_id;
            $model->updated_on = date('Y-m-d H:i:s');
            if (!$model->save()) {
                $transaction->rollBack();
                return [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'Something went wrong..',
                ];
            }
            $logModel = new LoanApplicationLogs();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $logModel->app_log_enc_id = $utilitiesModel->encrypt();
            $logModel->loan_app_enc_id = $id;
            $logModel->organization_enc_id = Yii::$app->user->identity->organization_enc_id;
//            $logModel->scheme_enc_id = $model->current_scheme_id;
            $logModel->scheme_enc_id = NULL;
            $logModel->created_by = Yii::$app->user->identity->user_enc_id;
            $logModel->created_on = date('Y-m-d H:i:s');
            $logModel->loan_status = $status;
            $logModel->sanctioned_report_id = $report_id;
            $logModel->is_reconsidered = $reconsider;
            if (!$logModel->save()) {
                $transaction->rollBack();
                return [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'Something went wrong..',
                ];
            }
            $transaction->commit();
            return [
                'status' => 200,
                'title' => 'Success',
                'message' => 'Updated Successfully..',
            ];
        } catch (yii\db\Exception $exception) {
            $transaction->rollBack();
            return [
                'status' => 201,
                'title' => 'DB Exception',
                'message' => 'Something went wrong..',
            ];
        }
    }
}