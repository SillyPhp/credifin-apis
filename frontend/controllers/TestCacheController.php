<?php

namespace frontend\controllers;
use common\models\Credentials;
use common\models\RandomColors;
use yii\web\Controller;
use Yii;

class TestCacheController extends Controller
{
    public function actionTokenTest(){
        $options['org_id'] = 'R09YXEkaql0a9WWvJ8Y27531Wdo82J';
        $keys = \common\models\credentials\Credentials::getrazorpayKey($options);
        print_r($keys);
    }
}
