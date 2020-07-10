<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\httpclient\Client;

class WhatsAppController extends Controller
{
   public function actionSendMessage()
   {
       $ch = curl_init("https://rest.messengerpeople.com/api/v11/chat");
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
           "id" => "+919592868808",
           "message" => "hello",
           "attachment" => "",
           "filename" => "",
           "conversation_status" => 0,
           "buttons" => "",
           "linkpreview" => 0,
           "push" => 1,
           "apikey" => "d04388772583586bdb14f4b048d52229_23136_4fe78c05427eed45983a05ebf"
       ]));
       curl_setopt($ch, CURLOPT_HTTPHEADER, [
           "Content-Type: application/json",
           "Content-Length: 205"
       ]);
       $response = curl_exec($ch);
       print_r($response);
       exit;
       curl_close($ch);
   }
}