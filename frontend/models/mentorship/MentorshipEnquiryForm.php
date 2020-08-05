<?php

namespace frontend\models\mentorship;

use Yii;
use yii\base\Model;
use common\models\Utilities;
//use borales\extensions\phoneInput\PhoneInputValidator;
//use borales\extensions\phoneInput\PhoneInputBehavior;
//use borales\extensions\phoneInput\PhoneInput;

class MentorshipEnquiryForm extends Model
{
    public $full_name;
    public $email;
    public $phone;
    public $experience;
    public $teaching_field;
    public $_flag;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['full_name', 'email', 'phone', 'experience', 'teaching_field'], 'required'],
        ];
    }
}