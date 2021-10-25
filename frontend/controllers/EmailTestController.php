<?php

namespace frontend\controllers;

use common\models\EmailLogs;
use common\models\Users;
use common\models\Utilities;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use SendGrid\Mail\Mail;

class EmailTestController extends Controller
{
    public function actionIndex()
    {
        $user_email = Users::find()
            ->select(['user_enc_id', 'email'])
            ->where(['not', ['user_of' => 'MIS']])
            ->andWhere([
                'or',
                ['gender' => null],
                ['description' => null],
                ['image' => null],
                ['city_enc_id' => null],
                ['dob' => null],
                ['experience' => null],
            ])
            ->asArray()
            ->all();
        foreach ($user_email as $email) {
            $email_logs = new EmailLogs();
            $utilitesModel = new Utilities();
            $utilitesModel->variables['string'] = time() . rand(100, 100000);
            $email_logs->email_log_enc_id = $utilitesModel->encrypt();
            $email_logs->email_type = 4;
            $email_logs->user_enc_id = $email['user_enc_id'];
            $email_logs->subject = 'Empower Youth Updates User Profile';
            $email_logs->template = 'applications-list';
            $email_logs->is_sent = 0;
            $email_logs->created_on = date('Y-m-d H:i:s');
            if (!$email_logs->save()) {
                print_r($email_logs->getErrors());
            }
        }
    }

    public function actionSendGrid()
    {
        $email = new Mail();
        $email->setFrom("tarandeep@empoweryouth.com", "Tarandeep Singh");
        $email->setSubject("Sending with Twilio SendGrid for testing");
        $emails = [
            "ravindersani15697@gmail.com" => "Ravinder singh",
            "ravindersinghsaini48@gmail.com" => "Tony",
            "ajayjuneja52@gmail.coim" => "Ajay Juneja",
        ];
        $email->addTos($emails);
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );

        $sendgrid = new \SendGrid(getenv('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'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }

}