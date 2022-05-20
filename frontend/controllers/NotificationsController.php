<?php

namespace frontend\controllers;
use common\models\Notifications;
use common\models\UserPreferences;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class NotificationsController extends Controller{
    public function actionIndex(){
        return $this->_SendPushNotification();
    }

    public function actionMatchPreferences($skills, $locations, $profile){
         $userSkills=UserPreferences::find()
            ->alias('a')
            ->select(['a.created_by'])
            ->joinWith(['userPreferredSkills b' => function($b) use($skills){
                $b->select(['b1.skill', 'b.skill_enc_id', 'b.preference_enc_id']);
                $b->joinWith(['skillEnc b1']);
            }],false)
            ->joinWith(['userPreferredLocations c' => function($c) use($locations){
                 $c->joinWith(['cityEnc c1']);
            }],false)
            ->joinWith(['userPreferredJobProfiles d' => function($d){
                 $d->joinWith(['jobProfileEnc d1']);
            }],false);
            if($skills != null){
                $userSkills->where(['b1.skill' => $skills]);
            }
            if($locations != null){
                $userSkills->andWhere(['c1.name' => $locations]);
            }
            if($profile != null){
                $userSkills->andWhere(['d1.name' => $profile]);
            }
            $userSkills = $userSkills->groupBy(['a.created_by'])
            ->asArray()
            ->all();

         $user_enc_arr = [];
         foreach ($userSkills as $us){
             $model= new Notifications();
             $model->user_enc_id = $us['created_by'];
             $model->job_enc_id =
             array_push($user_enc_arr, $us['created_by']);
         }

    }

    private function _SendPushNotification($arr){
        $content = array(
            "en" => 'Hello Kulwinder'
        );

        $fields = array(
            'app_id' => "a76531b8-a3c8-442b-a571-907e3e112de4",
            'included_segments'=> ["Subscribe Users"],
            'include_external_user_ids' => $arr,
            'data' => array("foo" => "bar"),
            'contents' => $content,
            "web_url"=> "https://shshank.eygb.me/"
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic YTcxNzQ0ZWYtMTUxMS00YTgwLWIxNGEtMDZhZDhlNzE3MzBj'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        print_r($response);
        return $response;


//        $response = sendMessage();
//        $return["allresponses"] = $response;
        $return = json_encode($return);

        print("\n\nJSON received:\n");
        print($return);
        print("\n");
    }
}