<?php

namespace common\models\extended;

use common\models\FinancerLoanProductLoginFeeStructure;
use common\models\InstituteLeadsPayments;
use common\models\LoanPayments;
use common\models\LoanPaymentsDetails;
use common\models\Utilities;

use common\models\EducationLoanPayments;

class Payments
{
    public function createUrl($options)
    {
        $model = new EducationLoanPayments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->education_loan_payment_enc_id = $utilitiesModel->encrypt();
        $model->loan_app_enc_id = $options['loan_enc_id'];
        $model->payment_amount = $options['amount'];
        $model->payment_gst = $options['gst'];
        $model->payment_token = $options['token'];
        $model->payment_short_url = $options['surl'];
        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function createUrlLink($options)
    {
        $model = new LoanPayments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->loan_payments_enc_id = $utilitiesModel->encrypt();
        $model->loan_app_enc_id = $options['loan_app_id'];
        $model->payment_amount = $options['amount'];
        $model->payment_token = $options['token'];
        $model->payment_short_url = $options['surl'];
        $model->created_on = date('Y-m-d h:i:s');
        $model->close_by = date('Y-m-d h:i:s', $options['close_by']);
        $model->payment_link_type = $options['method'];
        if (!$model->save()) {
            return false;
        }
        $payment_details = self::createPaymentDetails($options['amount_enc_ids'], $model->loan_payments_enc_id, $options['user_id']);
        if (!$payment_details) {
            return false;
        }
        return true;
    }

    private function createPaymentDetails($amount, $loan_payment_id, $user_id)
    {
        foreach ($amount as $value) {
            $nodues = FinancerLoanProductLoginFeeStructure::findOne(['financer_loan_product_no_dues_enc_id' => $value]);
            if (!$nodues) {
                return false;
            }
            $pay_details = new LoanPaymentsDetails();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $pay_details->loan_payments_details_enc_id = $utilitiesModel->encrypt();
            $pay_details->loan_payments_enc_id = $loan_payment_id;
            $pay_details->loan_no_dues_enc_id = $value;
            $pay_details->no_dues_name = $nodues['name'];
            $pay_details->no_dues_amount = $nodues['amount'];
            $pay_details->created_by = $user_id;
            $pay_details->created_on = date('Y-m-d h:i:s');
            if (!$pay_details->save()) {
                return false;
            }
        }
        return true;
    }

    public function createUrlInstitute($options)
    {
        $model = new InstituteLeadsPayments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->payment_enc_id = $utilitiesModel->encrypt();
        $model->lead_enc_id = $options['loan_enc_id'];
        $model->payment_amount = $options['amount'];
        $model->payment_gst = $options['gst'];
        $model->payment_token = $options['token'];
        $model->payment_short_url = $options['surl'];
        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function createLink($api, $options)
    {
        $link = $api->paymentLink->create([
            'amount' => $options['total'],
            'currency' => 'INR',
            'accept_partial' => false,
            'description' => $options['description'],
            'customer' => [
                'name' => $options['name'],
                'contact' => $options['contact'],
            ],
            'notify' => [
                'sms' => true,
            ],
            'expire_by' => $options['close_by'],
            'reminder_enable' => true,
            'callback_url' => $options['call_back_url'],
            'callback_method' => 'get',
            'options' => [
                "checkout" => [
                    "name" => $options['brand']
                ]
            ]
        ]);
        if ($link->short_url) {
            $options['surl'] = $link->short_url;
            $options['token'] = $link->id;
            $options['close_by'] = $link->expire_by;
            $options['method'] = 0;
            if (self::createUrlLink($options)) {
                return [
                    'status' => 200,
                    'surl' => $link->short_url,
                    'amount' => $options['total'] / 100
                ];
            } else {
                return [
                    'status' => 400,
                    'message' => 'Unable to save information'
                ];
            }
        } else {
            return [
                'status' => 500,
                'message' => 'Unable to create'
            ];
        }
    }

    public function createQr($api, $options)
    {
        $link = $api->qrCode->create(["type" => "upi_qr",
            "name" => $options['name'],
            "usage" => "single_use",
            "fixed_amount" => 1,
            "payment_amount" => $options['total'],
            "description" => $options['description'],
            "close_by" => $options['close_by'],
            "notes" => array("purpose" => $options['purpose'])]);
        if ($link) {
            $options['token'] = $link->id;
            $options['created_on'] = $link->created_at;
            $options['surl'] = $link->image_url;
            $options['close_by'] = $link->close_by;
            $options['method'] = 1;
            if (self::createUrlLink($options)) {
                return [
                    'status' => 200,
                    'surl' => $link->image_url
                ];
            } else {
                return [
                    'status' => 400,
                    'message' => 'Unable to save information'
                ];
            }
        }
    }
}