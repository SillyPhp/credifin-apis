<?php


namespace api\modules\v2\models;

use common\models\LoanApplications;
use common\models\LoanCoApplicants;
use Yii;
use yii\base\Model;

class LoanApplicationsForm extends LoanApplications
{
    public $applicants;
    public $_flag;

    public function rules()
    {
        return [
            [['applicants', 'college_course_enc_id', 'applicant_name', 'applicant_dob', 'applicant_current_city', 'degree', 'years', 'semesters', 'phone', 'email', 'gender', 'amount', 'purpose'], 'required'],
            [['degree', 'purpose'], 'string'],
            [['years', 'semesters', 'gender', 'status'], 'integer'],
            [['amount'], 'number'],
            [['applicant_name', 'college_course_enc_id', 'applicant_current_city', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
        ];
    }

    public function add($userId)
    {
        if (!$this->validate()) {
            print_r($this->getErrors());
        };

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $this->loan_app_enc_id = $utilitiesModel->encrypt();
            $this->created_by = $userId;
            $this->created_on = date('Y-m-d H:i:s');
            if (!$this->save()) {
                print_r($this->getErrors());
                $transaction->rollback();
                return false;
            }
            foreach ($this->applicants as $key => $applicant) {
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
                    print_r($model->getErrors());
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
                print_r($model->getErrors());
                return false;
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return false;
        }
    }
}