<?php

namespace frontend\controllers;

use frontend\models\onlineClassEnquiries\ClassEnquiryForm;
use Yii;
use yii\web\Controller;

class SchoolsController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $model = new ClassEnquiryForm();
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $model->save();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

}