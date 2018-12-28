<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\base\Model;

class ResumeContactInfo extends Model
{
    public $contact_mobile;
    public $contact_email;
    public $contact_address;
    public $postel_code;
    public $city;
    public $city_id;
    
     public function rules()
    {
        return [
        [['contact_mobile','contact_email','contact_address', 'postel_code', 'city_id'],'required'],
        ['contact_mobile','integer','max'=>10],   
         ['contact_email','email'],   
    ];
    }
    
    
}
