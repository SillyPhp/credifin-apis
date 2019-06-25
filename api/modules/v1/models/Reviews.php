<?php


namespace api\modules\v1\models;


use Yii;
use yii\base\Model;

class Reviews extends Model
{


    public $org_enc_id;
    public $user_detail;
    public $current_employee;
    public $job_security;
    public $career_growth;
    public $company_culture;
    public $salary_benefits;
    public $work_satisfaction;
    public $work_life_balance;
    public $skill_development;
    public $location;
    public $department;
    public $designation;
    public $like;
    public $dislike;
    public $from;
    public $to;
    public $reviewer_type;
    public $academics;
    public $faculty_teaching_quality;
    public $infrastructure;
    public $accomodation_food;
    public $placements_internships;
    public $social_life_extracurriculars;
    public $culture_diversity;
    public $student_engagement;
    public $school_infrastructure;
    public $faculty;
    public $accessibility_of_faculty;
    public $co_curricular_activities;
    public $leadership_development;
    public $sports;
    public $value_for_money;
    public $teaching_style;
    public $coverage_of_subject_matter;
    public $educational_stream;

//    public function rules()
//    {
//
//        return [
//            [['org_enc_id','user_detail', 'current_employee', 'job_security', 'career_growth', 'company_culture', 'salary_benefits', 'work_satisfaction', 'work_life_balance', 'skill_development', 'location', 'department', 'designation', 'like', 'dislike', 'from'], 'required'],
//            [['to'],'safe'],
////            [['org_enc_id','academics'],'required','on'=>'college']
//        ];
//
//    }

    public function rules(){

        return [
            [['org_enc_id','user_detail', 'current_employee', 'job_security', 'career_growth', 'company_culture', 'salary_benefits', 'work_satisfaction', 'work_life_balance', 'skill_development', 'location', 'department', 'designation', 'like', 'dislike', 'from'], 'required', 'on' => 'employee-review'],
            [['org_enc_id','user_detail', 'reviewer_type', 'job_security', 'career_growth', 'company_culture', 'salary_benefits', 'work_satisfaction', 'work_life_balance', 'skill_development', 'location', 'department', 'designation', 'like', 'dislike', 'from'], 'required', 'on' => 'unclaimed_employee_review'],
            [['org_enc_id','user_detail', 'reviewer_type', 'academics', 'faculty_teaching_quality', 'infrastructure', 'accomodation_food', 'placements_internships', 'social_life_extracurriculars', 'culture_diversity', 'location', 'educational_stream', 'like', 'dislike', 'from'], 'required','on'=>'college'],
            [['org_enc_id','user_detail', 'reviewer_type', 'student_engagement', 'school_infrastructure', 'faculty', 'accessibility_of_faculty', 'co_curricular_activities', 'leadership_development', 'sports', 'location', 'educational_stream', 'like', 'dislike', 'from'], 'required','on'=>'school'],
            [['org_enc_id','user_detail', 'reviewer_type', 'student_engagement', 'school_infrastructure', 'faculty', 'value_for_money', 'teaching_style', 'coverage_of_subject_matter', 'accessibility_of_faculty', 'location', 'educational_stream', 'like', 'dislike', 'from'], 'required','on'=>'edu_institute'],
            [['to'],'safe']
        ];
    }

}