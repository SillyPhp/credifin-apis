<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace account\models\resumeBuilder;

use yii\base\Model;

class ResumeSkills extends Model

{
    public $skills;
    
     public function rules()
    {
        return [
        [['skills'],'required'],
    ];
    }
}