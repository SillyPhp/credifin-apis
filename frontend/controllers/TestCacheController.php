<?php
namespace frontend\controllers;
use yii\web\Controller;
use common\models\Utilities;
use Yii;
class TestCacheController extends Controller
{
    public function actionTestQuery()
    {
      return Yii::$app->params->sendGrid->apiKey;
    }
}