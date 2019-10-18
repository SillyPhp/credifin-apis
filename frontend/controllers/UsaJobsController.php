<?php

namespace frontend\controllers;
use common\models\JsonMachine\JsonMachine;
use common\models\UsaProfileCodes;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\httpclient\Client;

class UsaJobsController extends Controller
{
    public function actionIndex($keywords=null)
    {
        return $this->render('index',['keywords'=>$keywords]);
    }

    public function actionDetail($familyid=null,$objectid=null)
    {
        $e = fopen(Yii::$app->params->upload_directories->resume->file_path.DIRECTORY_SEPARATOR.$familyid.'.json','r');
        $v = fgets($e);
        $v = json_decode($v,true);
        $flag = false;
        foreach ($v['SearchResult']['SearchResultItems'] as $key => $val)
        {
            if ($val['MatchedObjectId']==$objectid)
            {
                $flag = true;
                $get = $val['MatchedObjectDescriptor'];
            }
        }

        if (!$flag)
            return 'not found';
        return $this->render('detail',['get'=>$get,
            'familyid'=>$familyid,
            'objectid'=>$objectid
        ]);
    }
    public function actionGetData($min=null,$max=null)
    {
        if (Yii::$app->request->isAjax){
           //$v = file_get_contents('results.json');
           $e = fopen(Yii::$app->params->upload_directories->resume->file_path.DIRECTORY_SEPARATOR.'updated.json','r');
           $v = fgets($e);
           $v = json_decode($v,true);
           $min = Yii::$app->request->post('min');
           $max = Yii::$app->request->post('max');
            $i= 0 ;
           foreach ($v['SearchResult']['SearchResultItems'] as $key => $val)
           {
               if ($key>=$min && $key<=$max) {
                  $get[$i]['DepartmentName'] = $val['MatchedObjectDescriptor']['OrganizationName'];
                  $get[$i]['PositionTitle'] = $val['MatchedObjectDescriptor']['PositionTitle'];
                  $get[$i]['MinimumRange'] = $val['MatchedObjectDescriptor']['PositionRemuneration'][0]['MinimumRange'];
                  $get[$i]['MaximumRange'] = $val['MatchedObjectDescriptor']['PositionRemuneration'][0]['MaximumRange'];
                  $get[$i]['ApplicationCloseDate'] = date("d-m-Y", strtotime($val['MatchedObjectDescriptor']['ApplicationCloseDate']));
                  $get[$i]['PositionLocation'] = $this->getCityName($val['MatchedObjectDescriptor']['PositionLocationDisplay']);
                  $get[$i]['Location'] = $val['MatchedObjectDescriptor']['PositionLocationDisplay'];
                  $get[$i]['JobCategory'] = $val['MatchedObjectDescriptor']['JobCategory'][0]['Code'];
                  $get[$i]['MatchedObjectId'] = $val['MatchedObjectId'];
                  $get[$i]['Duration'] = $val['MatchedObjectDescriptor']['PositionRemuneration'][0]['RateIntervalCode'];
                   $i++;
               }
           }
           fclose($e);
           return json_encode($get);
        }
    }

    private function getCityName($string)
    {
        //Get the first occurrence of a character.
        $strpos = strpos($string, ',');
        $stringSplit1 = substr($string, 0, $strpos);
        return trim($stringSplit1);
    }

}