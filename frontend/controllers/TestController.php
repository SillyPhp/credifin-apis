<?php

namespace frontend\controllers;
use common\models\UserOtherDetails;
use frontend\models\applications\PreferencesCards;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TestController extends Controller
{
    public function actionClearMyCache()
    {
        $cache = Yii::$app->cache->flush();

        if ($cache) {
            $this->redirect(Yii::$app->request->referrer);
        } else {
            $this->redirect('/jobs/clear-my-cache');
            return 'something went wrong...! please try again later';
        }
    }
}