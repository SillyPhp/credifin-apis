<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class SkillsAndLanguagesForm extends Model{
    
    public $keyskills;
    public $communication;
    public $additionalskills;
    public $languages;
    
public function rules(){
    return[
        [['keyskills','communication','additionalskills','languages'],'required'],
    ];    
   }
    public function attributeLabels(){
        return[
            'keyskills' => Yii::t('frontend','KeySkills'),
            'communication' => Yii::t('frontend','Communication'),
            'additionalskills' => Yii::t('frontend','AdditionalSkills'),
            'languages' => Yii::t('frontend','Languages'),
        ];
    }
}
