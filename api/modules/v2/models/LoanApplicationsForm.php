<?php

namespace api\modules\v2\models;

use common\models\Countries;
use common\models\EducationLoanPayments;
use common\models\extended\PaymentsModule;
use common\models\LeadsApplications;
use common\models\LoanApplicationOptions;
use common\models\LoanApplications;
use common\models\LoanApplicationSchoolFee;
use common\models\LoanApplicationsCollegePreference;
use common\models\LoanApplicationTeacherLoan;
use common\models\LoanCoApplicants;
use common\models\LoanPurpose;
use common\models\LoanTypes;
use common\models\OrganizationFeeAmount;
use common\models\PathToClaimOrgLoanApplication;
use common\models\PathToOpenLeads;
use common\models\PathToUnclaimOrgLoanApplication;
use common\models\Referral;
use common\models\Users;
use Yii;
use yii\base\Model;

class LoanApplicationsForm extends LoanApplications
{
    public $co_applicants;
    public $purpose;
    public $_flag;
    public $course_enc_id;
    public $country_enc_id;

    public function rules()
    {
        return [
            [['applicant_name', 'applicant_dob', 'applicant_current_city', 'phone', 'email', 'amount'], 'required'],
            [['co_applicants', 'country_enc_id', 'aadhaar_number', 'purpose', 'gender', 'years', 'semesters', 'loan_type_enc_id', 'course_enc_id', 'college_course_enc_id', 'degree'], 'safe'],
            [['degree'], 'string'],
            [['years', 'semesters', 'gender', 'status'], 'integer'],
            [['amount'], 'number'],
            [['applicant_name', 'loan_type_enc_id', 'college_course_enc_id', 'applicant_current_city', 'email'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
        ];
    }

    public function add($addmission_taken = 1, $userId, $college_id, $source = 'Mec', $is_claimed = 1, $course_name = null, $pref = [], $refferal_id = null, $lead_id = null)
    {
        $loan_type = LoanTypes::findOne(['loan_name' => 'Annual'])->loan_type_enc_id;
        if (empty($this->country_enc_id)) {
            $this->country_enc_id = Countries::findOne(['name' => 'India'])->country_enc_id;
        }
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
            $this->course_enc_id = $this->college_course_enc_id;
            $this->college_course_enc_id = NULL;
            $this->source = $source;
            $this->had_taken_addmission = $addmission_taken;
            $this->loan_type_enc_id = (($loan_type) ? $loan_type : null);
            $this->created_by = (($userId) ? $userId : null);
            $this->created_on = date('Y-m-d H:i:s');
            if ($refferal_id) {
                $referralData = Referral::findOne(['code' => $refferal_id]);
                if ($referralData) {
                    $this->lead_by = $referralData->user_enc_id;
                }
            }
            if ($lead_id) {
                $checkLead = LeadsApplications::find()->select(['application_enc_id'])->where(['application_enc_id' => $lead_id,'is_deleted' => 0])->one();
                if ($checkLead) {
                    $this->lead_application_enc_id = $lead_id;
                }
            }
            if (!$this->save()) {
                $transaction->rollback();
                $this->_flag = false;
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($this->errors, 0, false)));
            } else {
                $this->_flag = true;
            }

            if ($is_claimed == 1) {
                $path_to_claim = new PathToClaimOrgLoanApplication();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $path_to_claim->bridge_enc_id = $utilitiesModel->encrypt();
                $path_to_claim->loan_app_enc_id = $this->loan_app_enc_id;
                $path_to_claim->assigned_course_enc_id = $this->course_enc_id;
                $path_to_claim->country_enc_id = $this->country_enc_id;
                $path_to_claim->created_by = (($userId) ? $userId : null);
                if (!$path_to_claim->save()) {
                    $transaction->rollback();
                    $this->_flag = false;
                    throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($path_to_claim->errors, 0, false)));
                } else {
                    $this->_flag = true;
                }
            } else if ($is_claimed == 2) {
                $path_to_Unclaim = new PathToUnclaimOrgLoanApplication();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $path_to_Unclaim->bridge_enc_id = $utilitiesModel->encrypt();
                $path_to_Unclaim->loan_app_enc_id = $this->loan_app_enc_id;
                $path_to_Unclaim->assigned_course_enc_id = $this->course_enc_id;
                $path_to_Unclaim->country_enc_id = $this->country_enc_id;
                $path_to_Unclaim->created_by = (($userId) ? $userId : null);
                if (!$path_to_Unclaim->save()) {
                    $transaction->rollback();
                    $this->_flag = false;
                    throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($path_to_Unclaim->errors, 0, false)));
                } else {
                    $this->_flag = true;
                }
            } else if ($is_claimed == 3) {
                if (!empty($course_name)) {
                    $path_to_leads = new PathToOpenLeads();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $path_to_leads->bridge_enc_id = $utilitiesModel->encrypt();
                    $path_to_leads->loan_app_enc_id = $this->loan_app_enc_id;
                    $path_to_leads->course_name = $course_name;
                    $path_to_leads->country_enc_id = $this->country_enc_id;
                    $path_to_leads->created_by = (($userId) ? $userId : null);
                    if (!$path_to_leads->save()) {
                        $transaction->rollback();
                        $this->_flag = false;
                        throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($path_to_leads->errors, 0, false)));
                    } else {
                        $this->_flag = true;
                    }
                } else {
                    $transaction->rollback();
                    $this->_flag = false;
                }

                if (!empty($pref))
                    $c = 1;
                foreach ($pref as $p) {
                    if (!empty($p)) {
                        $preferenceModel = new LoanApplicationsCollegePreference();
                        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                        $preferenceModel->preference_enc_id = $utilitiesModel->encrypt();
                        $preferenceModel->loan_app_enc_id = $this->loan_app_enc_id;
                        $preferenceModel->created_by = (($userId) ? $userId : null);
                        $preferenceModel->college_name = trim($p);
                        $preferenceModel->sequence = $c;
                        if (!$preferenceModel->save()) {
                            $transaction->rollback();
                            $this->_flag = false;
                            throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($preferenceModel->errors, 0, false)));
                        } else {
                            $c++;
                            $this->_flag = true;
                        }
                    }
                }
            }

            if (!empty($this->purpose)) {
                foreach ($this->purpose as $p) {
                    $purpose = new LoanPurpose();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $purpose->loan_purpose_enc_id = $utilitiesModel->encrypt();
                    $purpose->fee_component_enc_id = $p;
                    $purpose->loan_app_enc_id = $this->loan_app_enc_id;
                    $purpose->created_by = (($userId) ? $userId : null);;
                    $purpose->created_on = date('Y-m-d H:i:s');
                    if (!$purpose->save()) {
                        $transaction->rollback();
                        $this->_flag = false;
                        throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($purpose->errors, 0, false)));
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
                    $model->created_by = (($userId) ? $userId : null);
                    $model->created_on = date('Y-m-d H:i:s');
                    if (!$model->save()) {
                        $transaction->rollback();
                        $this->_flag = false;
                        throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)));
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
            $args['amount'] = $this->floatPaisa($total_amount); //for inr float to paisa format for razor pay payments
            $args['currency'] = "INR";
            $args['accessKey'] = Yii::$app->params->EmpowerYouth->permissionKey;
            $response = PaymentsModule::_authPayToken($args);
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
                $loan_payment->created_by = (($userId) ? $userId : null);
                $loan_payment->created_on = date('Y-m-d H:i:s');
                if (!$loan_payment->save()) {
                    $transaction->rollBack();
                    $this->_flag = false;
                    throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($loan_payment->errors, 0, false)));
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
            $transaction->rollBack();
            return $exception->getMessage();
        }
    }
    public function saveSchoolFeeLoan($userId,$source,$params){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $utilitiesModel = new \common\models\Utilities();
            $this->loan_app_enc_id = Yii::$app->security->generateRandomString(8);
            $this->source = $source;
            $this->had_taken_addmission = 0;
            $this->loan_type = 'School Fee Loan';
            $this->created_by = (($userId) ? $userId : null);
            $this->created_on = date('Y-m-d H:i:s');
            if (!$this->save()) {
                $transaction->rollback();
                $this->_flag = false;
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($this->errors, 0, false)));
            } else {
                $this->_flag = true;
            }
            $total_amount = PaymentsModule::_defaultPayment();
            $gst = PaymentsModule::_defaultGst();
            $percentage = ($total_amount * $gst) / 100;
            $total_amount = $total_amount + $percentage;
            $args = [];
            $args['amount'] = $this->floatPaisa($total_amount); //for inr float to paisa format for razor pay payments
            $args['currency'] = "INR";
            $args['accessKey'] = Yii::$app->params->EmpowerYouth->permissionKey;
            $response = PaymentsModule::_authPayToken($args);
            if (isset($response['status']) && $response['status'] == 'created') {
                $token = $response['id'];
                $loan_payment = new EducationLoanPayments();
                $loan_payment->education_loan_payment_enc_id = Yii::$app->security->generateRandomString(8);
                $loan_payment->loan_app_enc_id = $this->loan_app_enc_id;
                $loan_payment->payment_token = $token;
                $loan_payment->payment_amount = $total_amount;
                $loan_payment->payment_gst = $gst;
                $loan_payment->created_by = (($userId) ? $userId : null);
                $loan_payment->created_on = date('Y-m-d H:i:s');
                if (!$loan_payment->save()) {
                    $transaction->rollBack();
                    $this->_flag = false;
                    throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($loan_payment->errors, 0, false)));
                } else{
                    $this->_flag = true;
                }
            }

            if ($this->_flag){
                foreach ($params['child_information'] as $information){
                    $loanSchool = new LoanApplicationSchoolFee();
                    $loanSchool->school_fee_enc_id = Yii::$app->security->generateRandomString(8);
                    $loanSchool->loan_app_enc_id = $this->loan_app_enc_id;
                    $loanSchool->student_name = $information['child_name'];
                    $loanSchool->school_name = $information['child_school'];
                    $loanSchool->class = $information['child_class'];
                    $loanSchool->created_by = (($userId) ? $userId : null);
                    $loanSchool->created_on = date('Y-m-d H:i:s');
                    if (!$loanSchool->save()) {
                        $transaction->rollBack();
                        $this->_flag = false;
                        throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($loanSchool->errors, 0, false)));
                    } else{
                        $this->_flag = true;
                    }
                }
            }
             if ($this->_flag){
                 $loanOptions = new LoanApplicationOptions();
                 $loanOptions->option_enc_id = Yii::$app->security->generateRandomString(8);
                 $loanOptions->loan_app_enc_id = $this->loan_app_enc_id;
                 $loanOptions->application_by = (int)$params['is_applicant'];
                 $loanOptions->created_by = (($userId) ? $userId : null);
                 $loanOptions->created_on = date('Y-m-d H:i:s');
                 if (!$loanOptions->save()) {
                     $transaction->rollBack();
                     $this->_flag = false;
                     throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($loanOptions->errors, 0, false)));
                 } else{
                     $this->_flag = true;
                 }
             }
            if ($this->_flag) {
                $transaction->commit();
                $data = [];
                $data['loan_app_enc_id'] = $this->loan_app_enc_id;
                $data['education_loan_payment_enc_id'] = $loan_payment->education_loan_payment_enc_id;
                $data['payment_id'] = $loan_payment->payment_token;
                $data['status'] = true;
                return $data;
            } else {
                $transaction->rollBack();
                return [
                    'message'=>'Unable to Save',
                    'status'=>false
                ];
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return [
                'message'=>$exception->getMessage(),
                'status'=>false
            ];
        }
    }
    public function saveTeachersLoan($userId,$source,$params){
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->loan_app_enc_id = Yii::$app->security->generateRandomString(8);
            $this->source = $source;
            $this->had_taken_addmission = 0;
            $this->loan_type = 'Teacher Loan';
            $this->created_by = (($userId) ? $userId : null);
            $this->created_on = date('Y-m-d H:i:s');
            if (!$this->save()) {
                $transaction->rollback();
                $this->_flag = false;
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($this->errors, 0, false)));
            } else {
                $this->_flag = true;
            }
            $total_amount = PaymentsModule::_defaultPayment();
            $gst = PaymentsModule::_defaultGst();
            $percentage = ($total_amount * $gst) / 100;
            $total_amount = $total_amount + $percentage;
            $args = [];
            $args['amount'] = $this->floatPaisa($total_amount); //for inr float to paisa format for razor pay payments
            $args['currency'] = "INR";
            $args['accessKey'] = Yii::$app->params->EmpowerYouth->permissionKey;
            $response = PaymentsModule::_authPayToken($args);
            if (isset($response['status']) && $response['status'] == 'created') {
                $token = $response['id'];
                $loan_payment = new EducationLoanPayments();
                $loan_payment->education_loan_payment_enc_id = Yii::$app->security->generateRandomString(8);;
                $loan_payment->loan_app_enc_id = $this->loan_app_enc_id;
                $loan_payment->payment_token = $token;
                $loan_payment->payment_amount = $total_amount;
                $loan_payment->payment_gst = $gst;
                $loan_payment->created_by = (($userId) ? $userId : null);
                $loan_payment->created_on = date('Y-m-d H:i:s');
                if (!$loan_payment->save()) {
                    $transaction->rollBack();
                    $this->_flag = false;
                    throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($loan_payment->errors, 0, false)));
                } else{
                    $this->_flag = true;
                }
            }
            if ($this->_flag) {
                $loanTeacherForm = new LoanApplicationTeacherLoan();
                $loanTeacherForm->teacher_loan_enc_id = Yii::$app->security->generateRandomString(8);;
                $loanTeacherForm->loan_app_enc_id = $this->loan_app_enc_id;
                $loanTeacherForm->years = $params['years'];
                $loanTeacherForm->months = (($params['months'])?$params['months']:0);
                $loanTeacherForm->employement_type = $params['employement_type'];
                $loanTeacherForm->institution_name = $params['institution'];
                $loanTeacherForm->created_by = (($userId) ? $userId : null);
                $loanTeacherForm->created_on = date('Y-m-d H:i:s');
                if (!$loanTeacherForm->save()) {
                    $transaction->rollBack();
                    $this->_flag = false;
                    throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($loanTeacherForm->errors, 0, false)));
                } else{
                    $this->_flag = true;
                }
            }
            if ($this->_flag) {
                $transaction->commit();
                $data = [];
                $data['loan_app_enc_id'] = $this->loan_app_enc_id;
                $data['education_loan_payment_enc_id'] = $loan_payment->education_loan_payment_enc_id;
                $data['payment_id'] = $loan_payment->payment_token;
                $data['status'] = true;
                return $data;
            } else {
                $transaction->rollBack();
                return [
                    'message'=>'Unable to Save',
                    'status'=>false
                ];
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return [
                    'message'=>$exception->getMessage(),
                    'status'=>false
                ];
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

    private function floatPaisa($amount)
    {
        $c = $amount * 100;
        return (int)$c;
    }
}