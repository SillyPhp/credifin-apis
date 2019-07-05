<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class CandidatesController extends Controller
{
    public function actionFeatures()
    {
        return $this->render('features');
    }

}