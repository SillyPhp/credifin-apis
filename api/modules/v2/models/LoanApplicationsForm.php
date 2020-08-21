<?php


namespace api\modules\v2\models;

use common\models\EducationLoanPayments;
use common\models\LoanApplications;
use common\models\LoanCoApplicants;
use common\models\LoanPurpose;
use common\models\LoanTypes;
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
            [['purpose', 'college_course_enc_id', 'applicant_name', 'aadhaar_number', 'applicant_dob', 'applicant_current_city', 'degree', 'years', 'semesters', 'phone', 'email', 'gender', 'amount'], 'required'],
            [['co_applicants', 'loan_type_enc_id'], 'safe'],
            [['degree'], 'string'],
            [['years', 'semesters', 'gender', 'status'], 'integer'],
            [['amount'], 'number'],
            [['applicant_name', 'loan_type_enc_id', 'college_course_enc_id', 'applicant_current_city', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
        ];
    }

    public function add($userId, $college_id, $source = 'Mec')
    {
        $loan_type = LoanTypes::findOne(['loan_name' => 'Annual'])->loan_type_enc_id;
        $application_fee = OrganizationFeeAmount::find()
            ->select(['application_fee_amount_enc_id', 'amount', 'gst'])
            ->where(['organization_enc_id' => $college_id, 'loan_type_enc_id' => $loan_type, 'status' => 1])
            ->asArray()
            ->one();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $this->loan_app_enc_id = $utilitiesModel->encrypt();
            $this->college_enc_id = $college_id;
            $this->source = $source;
            $this->loan_type_enc_id = (($loan_type) ? $loan_type : null);
            $this->created_by = $userId;
            $this->created_on = date('Y-m-d H:i:s');
            if (!$this->save()) {
                print_r($this->getErrors());
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
                        print_r($purpose->getErrors());
                        die();
                        $transaction->rollback();
                        return false;
                    } else {
                        $this->_flag = true;
                    }
                }
            }
            if ($this->co_applicants && !empty($this->co_applicants) && $this->co_applicants != null) {
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
                    $model->aadhaar_number = $applicant['aadhaar_number'];
                    $model->created_by = (($userId) ? $userId : null);
                    $model->created_on = date('Y-m-d H:i:s');
                    if (!$model->save()) {
                        print_r($model->getErrors());
                        die();
                        $transaction->rollback();
                        return false;
                    } else {
                        $this->_flag = true;
                    }
                }
            }

            if (!empty($application_fee)) {
                $amount = $application_fee['amount'];
                $gst = $application_fee['gst'];
                $percentage = ($amount * $gst) / 100;
                $total_amount = $amount + $percentage;
            } else {
                $total_amount = 500;
                $gst = 0;
                $amount = 500;
            }


            $args = [];
            $args['amount'] = $total_amount;
            $args['currency'] = "INR";
            $args['email'] = $this->email;
            $args['contact'] = $this->phone;

            $response = $this->GetToken($args);

            if (isset($response['status']) && $response['status'] == 'created') {
                $token = $response['id'];
                $loan_payment = new EducationLoanPayments();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $loan_payment->education_loan_payment_enc_id = $utilitiesModel->encrypt();
                $loan_payment->college_enc_id = $college_id;
                $loan_payment->loan_app_enc_id = $this->loan_app_enc_id;
                $loan_payment->payment_token = $token;
                $loan_payment->payment_amount = $amount;
                $loan_payment->payment_gst = $gst;
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
            print_r($exception);
            die();
            $transaction->rollBack();
            return false;
        }
    }

    public function GetToken($args)
    {
        //Generation of REQUEST_SIGNATURE for a POST Request
        $date = date_create();
        $timestamp = date_timestamp_get($date);
        //params list start
        $currency = $args['currency'];
        $amount = $args['amount'];
        $contact = $args['contact'];
        $email = $args['email'];
        //unique number string
        $mtx = Yii::$app->getSecurity()->generateRandomString();
        //params list end
        if (Yii::$app->params->paymentGateways->mec->icici) {
            $configuration = Yii::$app->params->paymentGateways->mec->icici;
            if ($configuration->mode === "production") {
                $access_key = $configuration->credentials->production->access_key;
                $secret_key = $configuration->credentials->production->secret_key;
                $url = $configuration->credentials->production->url;
            } else {
                $access_key = $configuration->credentials->sandbox->access_key;
                $secret_key = $configuration->credentials->sandbox->secret_key;
                $url = $configuration->credentials->sandbox->url;
            }
        }
        $params = 'currency=' . $currency . '&amount=' . $amount . '&contact=' . $contact . '&mtx=' . $mtx . '&email=' . $email . '';
        $url = $url . "?$params";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        $header = [
            'Accept:*/*',
            'X-O-Timestamp: ' . $timestamp . '',
            'Content-Type: application/json',
            'Authorization: ' . $access_key . ':' . $secret_key . ''
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        return json_decode($result, true);
    }
}