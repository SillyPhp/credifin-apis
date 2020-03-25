<?php

namespace frontend\models\onlineClassEnquiries;

use common\models\OnlineCalssEnquiries;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use borales\extensions\phoneInput\PhoneInputValidator;
use borales\extensions\phoneInput\PhoneInputBehavior;
use borales\extensions\phoneInput\PhoneInput;

class ClassEnquiryForm extends Model
{
    public $full_name;
    public $email;
    public $phone;
    public $organization_name;
    public $enquiry_for;
    public $designation;
    public $_flag;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'organization_name', 'designation', 'enquiry_for'], 'required'],
            [['organization_name', 'designation', 'enquiry_for'], 'string', 'max' => 100],
            [['full_name'], 'string', 'max' => 30],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['phone'], PhoneInputValidator::className()],
        ];
    }

    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $enq = implode(",", $this->enquiry_for);
            $model = new OnlineCalssEnquiries();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->enquiry_enc_id = $utilitiesModel->encrypt();
            $model->full_name = $this->full_name;
            $model->email = $this->email;
            $model->phone = $this->phone;
            $model->organization_name = $this->organization_name;
            $model->designation = $this->designation;
            $model->enquiry_for = $enq;
            $model->created_on = date('Y-m-d H:i:s');
            if ($model->validate() && $model->save()) {
                $this->_flag = true;
            } else {
                $transaction->rollBack();
                $this->_flag = false;
            }

            if ($this->_flag) {
                $transaction->commit();
                return [
                    'status' => 200,
                    'title' => 'Success',
                    'message' => 'Submitted Successfully..',
                ];
            } else {
                return [
                    'status' => 201,
                    'title' => 'Error',
                    'message' => 'Something wrong.. Try Later..',
                ];
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}