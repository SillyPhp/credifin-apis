<?php

namespace account\models\training_program;

use Yii;
use yii\base\Model;

class InviteCandidatesForm extends Model
{
    public $email;
    public $name;

    public function rules()
    {
        return [
            [['email'],'required'],
//            [['email'],'email'],
            [['name'],'string','max'=>30],
            [['email', 'name'],'trim'],
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
                array_push($all_mails, $mail);
            }
        }
        $mail = Yii::$app->mail;
        $mail->receivers = [];
        $mail->receivers = $all_mails;
        $mail->subject = 'Educational Institute has invited you to join on Empower Youth';
        $mail->template = 'invitation-email';
    }

}