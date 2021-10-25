<?php

namespace common\models\extended;

use common\models\Users;
use common\models\Utilities;
use common\models\Webinar;
use common\models\WebinarRegistrations;
use Yii;

class WebinarPayments extends \common\models\WebinarPayments
{
    public $_flag;
    public $payment_id; //payment success id
    public $payment_status;
    public $payment_token;
    public $payment_gst;
    public $payment_amount;
    public $payment_enc_id;
    public $registration_enc_id;
    public $payment_signature;

    public function checkout()
    {
        $webinar_amount = Webinar::find()
            ->where(['webinar_enc_id' => $this->webinar_enc_id])
            ->asArray()
            ->one();

        if (!empty($webinar_amount)) {
            $total_amount = $webinar_amount['price'];
            $gst = $webinar_amount['gst'];
            $percentage = ($total_amount * $gst) / 100;
            $total_amount = $total_amount + $percentage;
            $args = [];
            $args['amount'] = $this->floatPaisa($total_amount); //for inr float to paisa format for razor pay payments
            $args['currency'] = "INR";
            $args['accessKey'] = Yii::$app->params->EmpowerYouth->permissionKey;
            $response = PaymentsModule::_authPayToken($args);

            $this->payment_amount = $webinar_amount['price'];
            $this->payment_gst = $webinar_amount['gst'];
        } else {
            return false;
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $Registration = new WebinarRegistrations();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $Registration->register_enc_id = $utilitiesModel->encrypt();
            $Registration->webinar_enc_id = $this->webinar_enc_id;
            $Registration->created_by = $this->created_by;
            $Registration->created_on = date('Y-m-d H:i:s');
            if (!$Registration->save()) {
                $transaction->rollBack();
                $this->_flag = false;
                return false;
            } else {
                $this->_flag = true;
            }

            if (isset($response['status']) && $response['status'] == 'created') {
                $token = $response['id'];
                $payment = new \common\models\WebinarPayments();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $payment->payment_enc_id = $utilitiesModel->encrypt();
                $payment->webinar_enc_id = $this->webinar_enc_id;
                $payment->registration_enc_id = $Registration->register_enc_id;
                $payment->created_by = $this->created_by;
                $payment->payment_token = $token;
                $payment->payment_amount = $this->payment_amount;
                $payment->payment_gst = $this->payment_gst;
                $payment->created_on = date('Y-m-d H:i:s');
                if (!$payment->save()) {
                    $transaction->rollBack();
                    $this->_flag = false;
                    return false;
                } else {
                    $this->_flag = true;
                }
            } else {
                $this->_flag = false;
                return false;
            }

            if ($this->_flag) {
                $transaction->commit();
                $data = [];
                $data['webinar_enc_id'] = $this->webinar_enc_id;
                $data['payment_enc_id'] = $payment->payment_enc_id;
                $data['payment_token'] = $payment->payment_token;
                $data['registration_enc_id'] = $Registration->register_enc_id;
                return $data;
            }
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return false;
        }
    }

    public function updateStatus($args)
    {
        $payment_model = \common\models\WebinarPayments::findOne(['payment_enc_id' => $args['payment_enc_id']]);
        $payment_model->payment_status = $args['status'];
        $payment_model->payment_id = $args['payment_id'];
        $payment_model->payment_signature = $args['signature'];
        if (!$payment_model->save()) {
            return false;
        } else {
            if ($payment_model->payment_status == 'captured' || $payment_model->payment_status == 'created') {
                $registration = WebinarRegistrations::findOne(['register_enc_id' => $payment_model->registration_enc_id]);
                $registration->status = 1;
                $registration->last_updated_on = date('Y-m-d H:i:s');
                if (!$registration->update()) {
                    return false;
                } else {
                    $user = Users::findOne(['user_enc_id' => $registration->created_by]);
                    $params = [];
                    $params['webinar_id'] = $registration->webinar_enc_id;
                    $params['email'] = $user->email;
                    $params['name'] = $user->first_name . ' ' . $user->last_name;
                    if (isset($args['is_campus']) && $args['is_campus']) {
                        $params['from'] = 'no-reply@myecampus.in';
                        $params['site_name'] = 'My E-Campus';
                        $params['is_my_campus'] = 1;
                    } else {
                        $params['from'] = Yii::$app->params->from_email;
                        $params['site_name'] = Yii::$app->params->site_name;
                    }
                    Yii::$app->notificationEmails->webinarRegistrationEmail($params);

                    $webinar = Webinar::findOne(['webinar_enc_id' => $registration->webinar_enc_id]);
                    if ($webinar->webinar_conduct_on == 1) {
                        $params['first_name'] = $user->first_name;
                        $params['last_name'] = $user->last_name;
                        $params["webinar_zoom_id"] = $webinar->platform_webinar_id;
                        $params["user_id"] = $user->user_enc_id;
                        Yii::$app->notificationEmails->zoomRegisterAccess($params);
                    }
                    return true;
                }
            }
            return true;
        }
    }

    private function floatPaisa($amount)
    {
        $c = $amount * 100;
        return (int)$c;
    }
}