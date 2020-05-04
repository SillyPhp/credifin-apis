<?php

namespace frontend\controllers;
use common\models\VideoSessions;
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
        if ($id) {
            return $this->renderAjax('view', ['tokenId' => $id]);
        }
    }

    public function actionBroadcast($id)
    {
        if ($id) {
            return $this->renderAjax('broadcast', ['tokenId' => $id]);
        }
    }

    public function actionAudience($id)
    {
        if ($id) {
            return $this->renderAjax('multi-view', ['tokenId' => $id]);
        }
    }

    public function actionMultiStream($id)
    {
        $session = Yii::$app->session;
        if (empty($session->get('uid'))) {
            $session->set('uid',rand(100,1000));
        }
        if ($id) {
            return $this->renderAjax('multi-stream', ['tokenId' => $id,'uid'=>$session->get('uid')]);
        }
    }

    public function actionConnect()
    {
        return $this->renderAjax('connect');
    }
}