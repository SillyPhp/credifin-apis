<?php

namespace account\models\training_program;

use common\models\ApplicationOption;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

class TrainingProgram extends Model
{
    public $title;
    public $fees;
    public $city;
    public $profile;
    public $skills;
    public $job_type;
    public $type;
    public $url;
    public $description;
    public $company_name;
    public $email;
    public $fees_type;
    public $fixed_wage;
    public $min_salary;
    public $max_salary;

    public function rules()
    {
        return [
            [['title','skills','fees','city','type','profile','fees_type','job_type','url','description','company_name'],'required'],
            [['email','fixed_wage','min_salary','max_salary'],'safe'],
            [['url'], 'url', 'defaultScheme' => 'http'],
            [['title','company_name'],'string','max'=>50],
            [['fees'],'integer','max'=>10],
            [['title','fees','company_name'],'trim'],
            ['email','email'],
        ];
    }

    public function formName()
    {
        return '';
    }
}