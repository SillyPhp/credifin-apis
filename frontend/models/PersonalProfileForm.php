<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class PersonalProfileForm extends Model{
    
    public $name;
    public $nationality;
    public $marital;
    public $dob;
    public $phone;
    public $email;
    public $aboutme;
    public $facebook;
    public $twitter;
    public $youtube;
    public $linkedin;
    public $skype;
    
public function rules(){
    return[
        [['name','nationality','marital','dob','phone','email','aboutme','facebook','twitter','youtube','linkedin','skype'],'required'],
    ];    
   }
    public function attributeLabels(){
        return[
            'name' => Yii::t('frontend','Name'),
            'nationality' => Yii::t('frontend','Nationality'),
            'marital' => Yii::t('frontend','Marital'),
            'dob' => Yii::t('frontend','DOB'),
            'phone' => Yii::t('frontend','Phone'),
            'email' => Yii::t('frontend','Email'),
            'aboutme' => Yii::t('frontend','AboutMe'),
            'facebook' => Yii::t('frontend','Facebook'),
            'twitter' => Yii::t('frontend','Twitter'),
            'youtube' => Yii::t('frontend','Youtube'),
            'linkedin' => Yii::t('frontend','LinkedIn'),
            'skype' => Yii::t('frontend','Skype'),
        ];
    }
}
