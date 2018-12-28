<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\base\Model;

class ResumeProfilePic extends Model
{
    public $profile_pic;
    
    public function rules()
    {
        return [
        [['profile_pic'],'required'],
    ];
    }
    
    
}