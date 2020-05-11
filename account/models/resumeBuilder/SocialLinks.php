<?php

namespace account\models\resumeBuilder;

use Yii;
use yii\base\Model;
use common\models\Utilities;

class SocialLinks extends Model{

    public $facebook;
    public $instagram;
    public $linkedin;
    public $google;
    public $twitter;
    public $youtube;
    public $skype;


    public function rules()
    {
        return [

            [['facebook','instagram','linkedin','google','twitter','youtube','skype'],'required'],
        ];
    }
}


?>