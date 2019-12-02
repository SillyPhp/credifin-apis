<?php

namespace frontend\controllers;

use common\models\UsaDepartments;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\httpclient\Client;
use common\models\JsonMachine\JsonMachine;

class UsaJobsController extends Controller
{
    public function actionIndex($keywords = null)
    {
        return $this->render('index', ['keywords' => $keywords]);
    }

    public function actionGetKeywords()
    {
        if (Yii::$app->request->isAjax) {
            $keywords = Yii::$app->request->post('Keyword');
            $url = "https://data.usajobs.gov/api/search?Keyword=" . $keywords . "&ResultsPerPage=36&DatePosted=45&SortField=PositionTitle&SortDirection=Asc";
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
            $v = json_decode($result, true);
            $i = 0;
            foreach ($v['SearchResult']['SearchResultItems'] as $key => $val) {
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
                $data = UsaDepartments::find()
                    ->select(['image','image_location'])
                    ->where(['Value'=>$get[$i]['DepartmentName']])
                    ->asArray()
                    ->one();
                if (!empty($data['image']) && !empty($data['image_location']))
                {
                    $get[$i]['logo'] = Yii::$app->params->upload_directories->usa_jobs->departments->image.$data['image_location'].DIRECTORY_SEPARATOR.$data['image'];
                }
                else
                {
                    $get[$i]['logo'] = null;
                }
                $i++;
            }
            return json_encode($get);
        }
    }

    public function actionDetail($familyid = null, $objectid = null)
    {
        $e = fopen(Yii::$app->params->upload_directories->jsonFiles->file_path . DIRECTORY_SEPARATOR . $familyid . '.json', 'r');
        $v = fgets($e);
        $v = json_decode($v, true);
        $flag = false;
        foreach ($v['SearchResult']['SearchResultItems'] as $key => $val) {
            if ($val['MatchedObjectId'] == $objectid) {
                $flag = true;
                $get = $val['MatchedObjectDescriptor'];
            }
        }

        if (!$flag)
            return 'not found';
        return $this->render('detail', ['get' => $get,
            'familyid' => $familyid,
            'objectid' => $objectid
        ]);
    }

    public function actionGetData($min = null, $max = null)
    {
        if (Yii::$app->request->isAjax) {
            $e = fopen(Yii::$app->params->upload_directories->jsonFiles->file_path . DIRECTORY_SEPARATOR . 'updated.json', 'r');
            $v = fgets($e);
            $v = json_decode($v, true);
            $min = Yii::$app->request->post('min');
            $max = Yii::$app->request->post('max');
            $i = 0;
            foreach ($v['SearchResult']['SearchResultItems'] as $key => $val) {
                if ($key >= $min && $key <= $max) {
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
                    $data = UsaDepartments::find()
                        ->select(['image','image_location'])
                        ->where(['Value'=>$get[$i]['DepartmentName']])
                        ->asArray()
                        ->one();
                    if (!empty($data['image']) && !empty($data['image_location']))
                    {
                        $get[$i]['logo'] = Yii::$app->params->upload_directories->usa_jobs->departments->image.$data['image_location'].DIRECTORY_SEPARATOR.$data['image'];
                    }
                    else
                    {
                        $get[$i]['logo'] = null;
                    }
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

    public function actionFederal(){

        return $this->render('federal');
    }

    public function actionMilitary(){

        return $this->render('military');
    }

    public function actionIndividualsWithDisabilities(){

        return $this->render('individuals-with-disabilities');
    }

    public function actionNativeAmericans(){
        return $this->render('native-americans');
    }

    public function actionStudentsRecentGraduates(){

        return $this->render('students-recent-graduates');
    }

    public function actionSpecialAuthorities(){

        return $this->render('special-authorities');
    }

    public function actionThePublic(){

        return $this->render('the-public');
    }

    public function actionNationalGuardReserves(){
        return $this->render('national-guard-reserves');
    }

    public function actionPeaceCorps(){
        return $this->render('peace-corps');
    }

    public function actionOverseasEmployees(){
        return $this->render('overseas-employees');
    }

    public function actionVeterans(){
        return $this->render('veterans');
    }

    public function actionSeniorExecutives(){
        return $this->render('senior-executives');
    }

    public function actionDepartments(){
        return $this->render('departments');
    }

    public function actionGetDepartments()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $limit = Yii::$app->request->post('limit');
            $d = UsaDepartments::find()
                ->select(['Value','total_applications','CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->usa_jobs->departments->image) . '", image_location, "/", image) ELSE NULL END logo'])
                ->asArray()
                ->orderBy(['total_applications' => SORT_DESC])
                ->limit($limit)
                ->all();
            return [
                'status'=>200,
                'cards'=>$d
            ];
        }
    }
}