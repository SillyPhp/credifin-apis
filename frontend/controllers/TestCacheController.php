<?php

namespace frontend\controllers;
use frontend\models\applications\PreferencesCards;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TestCacheController extends Controller
{
    public function actionIndex()
    {
        $data = new PreferencesCards();
        print_r($data->getPreferenceCards());
    }
}