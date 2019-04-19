<?php

namespace frontend\models\reviews;

use common\models\Organizations;
use yii\helpers\Url;
use Yii;

class ReviewCards {

    public function getReviewCards($options=[])
    {
        $cards =  Organizations::find()
              ->alias('a')
              ->select(['a.organization_enc_id','a.name','a.slug','CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '",a.logo_location, "/", a.logo) END logo','b.business_activity_enc_id','b.business_activity','ROUND(AVG(c.average_rating)) rating'])
              ->joinWith(['businessActivityEnc b'],false)
              ->joinWith(['organizationReviews c'=>function($b)
              {
                  $b->select(['c.organization_enc_id','COUNT(c.average_rating) total_reviews']);
                  $b->groupBy(['organization_enc_id']);
              }],true)
              ->joinWith(['employerApplications e'=>function($x)
              {
                  $x->select(['e.organization_enc_id','COUNT(CASE WHEN h.name = "Jobs" THEN 1 END) as total_jobs','COUNT(CASE WHEN h.name = "Internships" THEN 1 END) as total_internships']);
                  $x->joinWith(['applicationTypeEnc h'],false);
                  $x->andWhere(['e.is_deleted'=>0]);

                  $x->groupBy(['organization_enc_id']);
              }],true)
              ->limit($options['limit'])
              ->joinWith(['organizationLocations d'=>function($x)
              {
                      $x->joinWith(['cityEnc g'], false);
              }],false);
        if (isset($options['business_activity']))
        {
           $cards->orFilterWhere([
               'or',
               ['in','b.business_activity',$options['business_activity']]
           ]);
        }
        if (isset($options['keywords']))
        {
           $cards->orFilterWhere([
               'or',
               ['like', 'a.name', $options['keywords']],
           ]);
        }
        if (isset($options['city']))
        {
           $cards->orFilterWhere([
               'or',
               ['like', 'g.name', $options['city']],
           ]);
        }
        if (isset($options['rating']))
        {
            $cards->orFilterHaving(['ROUND(AVG(c.average_rating))'=>$options['rating']]);
        }
        return $cards->orderBy(['a.id' => SORT_DESC])->asArray()->all();
    }
}