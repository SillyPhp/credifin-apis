<?php

namespace frontend\models\reviews;

use common\models\NewOrganizationReviews;
use Yii;
use yii\base\Model;
use common\models\OrganizationReviews;

class EditUnclaimedCollegeOrg extends Model {

    public $identity;
    public $likes;
    public $dislikes;
    public $org_id;
    public $academics;
    public $faculty_teaching_quality;
    public $infrastructure;
    public $accomodation_food;
    public $placements_internships;
    public $social_life_extracurriculars;
    public $culture_diversity;
    public $type = 'college';

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['identity',
                'academics','type','faculty_teaching_quality','infrastructure','accomodation_food','placements_internships',
                'social_life_extracurriculars','culture_diversity','org_id','likes','dislikes'
            ],'safe'],
        ];
    }


    public function setValues_college($edit_review)
    {
        $this->academics = $edit_review->academics;
        $this->faculty_teaching_quality= $edit_review->faculty_teaching_quality;
        $this->infrastructure= $edit_review->infrastructure;
        $this->accomodation_food= $edit_review->accomodation_food;
        $this->placements_internships= $edit_review->placements_internships;
        $this->social_life_extracurriculars= $edit_review->social_life_extracurriculars;
        $this->culture_diversity= $edit_review->culture_diversity;
        $this->identity= $edit_review->show_user_details;
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
        $modal->academics = $this->academics;
        $modal->faculty_teaching_quality = $this->faculty_teaching_quality;
        $modal->infrastructure = $this->infrastructure;
        $modal->accomodation_food = $this->accomodation_food;
        $modal->placements_internships = $this->placements_internships;
        $modal->social_life_extracurriculars = $this->social_life_extracurriculars;
        $modal->culture_diversity = $this->culture_diversity;
        $modal->show_user_details = $this->identity;
        $modal->likes = $this->likes;
        $modal->dislikes = $this->dislikes;
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