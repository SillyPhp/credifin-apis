<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class PortfolioForm extends Model{
    
    public $webdesign;
    public $photography;
    public $mobileapp;
    public $branding;
    
public function rules(){
    return[
        [['webdesign','photography','mobileapp','branding'],'required'],
    ];    
   }
    public function attributeLabels(){
        return[
            'webdesign' => Yii::t('frontend','WebDesign'),
            'photography' => Yii::t('frontend','Photography'),
            'mobileapp' => Yii::t('frontend','MobileApp'),
            'branding' => Yii::t('frontend','Branding'),
        ];
    }
}
