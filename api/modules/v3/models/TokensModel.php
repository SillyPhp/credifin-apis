<?php
namespace api\modules\v3\models;
use account\models\online_classes\RtcTokenBuilder;
use common\models\VideoSessions;
use common\models\Utilities;
class TokensModel
{
    public function getToken($options)
    {
        $model = new VideoSessions();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->session_enc_id = $utilitiesModel->encrypt();
        $model->app_id = '9c38705a1b9542b1a1ccbf7edd7200c4';
        $model->channel_name = $options['user_enc_id'];
        $model->created_by = $options['user_enc_id'];
        $model->session_token = $this->genrateToken($model->app_id,$model->channel_name,'9ed4669b46c0408686ff5f70d29d2db7');
        if ($model->save())
        {
            return [
                'status'=>true,
                'session_id'=>$model->session_enc_id
            ];
        }
        else
        {
            return [
                'status'=>false,
            ];
        }
    }
    private function genrateToken($appID,$channelName,$appCertificate){
        $uid = 0;
        $uidStr = null;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new \DateTime("now", new \DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $token = \api\modules\v3\models\RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
        return $token;
    }

    public function validateToken($options)
    {
        $model = VideoSessions::find()
            ->where(['is_active' => 1, 'session_enc_id' => $options['tokenId']])
            ->asArray()->one();
        if ($model)
        {
            return [
                'status'=>true,
                'app_id'=>$model['app_id'],
                'channel_name'=>$model['channel_name'],
                'token'=>$model['session_token'],
            ];
        }
        else
        {
            return [
                'status'=>false
            ];
        }
    }
}