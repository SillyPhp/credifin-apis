<?php
namespace frontend\models\reviews;

use Yii;
use yii\base\Model;

class RegistrationForm extends Model {

    public $name;
    public $email;
    public $website;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['name','email'],'required'],
            ['email','email'],
        ];
    }

    public function saveVal()
    {

    }
}