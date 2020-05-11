<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace account\models\resumeBuilder;

use yii\base\Model;

class ResumeProject extends Model
{
    public $project_name;
    public $project_start_date;
    public $project_end_date;
    public $project_associate;
    public $project_url;
    public $project_desc;
    
     public function rules()
    {
        return [
        [['project_name','project_start_date','project_end_date','project_associate','project_url','project_desc'],'required'],
    ];
    }
    
}