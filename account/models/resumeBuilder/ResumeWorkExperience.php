<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace account\models\resumeBuilder;

use yii\base\Model;

class ResumeWorkExperience extends Model
{
    public $organisation;
    public $designation;
    public $desc;
    public $experience;
    
     public function rules()
    {
        return [
        [['organisation','designation','desc','experience'],'required'],
    ];
    }
}