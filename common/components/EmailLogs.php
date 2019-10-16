<?php


namespace common\components;


class EmailLogs extends Component
{

    public $user_enc_id = '';
    public $organization_enc_id = '';
    public $subject = '';
    public $email_type = '';
    public $template = '';

    public function setEmailLog(){
        $mail_log = new \common\models\EmailLogs();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $mail_log->email_log_enc_id = $utilitiesModel->encrypt();
        $mail_log->email_type = 5;
        $mail_log->user_enc_id = $usersModel->user_enc_id;
        $mail_log->organization_enc_id = $organizationsModel->organization_enc_id;
        $mail_log->subject = 'Create Jobs and Internships on Empower Youth';
        $mail_log->template = 'org-signup-mail';
        $mail_log->is_sent = 0;
        $mail_log->created_on = date('Y-m-d H:i:s');
        $mail_log->save();
    }
}