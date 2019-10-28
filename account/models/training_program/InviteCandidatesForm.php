<?php

namespace account\models\training_program;

use Yii;
use yii\base\Model;

class InviteCandidatesForm extends Model
{
    public $email;
    public $name;
    public $phone;

    public function rules()
    {
        return [
            [['email'],'required'],
            [['name', 'phone'],'safe'],
            [['phone'],'string','max'=>15],
            [['name'],'string','max'=>30],
            [['email', 'name', 'phone'],'trim'],
        ];
    }

    public function formName(){
        return '';
    }

    public function send()
    {
        $all_mails = [];
        for($i=0;$i<count($this->email);$i++){
            $mail = [];
            if(!empty($this->email[$i])) {
                $mail['email'] = $this->email[$i];
                $mail['name'] = $this->name[$i];
                $mail['phone'] = $this->phone[$i];
                array_push($all_mails, $mail);
            }
        }
        $mail = Yii::$app->mailLogs;
//        $mail->receivers = [];
        $mail->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
        $mail->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $mail->email_type = 6;
        $mail->email_receivers = $all_mails;
        $mail->email_subject = 'Educational Institute has invited you to join on Empower Youth';
        $mail->email_template = 'invitation-email';
        $mail->data['ref'] = Yii::$app->referral->getReferralCode();
        if (!$mail->setEmailLog()) {
            return false;
        }
        return true;
    }

}