<?php

namespace frontend\models\leads;

use common\models\extended\PaymentsModule;
use common\models\InstituteLeadsPayments;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class InstituteLeads extends Model {
    public $organizationName;
    public $orgType;
    public $ownerShipType;
    public $loanAmount;
    public $annualTurnOver;
    public $email;
    public $contact;
    public $_flag;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['organizationName','orgType','ownerShipType','email','contact','loanAmount','annualTurnOver'],'required'],
            [['organizationName','email'],'trim'],
            [['organizationName'], 'string', 'max' => 200],
            [['email'], 'string', 'max' => 100],
            [['contact'], 'string', 'length' => [10, 10]],
            [['email'], 'email'],
        ];
    }

    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new \common\models\InstituteLeads();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->lead_enc_id = $utilitiesModel->encrypt();
            $model->organization_name = $this->organizationName;
            $model->org_type_name = $this->orgType;
            $model->ownership_type = $this->ownerShipType;
            $model->email = $this->email;
            $model->contact = $this->contact;
            $model->loan_amount = str_replace(',', '', $this->loanAmount);
            $model->annual_turnover = str_replace(',', '', $this->annualTurnOver);
            $model->created_on = date('Y-m-d H:i:s');
            $model->created_by = ((Yii::$app->user->identity->user_enc_id)?Yii::$app->user->identity->user_enc_id:null);
            if (!$model->save()) {
                $transaction->rollback();
                return false;
            } else {
                $this->_flag = true;
            }

            if ($this->_flag){
                $total_amount = 1000;
                $gst = 0;
                $amount = 1000;
                $args = [];
                $args['amount'] = $this->floatPaisa($total_amount);
                $args['currency'] = "INR";
                $args['accessKey'] = Yii::$app->params->EmpowerYouth->permissionKey;
                $response = PaymentsModule::_authPayToken($args);
                if (isset($response['status']) && $response['status'] == 'created') {
                    $token = $response['id'];
                    $loan_payment = new InstituteLeadsPayments();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $loan_payment->payment_enc_id = $utilitiesModel->encrypt();
                    $loan_payment->lead_enc_id = $model->lead_enc_id;
                    $loan_payment->payment_token = $token;
                    $loan_payment->payment_amount = $amount;
                    $loan_payment->payment_gst = $gst;
                    $loan_payment->created_on = date('Y-m-d H:i:s');
                    if (!$loan_payment->save()) {
                        $transaction->rollBack();
                        return false;
                    }else{
                        $transaction->commit();
                        $data = [];
                        $data['lead_enc_id'] = $model->lead_enc_id;
                        $data['payment_enc_id'] = $loan_payment->payment_enc_id;
                        $data['payment_id'] = $loan_payment->payment_token;
                        return [
                            'status'=>true,
                            'data'=>$data
                        ];
                    }
                }else{
                    $transaction->rollBack();
                    return false;
                }
            }
        }
        catch (\Exception $exception) {
            $transaction->rollBack();
            echo $exception;
        }
    }
    private function floatPaisa($amount)
    {
        $c = $amount * 100;
        return (int)$c;
    }

}