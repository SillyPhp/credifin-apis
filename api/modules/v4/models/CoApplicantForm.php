<?php

namespace api\modules\v4\models;

use common\models\extended\LoanApplicantResidentialInfoExtended;
use common\models\extended\LoanCoApplicantsExtended;
use Yii;
use yii\base\Model;

class CoApplicantForm extends Model
{
    public $name;
    public $phone;
    public $dob;
    public $relation;
    public $father_name;
    public $borrower_type;
    public $pan_number;
    public $aadhaar_number;
    public $passport_number;
    public $voter_card_number;
    public $address;
    public $city;
    public $state;
    public $zip;
    public $gender;
    public $loan_co_app_enc_id;
    public $loan_id;
    public $user_id;
    public $driving_license_number;
    public $marital_status;

    public function rules()
    {
        return [
            [['name', 'dob', 'relation', 'borrower_type', 'father_name', 'loan_id'], 'required', 'when' => function ($model) {
                return !isset($model->loan_co_app_enc_id);
            }],
            [['pan_number', 'phone', 'loan_co_app_enc_id', 'aadhaar_number', 'passport_number', 'voter_card_number', 'address', 'city', 'state', 'zip', 'gender', 'driving_license_number', 'marital_status'], 'safe'],
            [['name', 'father_name', 'phone', 'pan_number', 'aadhaar_number', 'passport_number', 'voter_card_number'], 'trim'],
            [['name', 'father_name'], 'string', 'max' => 200],
            [['phone'], 'string', 'length' => [10, 15]],
        ];
    }

    public function formName()
    {
        return '';
    }

    // saving co-applicant
    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // saving data
            $co_applicant = new LoanCoApplicantsExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(10, 100000);
            $co_applicant->loan_co_app_enc_id = $utilitiesModel->encrypt();
            $co_applicant->loan_app_enc_id = $this->loan_id;
            $co_applicant->name = $this->name;
            $co_applicant->phone = $this->phone;
            $co_applicant->co_applicant_dob = $this->dob;
            $co_applicant->relation = $this->relation;
            $co_applicant->father_name = $this->father_name;
            $co_applicant->gender = $this->gender;
            $co_applicant->borrower_type = $this->borrower_type;
            $co_applicant->pan_number = $this->pan_number;
            $co_applicant->driving_license_number = $this->driving_license_number;
            $co_applicant->marital_status = $this->marital_status;
            $co_applicant->aadhaar_number = $this->aadhaar_number;
            $co_applicant->passport_number = $this->passport_number;
            $co_applicant->voter_card_number = $this->voter_card_number;
            $co_applicant->created_by = $this->user_id;
            $co_applicant->created_on = date('Y-m-d H:i:s');
            if (!$co_applicant->save()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $co_applicant->getErrors()];
            }

            // saving address
            $loan_address = new LoanApplicantResidentialInfoExtended();
            $loan_address->loan_id = $this->loan_id;
            $utilitiesModel->variables['string'] = time() . rand(10, 100000);
            $loan_address->loan_app_res_info_enc_id = $utilitiesModel->encrypt();
            $loan_address->loan_co_app_enc_id = $co_applicant->loan_co_app_enc_id;
            $loan_address->address = $this->address;
            $loan_address->city_enc_id = $this->city;
            $loan_address->state_enc_id = $this->state;
            $loan_address->postal_code = $this->zip;
            $loan_address->created_on = date('Y-m-d H:i:s');
            $loan_address->created_by = $this->user_id;
            if (!$loan_address->save()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_address->getErrors()];
            }

            $transaction->commit();
            return ['status' => 200, 'message' => 'successfully saved'];
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
        }
    }
    public function setBorrower($options, $user)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $object1 = LoanCoApplicantsExtended::findOne(['loan_co_app_enc_id' => $options['loan_co_app_enc_id']]);
            $object2 = LoanCoApplicantsExtended::findOne(['loan_co_app_enc_id' => $options['old_loan_co_app_enc_id']]);
            $object1->borrower_type = $options['borrower_type'];
            $object1->updated_by = $user;
            $object1->updated_on = date('Y-m-d H:i:s');
            $object2->borrower_type = $options['old_borrower_type'];
            $object2->updated_by = $user;
            $object2->updated_on = date('Y-m-d H:i:s');
            if (!$object1->update()) {
                $transaction->rollBack();
                throw new \Exception(implode("<br />", \yii\helpers\ArrayHelper::getColumn($object1->errors, 0, false)));
            }
            if (!$object2->update()) {
                $transaction->rollBack();
                throw new \Exception(implode("<br />", \yii\helpers\ArrayHelper::getColumn($object2->errors, 0, false)));
            }
            $transaction->commit();
            return ['status' => 200, 'message' => 'successfully updated'];
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
        }
    }

    // updating co-applicant
    public function update()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $co_applicant = LoanCoApplicantsExtended::findOne(['loan_co_app_enc_id' => $this->loan_co_app_enc_id]);
            $borrower_check = $co_applicant['borrower_type'] != $this->borrower_type;
            if ($borrower_check) {
                $co_applicant->borrower_type = $this->borrower_type;
            } else {
                $co_applicant->name = $this->name;
                $co_applicant->father_name = $this->father_name;
                $co_applicant->co_applicant_dob = $this->dob;
                $co_applicant->phone = $this->phone;
                $co_applicant->gender = $this->gender;
                $co_applicant->pan_number = $this->pan_number;
                $co_applicant->aadhaar_number = $this->aadhaar_number;
                $co_applicant->passport_number = $this->passport_number;
                $co_applicant->voter_card_number = $this->voter_card_number;
                $co_applicant->driving_license_number = $this->driving_license_number;
                $co_applicant->marital_status = $this->marital_status;
                $co_applicant->updated_by = $this->user_id;
                $co_applicant->updated_on = date('Y-m-d H:i:s');
            }
            if (!$co_applicant->update()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $co_applicant->getErrors()];
            }


            // skipping address save and update if borrower type is getting update
            if (!$borrower_check) {
                // address saving if exists already otherwise updating
                $loan_address = LoanApplicantResidentialInfoExtended::findOne(['loan_co_app_enc_id' => $this->loan_co_app_enc_id]);

                if (!empty($loan_address)) {
                    $loan_address->updated_on = date('Y-m-d H:i:s');
                    $loan_address->updated_by = $this->user_id;
                } else {
                    $loan_address = new LoanApplicantResidentialInfoExtended();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(10, 100000);
                    $loan_address->loan_app_res_info_enc_id = $utilitiesModel->encrypt();
                    $loan_address->created_on = date('Y-m-d H:i:s');
                    $loan_address->created_by = $this->user_id;
                }
                $loan_address->address = $this->address;
                $loan_address->city_enc_id = $this->city;
                $loan_address->state_enc_id = $this->state;
                $loan_address->postal_code = $this->zip;
                if (!$loan_address->update()) {
                    $transaction->rollBack();
                    return ['status' => 500, 'message' => 'an error occurred', 'error' => $loan_address->getErrors()];
                }
            }
            $transaction->commit();
            return ['status' => 200, 'message' => 'successfully updated'];
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
        }
    }
}
