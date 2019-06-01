<?php

namespace frontend\models\reviews;

use common\models\NewOrganizationReviews;
use Yii;
use yii\base\Model;
use common\models\OrganizationReviews;

class EditUnclaimedInstituteOrg extends Model {

    public $identity;
    public $likes;
    public $dislikes;
    public $org_id;
    public $student_engagement;
    public $school_infrastructure;
    public $faculty;
    public $value_for_money;
    public $teaching_style;
    public $coverage_of_subject_matter;
    public $accessibility_of_faculty;
    public $type = 'institute';

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['identity',
                'student_engagement','type','school_infrastructure','faculty','value_for_money',
                'teaching_style','coverage_of_subject_matter','accessibility_of_faculty','org_id','likes','dislikes'
            ],'safe'],
        ];
    }


    public function setValues_institute($edit_review)
    {
        $this->student_engagement = $edit_review->student_engagement;
        $this->school_infrastructure= $edit_review->school_infrastructure;
        $this->faculty= $edit_review->faculty;
        $this->value_for_money= $edit_review->value_for_money;
        $this->teaching_style= $edit_review->teaching_style;
        $this->coverage_of_subject_matter= $edit_review->coverage_of_subject_matter;
        $this->accessibility_of_faculty= $edit_review->accessibility_of_faculty;
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
        $modal->value_for_money= $this->value_for_money;
        $modal->teaching_style= $this->teaching_style;
        $modal->coverage_of_subject_matter= $this->coverage_of_subject_matter;
        $modal->accessibility_of_faculty = $this->accessibility_of_faculty;
        $modal->average_rating = (($this->student_engagement+$this->school_infrastructure+$this->faculty+$this->value_for_money+$this->teaching_style+$this->coverage_of_subject_matter+$this->accessibility_of_faculty)/7);
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