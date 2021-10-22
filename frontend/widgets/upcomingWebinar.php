<?php

namespace frontend\widgets;
use yii\base\Widget;
use common\models\Webinar;
use common\models\WebinarEvents;

class upcomingWebinar extends Widget
{
    public function run(){
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $currentTime = $dt->format('Y-m-d H:i:s');

        $upcomingWebinar = Webinar::find()
            ->alias('a')
            ->select(['a.title', 'a.slug', 'a.webinar_enc_id'])
            ->joinWith(['webinarEvents b' => function($b) use($currentTime){
                $b->andWhere(['>', 'b.start_datetime', $currentTime]);
            }])
            ->where(['a.is_deleted' => 0])
            ->orderBy(['b.start_datetime' => SORT_ASC])
            ->asArray()
            ->one();
        if($upcomingWebinar){
            return $this->render('@frontend/views/widgets/WebinarHeaderBar', [
                'upcomingWebinar' => $upcomingWebinar
            ]);
        }
    }
}