<?php

namespace api\modules\v3\models;
use Yii;
use api\modules\v3\models\RtcTokenBuilder;
use common\models\VideoSessions;
use common\models\Utilities;
use common\models\WebinarSessions;

class TokensModel
{
    public function getToken($options)
    {
        $model = new VideoSessions();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->session_enc_id = $utilitiesModel->encrypt();
        $model->app_id = Yii::$app->params->agora->appId;
        $model->expire_time = $options['expire_time'];
        $model->channel_name = 'EmpowerLive' . rand(100, 100000);
        $model->created_by = $options['user_enc_id'];
        $model->session_token = $this->genrateToken($model->app_id, $model->channel_name, Yii::$app->params->agora->appCertificate, $model->expire_time);
        if ($model->save()) {
            return [
                'status' => true,
                'session_id' => $model->session_enc_id
            ];
        } else {
            return [
                'status' => false,
            ];
        }
    }

    private function genrateToken($appID, $channelName, $appCertificate, $expire_time)
    {
        $uid = 0;
        $uidStr = null;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = $expire_time; //3600 default
        $currentTimestamp = (new \DateTime("now", new \DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
        return $token;
    }

    public function validateToken($options)
    {
        $session_id = WebinarSessions::findOne(['session_enc_id' => $options['tokenId']])->session_id;
        $model = VideoSessions::find()
            ->where(['is_active' => 1, 'session_enc_id' => $session_id])
            ->asArray()->one();
        if ($model) {
            return [
                'status' => true,
                'app_id' => $model['app_id'],
                'channel_name' => $model['channel_name'],
                'token' => $model['session_token'],
            ];
        } else {
            return [
                'status' => false
            ];
        }
    }
}