<?php


namespace api\modules\v3\controllers;


use common\models\AssignedCollegeCourses;
use common\models\ClaimServiceableLocations;
use common\models\Organizations;
use Yii;
use yii\web\Response;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\Utilities;

class EyCollegeProfileController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'college-detail' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionCollegeDetail()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $college_detail = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.email', 'a.website', 'b.affiliated_to', 'b1.name city_name', 'a.phone',
                'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE NULL END logo'
            ])
            ->innerJoinWith(['organizationOtherDetails b' => function ($b) {
                $b->joinWith(['locationEnc b1']);
            }], false)
            ->where(['a.slug' => $params['slug'], 'a.status' => 'Active', 'a.is_deleted' => 0, 'a.is_erexx_registered' => 1])
            ->asArray()
            ->all();

        if ($college_detail) {
            return $this->response(200, ['status' => 200, 'data' => $college_detail]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    public function actionCourses()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $college = Organizations::find()
            ->where(['slug' => $params['slug']])
            ->one();

        $courses = AssignedCollegeCourses::find()
            ->distinct()
            ->alias('a')
            ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.course_duration', 'a.type'])
            ->joinWith(['courseEnc c'], false)
            ->where(['a.organization_enc_id' => $college->organization_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();
        if ($courses) {
            return $this->response(200, ['status' => 200, 'courses' => $courses]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionLoanProviders()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $loans = ClaimServiceableLocations::find()
            ->alias('a')
            ->select(['a.service_location_enc_id', 'a.organization_enc_id', 'c.name', 'c.email', 'c.phone', 'c.website'])
            ->joinWith(['claimCollegeEnc b'])
            ->joinWith(['organizationEnc c'])
            ->where(['b.slug' => $params['slug'], 'b.status' => 'Active', 'b.is_deleted' => 0, 'b.is_erexx_registered' => 1])
            ->asArray()
            ->all();

        if ($loans) {
            return $this->response(200, ['status' => 200, 'data' => $loans]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }
}