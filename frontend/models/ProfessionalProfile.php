<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\base\Model;

class ProfessionalProfile extends Model {

public $higher_q;
public $course;
public $specialization;
public $university;
public $passing_year;
public $current_designaton;
public $current_company;
public $annual_sal;
public $current_state;
public $current_city;
public $past_company;
public $past_desg;
public $past_sal;
public $skills;
public $cv;
public $about_yourself;


public function rules() {
        return [
        [['higher_q','course','specialization','university','passing_year','current_designaton','current_state','current_city','current_company','annual_sal','current_location','skills','about_yourself'],'required'],
        ['annual_sal', 'integer'],['about_yourself','string','min'=>'300'],
    ];
                
    }



    }








