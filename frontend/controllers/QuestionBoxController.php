<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

/**
 * Questions Controller
 */
class QuestionBoxController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionDetail($slug=null){
        return $this->render('question-detail-page');
    }

    public function actionList(){
        return $this->render('question-landing-page');
    }
}