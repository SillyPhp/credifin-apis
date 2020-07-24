<?php


namespace api\modules\v2\models;

use common\models\LoanApplications;
use common\models\LoanCoApplicants;
use Yii;
use yii\base\Model;

class LoanApplicationsForm extends LoanApplications
{
    public $co_applicants;
    public $_flag;

    public function rules()
    {
        return [
            [['co_applicants', 'college_course_enc_id', 'applicant_name', 'applicant_dob', 'applicant_current_city', 'degree', 'years', 'semesters', 'phone', 'email', 'gender', 'amount', 'purpose'], 'required'],
            [['degree'], 'string'],
            [['years', 'semesters', 'gender', 'status'], 'integer'],
            [['amount'], 'number'],
            [['applicant_name', 'college_course_enc_id', 'applicant_current_city', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
        ];
    }

    public function add($userId)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $purpose = implode(',', $this->purpose);
            $this->purpose = $purpose;
            $this->loan_app_enc_id = $utilitiesModel->encrypt();
            $this->created_by = $userId;
            $this->created_on = date('Y-m-d H:i:s');
            if (!$this->save()) {
                $transaction->rollback();
                return false;
            }
            foreach ($this->co_applicants as $key => $applicant) {
                $model = new LoanCoApplicants();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $model->loan_co_app_enc_id = $utilitiesModel->encrypt();
                $model->loan_app_enc_id = $this->loan_app_enc_id;
                $model->name = $applicant['name'];
                $model->relation = $applicant['relation'];
                $model->employment_type = $applicant['employment_type'];
                $model->annual_income = $applicant['annual_income'];
                $model->created_by = $userId;
                $model->created_on = date('Y-m-d H:i:s');
                if (!$model->save()) {
                    $transaction->rollback();
                    return false;
                } else {
                    $this->_flag = true;
                }
            }
            if ($this->_flag) {
                $transaction->commit();
                return true;
            } else {
                $transaction->rollBack();
                return false;
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return false;
        }
    }
}