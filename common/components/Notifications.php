<?php

namespace common\components;

use common\models\UserPreferences;
use Yii;
use yii\db\Query;
use yii\base\Component;
use common\models\Utilities;


class Notifications extends Component
{
    public function matchPreferences($skills, $locations, $app_id){
        $locations = json_decode($locations);
        $locationsArr = [];
        foreach ($locations as $l){
            array_push($locationsArr, $l->name);
        }
        $locationsArr = array_values($locationsArr);
        $skills=array_unique(json_decode($skills, true));

        $userSkills=UserPreferences::find()
            ->alias('a')
            ->select(['a.created_by as user_id'])
            ->joinWith(['userPreferredSkills b' => function($b) use($skills){
                $b->select(['b1.skill', 'b.skill_enc_id', 'b.preference_enc_id']);
                $b->joinWith(['skillEnc b1']);
            }],false)
            ->joinWith(['userPreferredLocations c' => function($c) use($locations){
                $c->joinWith(['cityEnc c1']);
            }],false);
            if($skills != null){
                $userSkills->where(['in', 'b1.skill', $skills]);
            }
            if($locations != null){
                $userSkills->andWhere(['in', 'c1.name', $locationsArr]);
            }
            $userSkills = $userSkills->groupBy(['a.created_by'])
            ->asArray()
            ->all();

        foreach ($userSkills as $us){
            $model= new \common\models\Notifications();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->notification_enc_id = $utilitiesModel->encrypt();
            $model->user_enc_id = $us['user_id'];
            $model->application_enc_id = $app_id;
            $model->created_by = Yii::$app->user->identity->user_enc_id;
            if(!$model->save()){
                print_r($model->getErrors());
            }
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