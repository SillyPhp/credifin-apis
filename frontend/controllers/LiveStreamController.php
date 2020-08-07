<?php

namespace frontend\controllers;

use common\models\VideoSessions;
use common\models\Webinars;
use common\models\WebinarSessions;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\db\Query;

class LiveStreamController extends Controller
{
    public function actionView($id)
    {
        $session_id = WebinarSessions::findOne(['session_enc_id' => $id])['session_id'];
        if ($session_id) {
            return $this->renderAjax('view', ['tokenId' => $session_id]);
        } else {
            $webinar = Webinars::findOne(['session_enc_id' => $id]);
            return $this->renderAjax('webinar-view', ['webinar' => $webinar]);
        }
    }

    public function actionBroadcast($id)
    {
        $data = WebinarSessions::findOne(['session_enc_id' => $id]);
        if (!$data->session_id) {
            $data = $data->webinars;
            foreach ($data as $d) {
                foreach ($d->webinarSpeakers as $speaker) {
                    $user_id = $speaker->speakerEnc->userEnc->user_enc_id;
                    break;
                }
                break;
            }
            return $this->render('generate-session', ['user_id' => $user_id, 'id' => $id]);
        }

        return $this->renderAjax('broadcast', ['tokenId' => $data->session_id]);
    }
}