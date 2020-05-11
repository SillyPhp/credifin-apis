<?php

namespace common\components\email_service;

use common\models\EmailLogs;
use common\models\Users;
use common\models\UserVerificationTokens;
use yii\base\Component;
use yii\base\InvalidParamException;
use common\models\Utilities;
use Yii;
use yii\helpers\Url;

class IndividualSignup extends Component{

    public function registrationEmail($id){
        $condition = ['created_by' => $id];

        $data = Users::find()
            ->select(['user_enc_id user_id', 'CONCAT(first_name," ", last_name) name', 'email'])
            ->where([
                'user_enc_id' => $id,
                'status' => 'Active',
                'is_email_verified' => 0,
                'is_deleted' => 0
            ])
            ->asArray()
            ->one();

        if(!$data){
            return false;
        }

        UserVerificationTokens::updateAll([
            'last_updated_on' => date('Y-m-d H:i:s'),
            'last_updated_by' => $id,
            'is_deleted' => 1,
        ], ['and',
            ['verification_type' => 2],
            ['status' => 'Pending'],
            ['is_deleted' => 0],
            $condition
        ]);

        $utilitesModel = new Utilities();
        $userVerificationTokensModel = new UserVerificationTokens();
        $utilitesModel->variables['string'] = time() . rand(100, 100000);
        $userVerificationTokensModel->token_enc_id = $utilitesModel->encrypt();
        $userVerificationTokensModel->token = Yii::$app->security->generateRandomString();
        $userVerificationTokensModel->verification_type = 2;
        $userVerificationTokensModel->created_on = $userVerificationTokensModel->last_updated_on = date('Y-m-d H:i:s');
        $userVerificationTokensModel->created_by = $userVerificationTokensModel->last_updated_by = $data['user_id'];

        if ($userVerificationTokensModel->validate() && $userVerificationTokensModel->save()) {
            $user['name'] = $data['name'];
            $user['link'] = Url::to('/verify/' . $userVerificationTokensModel->token,'https');

            Yii::$app->mailer->htmlLayout = 'layouts/email';

            $mail = Yii::$app->mailer->compose(
                ['html' => 'verification-email'], ['data' => $user]
            )
            ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
            ->setTo([$data['email'] => $data['name']])
            ->setSubject(Yii::t('app', 'Active your ' . Yii::$app->params->site_name . ' account'));

            if($mail->send()){
                $mail_logs = new EmailLogs();
                $utilitesModel = new Utilities();
                $utilitesModel->variables['string'] = time() . rand(100, 100000);
                $mail_logs->email_log_enc_id = $utilitesModel->encrypt();
                $mail_logs->email_type = 1;
                $mail_logs->user_enc_id = $data['user_id'];
                $mail_logs->receiver_name = $data['name'];
                $mail_logs->receiver_email = $data['email'];
                $mail_logs->receiver_phone = $data['phone'];
                $mail_logs->subject = 'Active your ' . Yii::$app->params->site_name . ' account';
                $mail_logs->template = 'verification-email';
                $mail_logs->is_sent = 1;
                $mail_logs->save();
                return true;
            }
            return false;
        }else{
            return false;
        }
    }

}