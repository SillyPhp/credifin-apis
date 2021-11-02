<?php


namespace api\modules\v1\controllers;

use common\models\IndianGovtDepartments;
use common\models\IndianGovtJobs;
use common\models\UsaDepartments;
use frontend\models\applications\ApplicationCards;
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
                'in-departments' => ['POST'],
                'in-dept-jobs' => ['POST'],
                'in-job-detail' => ['POST'],
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
            ->select(['Value', 'slug', 'total_applications', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->usa_jobs->departments->image, 'https') . '", image_location, "/", image) ELSE CONCAT("https://ui-avatars.com/api/?name=", value, "&size=200&rounded=false&background=random&color=ffffff") END logo'])
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
        $v = fgets($e);
        $v = json_decode($v, true);
        $i = 0;
        foreach ($v['SearchResult']['SearchResultItems'] as $key => $val) {
            if ($key >= $min && $key <= $max) {
                $desc = $val['MatchedObjectDescriptor'];
                $pos = $desc['PositionRemuneration'][0];
                $get[$i]['DepartmentName'] = $desc['OrganizationName'];
                $get[$i]['PositionTitle'] = $desc['PositionTitle'];
                $get[$i]['MinimumRange'] = $pos['MinimumRange'];
                $get[$i]['MaximumRange'] = $pos['MaximumRange'];
                $get[$i]['ApplicationCloseDate'] = date("d-m-Y", strtotime($desc['ApplicationCloseDate']));
                $get[$i]['PositionLocation'] = $this->getCityName($desc['PositionLocationDisplay']);
                $get[$i]['Location'] = $desc['PositionLocationDisplay'];
                $get[$i]['JobCategory'] = $desc['JobCategory'][0]['Code'];
                $get[$i]['MatchedObjectId'] = $val['MatchedObjectId'];
                $get[$i]['Duration'] = $pos['RateIntervalCode'];
                $get[$i]['salary'] = 'View in Details';
                if ($pos['MinimumRange'] || $pos['MaximumRange']) {
                    $get[$i]['salary'] = '';
                    if ($pos['MinimumRange']) {
                        $get[$i]['salary'] .= '$' . $pos['MinimumRange'];
                    }
                    if ($pos['MinimumRange'] && $pos['MaximumRange']) {
                        $get[$i]['salary'] .= ' - ';
                    }
                    if ($pos['MinimumRange']) {
                        $get[$i]['salary'] .= '$' . $pos['MinimumRange'];
                    }
                    if ($pos['RateIntervalCode']) {
                        $get[$i]['salary'] .= ' ' . $pos['RateIntervalCode'];
                    }
                }
                $data = UsaDepartments::find()
                    ->select(['image', 'image_location'])
                    ->where(['Value' => $get[$i]['DepartmentName']])
                    ->asArray()
                    ->one();
                if (!empty($data['image']) && !empty($data['image_location'])) {
                    $get[$i]['logo'] = Url::to(Yii::$app->params->upload_directories->usa_jobs->departments->image . $data['image_location'] . DIRECTORY_SEPARATOR . $data['image'], 'https');
                } else {
                    $get[$i]['logo'] = "https://ui-avatars.com/api/?name=" . $get[$i]['DepartmentName'] . "&size=200&rounded=false&background=random&color=ffffff";
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

                if ($get['UserArea']['Details']['LowGrade'] != $get['UserArea']['Details']['HighGrade']) {
                    $data['JobGrade'] = $get['JobGrade'][0]['Code'] . " " . $get['UserArea']['Details']['LowGrade'] . "-" . $get['UserArea']['Details']['HighGrade'];
                } else {
                    $data['JobGrade'] = $get['JobGrade'][0]['Code'] . " " . $get['UserArea']['Details']['HighGrade'];
                }
            }
        }

        if (!$flag) {
            return $this->response(404, 'not found');
        } else {
            return $this->response(200, $data);
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
            $desc = $val['MatchedObjectDescriptor'];
            $pos = $desc['PositionRemuneration'][0];
            $get[$i]['DepartmentName'] = $desc['OrganizationName'];
            $get[$i]['PositionTitle'] = $desc['PositionTitle'];
            $get[$i]['MinimumRange'] = $pos['MinimumRange'];
            $get[$i]['MaximumRange'] = $pos['MaximumRange'];
            $get[$i]['ApplicationCloseDate'] = date("d-m-Y", strtotime($desc['ApplicationCloseDate']));
            $get[$i]['PositionLocation'] = $this->getCityName($desc['PositionLocationDisplay']);
            $get[$i]['Location'] = $desc['PositionLocationDisplay'];
            $get[$i]['JobCategory'] = $desc['JobCategory'][0]['Code'];
            $get[$i]['MatchedObjectId'] = $val['MatchedObjectId'];
            $get[$i]['Duration'] = $pos['RateIntervalCode'];
            $get[$i]['salary'] = 'View in Details';
            if ($pos['MinimumRange'] || $pos['MaximumRange']) {
                $get[$i]['salary'] = '';
                if ($pos['MinimumRange']) {
                    $get[$i]['salary'] .= '$' . $pos['MinimumRange'];
                }
                if ($pos['MinimumRange'] && $pos['MaximumRange']) {
                    $get[$i]['salary'] .= ' - ';
                }
                if ($pos['MinimumRange']) {
                    $get[$i]['salary'] .= '$' . $pos['MinimumRange'];
                }
                if ($pos['RateIntervalCode']) {
                    $get[$i]['salary'] .= ' ' . $pos['RateIntervalCode'];
                }
            }
            $data = UsaDepartments::find()
                ->select(['image', 'image_location'])
                ->where(['Value' => $get[$i]['DepartmentName']])
                ->asArray()
                ->one();
            if (!empty($data['image']) && !empty($data['image_location'])) {
                $get[$i]['logo'] = Url::to(Yii::$app->params->upload_directories->usa_jobs->departments->image, 'https') . $data['image_location'] . DIRECTORY_SEPARATOR . $data['image'];
            } else {
                $get[$i]['logo'] = "https://ui-avatars.com/api/?name=" . $get[$i]['DepartmentName'] . "&size=200&rounded=false&background=random&color=ffffff";;
            }
            $i++;
        }

        if ($get) {
            return $this->response(200, $get);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionUsDeptDetail()
    {

        $params = Yii::$app->request->post();
        if (isset($params['slug']) && !empty($params['slug'])) {
            $slug = $params['slug'];
        } else {
            return $this->response(422, 'missing information "slug"');
        }

        $d = UsaDepartments::find()
            ->select(['Value', 'slug', 'total_applications', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->usa_jobs->departments->image, 'https') . '", image_location, "/", image) ELSE CONCAT("https://ui-avatars.com/api/?name=", value, "&size=200&rounded=false&background=random&color=ffffff") END logo'])
            ->where(['slug' => $slug])
            ->asArray()
            ->one();

        if ($d) {
            return $this->response(200, $d);
        } else {
            return $this->response(404, 'Not Found');
        }
    }

    public function actionSearchUsaJobs()
    {

        $params = Yii::$app->request->post();
        if (isset($params['keyword']) && !empty($params['keyword'])) {
            $keywords = $params['keyword'];
        } else {
            return $this->response(422, 'missing information');
        }

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
                ->select(['image', 'image_location'])
                ->where(['Value' => $get[$i]['DepartmentName']])
                ->asArray()
                ->one();
            if (!empty($data['image']) && !empty($data['image_location'])) {
                $get[$i]['logo'] = Url::to(Yii::$app->params->upload_directories->usa_jobs->departments->image, 'https') . $data['image_location'] . DIRECTORY_SEPARATOR . $data['image'];
            } else {
                $get[$i]['logo'] = "https://ui-avatars.com/api/?name=" . $get[$i]['DepartmentName'] . "&size=200&rounded=false&background=random&color=ffffff";;
            }
            $i++;
        }

        if ($get) {
            return $this->response(200, $get);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionInDepartments()
    {
        $params = Yii::$app->request->post();

        if (isset($params['limit']) && !empty($params['limit'])) {
            $limit = $params['limit'];
        } else {
            $limit = 10;
        }

        if (isset($params['page']) && !empty($params['page'])) {
            $page = $params['page'];
        } else {
            $page = 1;
        }

        $data = IndianGovtDepartments::find()
            ->select(['dept_enc_id dept_id', 'Value', 'total_applications', 'slug', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->indian_jobs->departments->image, 'https') . '", image_location, "/", image) ELSE CONCAT("https://ui-avatars.com/api/?name=", value, "&size=200&rounded=false&background=random&color=ffffff") END logo'])
            ->asArray()
            ->orderBy(['total_applications' => SORT_DESC])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->all();
        if ($data) {
            return $this->response(200, $data);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionInDeptDetail()
    {
        $params = Yii::$app->request->post();

        if (isset($params['dept_id']) && !empty($params['dept_id'])) {
            $dept_id = $params['dept_id'];
        } else {
            return $this->response(422, 'missing information "dept_id"');
        }

        $data = IndianGovtDepartments::find()
            ->select(['dept_enc_id dept_id', 'Value', 'total_applications', 'slug', 'CASE WHEN image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->indian_jobs->departments->image, 'https') . '", image_location, "/", image) ELSE CONCAT("https://ui-avatars.com/api/?name=", value, "&size=200&rounded=false&background=random&color=ffffff") END logo'])
            ->Where(['or', ['dept_enc_id' => $dept_id], ['slug' => $dept_id]])
            ->asArray()
            ->one();

        if ($data) {
            return $this->response(200, $data);
        } else {
            return $this->response(404, 'not found');
        }

    }

    public function actionInJobs()
    {

        $params = Yii::$app->request->post();

        if (isset($params['limit']) && !empty($params['limit'])) {
            $limit = $params['limit'];
        } else {
            $limit = 10;
        }

        if (isset($params['page']) && !empty($params['page'])) {
            $page = $params['page'];
        } else {
            $page = 1;
        }

        $keywords = $params['keywords'];
        $search = trim($keywords, " ");
        $search_pattern = $this->makeSQL_search_pattern($search);
        $data = IndianGovtJobs::find()
            ->alias('a')
            ->select(['a.job_id id', 'c.slug company_slug',
//                'CASE WHEN a.image IS NOT NULL THEN CONCAT("https://eycdn.ams3.digitaloceanspaces.com/' . Yii::$app->params->upload_directories->indian_jobs->departments->image . '", a.image_location, "/", a.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.Position, "&size=200&rounded=false&background=random&color=ffffff") END logo',
                'a.slug', 'a.image_location', 'a.image', 'a.Organizations', 'a.Location', 'a.Position', 'a.Eligibility', 'a.Last_date'])
            ->andWhere(['a.is_deleted' => 0])
            ->andFilterWhere([
                'or',
                ['REGEXP', 'a.Organizations', $search_pattern],
                ['REGEXP', 'a.Location', $search_pattern],
                ['REGEXP', 'a.Position', $search_pattern],
                ['REGEXP', 'a.Eligibility', $search_pattern],
            ])
            ->joinWith(['assignedIndianJobs b' => function ($b) {
                $b->joinWith(['deptEnc c'], false);
            }], false, 'LEFT JOIN')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->orderBy(['a.job_id' => SORT_DESC])
            ->asArray()
            ->all();

        if ($data) {
            foreach ($data as $i => $d) {
                if (!$d['Eligibility']) {
                    $data[$i]['Eligibility'] = 'View In Details';
                }
                if (!empty($d['image']) && !empty($d['image_location'])) {
                    $logo = "https://eycdn.ams3.digitaloceanspaces.com/" . Yii::$app->params->upload_directories->indian_jobs->departments->image . $d['image_location'] . DIRECTORY_SEPARATOR . $d['image'];
                    if (file_exists($logo)) {
                        $data[$i]['logo'] = "https://eycdn.ams3.digitaloceanspaces.com/" . Yii::$app->params->upload_directories->indian_jobs->departments->image . $d['image_location'] . DIRECTORY_SEPARATOR . $d['image'];
                    } else {
                        $data[$i]['logo'] = "https://ui-avatars.com/api/?name=" . $d['Position'] . "&size=200&rounded=false&background=random&color=ffffff";
                    }
                } else {
                    $data[$i]['logo'] = "https://ui-avatars.com/api/?name=" . $d['Position'] . "&size=200&rounded=false&background=random&color=ffffff";
                }
            }
            return $this->response(200, $data);
        }
        return $this->response(404, 'not found');
    }

    public function actionInDeptJobs()
    {

        $params = Yii::$app->request->post();

        if (isset($params['limit']) && !empty($params['limit'])) {
            $limit = $params['limit'];
        } else {
            $limit = 10;
        }

        if (isset($params['page']) && !empty($params['page'])) {
            $page = $params['page'];
        } else {
            $page = 1;
        }

        if (isset($params['dept_id']) && !empty($params['dept_id'])) {
            $dept_id = $params['dept_id'];
        } else {
            return $this->response(422, 'missing information');
        }

        $data = IndianGovtJobs::find()
            ->alias('a')
            ->select(['a.job_enc_id id', 'a.slug',
//                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->indian_jobs->departments->image, 'https') . '", a.image_location, "/", a.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.Position, "&size=200&rounded=false&background=random&color=ffffff") END logo',
                'c.Value Organizations', 'a.Location', 'a.Position', 'a.Eligibility', 'a.Last_date'])
            ->joinWith(['assignedIndianJobs b' => function ($b) use ($dept_id) {
                $b->joinWith(['deptEnc c'], false);
                $b->andWhere(['or', ['b.dept_enc_id' => $dept_id],
                    ['c.slug' => $dept_id]]);
            }], false, 'LEFT JOIN')
            ->limit($limit)
            ->orderBy(['a.created_on' => SORT_DESC])
            ->offset(($page - 1) * $limit)
            ->asArray()
            ->all();

        if ($data) {
            foreach ($data as $i => $d) {
                if (!$d['Eligibility']) {
                    $data[$i]['Eligibility'] = 'View In Details';
                }
                if (!empty($d['image']) && !empty($d['image_location'])) {
                    $logo = "https://eycdn.ams3.digitaloceanspaces.com/" . Yii::$app->params->upload_directories->indian_jobs->departments->image . $d['image_location'] . DIRECTORY_SEPARATOR . $d['image'];
                    if (file_exists($logo)) {
                        $data[$i]['logo'] = "https://eycdn.ams3.digitaloceanspaces.com/" . Yii::$app->params->upload_directories->indian_jobs->departments->image . $d['image_location'] . DIRECTORY_SEPARATOR . $d['image'];
                    } else {
                        $data[$i]['logo'] = "https://ui-avatars.com/api/?name=" . $d['Position'] . "&size=200&rounded=false&background=random&color=ffffff";
                    }
                } else {
                    $data[$i]['logo'] = "https://ui-avatars.com/api/?name=" . $d['Position'] . "&size=200&rounded=false&background=random&color=ffffff";
                }
            }
        }

        if ($data) {
            return $this->response(200, $data);
        } else {
            return $this->response(404, 'not found');
        }
    }

    public function actionInJobDetail()
    {
        $params = Yii::$app->request->post();

        if (isset($params['slug']) && isset($params['slug'])) {
            $slug = $params['slug'];
        } else {
            return $this->response(422, 'missing information');
        }

        $get = IndianGovtJobs::find()
            ->select(['job_enc_id', 'slug', 'Organizations', 'Location', 'Position', 'Eligibility', 'Last_date', 'Pdf_link', 'Data'])
            ->where(['slug' => $slug])
            ->asArray()
            ->indexBy('job_enc_id')
            ->one();

        if ($get) {
            return $this->response(200, $get);
        } else {
            return $this->response(404, 'not found');
        }

    }

    private function makeSQL_search_pattern($search)
    {
        if ($search == null || empty($search)) {
            return "";
        }
        $search_pattern = false;
        $wordArray = preg_split('/[^-\w\']+/', $search, -1, PREG_SPLIT_NO_EMPTY);
        $search = $this->optimizeSearchString($wordArray);
        $search = str_replace('"', "''", $search);
        $search = str_replace('^', "\\^", $search);
        $search = str_replace('$', "\\$", $search);
        $search = str_replace('.', "\\.", $search);
        $search = str_replace('[', "\\[", $search);
        $search = str_replace(']', "\\]", $search);
        $search = str_replace('|', "\\|", $search);
        $search = str_replace('*', "\\*", $search);
        $search = str_replace('+', "\\+", $search);
        $search = str_replace('{', "\\{", $search);
        $search = str_replace('}', "\\}", $search);
        $search = preg_split('/ /', $search, null, PREG_SPLIT_NO_EMPTY);
        for ($i = 0; $i < count($search); $i++) {
            if ($i > 0 && $i < count($search)) {
                $search_pattern .= "|";
            }
            $search_pattern .= $search[$i];
        }
        return $search_pattern;
    }

    private function optimizeSearchString($wordArray)
    {
        $articles = ['in', 'is', 'jobs', 'job', 'internship', 'internships'];
        $newArray = array_udiff($wordArray, $articles, 'strcasecmp');
        if (!empty($newArray))
            return implode(" ", $newArray);
        else
            return "";
    }


}