<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;
use yii\helpers\Url;

class FramedWidgetsController extends Controller
{
  public $layout = 'blank-layout';
  public function actionEducationsLoan()
   {
       return $this->render('education-loan');
   }
}