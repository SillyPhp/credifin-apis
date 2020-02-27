<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\EmailLogs;
use common\models\Users;
use common\models\Utilities;
use yii\db\Query;

class NotificationEmailsController extends Controller
{

    public function actionUpdateUserProfile()
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
                echo 'failed';
            }
        }
    }

    public function actionSendMail()
    {
        $emailLogs = EmailLogs::find()
            ->where([
                'type' => 4,
                'template' => 1,
                'is_send' => 0,
                'is_deleted' => 0,
            ])
            ->asArray()
            ->all();

        if (count($emailLogs) > 0) {

        }
    }

    public function actionGetOrganizationProfile()
    {
        return Yii::$app->notification->orgProfileMail();
    }

    public function actionGetUserProfile()
    {
        return Yii::$app->notification->getData();
    }

    public function actionSendUserProfileMail($limit = 10)
    {
        $data = (new Query())
            ->from(['a' => EmailLogs::tableName()])
            ->where(['a.email_type' => 4, 'a.organization_enc_id' => null, 'is_sent' => 0]);
        foreach ($data->batch($limit) as $rows) {
            foreach ($rows as $r) {
                $mailData = "";
                $mailData = json_decode($r['data'], true);
                $mail = Yii::$app->mail;
                $mail->receivers = [];
                $mail->receivers[] = [
                    "name" => $mailData['user']['name'],
                    "email" => $mailData['user']['email'],
                ];
                $mail->subject = 'Empower Youth Updates User Profile';
                $mail->data = ['name' => $mailData['user']['name'], 'username' => $mailData['user']['username']];
                $mail->template = 'complete-profile';
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

    public function actionSendProfileMail($limit = 10)
    {
        $data = (new Query())
            ->from(['a' => EmailLogs::tableName()])
            ->where(['a.email_type' => 4, 'is_sent' => 0])
            ->andWhere(['not', ['a.organization_enc_id' => null]]);
        foreach ($data->batch($limit) as $rows) {
            foreach ($rows as $r) {
                $mailData = "";
                $mailData = json_decode($r['data'], true);
                $mail = Yii::$app->mail;
                $mail->receivers = [];
                $mail->receivers[] = [
                    "name" => $mailData['organization']['name'],
                    "email" => $mailData['organization']['email'],
                ];
                $mail->subject = 'Empower Youth Updates User Profile';
                $mail->data = ['name' => $mailData['organization']['name'], 'username' => $mailData['organization']['username']];
                $mail->template = 'complete-profile';
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
}