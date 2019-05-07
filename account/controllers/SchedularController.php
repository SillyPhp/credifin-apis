<?php
namespace account\controllers;

use Yii;
use yii\web\Controller;

class SchedularController extends Controller
{
    public function actionTest(){
        return $this->render('test');
    }
}