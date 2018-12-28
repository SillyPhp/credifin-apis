<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
//use common\models\Utilities;

class VideoRangeForm extends Model{
    
    public $range;
    
    public function rules(){
        return[
          [['range'], 'required'],  
        ];
    }
      public function attributeLabels() {
        return[
            'range' => Yii::t('frontend', 'range'),
        ];
    }
}
