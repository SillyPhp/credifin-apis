<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\base\Model;

class PersonalProfile extends Model {

    public $firstname;
    public $lastname;
    public $user_email;
    public $mobileNo;
    public $state;
    public $city;
    public $jobskills;
    public $image_file;

    public function rules() {
        return [
        [['firstname','lastname','user_email','mobileNo','state','city','jobskills'],'required'],
            ['user_email','email'],['mobileNo', 'integer', 'max' => 10],
            ];
                
    }

}





