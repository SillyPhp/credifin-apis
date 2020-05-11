<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class TrendsController extends Controller {

    public function actionIndex(){
        return $this->render('news-list');
    }
}