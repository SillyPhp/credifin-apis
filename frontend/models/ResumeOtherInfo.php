<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\base\Model;

class ResumeOtherInfo extends \yii\db\ActiveRecord
{
    public $dob;
    public $preference;
    public $gender;
    
     public function rules()
    {
        return [
        [['dob','preference','gender'],'required'],
    ];
    }
    
}
