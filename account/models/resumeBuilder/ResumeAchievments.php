<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace account\models\resumeBuilder;

use yii\base\Model;

class ResumeAchievments extends \yii\db\ActiveRecord
{
   public $achievments;
    
     public function rules()
    {
        return [
        [['achievments'],'required'],
    ];
    }
    
}