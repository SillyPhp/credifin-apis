<?php

namespace api\modules\v4\controllers;

use common\models\FinancerVehicleTypes;
use common\models\spaces\Spaces;
use common\models\Utilities;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use yii;

class DealersController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'financer-vehicle-type' => ['POST', 'OPTIONS'],
                'get-financer-vehicle-type' => ['POST', 'OPTIONS'],
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

    public function actionFinancerVehicleType()
    {
        if (!$user = $this->isAuthorized()) {
            return $this->response(401, ['status' => 401, 'message' => 'unauthorised']);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $type_name = Yii::$app->request->post('type_name');
            $org_id = Yii::$app->request->post('organization_enc_id');

            $vehicle_type = new FinancerVehicleTypes();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $vehicle_type->financer_vehicle_type_enc_id = $utilitiesModel->encrypt();
            $vehicle_type->vehicle_type = $type_name;
            $vehicle_type->organization_enc_id = $org_id;
            $vehicle_type->created_by = $user->user_enc_id;
            $vehicle_type->created_on = date('Y-m-d H:i:s');

            if ($icon_image = UploadedFile::getInstanceByName('icon_image')) {
                $icon = Yii::$app->getSecurity()->generateRandomString() . '.' . $icon_image->extension;
                $icon_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = Yii::$app->params->upload_directories->vehicle_types->icon . $icon_location;

                $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
                $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
                $result = $my_space->uploadFileSources($icon_image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . '/' . $icon, "public", ['params' => ['contentType' => $icon_image->type]]);

                $vehicle_type->icon = $icon;
                $vehicle_type->icon_location = $icon_location;
            }

            if (!$vehicle_type->save()) {
                $transaction->rollback();
                return $this->response(500, ['status' => 500, 'message' => 'An error occurred while saving the vehicle type data.', 'error' => $vehicle_type->getErrors()]);
            }

            $transaction->commit();
            return $this->response(200, ['status' => 200, 'type_name' => $type_name]);
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'An error occurred', 'error' => json_decode($exception->getMessage(), true)];
        }
    }

}


?>