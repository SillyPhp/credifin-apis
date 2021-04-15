<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class SkillupController extends Controller
{

    public function actionCreate()
    {
        return $this->render('create');
    }

}