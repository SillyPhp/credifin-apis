<?php

namespace common\models\credentials;

use Yii;

class Payments
{
    public static function createQr($api, $options)
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
            return [
                'status' => 200,
                'data' => $link
            ];
        } else {
            return [
                'status' => 500,
                'message' => 'Unable to create qr'
            ];
        }
    }

    public static function createLink($api, $options)
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
            return [
                'status' => 200,
                'data' => $link
            ];
        } else {
            return [
                'status' => 500,
                'message' => 'Unable to create link'
            ];
        }
    }
}