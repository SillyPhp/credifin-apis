<?php

namespace frontend\controllers;
use common\models\EmailLogs;
use common\models\Users;
use common\models\Utilities;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class EmailTestController extends Controller
{
    public function actionIndex()
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
                print_r($email_logs->getErrors());
            }
        }
    }

}