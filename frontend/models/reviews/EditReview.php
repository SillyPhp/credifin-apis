<?php

namespace frontend\models\reviews;

use common\models\NewOrganizationReviews;
use Yii;
use yii\base\Model;
use common\models\OrganizationReviews;

class EditReview extends Model {

    public $identity;
    public $likes;
    public $dislikes;
    public $org_id;
    public $dept;
    public $job_security;
    public $career_growth;
    public $compnay_culture;
    public $salary_benefits;
    public $work_satisfaction;
    public $work_life;
    public $skill_devel;
    public $type = 'org';

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['identity','type','job_security','org_id','likes','dislikes','career_growth','compnay_culture','salary_benefits',
            'work_satisfaction','work_life','skill_devel'],'required'],
            ['dept','safe'],
            ];
    }

    public function setValues($edit_review)
    {
        $this->identity = $edit_review->show_user_details;
        $this->dept = $edit_review->category_enc_id;
        $this->career_growth = $edit_review->growth;
        $this->compnay_culture = $edit_review->organization_culture;
        $this->salary_benefits = $edit_review->compensation;
        $this->work_satisfaction = $edit_review->work;
        $this->work_life = $edit_review->work_life;
        $this->skill_devel = $edit_review->skill_development;
        $this->job_security = $edit_review->job_security;
        $this->likes = $edit_review->likes;
        $this->dislikes = $edit_review->dislikes;
        $this->org_id = $edit_review->organization_enc_id;
    }

    public function setValues_college($edit_review)
    {
        $this->identity = $edit_review->show_user_details;
        $this->dept = $edit_review->category_enc_id;
        $this->career_growth = $edit_review->growth;
        $this->compnay_culture = $edit_review->organization_culture;
        $this->salary_benefits = $edit_review->compensation;
        $this->work_satisfaction = $edit_review->work;
        $this->work_life = $edit_review->work_life;
        $this->skill_devel = $edit_review->skill_development;
        $this->job_security = $edit_review->job_security;
        $this->likes = $edit_review->likes;
        $this->dislikes = $edit_review->dislikes;
        $this->org_id = $edit_review->organization_enc_id;
    }

    public function save($request_type)
    {
        if ($request_type==1) {
            $modal = OrganizationReviews::find()
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['organization_enc_id' => $this->org_id])
                ->one();
        }
        elseif ($request_type==2)
        {
            $modal = NewOrganizationReviews::find()
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['organization_enc_id' => $this->org_id])
                ->one();
        }
        $modal->likes = $this->likes;
        $modal->dislikes = $this->dislikes;
        $modal->job_security = $this->job_security;
        $modal->skill_development = $this->skill_devel;
        $modal->work_life = $this->work_life;
        $modal->work = $this->work_satisfaction;
        $modal->compensation = $this->salary_benefits;
        $modal->organization_culture = $this->compnay_culture;
        $modal->growth = $this->career_growth;
        $modal->category_enc_id = $this->dept;
        $modal->show_user_details = $this->identity;
        $modal->last_updated_by = Yii::$app->user->identity->user_enc_id;

     if ($modal->update())
     {
         return true;
     }
     else{
         return false;
     }
    }

    public function Collegesave($request_type)
    {
        if ($request_type==1) {
            $modal = OrganizationReviews::find()
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['organization_enc_id' => $this->org_id])
                ->one();
        }
        elseif ($request_type==2)
        {
            $modal = NewOrganizationReviews::find()
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['organization_enc_id' => $this->org_id])
                ->one();
        }
        $modal->academics = $this->academics;
        $modal->faculty_teaching_quality = $this->faculty_teaching_quality;
        $modal->infrastructure = $this->infrastructure;
        $modal->accomodation_food = $this->accomodation_food;
        $modal->placements_internships = $this->placements_internships;
        $modal->social_life_extracurriculars = $this->social_life_extracurriculars;
        $modal->culture_diversity = $this->culture_diversity;
        $modal->show_user_details = $this->identity;
        $modal->last_updated_by = Yii::$app->user->identity->user_enc_id;

        if ($modal->update())
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function Schoolsave($request_type)
    {
        if ($request_type==1) {
            $modal = OrganizationReviews::find()
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['organization_enc_id' => $this->org_id])
                ->one();
        }
        elseif ($request_type==2)
        {
            $modal = NewOrganizationReviews::find()
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['organization_enc_id' => $this->org_id])
                ->one();
        }
        $modal->student_engagement = $this->student_engagement;
        $modal->school_infrastructure= $this->school_infrastructure;
        $modal->faculty= $this->faculty;
        $modal->accessibility_of_faculty= $this->accessibility_of_faculty;
        $modal->co_curricular_activities= $this->co_curricular_activities;
        $modal->leadership_development= $this->leadership_development;
        $modal->sports = $this->sports;
        $modal->show_user_details = $this->identity;
        $modal->last_updated_by = Yii::$app->user->identity->user_enc_id;

        if ($modal->update())
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function getEditReview($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->alias('a')
            ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
            ->andWhere(['a.created_by' => Yii::$app->user->identity->user_enc_id])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->one();
    }
}