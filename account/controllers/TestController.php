<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller {

    public function actionKeys() {
        if ((int) Yii::$app->request->get('n')) {
            for ($i = 1; $i <= Yii::$app->request->get('n'); $i++) {
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                echo $utilitiesModel->encrypt() . '<br>';
            }
        }
    }

}
