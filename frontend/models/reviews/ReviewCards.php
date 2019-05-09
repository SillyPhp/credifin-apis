<?php

namespace frontend\models\reviews;

use common\models\NewOrganizationReviews;
use common\models\Organizations;
use yii\helpers\Url;
use Yii;

class ReviewCards {

    public function getReviewCards($options=[])
    {
        $cards =  Organizations::find()
              ->alias('a')
              ->select(['a.organization_enc_id','a.name','a.initials_color color','a.slug','CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '",a.logo_location, "/", a.logo) END logo','b.business_activity_enc_id','b.business_activity','ROUND(AVG(c.average_rating)) rating'])
              ->where(['a.is_deleted'=>0])
              ->joinWith(['businessActivityEnc b'],false)
              ->joinWith(['organizationReviews c'=>function($b)
              {
                  $b->select(['c.organization_enc_id','COUNT(c.average_rating) total_reviews']);
                  $b->groupBy(['c.organization_enc_id']);
              }],true)
              ->joinWith(['employerApplications e'=>function($x)
              {
                  $x->select(['e.organization_enc_id','COUNT(CASE WHEN h.name = "Jobs" THEN 1 END) as total_jobs','COUNT(CASE WHEN h.name = "Internships" THEN 1 END) as total_internships']);
                  $x->joinWith(['applicationTypeEnc h'],false);
                  $x->onCondition(['e.is_deleted'=>0]);
                  $x->groupBy(['e.organization_enc_id']);
              }],true)
              ->joinWith(['organizationLocations d'=>function($x)
              {
                      $x->joinWith(['cityEnc g'], false);
              }],false)
              ->groupBy('a.organization_enc_id');
        if (isset($options['business_activity']))
        {
           $cards->andWhere([
               'or',
               ['in','b.business_activity',$options['business_activity']]
           ]);
        }
        if (isset($options['keywords']))
        {
           $cards->andWhere([
               'or',
               ['like', 'a.name', $options['keywords']],
           ]);
        }
        if (isset($options['city']))
        {
           $cards->andWhere([
               'or',
               ['like', 'g.name', $options['city']],
           ]);
        }
        if (isset($options['rating']))
        {
            $cards->orFilterHaving(['ROUND(AVG(c.average_rating))'=>$options['rating']]);
        }
        $total_cards = $cards->count();
        $data = $cards->limit($options['limit'])->offset($options['offset'])->asArray()->all();

        return [
            'total'=>$total_cards,
            'cards'=>$data
        ];
    }

    public function getReviewsCount($unclaimed_org)
    {
        return  NewOrganizationReviews::find()
            ->alias('a')
            ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
            ->andWhere(['in','reviewer_type',[0,1]])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
            ->count();
    }

    public function getCollegeReviewsCount($unclaimed_org)
    {
        return  NewOrganizationReviews::find()
            ->alias('a')
            ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
            ->andWhere(['in','reviewer_type',[2,3]])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
            ->count();
    }

    public function getSchoolReviewsCount($unclaimed_org)
    {
        return  NewOrganizationReviews::find()
            ->alias('a')
            ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
            ->andWhere(['in','reviewer_type',[4,5]])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
            ->count();
    }
    public function getInstituteReviewsCount($unclaimed_org)
    {
        return  NewOrganizationReviews::find()
            ->alias('a')
            ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
            ->andWhere(['in','reviewer_type',[6,7]])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
            ->count();
    }

    public function getReviewStats($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->select(['ROUND(AVG(job_security)) job_avg', 'ROUND(AVG(growth)) growth_avg', 'ROUND(AVG(organization_culture)) avg_cult', 'ROUND(AVG(compensation)) avg_compensation', 'ROUND(AVG(work)) avg_work', 'ROUND(AVG(work_life)) avg_work_life', 'ROUND(AVG(skill_development)) avg_skill'])
            ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
            ->andWhere(['in','reviewer_type',[0,1]])
            ->asArray()
            ->one();
    }

    public function getCollegeReviewStats($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->select(['ROUND(AVG(academics)) academics', 'ROUND(AVG(faculty_teaching_quality)) faculty_teaching_quality', 'ROUND(AVG(infrastructure)) infrastructure', 'ROUND(AVG(accomodation_food)) accomodation_food', 'ROUND(AVG(placements_internships)) placements_internships', 'ROUND(AVG(social_life_extracurriculars)) social_life_extracurriculars', 'ROUND(AVG(culture_diversity)) culture_diversity'])
            ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
            ->andWhere(['in','reviewer_type',[2,3]])
            ->asArray()
            ->one();
    }

    public function getSchoolReviewStats($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->select(['ROUND(AVG(student_engagement)) student_engagement', 'ROUND(AVG(school_infrastructure)) school_infrastructure', 'ROUND(AVG(faculty)) faculty', 'ROUND(AVG(accessibility_of_faculty)) accessibility_of_faculty', 'ROUND(AVG(co_curricular_activities)) co_curricular_activities', 'ROUND(AVG(leadership_development)) leadership_development', 'ROUND(AVG(sports)) sports'])
            ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
            ->andWhere(['in','reviewer_type',[4,5]])
            ->asArray()
            ->one();
    }
    public function getInstituteReviewStats($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->select(['ROUND(AVG(student_engagement)) student_engagement', 'ROUND(AVG(school_infrastructure)) school_infrastructure', 'ROUND(AVG(faculty)) faculty', 'ROUND(AVG(value_for_money)) value_for_money', 'ROUND(AVG(teaching_style)) teaching_style', 'ROUND(AVG(coverage_of_subject_matter)) coverage_of_subject_matter', 'ROUND(AVG(accessibility_of_faculty)) accessibility_of_faculty'])
            ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
            ->andWhere(['in','reviewer_type',[6,7]])
            ->asArray()
            ->one();
    }
}