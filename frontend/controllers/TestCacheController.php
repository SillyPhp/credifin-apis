<?php

namespace frontend\controllers;

use common\models\AppliedApplicationProcess;
use common\models\AppliedApplications;
use common\models\AssignedCategories;
use common\models\Auth;
use common\models\CollegeCoursesPool;
use common\models\CollegeSettings;
use common\models\CollegeStreams;
use common\models\EmployerApplications;
use common\models\ErexxSettings;
use common\models\InterviewProcessFields;
use common\models\Organizations;
use common\models\User;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\UserOtherDetails;
use common\models\UserResume;
use common\models\Users;
use common\models\Utilities;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use Yii;

class TestCacheController extends Controller
{
    public function actionTest()
    {
        try {
            $model = new Auth();
            $model->user_id = 12;
            if (!$model->save()) //model errors
            {
                throw new \Exception (implode("<br />", \yii\helpers\ArrayHelper::getColumn($model->errors, 0, false)));
            }

            //some kind of err
        } catch (\Exception $exception) {
            return $exception->getMessage(); //final messege for user
        }
    }

    public function actionCourses(){
        // your client's IP Address
        $url = "https://ipinfo.io/".Yii::$app->request->remoteIP;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $header = [
            'Accept: application/json, text/plain, */*',
            'Content-Type: application/json;charset=utf-8',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        $result = json_decode($result);
        $url = "https://www.udemy.com/api-2.0/courses/?page=1&page_size=6&fields[course]=title,price,is_paid,visible_instructors,discount";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_COOKIE, '__udmy_2_v57r=; ud_cache_price_country='.$result->country.';');
        $header = [
            'Accept: application/json, text/plain, */*',
            'Content-Type: application/json;charset=utf-8',
            'Authorization: Basic c09DMng2QWdMRUp2UE9rNUxxeXEzaGVjdHFZaHVJRVFZazRrc0xHazpLaHdxOEd1Uk9VTENmQW9PZTZjUWpvWWZ0b1hNWWdhQ1dzUG9MMWZLbVZsb3ViYlNlc1FSc3hTYVdSNm51M0UzMVUzM1BRTGs4enFiSDQzeDh0ZDhHR0ZrSWdSVHhHTmM0UWpKS25VVWpTU1ZXTm9sOEI1c2huR3ZENnBYWEFwMQ=='
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $result = curl_exec($ch);
        $result = json_decode($result);
        print_r($result);
    }

    public function actionCatching(){
        return 12;
    }
}
