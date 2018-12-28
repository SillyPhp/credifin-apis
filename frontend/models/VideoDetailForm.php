<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
//use common\models\Utilities;

class VideoDetailForm extends Model{
    
    public $question;
    
    public function rules(){
        return[
          [['question']],  
        ];
    }
      public function attributeLabels() {
        return[
            'question' => Yii::t('frontend', 'question'),
        ];
    }
}
