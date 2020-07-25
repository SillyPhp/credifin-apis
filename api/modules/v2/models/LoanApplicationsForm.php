<?php


namespace api\modules\v2\models;

use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use common\models\LoanCoApplicants;
use common\models\LoanPurpose;
use common\models\OrganizationFeeAmount;
use Yii;
use yii\base\Model;

class LoanApplicationsForm extends LoanApplications
{
    public $co_applicants;
    public $purpose;
    public $_flag;

    public function rules()
    {
        return [
            [['co_applicants', 'purpose', 'college_course_enc_id', 'applicant_name', 'applicant_dob', 'applicant_current_city', 'degree', 'years', 'semesters', 'phone', 'email', 'gender', 'amount'], 'required'],
            [['degree'], 'string'],
            [['years', 'semesters', 'gender', 'status'], 'integer'],
            [['amount'], 'number'],
            [['applicant_name', 'college_course_enc_id', 'applicant_current_city', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
        ];
    }

    public function add($userId, $college_id)
    {
        $application_fee = OrganizationFeeAmount::find()
            ->select(['application_fee_amount_enc_id', 'amount', 'gst'])
            ->where(['organization_enc_id' => $college_id, 'loan_type_enc_id' => $this->loan_type_enc_id, 'status' => 1])
            ->asArray()
            ->one();

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $this->loan_app_enc_id = $utilitiesModel->encrypt();
            $this->college_enc_id = $college_id;
            if (!empty($application_fee)) {
                $this->status = 4;
            }
            $this->source = 'Mec';
            $this->created_by = $userId;
            $this->created_on = date('Y-m-d H:i:s');
            if (!$this->save()) {
                $transaction->rollback();
                return false;
            } else {
                $this->_flag = true;
            }

            if (!empty($this->purpose)) {
                foreach ($this->purpose as $p) {
                    $purpose = new LoanPurpose();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $purpose->loan_purpose_enc_id = $utilitiesModel->encrypt();
                    $purpose->fee_component_enc_id = $p;
                    $purpose->loan_app_enc_id = $this->loan_app_enc_id;
                    $purpose->created_by = $userId;
                    $purpose->created_on = date('Y-m-d H:i:s');
                    if (!$purpose->save()) {
                        $transaction->rollback();
                        return false;
                    } else {
                        $this->_flag = true;
                    }
                }
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
                $model->pan_number = $applicant['pan_number'];
                $model->created_by = $userId;
                $model->created_on = date('Y-m-d H:i:s');
                if (!$model->save()) {
                    $transaction->rollback();
                    return false;
                } else {
                    $this->_flag = true;
                }
            }
            if (!empty($application_fee)) {

                $amount = $application_fee['amount'];
                $gst = $application_fee['gst'];
                $percentage = ($amount * $gst) / 100;
                $total_amount = $amount + $percentage;
                $application_fee['total_amount'] = $total_amount;

                $args = [];
                $args['amount'] = $application_fee['total_amount'];
                $args['currency'] = "INR";
                $args['email'] = $this->email;
                $args['contact'] = $this->phone;

                $request = curl_init('http://www.sneh.eygb.me/api/v3/payment-request/get-token');
                curl_setopt($request, CURLOPT_POST, true);
                curl_setopt($request, CURLOPT_POSTFIELDS, $args);
                curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
                $response = json_decode(curl_exec($request), true);

                if (isset($response['status']) && $response['status'] == 'created') {
                    $token = $response['id'];
                    $loan_payment = new EducationLoanPayments();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $loan_payment->education_loan_payment_enc_id = $utilitiesModel->encrypt();
                    $loan_payment->college_enc_id = $college_id;
                    $loan_payment->loan_app_enc_id = $this->loan_app_enc_id;
                    $loan_payment->payment_token = $token;
                    $loan_payment->payment_amount = $application_fee['total_amount'];
                    $loan_payment->payment_gst = $application_fee['gst'];
                    $loan_payment->created_by = $userId;
                    $loan_payment->created_on = date('Y-m-d H:i:s');
                    if (!$loan_payment->save()) {
                        print_r($loan_payment->getErrors());
                        die();
                        $transaction->rollBack();
                        return false;
                    } else {
                        $transaction->commit();
                        $data = [];
                        $data['loan_app_enc_id'] = $this->loan_app_enc_id;
                        $data['education_loan_payment_enc_id'] = $loan_payment->education_loan_payment_enc_id;
                        $data['payment_id'] = $loan_payment->payment_token;
                        return $data;
                    }
                }
            }
            if ($this->_flag) {
                $transaction->commit();
                $data = [];
                $data['loan_app_enc_id'] = $this->loan_app_enc_id;
                $data['education_loan_payment_enc_id'] = '';
                $data['payment_id'] = '';
                return $data;
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