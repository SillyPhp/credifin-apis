<?php

namespace frontend\models\questions;

use Yii;
use yii\base\Model;

class PostQuestion extends Model {

    public $question;
    public $topics;

    public function rules()
    {
        return [
            [['question','topics'],'required'],
            [['question','topics'], 'trim'],
            [['question'], 'string','length' => [6, 200]],
        ];
    }

    public function formName()
    {
        return '';
    }
}
