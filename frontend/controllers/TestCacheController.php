<?php

namespace frontend\controllers;
use common\models\UserOtherDetails;
use frontend\models\applications\PreferencesCards;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TestCacheController extends Controller
{
   public function actionScript()
   {
       return 123;
   }
}