<?php

namespace frontend\controllers;
use common\models\JsonMachine\JsonMachine;
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

    public function actionGetJobs()
    {
        $url = "https://data.usajobs.gov/api/search?JobCategoryCode=2210&ResultsPerPage=100";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $header = [
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization-Key: ePz5DRXvkE/1XaIu++wGwe5EzgmvM3jNTbHRe9dGMRM='
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        $fp = fopen(Yii::$app->params->upload_directories->resume->file_path.DIRECTORY_SEPARATOR.'results.json', 'w');
        fwrite($fp,$result);
        fclose($fp);
    }
    public function actionDetail($familyid=null,$objectid=null)
    {
        $e = fopen(Yii::$app->params->upload_directories->resume->file_path.DIRECTORY_SEPARATOR.'results.json','r');
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
           $e = fopen(Yii::$app->params->upload_directories->resume->file_path.DIRECTORY_SEPARATOR.'results.json','r');
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
                  $get[$i]['PositionLocation'] = $val['MatchedObjectDescriptor']['PositionLocation'][0]['LocationName'];
                  $get[$i]['JobCategory'] = $val['MatchedObjectDescriptor']['JobCategory'][0]['Code'];
                  $get[$i]['MatchedObjectId'] = $val['MatchedObjectId'];
                   $i++;
               }
           }
           fclose($e);
           return json_encode($get);
        }
    }

    public function actionTest()
    {
        $e = fopen(Yii::$app->params->upload_directories->resume->file_path.DIRECTORY_SEPARATOR.'results.json','r');
        $v = fgets($e);
        $v = json_decode($v,true);
        fclose($e);
        foreach ($v['SearchResult']['SearchResultItems'] as $key => $val)
        {
            if ($key>=0 && $key<=20) {
                $v[] = $val;
            }
        }
        print_r($v);
    }

}