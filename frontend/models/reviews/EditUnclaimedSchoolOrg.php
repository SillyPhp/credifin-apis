<?php

namespace frontend\models\reviews;

use common\models\NewOrganizationReviews;
use Yii;
use yii\base\Model;
use common\models\OrganizationReviews;

class EditUnclaimedSchoolOrg extends Model {

    public $identity;
    public $likes;
    public $dislikes;
    public $org_id;
    public $student_engagement;
    public $school_infrastructure;
    public $faculty;
    public $accessibility_of_faculty;
    public $co_curricular_activities;
    public $leadership_development;
    public $sports;
    public $type = 'school';

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['identity',
                'student_engagement','type','school_infrastructure','faculty','accessibility_of_faculty',
                'co_curricular_activities','leadership_development','sports','org_id','likes','dislikes'
            ],'safe'],
        ];
    }


    public function setValues_school($edit_review)
    {
        $this->student_engagement = $edit_review->student_engagement;
        $this->school_infrastructure= $edit_review->school_infrastructure;
        $this->faculty= $edit_review->faculty;
        $this->accessibility_of_faculty= $edit_review->accessibility_of_faculty;
        $this->co_curricular_activities = $edit_review->co_curricular_activities;
        $this->leadership_development = $edit_review->leadership_development;
        $this->sports= $edit_review->sports;
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
        $modal->student_engagement = $this->student_engagement;
        $modal->school_infrastructure= $this->school_infrastructure;
        $modal->faculty= $this->faculty;
        $modal->accessibility_of_faculty= $this->accessibility_of_faculty;
        $modal->co_curricular_activities= $this->co_curricular_activities;
        $modal->leadership_development= $this->leadership_development;
        $modal->sports = $this->sports;
        $modal->likes = $this->likes;
        $modal->dislikes = $this->dislikes;
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