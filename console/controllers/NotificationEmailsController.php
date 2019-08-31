<?php

namespace console\controllers;

use common\models\EmailLogs;
use common\models\Users;
use common\models\Utilities;
use Yii;
use yii\console\Controller;

class NotificationEmailsController extends Controller
{
    public function actionIndex() {
        echo "cron service";
    }

    public function actionMail($to) {
    echo "Sending mail to " . $to;
    }

    public function actionUpdateUserProfile()
    {
     $user_email = Users::find()
            ->select(['user_enc_id','email'])
            ->where(['not',['user_of'=>'MIS']])
            ->andWhere([
                'or',
                ['gender'=>null],
                ['description'=>null],
                ['image'=>null],
                ['city_enc_id'=>null],
                ['dob'=>null],
                ['experience'=>null],
            ])
            ->asArray()
            ->all();
     foreach ($user_email as $email)
     {
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
         if (!$email_logs->save())
         {
             echo 'failed';
         }
     }
    }
}


