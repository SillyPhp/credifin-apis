<?php


namespace api\modules\v1\models;


use common\models\Categories;
use common\models\Designations;
use common\models\NewOrganizationReviews;
use common\models\Qualifications;
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


    public function rules()
    {

        return [
            [['org_enc_id', 'user_detail', 'current_employee', 'job_security', 'career_growth', 'company_culture', 'salary_benefits', 'work_satisfaction', 'work_life_balance', 'skill_development', 'location', 'department', 'designation', 'like', 'dislike', 'from'], 'required', 'on' => 'employee-review'],
            [['org_enc_id', 'user_detail', 'job_security', 'career_growth', 'company_culture', 'salary_benefits', 'work_satisfaction', 'work_life_balance', 'skill_development', 'like', 'dislike'], 'required', 'on' => 'edit-employee-review'],
            [['org_enc_id', 'user_detail', 'reviewer_type', 'job_security', 'career_growth', 'company_culture', 'salary_benefits', 'work_satisfaction', 'work_life_balance', 'skill_development', 'location', 'department', 'designation', 'like', 'dislike', 'from'], 'required', 'on' => 'unclaimed_employee_review'],
            [['org_enc_id', 'user_detail', 'reviewer_type', 'job_security', 'career_growth', 'company_culture', 'salary_benefits', 'work_satisfaction', 'work_life_balance', 'skill_development', 'like', 'dislike'], 'required', 'on' => 'edit_unclaimed_employee_review'],
            [['org_enc_id', 'user_detail', 'reviewer_type', 'academics', 'faculty_teaching_quality', 'infrastructure', 'accomodation_food', 'placements_internships', 'social_life_extracurriculars', 'culture_diversity', 'location', 'educational_stream', 'like', 'dislike', 'from'], 'required', 'on' => 'college'],
            [['org_enc_id', 'user_detail', 'reviewer_type', 'academics', 'faculty_teaching_quality', 'infrastructure', 'accomodation_food', 'placements_internships', 'social_life_extracurriculars', 'culture_diversity', 'like', 'dislike'], 'required', 'on' => 'edit_college'],
            [['org_enc_id', 'user_detail', 'reviewer_type', 'student_engagement', 'school_infrastructure', 'faculty', 'accessibility_of_faculty', 'co_curricular_activities', 'leadership_development', 'sports', 'location', 'educational_stream', 'like', 'dislike', 'from'], 'required', 'on' => 'school'],
            [['org_enc_id', 'user_detail', 'reviewer_type', 'student_engagement', 'school_infrastructure', 'faculty', 'accessibility_of_faculty', 'co_curricular_activities', 'leadership_development', 'sports', 'like', 'dislike'], 'required', 'on' => 'edit_school'],
            [['org_enc_id', 'user_detail', 'reviewer_type', 'student_engagement', 'school_infrastructure', 'faculty', 'value_for_money', 'teaching_style', 'coverage_of_subject_matter', 'accessibility_of_faculty', 'location', 'educational_stream', 'like', 'dislike', 'from'], 'required', 'on' => 'edu_institute'],
            [['org_enc_id', 'user_detail', 'reviewer_type', 'student_engagement', 'school_infrastructure', 'faculty', 'value_for_money', 'teaching_style', 'coverage_of_subject_matter', 'accessibility_of_faculty', 'like', 'dislike'], 'required', 'on' => 'edit_edu_institute'],
            [['job_security', 'career_growth', 'company_culture', 'salary_benefits', 'work_satisfaction', 'work_life_balance', 'skill_development', 'academics', 'faculty_teaching_quality', 'infrastructure', 'accomodation_food', 'placements_internships', 'social_life_extracurriculars', 'culture_diversity', 'student_engagement', 'school_infrastructure', 'faculty', 'accessibility_of_faculty', 'co_curricular_activities', 'leadership_development', 'sports', 'value_for_money', 'teaching_style', 'coverage_of_subject_matter'], 'string', 'min' => 1, 'max' => 5],
            [['reviewer_type'], 'string', 'min' => 0, 'max' => 7],
            [['user_detail'], 'string', 'min' => 0, 'max' => 1],
            [['current_employee'], 'string', 'min' => 0, 'max' => 1],
            [['to'], 'safe']
        ];
    }

    public function __saveData($options)
    {

        $data = new NewOrganizationReviews();

        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $data->review_enc_id = $utilitiesModel->encrypt();
        $data->organization_enc_id = $this->org_enc_id;
        $data->reviewer_type = $this->reviewer_type;
        $data->city_enc_id = $this->location;
        $data->likes = $this->like;
        $data->dislikes = $this->dislike;
        $data->from_date = $this->from;
        if ($this->reviewer_type == 0 || $this->reviewer_type == 2 || $this->reviewer_type == 4 || $this->reviewer_type == 6) {
            $data->to_date = $this->to;
        }
        $data->show_user_details = $this->user_detail;
        $data->created_by = $options['user_enc_id'];
        $data->created_on = date('Y-m-d H:i:s');
        $data->status = 1;
        if ($this->reviewer_type == 0 || $this->reviewer_type == 1) {
            $rating = [$this->skill_development, $this->work_life_balance, $this->salary_benefits, $this->company_culture, $this->job_security, $this->career_growth, $this->work_satisfaction];
            $data->average_rating = $this->findAvg($rating);
            $data->category_enc_id = $this->__addCategory($this->department, $options['user_enc_id']);
            $data->designation_enc_id = $this->__addDesignation($this->designation, $options['user_enc_id']);
            $data->job_security = $this->job_security;
            $data->growth = $this->career_growth;
            $data->organization_culture = $this->company_culture;
            $data->compensation = $this->salary_benefits;
            $data->work = $this->work_satisfaction;
            $data->work_life = $this->work_life_balance;
            $data->skill_development = $this->skill_development;
        } elseif ($this->reviewer_type == 2 || $this->reviewer_type == 3) {
            $rating = [$this->academics, $this->faculty_teaching_quality, $this->infrastructure, $this->accomodation_food, $this->placements_internships, $this->social_life_extracurriculars, $this->culture_diversity];
            $data->average_rating = $this->findAvg($rating);
            $data->educational_stream_enc_id = $this->__eduStream($this->educational_stream);
            $data->academics = $this->academics;
            $data->faculty_teaching_quality = $this->faculty_teaching_quality;
            $data->infrastructure = $this->infrastructure;
            $data->accomodation_food = $this->accomodation_food;
            $data->placements_internships = $this->placements_internships;
            $data->social_life_extracurriculars = $this->social_life_extracurriculars;
            $data->culture_diversity = $this->culture_diversity;
        } elseif ($this->reviewer_type == 4 || $this->reviewer_type == 5) {
            $rating = [$this->student_engagement, $this->school_infrastructure, $this->faculty, $this->accessibility_of_faculty, $this->co_curricular_activities, $this->leadership_development, $this->sports];
            $data->average_rating = $this->findAvg($rating);
            $data->educational_stream_enc_id = $this->__eduStream($this->educational_stream);
            $data->student_engagement = $this->student_engagement;
            $data->school_infrastructure = $this->school_infrastructure;
            $data->faculty = $this->faculty;
            $data->accessibility_of_faculty = $this->accessibility_of_faculty;
            $data->co_curricular_activities = $this->co_curricular_activities;
            $data->leadership_development = $this->leadership_development;
            $data->sports = $this->sports;
        } elseif ($this->reviewer_type == 6 || $this->reviewer_type == 7) {
            $rating = [$this->student_engagement, $this->school_infrastructure, $this->faculty, $this->value_for_money, $this->teaching_style, $this->coverage_of_subject_matter, $this->accessibility_of_faculty];
            $data->average_rating = $this->findAvg($rating);
            $data->educational_stream_enc_id = $this->__eduStream($this->educational_stream);
            $data->student_engagement = $this->student_engagement;
            $data->school_infrastructure = $this->school_infrastructure;
            $data->faculty = $this->faculty;
            $data->value_for_money = $this->value_for_money;
            $data->teaching_style = $this->teaching_style;
            $data->coverage_of_subject_matter = $this->coverage_of_subject_matter;
            $data->accessibility_of_faculty = $this->accessibility_of_faculty;
        }
        if ($data->save()) {
            return true;
        } else {
            return false;
        }

    }

    public function __updateData($options)
    {

        $data = NewOrganizationReviews::find()
            ->select(['*'])
            ->where(['created_by' => $options['user_enc_id'], 'organization_enc_id' => $options['org_enc_id']])
            ->one();


        $data->likes = $this->like;
        $data->dislikes = $this->dislike;

        $data->show_user_details = $this->user_detail;
        $data->last_updated_by = $options['user_enc_id'];
        $data->last_updated_on = date('Y-m-d H:i:s');
        if ($this->reviewer_type == 0 || $this->reviewer_type == 1) {
            $rating = [$this->skill_development, $this->work_life_balance, $this->salary_benefits, $this->company_culture, $this->job_security, $this->career_growth, $this->work_satisfaction];
            $data->average_rating = $this->findAvg($rating);
            $data->job_security = $this->job_security;
            $data->growth = $this->career_growth;
            $data->organization_culture = $this->company_culture;
            $data->compensation = $this->salary_benefits;
            $data->work = $this->work_satisfaction;
            $data->work_life = $this->work_life_balance;
            $data->skill_development = $this->skill_development;
        } elseif ($this->reviewer_type == 2 || $this->reviewer_type == 3) {
            $rating = [$this->academics, $this->faculty_teaching_quality, $this->infrastructure, $this->accomodation_food, $this->placements_internships, $this->social_life_extracurriculars, $this->culture_diversity];
            $data->average_rating = $this->findAvg($rating);
            $data->academics = $this->academics;
            $data->faculty_teaching_quality = $this->faculty_teaching_quality;
            $data->infrastructure = $this->infrastructure;
            $data->accomodation_food = $this->accomodation_food;
            $data->placements_internships = $this->placements_internships;
            $data->social_life_extracurriculars = $this->social_life_extracurriculars;
            $data->culture_diversity = $this->culture_diversity;
        } elseif ($this->reviewer_type == 4 || $this->reviewer_type == 5) {
            $rating = [$this->student_engagement, $this->school_infrastructure, $this->faculty, $this->accessibility_of_faculty, $this->co_curricular_activities, $this->leadership_development, $this->sports];
            $data->average_rating = $this->findAvg($rating);
            $data->student_engagement = $this->student_engagement;
            $data->school_infrastructure = $this->school_infrastructure;
            $data->faculty = $this->faculty;
            $data->accessibility_of_faculty = $this->accessibility_of_faculty;
            $data->co_curricular_activities = $this->co_curricular_activities;
            $data->leadership_development = $this->leadership_development;
            $data->sports = $this->sports;
        } elseif ($this->reviewer_type == 6 || $this->reviewer_type == 7) {
            $rating = [$this->student_engagement, $this->school_infrastructure, $this->faculty, $this->value_for_money, $this->teaching_style, $this->coverage_of_subject_matter, $this->accessibility_of_faculty];
            $data->average_rating = $this->findAvg($rating);
            $data->student_engagement = $this->student_engagement;
            $data->school_infrastructure = $this->school_infrastructure;
            $data->faculty = $this->faculty;
            $data->value_for_money = $this->value_for_money;
            $data->teaching_style = $this->teaching_style;
            $data->coverage_of_subject_matter = $this->coverage_of_subject_matter;
            $data->accessibility_of_faculty = $this->accessibility_of_faculty;
        }
        if ($data->update()) {
            return true;
        } else {
            return false;
        }
    }

    private function findAvg($data)
    {
        $avg_rating = array_sum($data) / 7;
        $avg_rating = number_format($avg_rating, 2);
        return $avg_rating;
    }

    private function __addCategory($name, $id)
    {

        $cat = Categories::find()
            ->select(['category_enc_id', 'name'])
            ->where(['name' => $name])
            ->asArray()
            ->one();

        if (!empty($cat)) {
            return $cat['category_enc_id'];
        } else {
            $model = new Categories();

            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->category_enc_id = $utilitiesModel->encrypt();
            $model->name = $name;
            $utilitiesModel->variables['name'] = $name;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $model->slug = $utilitiesModel->create_slug();
            $model->created_by = $id;
            $model->created_on = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $model->category_enc_id;
            } else {
                return $this->response(500);
            }
        }
    }

    private function __addDesignation($designation, $id)
    {

        $des = Designations::find()
            ->select(['designation_enc_id', 'designation'])
            ->where(['designation' => $designation])
            ->asArray()
            ->one();

        if (!empty($des)) {
            return $des['designation_enc_id'];
        } else {
            $model = new Designations();

            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->designation_enc_id = $utilitiesModel->encrypt();
            $model->designation = $designation;
            $utilitiesModel->variables['name'] = $designation;
            $utilitiesModel->variables['table_name'] = Designations::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $model->slug = $utilitiesModel->create_slug();
            $model->created_on = date('Y-m-d H:i:s');
            $model->created_by = $id;
            if ($model->save()) {
                return $model->designation_enc_id;
            } else {
                return $this->response(500);
            }
        }

    }

    private function __eduStream($name)
    {

        $chk = Qualifications::find()
            ->select(['qualification_enc_id'])
            ->where(['name' => $name])
            ->asArray()
            ->one();

        if (!empty($chk)) {
            return $chk['qualification_enc_id'];
        } else {
            $model = new Qualifications();

            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->qualification_enc_id = $utilitiesModel->encrypt();
            $model->name = $name;
            $utilitiesModel->variables['name'] = $name;
            $utilitiesModel->variables['table_name'] = Qualifications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $model->slug = $utilitiesModel->create_slug();
            if ($model->save()) {
                return $model->qualification_enc_id;
            } else {
                return $this->response(500);
            }
        }

    }

}