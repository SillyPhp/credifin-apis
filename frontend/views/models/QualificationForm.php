<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class QualificationForm extends Model{
    
    public $degreename;
    public $universityname;
    public $year;
    
public function rules(){
    return[
        [['degreename','universityname','year'],'required'],
    ];    
   }
    public function attributeLabels(){
        return[
            'degreename' => Yii::t('frontend','DegreeName'),
            'universityname' => Yii::t('frontend','UniversityName'),
            'year' => Yii::t('frontend','Year'),
        ];
    }
}
