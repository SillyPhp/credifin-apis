<?php


namespace common\models\extended;

use common\models\WebinarEvents;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use Yii;

class Webinar extends \common\models\Webinar
{
    public function webinarsList($college_id)
    {
        $webinar = \common\models\Webinar::find()
            ->distinct()
            ->alias('a')
            ->select([
                'a.webinar_enc_id',
                'a.title',
                'a.name',
                'a.description',
                'a.price',
                'a.seats',
                'a.slug'
            ])
            ->joinWith(['assignedWebinarTos b'], false)
            ->joinWith(['webinarRegistrations d' => function ($d) {
                $d->select([
                    'd.webinar_enc_id',
                    'd.register_enc_id',
                    'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", d1.first_name, "&size=200&rounded=false&background=", REPLACE(d1.initials_color, "#", ""), "&color=ffffff") END image',
                ]);
                $d->joinWith(['createdBy d1'], false);
                $d->onCondition(['d.is_deleted' => 0, 'd.status' => 1]);
            }])
            ->joinWith(['webinarEvents c' => function ($c) {
                $c->select(['c.event_enc_id', 'c.webinar_enc_id', 'c.start_datetime', 'c.session_enc_id']);
                $c->onCondition(['c.is_deleted' => 0, 'c.status' => [0, 1]]);
                $c->orderBy(['c.start_datetime' => SORT_ASC]);
            }])
            ->where(['a.is_deleted' => 0, 'b.organization_enc_id' => $college_id])
            ->andWhere(['a.session_for' => [0, 2]])
            ->asArray()
            ->all();

        return $webinar;
    }

    public function webinarDetail($college_id, $webinar_id)
    {
        $webinar_detail = \common\models\Webinar::find()
            ->alias('a')
            ->select([
                'a.webinar_enc_id',
                'a.title',
                'a.name',
                'a.description',
                'a.price',
                'a.seats',
                'a.slug',
                'a.availability',
                'COUNT(DISTINCT(c3.assigned_speaker_enc_id)) speaker_count'
            ])
            ->joinWith(['assignedWebinarTos b'], false)
            ->joinWith(['webinarEvents c' => function ($c) {
                $c->select([
                    'c.event_enc_id',
                    'c.webinar_enc_id',
                    'c.title event_title',
                    'c.description event_description',
                    'c.start_datetime',
                    'c.duration',
                    'c.status',
                    'c.session_enc_id',
                ]);
                $c->joinWith(['webinarSpeakers c3' => function ($c2) {
                    $c2->select([
                        'c3.webinar_event_enc_id',
                        'c3.speaker_enc_id',
                        'c6.designation',
                        'CONCAT(c5.first_name," ",c5.last_name) full_name',
                        'CASE WHEN c5.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", c5.image_location, "/", c5.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", c5.first_name, "&size=200&rounded=false&background=", REPLACE(c5.initials_color, "#", ""), "&color=ffffff") END image',
                        'c5.facebook',
                        'c5.twitter',
                        'c5.linkedin',
                        'c5.instagram',
                    ]);
                    $c2->joinWith(['speakerEnc c4' => function ($c4) {
                        $c4->joinWith(['userEnc c5']);
                        $c4->joinWith(['designationEnc c6']);
                    }], false);
                    $c2->onCondition(['c3.is_deleted' => 0]);
                }]);
                $c->onCondition(['c.is_deleted' => 0]);
                $c->orderBy(['c.start_datetime' => SORT_ASC]);
                $c->groupBy(['c.event_enc_id']);
            }])
            ->joinWith(['webinarRegistrations d' => function ($d) {
                $d->select([
                    'd.webinar_enc_id',
                    'd.register_enc_id',
                    'CASE WHEN d1.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d1.image_location, "/", d1.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", d1.first_name, "&size=200&rounded=false&background=", REPLACE(d1.initials_color, "#", ""), "&color=ffffff") END image'
                ]);
                $d->joinWith(['createdBy d1'], false);
                $d->onCondition(['d.is_deleted' => 0, 'd.status' => 1]);
            }])
            ->joinWith(['webinarOutcomes e' => function ($e) {
                $e->select([
                    'e.outcome_pool_enc_id',
                    'e.webinar_enc_id',
                    'e1.name',
                    'e1.bg_colour',
                    'e1.icon'
                ]);
                $e->joinWith(['outcomePoolEnc e1'], false);
            }])
            ->where([
                'b.organization_enc_id' => $college_id,
                'a.is_deleted' => 0,
                'a.webinar_enc_id' => $webinar_id
            ])
            ->asArray()
            ->one();

        if ($webinar_detail) {

            $events = WebinarEvents::find()
                ->alias('a')
                ->select(["a.event_enc_id", 'a.duration', "DATE_FORMAT(a.start_datetime, '%d-%m-%Y') event_date", "DATE_FORMAT(a.start_datetime, '%H:%i') event_time", "ADDTIME(DATE_FORMAT(a.start_datetime, '%H:%i'), SEC_TO_TIME(a.duration*60)) endtime", "a.description"])
                ->joinWith(['webinarSpeakers d' => function ($d) {
                    $d->select([
                        'd.webinar_event_enc_id',
                        'd.speaker_enc_id',
                        'd1.user_enc_id',
                        'CONCAT(d2.first_name, " ", d2.last_name) as fullname',
                        'd2.image',
                        'd2.image_location',
                        'CASE WHEN d2.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d2.image_location, "/", d2.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", d2.first_name, "&size=200&rounded=false&background=", REPLACE(d2.initials_color, "#", ""), "&color=ffffff") END image'
                    ]);
                    $d->joinWith(['speakerEnc d1' => function ($d1) {
                        $d1->joinWith(['userEnc d2']);
                    }],false);
                    $d->andWhere(['d.is_deleted' => 0]);
                }])
                ->where(['a.webinar_enc_id' => $webinar_detail['webinar_enc_id']])
                ->andWhere(['a.is_deleted' => 0])
                ->orderBy(['a.start_datetime' => SORT_ASC])
                ->asArray()
                ->all();
            $dateEvents = ArrayHelper::index($events, null, 'event_date');

            $events = WebinarEvents::find()
                ->select(['start_datetime'])
                ->where(['webinar_enc_id' => $webinar_detail['webinar_enc_id'], 'status' => [0, 1]])
                ->orderBy(['start_datetime' => SORT_ASC])
                ->asArray()
                ->one();
            $webinar_detail['event'] = $events;
            $webinar_detail['events'] = $dateEvents;
        }

        return $webinar_detail;
    }
}