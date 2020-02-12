<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class CoursesController extends Controller
{

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $url = "https://www.udemy.com/api-2.0/courses/?page=1&page_size=6";
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
        return $this->render('index');
    }

    public function actionCoursesList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $cat = Yii::$app->request->post('cat');
            $keyword = Yii::$app->request->post('keyword');
            $page = Yii::$app->request->post('page');
            if($keyword || $cat){
                if($cat){
                    $keyword = $cat;
                }
                $url = "https://www.udemy.com/api-2.0/courses/?page=".$page."&page_size=21&search=" .$keyword;
            } else {
                $url = "https://www.udemy.com/api-2.0/courses/?page=".$page."&page_size=21";
            }
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

    public function actionSearch($q = null)
    {
//        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $url = "https://www.udemy.com/api-2.0/courses/?page=1&page_size=20&search=" . $q;
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