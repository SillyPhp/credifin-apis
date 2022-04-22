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
            ]
        ];
        return $behaviors;
    }

    public function actionGetGroups($permissionKey){
        if ($permissionKey == Yii::$app->params->EmpowerYouth->permissionKey) {
            $data = TelegramGroups::find()
                ->select(['telegram_enc_id', 'name', 'group_id'])
                ->where(['is_deleted' => 0])
                ->asArray()
                ->all();
            if($data) {
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(201, ['status' => 201, 'message' => 'Data Not Found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetBots($permissionKey){
        if ($permissionKey == Yii::$app->params->EmpowerYouth->permissionKey) {
            $data = TelegramBots::find()
                ->select(['bot_enc_id', 'bot_name name', 'bot_username username','bot_api_key api_key'])
                ->where(['is_deleted' => 0])
                ->asArray()
                ->all();
            if($data) {
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(201, ['status' => 201, 'message' => 'Data Not Found']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionGetWebinars($permissionKey, $schedularTime = null){
        if ($permissionKey == Yii::$app->params->EmpowerYouth->permissionKey) {
            $dt = new \DateTime();
            $tz = new \DateTimeZone('Asia/Kolkata');
            $dt->setTimezone($tz);
            $currentTime = $dt->format('Y-m-d H:i:s');
            if(!$schedularTime){
                $schedularTime = $currentTime;
            }
            $eventModel = WebinarEvents::find()
                ->alias('a')
                ->select([
                     'a.webinar_enc_id',
                    "ADDTIME(DATE_FORMAT(a.start_datetime, '%H:%i:%s'), SEC_TO_TIME(a.duration*60)) as endtime",
                    "DATE_FORMAT(a.start_datetime, '%d-%m-%Y') event_date",
                    "DATE_FORMAT(a.start_datetime, '%H:%i:%s %p') event_time",
                    'b.name', 'b.slug'
                ])
                ->joinWith(['webinarEnc b'],false)
                ->andWhere(['>', 'a.start_datetime', $schedularTime])
                ->andWhere(['b.is_deleted' => 0])
                ->orderBy(['a.start_datetime' => SORT_ASC])
                ->asArray()
                ->all();
            if ($eventModel) {
                for($i = 0; $i < count($eventModel); $i++){
                    if($eventModel[$i]['event_date'] != $eventModel[0]['event_date']) {
                        unset($eventModel[$i]);
                    }
                }
                return $this->response(200, ['status' => 200, 'data' => $eventModel]);
            } else {
                return $this->response(201, ['status' => 201, 'message' => 'Data Not Found']);
            }

        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }
}