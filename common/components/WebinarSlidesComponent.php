<?php
namespace common\components;

use yii\base\component;

class WebinarSlidesComponent extends component
{
    public function Check(){
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $currentTime = $dt->format('Y-m-d H:i:s');

        $widgetWebinars = \common\models\WebinarWidgetTemplates::find()
            ->alias('a')
            ->select(['a.widget_enc_id', 'a.webinar_enc_id', 'a.template_name', 'a.template_path'])
            ->innerJoinWith(['webinarEnc b' => function ($b) use ($currentTime) {
                $b->joinWith(['webinarEvents c' => function ($c) use ($currentTime) {
                    $c->andWhere(['>', 'ADDDATE(c.start_datetime, INTERVAL c.duration MINUTE)', $currentTime]);
                }]);
            }], false)
            ->where(['a.is_deleted' => 0, 'b.is_deleted' => 0, 'b.session_for' => [0, 1]])
            ->asArray()
            ->all();

        return $widgetWebinars;
    }
}