<?php

namespace account\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
class QuizController extends Controller
{
    public function actionDashboard(){
        return $this->render('dashboard');
    }
    public function actionCreate(){
        $categories = $this->_data('Groups');
        $sub = $this->_data('Subject');
        $rec_topics = $this->_topics(1);
        $user_topics = $this->_topics(0);
        return $this->render('create-quiz-multi',['categories'=>$categories,'subject'=>$sub]);
    }

    public function actionAddGroups()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $d = Yii::$app->request->post('data');
            $model = new QuizModel();
            $res = $model->addGrp($d);
            if ($res)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}