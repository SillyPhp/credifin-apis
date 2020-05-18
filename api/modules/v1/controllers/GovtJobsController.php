<?php


namespace api\modules\v1\controllers;

use common\models\UsaDepartments;
use Yii;
use yii\helpers\Url;

class GovtJobsController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'us-departments' => ['POST'],
                'us-jobs' => ['POST'],
                'usa-jobs-detail' => ['POST'],
                'get-dept-cards' => ['POST'],
            ]
        ];
        return $behaviors;
    }

    public function actionUsDepartments()
    {
        $params = Yii::$app->request->post();

        if (isset($params['limit']) && !empty($params['limit'])) {
            $limit = $params['limit'];
        } else {
            $limit = 4;
        }

        if (isset($params['page']) && !empty($params['page'])) {
            $page = $params['page'];
        } else {
            $page = 1;
        }

        $d = UsaDepartments::find()
            ->select(['Value', 'slug', 'total_applications', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->usa_jobs->departments->image, 'https') . '", image_location, "/", image) ELSE NULL END logo'])
            ->asArray()
            ->orderBy(['total_applications' => SORT_DESC])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->all();

        if ($d) {
            return $this->response(200, $d);
        } else {
            return $this->response(404, 'Not Found');
        }
    }

    public function actionUsJobs()
    {
        $params = Yii::$app->request->post();

        if (isset($params['min']) && !empty($params['min'])) {
            $min = $params['min'];
        } else {
            $min = 0;
        }

        if (isset($params['max']) && !empty($params['max'])) {
            $max = $params['max'];
        } else {
            $max = 8;
        }

        $e = fopen(Yii::$app->params->upload_directories->jsonFiles->file_path . DIRECTORY_SEPARATOR . 'updated.json', 'r');
//            $e = fopen('updated.json', 'r');
        $v = fgets($e);
        $v = json_decode($v, true);
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
                    ->select(['image', 'image_location'])
                    ->where(['Value' => $get[$i]['DepartmentName']])
                    ->asArray()
                    ->one();
                if (!empty($data['image']) && !empty($data['image_location'])) {
                    $get[$i]['logo'] = Url::to(Yii::$app->params->upload_directories->usa_jobs->departments->image . $data['image_location'] . DIRECTORY_SEPARATOR . $data['image'], 'https');
                } else {
                    $get[$i]['logo'] = null;
                }
                $i++;
            }
        }
        fclose($e);

        if ($get) {
            return $this->response(200, $get);
        } else {
            return $this->response(404, 'Not Found');
        }
    }

    private function getCityName($string)
    {
        //Get the first occurrence of a character.
        $strpos = strpos($string, ',');
        $stringSplit1 = substr($string, 0, $strpos);
        return trim($stringSplit1);
    }

    public function actionUsaJobsDetail()
    {
        $params = Yii::$app->request->post();

        if (isset($params['category_id']) && isset($params['object_id'])) {
            $familyid = $params['category_id'];
            $objectid = $params['object_id'];
        } else {
            return $this->response(422, 'missing information');
        }

        $e = fopen(Yii::$app->params->upload_directories->jsonFiles->file_path . DIRECTORY_SEPARATOR . $familyid . '.json', 'r');
        $v = fgets($e);
        $v = json_decode($v, true);
        $flag = false;
        foreach ($v['SearchResult']['SearchResultItems'] as $key => $val) {
            if ($val['MatchedObjectId'] == $objectid) {
                $flag = true;
                $get = $val['MatchedObjectDescriptor'];
                $data = [];
                $data['DepartmentName'] = $get['DepartmentName'];
                $data['PositionTitle'] = $get['PositionTitle'];
                $data['PositionSchedule'] = $get['PositionSchedule'][0]['Name'];
                $data['PositionLocationDisplay'] = $get['PositionLocationDisplay'];
                $data['PositionStartDate'] = $get['PositionStartDate'];
                $data['PositionEndDate'] = $get['PositionEndDate'];
                $data['PositionRemuneration'] = $get['PositionRemuneration'];
                $data['Service'] = 'Excepted';
                $data['PositionOfferingType'] = $get['PositionOfferingType'][0]['Name'];
                $data['QualificationSummary'] = $get['QualificationSummary'];
                $data['PositionLocation'] = $get['PositionLocation'];
                $data['OrganizationName'] = $get['OrganizationName'];
                $data['PositionID'] = $get['PositionID'];
                $data['ApplyURI'] = $get['ApplyURI'][0];
                $data['PositionURI'] = $get['PositionURI'];
                $data['UserArea'] = $get['UserArea'];

                if ($get['UserArea']['Details']['LowGrade'] != $get['UserArea']['Details']['HighGrade']){
                    $data['JobGrade'] = $get['JobGrade'][0]['Code'] . " " . $get['UserArea']['Details']['LowGrade'] . "-" . $get['UserArea']['Details']['HighGrade'];
                }else{
                    $data['JobGrade'] = $get['JobGrade'][0]['Code'] . " " . $get['UserArea']['Details']['HighGrade'];
                }
            }
        }

        if (!$flag) {
            return $this->response(404, 'not found');
        } else {
            return $this->response(200, $data   );
        }
    }

    public function actionGetDeptCards()
    {
        $params = Yii::$app->request->post();
        if (isset($params['slug']) && !empty($params['slug'])) {
            $keywords = $params['slug'];
        } else {
            return $this->response(422, 'missing information');
        }

        $keywords = explode('-', $keywords);
        $keywords = strtoupper(end($keywords));

        $url = "https://data.usajobs.gov/api/search?Organization=" . $keywords . "&ResultsPerPage=36&DatePosted=45&SortField=PositionTitle&SortDirection=Asc";
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
                ->select(['image', 'image_location'])
                ->where(['Value' => $get[$i]['DepartmentName']])
                ->asArray()
                ->one();
            if (!empty($data['image']) && !empty($data['image_location'])) {
                $get[$i]['logo'] = Url::to(Yii::$app->params->upload_directories->usa_jobs->departments->image,'https') . $data['image_location'] . DIRECTORY_SEPARATOR . $data['image'];
            } else {
                $get[$i]['logo'] = null;
            }
            $i++;
        }

        if($get){
            return $this->response(200,$get);
        }else{
            return $this->response(404,'not found');
        }
    }


}