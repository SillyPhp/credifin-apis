<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\FeedbackForm;
use frontend\models\PartnerWithUsForm;
use frontend\models\accounts\LoginForm;

class EmployersController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $feedbackFormModel = new FeedbackForm();
        $partnerWithUsModel = new PartnerWithUsForm();
        $loginFormModel = new LoginForm();

        return $this->render('index', [
            'feedbackFormModel' => $feedbackFormModel,
            'partnerWithUsModel' => $partnerWithUsModel,
            'loginFormModel' => $loginFormModel,
        ]);
    }

    public function actionFeatures()
    {
        return $this->render('features');
    }

}