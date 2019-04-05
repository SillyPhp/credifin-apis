<?php

namespace frontend\models\reviews;

use Yii;
use yii\base\Model;
use common\models\OrganizationReviews;

class EditReview extends Model {

    public $identity;
    public $job_security;
    public $dept;
    public $career_growth;
    public $compnay_culture;
    public $salary_benefits;
    public $work_satisfaction;
    public $work_life;
    public $skill_devel;
    public $likes;
    public $dislikes;
    public $org_id;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['identity','job_security','org_id','likes','dislikes','dept','career_growth','compnay_culture','salary_benefits',
            'work_satisfaction','work_life','skill_devel'],'required'],
            ];
    }

    public function setValues($edit_review,$slug)
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

    public function save()
    {
        $modal = OrganizationReviews::find()
            ->where(['created_by'=>Yii::$app->user->identity->user_enc_id])
            ->andWhere(['organization_enc_id'=>$this->org_id])
            ->one();

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

     if ($modal->update())
     {
         return true;
     }
     else{
         return false;
     }
    }

}