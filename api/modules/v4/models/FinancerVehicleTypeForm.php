<?php

namespace api\modules\v4\models;

use common\models\FinancerVehicleTypes;
use common\models\spaces\Spaces;
use yii\base\Model;
use common\models\Utilities;
use Yii;
use yii\web\UploadedFile;

class FinancerVehicleTypeForm extends FinancerVehicleTypes
{
    public $image;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['created_on', 'updated_on', 'created_by', 'image', 'is_deleted', 'icon', 'icon_location', 'updated_by', 'created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['vehicle_type', 'icon', 'icon_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
        ];
    }

    public function vehicleType($user, $organization_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $vehicle_type = new FinancerVehicleTypeForm();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $vehicle_type->financer_vehicle_type_enc_id = $utilitiesModel->encrypt();
            $vehicle_type->vehicle_type = $this->vehicle_type;
            $vehicle_type->organization_enc_id = $organization_id;
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
                return ['status' => 500, 'message' => 'An error occurred while saving the vehicle type data.', 'error' => $vehicle_type->getErrors()];
            }

            $transaction->commit();
            return ['status' => 200, 'message' => 'Vehicle type created successfully'];
        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'An error occurred', 'error' => $exception->getMessage()];
        }
    }
}
