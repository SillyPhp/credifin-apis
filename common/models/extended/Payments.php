<?php

namespace common\models\extended;

use common\models\InstituteLeadsPayments;
use common\models\LoanPayments;
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
        $model->loan_app_enc_id = $options['loan_app_enc_id'];
        $model->payment_amount = $options['amount'];
        $model->payment_token = $options['token'];
        $model->payment_short_url = $options['surl'];
        $model->created_on = date('Y-m-d h:i:s');
        $model->close_by = date('Y-m-d h:i:s', $options['close_by']);
//        date('Y-m-d h:i:s');
        $model->payment_link_type = $options['method'];
        if (!$model->save()) {
            return $model->getErrors();
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
            'description' => 'Testing out',
            'customer' => [
                'name' => $options['name'],
                'contact' => $options['contact'],
                'email' => 'cajgsvc@gmail.com'
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
            if (self::createUrlLink($options)) {
                return [
                    'surl' => $link->short_url,
                    'status' => 200
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
            "description" => "For Store 1",
            "close_by" => $options['close_by'],
            "notes" => array("purpose" => "Test UPI QR code notes")]);
        if ($link) {
            $options['token'] = $link->id;
            $options['created_on'] = $link->created_at;
            $options['surl'] = $link->image_url;
            $options['close_by'] = $link->close_by;
            if (self::createUrlLink($options)) {
                return [
                    'surl' => $link->image_url,
                    'status' => 200,
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