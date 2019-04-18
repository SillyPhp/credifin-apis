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
              ->select(['a.organization_enc_id','a.initials_color color','a.name','a.slug','CASE WHEN a.logo IS NOT NULL  THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '",a.logo_location, "/", a.logo) END logo','b.business_activity_enc_id','b.business_activity','ROUND(AVG(c.average_rating)) rating','COUNT(c.average_rating) total_reviews'])
              ->joinWith(['businessActivityEnc b'],false)
              ->joinWith(['organizationReviews c'=>function($b)
              {
                  $b->groupBy(['organization_enc_id']);
              }],false)
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