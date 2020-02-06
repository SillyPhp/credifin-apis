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

    public function actionCoursesDetail($id)
    {
        return $this->render('courses-detail-page');
    }

    public function actionGetData(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('id');
            $url = "https://www.udemy.com/api-2.0/courses/" . $id . "?fields[course]=@all";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $header = [
                'Accept: application/json, text/plain, */*',
                'Content-Type: application/json;charset=utf-8',
                'Authorization: Basic c09DMng2QWdMRUp2UE9rNUxxeXEzaGVjdHFZaHVJRVFZazRrc0xHazpLaHdxOEd1Uk9VTENmQW9PZTZjUWpvWWZ0b1hNWWdhQ1dzUG9MMWZLbVZsb3ViYlNlc1FSc3hTYVdSNm51M0UzMVUzM1BRTGs4enFiSDQzeDh0ZDhHR0ZrSWdSVHhHTmM0UWpKS25VVWpTU1ZXTm9sOEI1c2huR3ZENnBYWEFwMQ=='
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            $result = curl_exec($ch);

            return $result;
        }
    }

}