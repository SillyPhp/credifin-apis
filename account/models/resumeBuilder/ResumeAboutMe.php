<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


namespace account\models\resumeBuilder;

use yii\base\Model;

class ResumeAboutMe extends Model
{
    public $about_me;
    
     public function rules()
    {
        return [
        [['about_me'],'required'],
    ];
    }
    
}