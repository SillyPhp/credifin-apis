<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace frontend\models;

use yii\base\Model;


class Resume extends Model
{
    public $profile_pic;
    public $about_me;
    public $contact_mobile;
    public $contact_email;
    public $contact_address;
    public $dob;
    public $preference;
    public $gender;
    public $school_class;
    public $school_marks;
    public $school_board;
    public $school_year;
    public $degree_name;
    public $degree_college;
    public $degree_marks;
    public $degree_start_year;
    public $degree_end_year;
    public $work_org;
    public $work_designation;
    public $work_desc;
    public $work_experience;
    public $cerificates;
    public $skills;
    public $project_name;
    public $project_start_date;
    public $project_end_date;
    public $project_associate;
    public $project_url;
    public $project_desc;
    public $achievments;
    public $interests_hobies;
 
    public function rules()
    {
        
        return [
          [['about_me','contact_mobile','contact_email','contact_address','dob','preference'],'required'],
           ['contact_email','email'],['contact_mobile','integer'],
        ];
    }
}