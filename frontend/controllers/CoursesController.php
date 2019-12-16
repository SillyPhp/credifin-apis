<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class CoursesController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionCoursesList()
    {
        return $this->render('courses-list-page');
    }

}