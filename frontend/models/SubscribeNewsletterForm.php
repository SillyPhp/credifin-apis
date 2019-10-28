<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

class SubscribeNewsletterForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;

    public function rules(){
        return[
            [['first_name','last_name','email' ], 'required'],
            [['first_name','last_name','email' ], 'trim'],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels(){
        return[
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
        ];
    }
}