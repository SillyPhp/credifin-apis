<?php

namespace frontend\controllers;

use frontend\models\applications\PreferredApplicationCards;
use Yii;
use yii\web\Controller;
use frontend\models\FeedbackForm;
use frontend\models\PartnerWithUsForm;
use frontend\models\accounts\LoginForm;
use yii\web\Response;

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

    public function actionPreferredApplicationList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $options = Yii::$app->request->post();
            $cards = PreferredApplicationCards::employerApplications($options);
            if ($cards) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'cards' => $cards,
                    'total' => count($cards),
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }
    }

    public function actionFeatures()
    {
        return $this->render('features');
    }

}