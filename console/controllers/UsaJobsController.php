<?php

namespace console\controllers;
use common\models\UsaProfileCodes;
use Yii;
use yii\console\Controller;

class UsaJobsController extends Controller
{
    public function actionGetJobs($offset=680,$code_limit=10,$result_limit=200)
    {
        $path = '/home2/cds73inc/public_html/Employees/Sneh/EYGBME/files/users/resume/STVzyMfVOnGfaDtdbtAVCvW4s6ohZAiz/';
        $model = UsaProfileCodes::find()
            ->select(['id','Profile_Code'])
            ->orderBy(['id'=>SORT_ASC])
            ->limit($code_limit)
            ->offset($offset)
            ->asArray()
            ->all();
        $flag = 0;
        foreach ($model as $m) {
            $url = "https://data.usajobs.gov/api/search?JobCategoryCode=" . $m['Profile_Code'] . "&ResultsPerPage=" . $result_limit."&DatePosted=45&SortField=PositionTitle&SortDirection=Asc";
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
            $tcount = json_decode($result,true);
            $tcount = $tcount['SearchResult']['SearchResultCount'];
            $update = Yii::$app->db->createCommand()
                ->update(UsaProfileCodes::tableName(), ['Total_Jobs' => $tcount], ['Profile_Code' => $m['Profile_Code']])
                ->execute();
            $fp = fopen($path. $m['Profile_Code'] . '.json', 'w');
            fwrite($fp, $result);
            fclose($fp);
            $flag++;
        }
        echo $flag;
    }

    public function actionUpdate($result_limit=500)
    {
        $path = '/home2/cds73inc/public_html/Employees/Sneh/EYGBME/files/users/resume/STVzyMfVOnGfaDtdbtAVCvW4s6ohZAiz/';
        $flag = 0;
            $url = "https://data.usajobs.gov/api/search?ResultsPerPage=" . $result_limit."&DatePosted=45&SortField=PositionTitle&SortDirection=Asc";
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
            $fp = fopen($path.'updated.json', 'w');
            fwrite($fp, $result);
            fclose($fp);
            $flag++;
        echo $flag;
    }

    public function actionIndex()
    {
        echo 'my new ';
    }
}