<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class Covid19Controller extends Controller
{
    public function actionPosters()
    {
        return $this->actionSafetyPosters();
    }
    public function actionSafetyPosters()
    {
        return $this->render('warning-posters');
    }
    public function actionWarningPosters()
    {
        return $this->actionSafetyPosters();
    }
}