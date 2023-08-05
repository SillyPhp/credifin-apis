<?php

namespace common\models\extended;

use common\models\AssignedLoanPayments;
use common\models\EducationLoanPayments;
use common\models\InstituteLeadsPayments;
use common\models\LoanPayments;
use common\models\Utilities;

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

    public static function saveLoanPayment($options)
    {
        $model = new LoanPayments();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->loan_payments_enc_id = $utilitiesModel->encrypt();
        $model->payment_amount = $options['amount'];
        $model->payment_token = $options['token'];
        $model->payment_short_url = $options['surl'];
        $model->payment_status = 'pending';
        $model->created_on = date('Y-m-d h:i:s');
        $model->close_by = date('Y-m-d h:i:s', $options['close_by']);
        $model->payment_link_type = $options['method'];
        if (!$model->save()) {
            return false;
        }

        $assign = new AssignedLoanPayments();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $assign->assigned_loan_payments_enc_id = $utilitiesModel->encrypt();
        $assign->loan_payments_enc_id = $model->loan_payments_enc_id;
        if (!empty($options['emi_collection_enc_id'])) {
            $assign->emi_collection_enc_id = $options['emi_collection_enc_id'];
        }
        if (!empty($options['loan_app_enc_id'])) {
            $assign->loan_app_enc_id = $options['loan_app_enc_id'];
        }
        $assign->created_by = $assign->updated_by = $options['user_id'];
        $assign->created_on = $assign->updated_on = date('Y-m-d h:i:s');
        if (!$assign->save()) {
            return false;
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
                    'status' => true
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
            "notes" => array("purpose" => $options['purpose'])]);
        if ($link) {
            $options['token'] = $link->id;
            $options['created_on'] = $link->created_at;
            $options['surl'] = $link->image_url;
            $options['close_by'] = $link->close_by;
            if (self::createUrlLink($options)) {
                return [
                    'surl' => $link->image_url,
                    'status' => true,
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