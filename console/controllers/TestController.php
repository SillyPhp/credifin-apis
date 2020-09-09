<?php

namespace console\controllers;

use common\models\Cities;
use common\models\ShellExceTest;
use Yii;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionTest()
    {
        echo 'ok';
    }

    public function actionXyz()
    {
        $faker = \Faker\Factory::create();
        $model = new ShellExceTest();
        for ($i = 1; $i <= 10; $i++) {
            $model->setIsNewRecord(true);
            $model->id = null;
            $model->name = $faker->word(random_int(1, 3));
            $model->address = $faker->paragraph(random_int(1, 2));
            $model->save(false);
        }
    }

    public function actionTrimSpaces(){
        $cities = Cities::find()->asArray()->all();
        $city_ids = yii\helpers\ArrayHelper::getcolumn($cities, 'id');
        $i=0;
        $j=0;
        $total = count($cities);
        foreach ($city_ids as $id){
            $city = Cities::findOne(['id' => $id]);
            if($city){
                $city->name = trim($city->name);
                if($city->save()){
                    $i++;
                } else {
                    $j++;
                }
            }
        }
        print_r('Updated '.$i.' out of ' . $total);
    }
}