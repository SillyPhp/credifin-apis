<?php

namespace console\controllers;

use common\models\ApplicationTypes;
use common\models\EmailLogs;
use common\models\EmployerApplications;
use common\models\UserPreferences;
use common\models\Users;
use Yii;
use yii\console\Controller;
use yii\helpers\Url;
use common\models\Utilities;
use yii\helpers\ArrayHelper;
use yii\db\Query;

class DailyEmailsController extends Controller
{

    public function actionSendPreferredMail($limit = 10)
    {
        $data = (new Query())
            ->from(['a' => EmailLogs::tableName()])
            ->where(['a.email_type' => 2, 'is_sent' => 0])
            ->andWhere(['template'=>'applications-list']);
        foreach ($data->batch($limit) as $rows) {
            foreach ($rows as $r) {
                $mailData = "";
                $mailData = json_decode($r['data'], true);
                $mail = Yii::$app->mail;
                $mail->receivers = [];
                $mail->receivers[] = [
                    "name" => $mailData['user_detail']['name'],
                    "email" => $mailData['user_detail']['email'],
                ];
                $mail->subject = $r['subject'];
                $mail->data = $mailData;
                $mail->template = $r['template'];
                if ($mail->send()) {
                    $update = Yii::$app->db->createCommand()
                        ->update(EmailLogs::tableName(), ['is_sent' => 1, 'last_updated_on' => date('Y-m-d H:i:s')], ['email_log_enc_id' => $r['email_log_enc_id']])
                        ->execute();
                    if (!$update) {
                        return false;
                    }
                }
            }
        }
    }

    public function actionSetEmailLogs($type = "Jobs"){
        Yii::$app->preferredEmail->sendPreferredEmails($type);
    }

}