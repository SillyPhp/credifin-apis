<?php

namespace api\modules\v4\controllers;

use common\models\BillDetails;
use common\models\Cities;
use common\models\Designations;
use common\models\GodaddyCourses;
use common\models\OrganizationTypes;
use common\models\spaces\Spaces;
use common\models\States;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use Yii;
use yii\filters\Cors;
use yii\filters\ContentNegotiator;
use common\models\Utilities;

class UtilitiesController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'organization-types' => ['GET', 'OPTIONS'],
                'designations' => ['GET', 'OPTIONS'],
                'states' => ['GET', 'OPTIONS'],
                'cities' => ['GET', 'OPTIONS'],
                'file-upload' => ['POST', 'OPTIONS'],
            ]
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
            'cors' => [
                'Origin' => ['https://www.empowerloans.in/'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
            ],
        ];

        return $behaviors;
    }

    public function actionOrganizationTypes()
    {
        $org_types = OrganizationTypes::find()
            ->select(['organization_type_enc_id', 'organization_type'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'organization_types' => $org_types]);
    }

    public function actionDesignations($keyword)
    {
        $designations = Designations::find()
            ->select(['designation_enc_id', 'designation', 'designation_enc_id id', 'designation name'])
            ->where(['is_deleted' => 0])
            ->andFilterWhere(['like', 'designation', $keyword])
            ->limit(20)
            ->asArray()
            ->all();

        // remove designations after deploy on react
        return $this->response(200, ['status' => 200, 'list' => $designations, 'designations' => $designations]);
    }

    public function actionStates()
    {
        $states = States::find()
            ->select(['state_enc_id', 'name'])
            ->andWhere(['country_enc_id' => 'b05tQ3NsL25mNkxHQ2VMOGM2K3loZz09'])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'states' => $states]);
    }

    public function actionCities($state_id = 'OVlINEg0MGxyRzMydlFrblNTSWExQT09')
    {
        $cities = Cities::find()
            ->select(['city_enc_id', 'name'])
            ->andWhere(['state_enc_id' => $state_id])
            ->asArray()
            ->all();

        return $this->response(200, ['status' => 200, 'cities' => $cities]);
    }

    public function actionFileUpload()
    {
        if ($this->isAuthorized()) {
            $file = UploadedFile::getInstanceByName('file');

            $base_path = Yii::$app->params->upload_directories->loans->e_sign . Yii::$app->getSecurity()->generateRandomString() . '/';
            $type = $file->type;
            $file = Yii::$app->getSecurity()->generateRandomString() . '.' . 'pdf';

            $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
            $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
            $result = $my_space->uploadFileSources($file->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $file, "private", ['params' => ['ContentType' => $type]]);
            if ($result['ObjectURL']) {
                return $this->response(200, ['status' => 200, 'path' => Yii::$app->params->digitalOcean->rootDirectory . $base_path . $file]);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'an error occurred']);
            }
        } else {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorized']);
        }
    }

    public function actionSaveCourse()
    {
        $params = Yii::$app->request->post();

        $course = new GodaddyCourses();
        $course->course_enc_id = Yii::$app->getSecurity()->generateRandomString();
        $course->name = $params['name'];
        $course->phone = $params['phone'];
        $course->email = $params['email'];
        $course->course_name = $params['course_name'];
        $course->created_on = date('Y-m-d H:i:s');
        if (!empty($params['course_price'])) {
            $course->price = $params['course_price'];
        }

        if ($user = $this->isAuthorized()) {
            $course->created_by = $user->user_enc_id;
        }

        if (!$course->save()) {
            return $this->response(500, ['status' => 500, 'message' => 'an error occurred', 'error' => $course->getErrors()]);
        }

        return $this->response(200, ['status' => 200, 'message' => 'successfully saved']);
    }
}