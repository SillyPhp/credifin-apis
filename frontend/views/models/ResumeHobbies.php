<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\base\Model;

class ResumeHobbies extends \yii\db\ActiveRecord
{
    public $interests_hobbies;
    
     public function rules()
    {
        return [
        [['interests_hobbies'],'required'],
    ];
    }
    
}
