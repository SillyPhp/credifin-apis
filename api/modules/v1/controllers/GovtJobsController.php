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
                    $get[$i]['logo'] = Url::to(Yii::$app->params->upload_directories->usa_jobs->departments->image . $data['image_location'] . DIRECTORY_SEPARATOR . $data['image'],'https');
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


}