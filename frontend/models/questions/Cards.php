<?php
namespace frontend\models\questions;
use yii\helpers\Url;
use Yii;
use common\models\QuestionsPoolAnswer;

class Cards
{
   public function getCards($options)
   {
     $cards = QuestionsPoolAnswer::find()
               ->alias('a')
               ->select(['a.answer',
                   'CONCAT(b.first_name," ",b.last_name) full_name',
                   'b.initials_color color',
                   'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image',
                   'b.username',
                   'DATE_FORMAT(a.created_on,"%e %M %Y") created_on'])
               ->where(['question_pool_enc_id'=>$options['que_id']])
               ->andWhere(['a.is_deleted'=>0])
               ->orderBy(['a.created_on' => SORT_DESC])
               ->joinWith(['createdBy b'],false);

     $total = $cards->count();

     return [
           'total' => $total,
           'cards' => $cards->asArray()->all()
       ];
   }
}