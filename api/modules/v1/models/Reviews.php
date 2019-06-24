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

    public function rules()
    {

        return [
            [['org_enc_id','user_detail', 'current_employee', 'job_security', 'career_growth', 'company_culture', 'salary_benefits', 'work_satisfaction', 'work_life_balance', 'skill_development', 'location', 'department', 'designation', 'like', 'dislike', 'from'], 'required'],
        ];

    }

}