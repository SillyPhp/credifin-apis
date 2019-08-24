<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\FeedbackForm;
use frontend\models\PartnerWithUsForm;

class EmployersController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->requestedRoute);
        Yii::$app->seo->setSeoByRoute(Yii::$app->requestedRoute, $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $feedbackFormModel = new FeedbackForm();
        $partnerWithUsModel = new PartnerWithUsForm();

        return $this->render('index', [
            'feedbackFormModel' => $feedbackFormModel,
            'partnerWithUsModel' => $partnerWithUsModel,
        ]);
    }

    public function actionFeatures()
    {
        return $this->render('features');
    }

}