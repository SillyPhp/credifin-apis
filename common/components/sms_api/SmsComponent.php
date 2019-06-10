<?php

namespace common\components\sms_api;

use yii\base\InvalidParamException;
use Yii;
use yii\base\Component;
use yii\httpclient\Client;
class SmsComponent  extends Component
{
    public function send($mobile,$senderId,$msg)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('https://api.msg91.com/api/sendhttp.php')
            ->setData(['mobiles' => $mobile,
                'authkey' => '270651Ai9cdZkkd6m5cfdf340',
                'route'=>4,
                'sender'=>$senderId,
                'message'=>$msg,
                'country'=>91
                ])
            ->send();
        if ($response->isOk) {
            return true;
        }
        else
        {
            return false;
        }
    }
}