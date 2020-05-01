<?php

namespace account\models\quiz;

use Yii;
use yii\base\Model;
use common\models\Utilities; 

class QuizModel extends Model
{
    public $formbuilderdata;
    public function rules()
    {
        return [
            [[''], 'required']
        ];
    }

    public function formName()
    {
        return '';
    }
}