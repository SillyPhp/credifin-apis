<?php


namespace common\models\extended;

use common\models\Speakers;
use common\models\WebinarEvents;
use common\models\WebinarModerators;
use common\models\WebinarSpeakers;
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
                $c->select(['c.event_enc_id', 'c.webinar_enc_id', "DATE_FORMAT(c.start_datetime, '%Y/%m/%d %H:%i:%s') start_datetime", 'c.session_enc_id']);
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
            ])
            ->joinWith(['assignedWebinarTos b'], false)
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
                    'CASE WHEN e1.icon IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->webinars->outcome->icon, 'https') . '", e1.icon_location, "/", e1.icon) ELSE "' . Url::to('@eyAssets/images/pages/webinar/default-outcome.png', 'https') . '" END icon'
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
                ->select([
                    "a.event_enc_id",
                    'a.duration',
                    'a.start_datetime',
                    "DATE_FORMAT(ADDDATE(a.start_datetime, INTERVAL duration MINUTE), '%H:%i:%s') endtime",
                    "DATE_FORMAT(a.start_datetime, '%d/%m/%Y') event_date",
                    "DATE_FORMAT(a.start_datetime, '%H:%i:%s') event_time",
//                    "ADDTIME(DATE_FORMAT(a.start_datetime, '%H:%i:%s'), SEC_TO_TIME(a.duration*60)) endtime",
                    "a.description event_description",
                    'a.title event_title',
                    'a.session_enc_id',
                    'a.status'
                ])
                ->joinWith(['webinarSpeakers d' => function ($d) {
                    $d->select([
                        'd.webinar_event_enc_id',
                        'd.speaker_enc_id',
                        'd1.user_enc_id',
                        'CONCAT(d2.first_name, " ", d2.last_name) as fullname',
                        'CASE WHEN d2.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d2.image_location, "/", d2.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(d2.first_name, " ", d2.last_name), "&size=200&rounded=false&background=", REPLACE(d2.initials_color, "#", ""), "&color=ffffff") END image',
                        'd3.designation',
                        'd2.facebook',
                        'd2.twitter',
                        'd2.linkedin',
                        'd2.instagram',
                    ]);
                    $d->joinWith(['speakerEnc d1' => function ($d1) {
                        $d1->joinWith(['userEnc d2']);
                        $d1->joinWith(['designationEnc d3']);
                    }], false);
                    $d->onCondition(['d.is_deleted' => 0]);
                }])
                ->where(['a.webinar_enc_id' => $webinar_detail['webinar_enc_id']])
                ->andWhere(['a.is_deleted' => 0])
                ->groupBy(['a.event_enc_id'])
                ->orderBy(['a.start_datetime' => SORT_ASC])
                ->asArray()
                ->all();
            $dateEvents = ArrayHelper::index($events, null, 'event_date');

            $speaker_count = WebinarSpeakers::find()
                ->alias('a')
                ->joinWith(['webinarEventEnc b'])
                ->where(['b.webinar_enc_id' => $webinar_detail['webinar_enc_id']])
                ->groupBy(['a.speaker_enc_id'])
                ->count();

            $events = WebinarEvents::find()
                ->select(["DATE_FORMAT(start_datetime, '%Y/%m/%d %H:%i:%s') start_datetime", 'session_enc_id'])
                ->where(['webinar_enc_id' => $webinar_detail['webinar_enc_id'], 'status' => [0, 1]])
                ->orderBy(['start_datetime' => SORT_ASC])
                ->asArray()
                ->one();

            $speakers = WebinarSpeakers::find()
                ->distinct()
                ->alias('a')
                ->select(['a.speaker_enc_id',
                    'a.webinar_event_enc_id',
                    'f.user_enc_id',
                    'CONCAT(f.first_name, " ", f.last_name) as fullname',
                    'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(f.first_name, " ", f.last_name), "&size=200&rounded=false&background=", REPLACE(f.initials_color, "#", ""), "&color=ffffff") END image',
                    'e.designation',
                    'f.facebook',
                    'f.twitter',
                    'f.linkedin',
                    'f.instagram',
                    'REPLACE(g.name, "&amp;", "&") as org_name',
                    'f.description',
                    'CASE WHEN g.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->unclaimedOrganizations->logo, 'https') . '", g.logo_location, "/", g.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", g.name, "&size=200&rounded=false&background=", REPLACE(g.initials_color, "#", ""), "&color=ffffff") END logo',
                ])
                ->joinWith(['webinarEventEnc b'], false)
                ->joinWith(['speakerEnc c' => function ($c) {
                    $c->select(['c.speaker_enc_id']);
                    $c->joinWith(['speakerExpertises d' => function ($d) {
                        $d->select(['d.speaker_enc_id', 'd.skill_enc_id', 'ee.skill']);
                        $d->joinWith(['skillEnc ee'], false);
                    }]);
                    $c->joinWith(['designationEnc e'], false)
                        ->joinWith(['userEnc f'], false)
                        ->joinWith(['unclaimedOrg g'], false);
                }])
                ->where(['b.webinar_enc_id' => $webinar_detail['webinar_enc_id'], 'a.is_deleted' => 0])
                ->groupBy(['a.speaker_enc_id'])
                ->asArray()
                ->all();

            $moderator = WebinarModerators::find()
                ->distinct()
                ->alias('a')
                ->select(['a.speaker_enc_id',
                    'a.webinar_event_enc_id',
                    'f.user_enc_id',
                    'CONCAT(f.first_name, " ", f.last_name) as fullname',
                    'CASE WHEN f.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", f.image_location, "/", f.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(f.first_name, " ", f.last_name), "&size=200&rounded=false&background=", REPLACE(f.initials_color, "#", ""), "&color=ffffff") END image',
                    'e.designation',
                    'f.facebook',
                    'f.twitter',
                    'f.linkedin',
                    'f.instagram',
                    'REPLACE(g.name, "&amp;", "&") as org_name',
                    'f.description',
                    'CASE WHEN g.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->unclaimedOrganizations->logo, 'https') . '", g.logo_location, "/", g.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", g.name, "&size=200&rounded=false&background=", REPLACE(g.initials_color, "#", ""), "&color=ffffff") END logo',
                ])
                ->joinWith(['webinarEventEnc b'], false)
                ->joinWith(['speakerEnc c' => function ($c) {
                    $c->select(['c.speaker_enc_id']);
                    $c->joinWith(['speakerExpertises d' => function ($d) {
                        $d->select(['d.speaker_enc_id', 'd.skill_enc_id', 'ee.skill']);
                        $d->joinWith(['skillEnc ee'], false);
                    }]);
                    $c->joinWith(['designationEnc e'], false)
                        ->joinWith(['userEnc f'], false)
                        ->joinWith(['unclaimedOrg g'], false);
                }])
                ->where(['b.webinar_enc_id' => $webinar_detail['webinar_enc_id'], 'a.is_deleted' => 0])
                ->groupBy(['a.speaker_enc_id'])
                ->asArray()
                ->all();

            $webinar_detail['moderator'] = $moderator;
            $webinar_detail['event'] = $events;
            $webinar_detail['events'] = $dateEvents;
            $webinar_detail['speaker_count'] = $speaker_count;
            $webinar_detail['speakers'] = $speakers;
        }

        return $webinar_detail;
    }

    public function nextEvent($webinar_enc_id, $date)
    {
        $events = WebinarEvents::find()
            ->alias('a')
            ->select([
                "a.event_enc_id",
                'a.duration',
                'a.start_datetime',
                "DATE_FORMAT(ADDDATE(a.start_datetime, INTERVAL duration MINUTE), '%H:%i:%s') endtime",
                "DATE_FORMAT(a.start_datetime, '%d/%m/%Y') event_date",
                "DATE_FORMAT(a.start_datetime, '%H:%i:%s') event_time",
                "a.description event_description",
                'a.title event_title',
                'a.session_enc_id',
                'a.status'
            ])
            ->joinWith(['webinarSpeakers d' => function ($d) {
                $d->select([
                    'd.webinar_event_enc_id',
                    'd.speaker_enc_id',
                    'd1.user_enc_id',
                    'CONCAT(d2.first_name, " ", d2.last_name) as fullname',
                    'CASE WHEN d2.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", d2.image_location, "/", d2.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", CONCAT(d2.first_name, " ", d2.last_name), "&size=200&rounded=false&background=", REPLACE(d2.initials_color, "#", ""), "&color=ffffff") END image',
                    'd3.designation',
                    'd2.facebook',
                    'd2.twitter',
                    'd2.linkedin',
                    'd2.instagram',
                ]);
                $d->joinWith(['speakerEnc d1' => function ($d1) {
                    $d1->joinWith(['userEnc d2']);
                    $d1->joinWith(['designationEnc d3']);
                }], false);
                $d->onCondition(['d.is_deleted' => 0]);
            }])
            ->where(['a.webinar_enc_id' => $webinar_enc_id, "DATE_FORMAT(a.start_datetime, '%Y-%m-%d')" => $date])
            ->andWhere(['a.is_deleted' => 0, 'a.status' => [0, 1]])
            ->groupBy(['a.event_enc_id'])
            ->orderBy(['a.start_datetime' => SORT_ASC])
            ->offset(1)
            ->asArray()
            ->all();

        return $events;
    }

    public function allWebinars($data)
    {
        $dt = new \DateTime();
        $tz = new \DateTimeZone('Asia/Kolkata');
        $dt->setTimezone($tz);
        $date_now = $dt->format('Y-m-d H:i:s');

        $past_webinars = \common\models\Webinar::find()
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
            ->joinWith(['webinarEvents c' => function ($c) use ($date_now) {
                $c->select(['c.event_enc_id', 'c.webinar_enc_id',
                    "DATE_FORMAT(c.start_datetime, '%Y/%m/%d %H:%i:%s') start_datetime",
                    "DATE_FORMAT(c.start_datetime, '%Y-%m-%d %H:%i:%s') event_date",
                    'c.session_enc_id']);
                $c->onCondition(['c.is_deleted' => 0]);
                $c->orderBy(['c.start_datetime' => SORT_ASC]);
            }])
            ->where(['a.is_deleted' => 0, 'b.organization_enc_id' => $data['college_id']])
            ->andWhere(['a.session_for' => [0, 2]])
//            ->andWhere(['<', 'c.start_datetime', $date_now])
            ->asArray()
            ->all();

        $past = [];
        $i = 0;
        foreach ($past_webinars as $p) {
            $last_event = current($p['webinarEvents']);
            if ($data['type'] == 'past') {
                if ($last_event['event_date'] < $date_now) {
                    array_push($past, $past_webinars[$i]);
                }
            } elseif ($data['type'] == 'upcoming') {
                if ($last_event['event_date'] > $date_now) {
                    array_push($past, $past_webinars[$i]);
                }
            }
            $i++;
        }

        return $past;
    }

}