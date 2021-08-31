<?php

namespace frontend\controllers;

use common\models\VideoSessions;
use common\models\Webinar;
use common\models\WebinarEvents;
use common\models\WebinarRegistrations;
use common\models\Webinars;
use common\models\WebinarSessions;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use common\models\Utilities;

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
            return $this->renderAjax('generate-session', ['user_id' => $user_id, 'id' => $id]);
        }

        return $this->renderAjax('broadcast', ['tokenId' => $data->session_id]);
    }

    public function actionAudience($id)
    {
        $user_id = Yii::$app->user->identity->user_enc_id;
        $webinar_id = WebinarEvents::findOne(['session_enc_id' => $id])['webinar_enc_id'];
        $chkRegistration = WebinarRegistrations::findOne(['created_by' => $user_id, 'webinar_enc_id' => $webinar_id, 'status' => 1]);
        $webinar = Webinar::findOne(['webinar_enc_id' => $webinar_id]);
        if (empty($chkRegistration) && !(int)$webinar->price) {

            self::webinarRegistration($user_id, $webinar_id);

        }
        $this->layout = 'blank-layout';
        if ($id) {
            return $this->render('multi-view', ['tokenId' => $id]);
        } else {
            return 'Access Denied';
        }
    }

    private function webinarRegistration($user_id, $webinar_id)
    {
        $model = new WebinarRegistrations();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $model->register_enc_id = $utilitiesModel->encrypt();
        $model->webinar_enc_id = $webinar_id;
        $model->status = 1;
        $model->created_by = $user_id;
        $model->created_on = date('Y-m-d h:i:s');
        if ($model->save()) {
            return true;
        }
    }

    public function actionMultiStream($id)
    {
        $data = WebinarSessions::findOne(['session_enc_id' => $id]);
        if (!$data->session_id) {
            $data = $data->webinarEvents;
            foreach ($data as $d) {
                foreach ($d->webinarSpeakers as $speaker) {
                    $user_id = $speaker->speakerEnc->userEnc->user_enc_id;
                    break;
                }
                break;
            }
            return $this->renderAjax('generate-session', ['user_id' => $user_id, 'id' => $id]);
        }
        $this->layout = 'blank-layout';
        $session = Yii::$app->session;
        if (empty($session->get('uid'))) {
            $session->set('uid', Yii::$app->user->identity->id);
        }
        if ($id) {
            return $this->render('multi-stream', ['tokenId' => $id, 'uid' => $session->get('uid')]);
        } else {
            return 'Access Denied';
        }
    }

    public function actionConnect()
    {
        return $this->renderAjax('connect');
    }
}