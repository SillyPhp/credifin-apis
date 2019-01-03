<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Utilities;

class TestController extends Controller
{

//    public function actionKeys()
//    {
//        $number = Yii::$app->request->get('n');
//
//        for ($i = 1; $i <= $number; $i++) {
//            $utilitiesModel = new Utilities();
//            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
//            $return .= $utilitiesModel->encrypt() . '<br>';
//        }
//        return $return;
//    }

    public function actionUpdate()
    {
        $utilitiesModel = new Utilities();
        $records = \common\models\ApplicationTypes::find()->all();
        foreach ($records as $record) {
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $record->application_type_enc_id = $utilitiesModel->encrypt();
            if(!$record->update(false)) {
                print_r($record->getErrors());
            }
        }
    }

}