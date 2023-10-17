<?php

namespace api\modules\v4\models;

use common\models\spaces\Spaces;
use common\models\VehicleRepossession;
use common\models\VehicleRepossessionImages;
use mysql_xdevapi\Exception;
use yii\base\Model;
use common\models\Utilities;
use Yii;

class VehicleRepoForm extends Model
{
    public $image;

    public $front;
    public $back;
    public $right;
    public $left;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['image', 'front', 'back', 'left', 'right'], 'safe'],
        ];
    }

    public function vehicleRepo($user)
    {
        $params = Yii::$app->request->post();
        if (empty($params['loan_account_enc_id'])) {
            return ['status' => 422, 'message' => 'missing information "loan_account_enc_id'];
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $repo = new VehicleRepossession();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $repo->vehicle_repossession_enc_id = $utilitiesModel->encrypt();
            $repo->loan_account_enc_id = $params['loan_account_enc_id'];
            $repo->vehicle_model = $params['vehicle_model'];
            $repo->km_driven = $params['km_driven'];
            $repo->insurance = $params['insurance'] == 'yes' ? 1 : 0;
            $repo->rc = $params['rc'] == 'yes' ? 1 : 0;
            $repo->registration_number = !empty($params['registration_number']) ? $params['registration_number'] : null;
            $repo->current_market_value = $params['current_value'];
            $repo->repossession_date = $params['repossession_date'];
            $repo->created_by = $repo->updated_by = $user->user_enc_id;
            $repo->created_on = $repo->updated_on = date('Y-m-d H:i:s');

            if (!$repo->save()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'An error occurred while saving the data.', 'error' => $repo->getErrors()];
            }

            foreach ($this->front as $val) {
                $this->saveImages($val, $repo->vehicle_repossession_enc_id, $user->user_enc_id, 1);
            }
            foreach ($this->back as $val) {
                $this->saveImages($val, $repo->vehicle_repossession_enc_id, $user->user_enc_id, 2);
            }
            foreach ($this->left as $val) {
                $this->saveImages($val, $repo->vehicle_repossession_enc_id, $user->user_enc_id, 3);
            }
            foreach ($this->right as $val) {
                $this->saveImages($val, $repo->vehicle_repossession_enc_id, $user->user_enc_id, 4);
            }

            $transaction->commit();
            return ['status' => 200, 'message' => 'successfully added'];

        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'An error occurred', 'error' => $exception->getMessage()];
        }
    }

    private function saveImages($val, $vehicle_repossession_id, $uid, $type)
    {
        $repo_im_in = new VehicleRepossessionImages();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $repo_im_in->vehicle_repossession_images_enc_id = $utilitiesModel->encrypt();
        $repo_im_in->vehicle_repossession_enc_id = $vehicle_repossession_id;
        $repo_im_in->image_type = $type;

        $repo_im_in->created_by = $repo_im_in->updated_by = $uid;
        $repo_im_in->created_on = $repo_im_in->updated_on = date('Y-m-d H:i:s');

        $repo_im_in->image = Yii::$app->getSecurity()->generateRandomString() . '.' . $val->extension;
        $repo_im_in->image_location = Yii::$app->getSecurity()->generateRandomString() . '/';
        $base_path = Yii::$app->params->upload_directories->repo_images->image . $repo_im_in->image_location;

        $this->fileUpload($val, $base_path, $repo_im_in->image);

        if (!$repo_im_in->save()) {
            throw new \Exception(json_encode($repo_im_in->getErrors()));
        }
    }

    private function fileUpload($image, $base_path, $name)
    {
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $result = $my_space->uploadFileSources($image->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $name, "public", ['params' => ['ContentType' => $image->type]]);
        if (!$result) {
            throw new \Exception('error occurred while uploading the image');
        }
    }

}