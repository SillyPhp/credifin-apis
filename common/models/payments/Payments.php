<?php

namespace common\models\payments;
class Payments
{
    public static function createQr($api, $options)
    {
        $qr = $api->qrCode->create(["type" => "upi_qr",
            "name" => $options['name'],
            "usage" => "single_use",
            "fixed_amount" => 1,
            "payment_amount" => (int)($options['amount'] * 100),
            "description" => $options['description'],
            "close_by" => $options['close_by'],
            "notes" => array("purpose" => $options['purpose'])]);
        if ($qr->image_url) {
            $options['surl'] = $qr->image_url;
            $options['token'] = $qr->id;
            $options['close_by'] = $qr->close_by;
            $options['method'] = 1;
            $save = \common\models\extended\Payments::saveLoanPayment($options);
            if (!$save) {
                return false;
            }
            return $qr->image_url;
        }
        return false;

    }

    public static function createLink($api, $options)
    {
        $link = $api->paymentLink->create([
            'amount' => (int)($options['amount'] * 100),
            'currency' => 'INR',
            'reference_id' => $options['ref_id'],
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
            $save = \common\models\extended\Payments::saveLoanPayment($options);
            if (!$save) {
                return false;
            }
            return $link->short_url;
        }

        return false;
    }
}