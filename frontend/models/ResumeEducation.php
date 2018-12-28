<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\base\Model;

class ResumeEducation extends \yii\db\ActiveRecord
{
    public $education_type;
    public $marks;
    public $year;
    public $stream;
    public function rules()
    {
        return [
        [['education_type','marks','year','stream'],'required'],
            ['marks','integer'],
    ];
    }
    
    
    
}