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
//        $mail = Yii::$app->mail;
//        $mail->
    }

}