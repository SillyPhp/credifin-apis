<?php

namespace api\modules\v4\models;

use common\models\extended\LoanApplicantResidentialInfoExtended;
use common\models\extended\LoanCoApplicantsExtended;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class CoApplicantFrom extends Model
{

    public $name;
    public $phone;
    public $dob;
    public $relation;
    public $borrower_type;

    public $pan_number;
    public $aadhaar_number;
    public $voter_card_number;
    public $address;
    public $city;
    public $state;
    public $zip;


    public function rules()
    {
        return [
            [['name', 'dob', 'relation', 'borrower_type'], 'required'],
            [['pan_number', 'phone', 'aadhaar_number', 'voter_card_number', 'address', 'city', 'state', 'zip'], 'safe'],
            [['name', 'phone', 'pan_number', 'aadhaar_number', 'voter_card_number'], 'trim'],
            [['name'], 'string', 'max' => 200],
            [['phone'], 'string', 'length' => [10, 15]],
        ];
    }

    public function save($loan_id, $user_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $co_applicant = new LoanCoApplicantsExtended();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(10, 100000);
            $co_applicant->loan_co_app_enc_id = $utilitiesModel->encrypt();
            $co_applicant->loan_app_enc_id = $loan_id;
            $co_applicant->name = $this->name;
            $co_applicant->phone = $this->phone;
            $co_applicant->co_applicant_dob = $this->dob;
            $co_applicant->relation = $this->relation;
            $co_applicant->borrower_type = $this->borrower_type;
            $co_applicant->pan_number = $this->pan_number;
            $co_applicant->aadhaar_number = $this->aadhaar_number;
            $co_applicant->voter_card_number = $this->voter_card_number;
            $co_applicant->created_by = $user_id;
            $co_applicant->created_on = date('Y-m-d H:i:s');
            if (!$co_applicant->save()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error3' => $co_applicant->getErrors()];
            }

            // saving address
            $loan_address = new LoanApplicantResidentialInfoExtended();
            $loan_address->loan_id = $loan_id;
            $utilitiesModel->variables['string'] = time() . rand(10, 100000);
            $loan_address->loan_app_res_info_enc_id = $utilitiesModel->encrypt();
            $loan_address->loan_co_app_enc_id = $co_applicant->loan_co_app_enc_id;
            $loan_address->address = $this->address;
            $loan_address->city_enc_id = $this->city;
            $loan_address->state_enc_id = $this->state;
            $loan_address->postal_code = $this->zip;
            $loan_address->created_on = date('Y-m-d H:i:s');
            $loan_address->created_by = $user_id;
            if (!$loan_address->save()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error2' => $loan_address->getErrors()];
            }

            $transaction->commit();

            return ['status' => 200, 'message' => 'successfully saved'];

        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error1' => $exception->getMessage()];
        }
    }

    public function update($co_app_id, $user_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $co_applicant = LoanCoApplicantsExtended::findOne(['loan_co_app_enc_id' => $co_app_id]);

            $co_applicant->name = $this->name ? $this->name : $co_applicant->name;
            $co_applicant->co_applicant_dob = $this->dob ? $this->dob : $co_applicant->co_applicant_dob;
            $co_applicant->phone = $this->phone ? $this->phone : $co_applicant->phone;
            $co_applicant->gender = $this->gender ? $this->gender : $co_applicant->gender;
            $co_applicant->pan_number = $this->pan_number ? $this->pan_number : $co_applicant->pan_number;
            $co_applicant->aadhaar_number = $this->aadhaar_number ? $this->aadhaar_number : $co_applicant->aadhaar_number;
            $co_applicant->voter_card_number = $this->voter_card_number ? $this->voter_card_number : $co_applicant->voter_card_number;
            $co_applicant->updated_by = $user_id;
            $co_applicant->updated_on = date('Y-m-d H:i:s');
            if (!$co_applicant->update()) {
                $transaction->rollBack();
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $co_applicant->getErrors()]);
            }

            // saving address
            $loan_address = LoanApplicantResidentialInfoExtended::findOne(['loan_co_app_enc_id' => $co_app_id]);
            $loan_address->address = $this->address ? $this->address : $loan_address->address;
            $loan_address->city_enc_id = $this->city ? $this->city : $loan_address->city_enc_id;
            $loan_address->state_enc_id = $this->state ? $this->state : $loan_address->state_enc_id;
            $loan_address->postal_code = $this->zip ? $this->zip : $loan_address->postal_code;
            $loan_address->updated_on = date('Y-m-d H:i:s');
            $loan_address->updated_by = $user_id;
            if (!$loan_address->save()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error2' => $loan_address->getErrors()];
            }
            $transaction->commit();

            return $this->response(200, ['status' => 200, 'message' => 'successfully updated']);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error1' => $exception->getMessage()];
        }

    }
}