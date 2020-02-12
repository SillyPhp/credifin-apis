<?php

namespace frontend\controllers;
use common\models\IndianGovtDepartments;
use common\models\IndianGovtJobs;
use common\models\Utilities;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\HttpException;

class QuestionSuggestionController extends Controller
{
    public function actionIndex()
    {
      return $this->render('index');
    }
}