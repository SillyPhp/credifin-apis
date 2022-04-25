<?php

namespace api\modules\v3\controllers;

use common\models\TelegramBots;
use common\models\TelegramGroups;
use common\models\Webinar;
use common\models\WebinarEvents;
use common\models\WebinarPayments;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use Yii;

class TelegramController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'get-groups' => ['GET', 'OPTIONS'],
                'get-bots' => ['GET', 'OPTIONS'],
                'get-webinars' => ['GET', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionGetGroups($permissionKey, $option = null, $tags = null)
    {
        if ($permissionKey == Yii::$app->params->EmpowerYouth->permissionKey) {
            $data = TelegramGroups::find()
                ->alias('a')
                ->select(['a.telegram_enc_id', 'a.name', 'a.group_id'])
                ->andWhere(['a.is_deleted' => 0]);
            if ($option) {
                $data->andWhere(['or',
                    ['a.name' => $option],
                    ['a.group_id' => $option]
                ]);
            }
            if ($tags) {
                $data->joinWith(['assignTelegramGroups b' => function ($a) use ($tags) {
                    $a->onCondition(['b.is_deleted' => 0]);
                    $a->andFilterWhere(['like', 'b.tag', $tags]);
                }], false);
            }
            $data = $data->asArray()
                ->all();
            if ($data) {
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(201, ['status' => 201, 'message' => 'Data Not Found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetBots($permissionKey, $option = null)
    {
        if ($permissionKey == Yii::$app->params->EmpowerYouth->permissionKey) {
            $data = TelegramBots::find()
                ->select(['bot_enc_id', 'bot_name name', 'bot_username username', 'bot_api_key api_key'])
                ->where(['is_deleted' => 0]);
            if ($option) {
                $data->andWhere(['or',
                    ['bot_name' => $option],
                    ['bot_username' => $option],
                    ['bot_api_key' => $option]
                ]);
            }
            $data = $data->asArray()
                ->all();
            if ($data) {
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(201, ['status' => 201, 'message' => 'Data Not Found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetWebinars($permissionKey, $schedularTime = null)
    {
        if ($permissionKey == Yii::$app->params->EmpowerYouth->permissionKey) {
            $dt = new \DateTime();
            $tz = new \DateTimeZone('Asia/Kolkata');
            $dt->setTimezone($tz);
            $currentTime = $dt->format('Y-m-d H:i:s');
            if (!$schedularTime) {
                $schedularTime = $currentTime;
            }
            $bots = self::actionGetBots(Yii::$app->params->EmpowerYouth->permissionKey, 'eywebinarbot');
            $groups = self::actionGetGroups(Yii::$app->params->EmpowerYouth->permissionKey, '', 'webinar');
            $group_ids = [];
            if ($bots['response']['status'] == 200) {
                if ($groups['response']['status'] == 200) {
                    foreach ($groups['response']['data'] as $d){
                        array_push($group_ids , $d['group_id']);
                    }
                    $eventModel = WebinarEvents::find()
                        ->alias('a')
                        ->distinct()
                        ->select([
                            'a.webinar_enc_id',
                            'a.start_datetime',
                            "ADDTIME(DATE_FORMAT(a.start_datetime, '%H:%i:%s'), SEC_TO_TIME(a.duration*60)) as endtime",
                            "DATE_FORMAT(a.start_datetime, '%d-%m-%Y') event_date",
                            "DATE_FORMAT(a.start_datetime, '%H:%i:%s %p') event_time",
                            'b.name', 'b.slug'
                        ])
                        ->joinWith(['webinarEnc b'], false)
                        ->andWhere(['>', 'a.start_datetime', $schedularTime])
                        ->andWhere(['b.is_deleted' => 0])
                        ->orderBy(['a.start_datetime' => SORT_ASC])
                        ->asArray()
                        ->all();
                    if ($eventModel) {
                        $data = [];
                        for ($i = 0; $i < count($eventModel); $i++) {
                            if ($eventModel[$i]['event_date'] != $eventModel[0]['event_date']) {
                                unset($eventModel[$i]);
                            } else {
                                $date = date_format(date_create($eventModel[$i]['start_datetime']), 'j F Y');
                                $start_time = date('g:iA', strtotime($eventModel[$i]['event_time']));
                                $end_time = date('g:iA', strtotime($eventModel[$i]['endtime']));
                                $time = ($eventModel[$i]['endtime'] && $eventModel[$i]['event_time']) ? $start_time . " TO " . $end_time : "Expired";
                                $url = 'https://www.empoweryouth.com/webinar/' . $eventModel[$i]['slug'];
                                $content = "<b>REGISTER NOW!! " . chr(10) . chr(10) . "</b>Date- " . $date . " \nTime- " . $time . "<b>" . chr(10) . chr(10) . "</b>\xE2\x9C\x85 <b>" . 'E-Certificcates will be provided to all the registered attendees' . chr(10) . chr(10) . "</b>\xE2\x9C\x85 <b>" . 'Attend a webinar and avail 20% discount on GoDaddy Academy Courses' . "</b>" . chr(10) . chr(10) . $url;
                                $date_time = ($date) ? $date : date('Y-m-d H:i:s');

                                $body = [
                                    "permissionKey" => Yii::$app->params->EmpowerYouth->permissionKey,
                                    "content" => $content,
                                    "group_id" => $group_ids,
                                    "api_key" => $bots['response']['data'][0]['api_key'],
                                    "date_time" => $date_time,
                                    "url" => $url,
                                    "button_text" => "Apply",
                                    "button_url" => $url
                                ];
                                array_push($data, $body);
                            }
                        }
                        return $this->response(200, ['status' => 200, 'data' => $data]);
                    } else {
                        return $this->response(201, ['status' => 201, 'message' => 'Data Not Found']);
                    }
                } else {
                    return $this->response(204, ['status' => 204, 'message' => 'Groups Not Found']);
                }
            } else {
                return $this->response(202, ['status' => 202, 'message' => 'Bots Not Found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}