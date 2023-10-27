<?php

namespace api\modules\v4\models;

use common\models\OrganizationAppFields;
use common\models\OrganizationApps;
use common\models\OrganizationAppUsers;
use common\models\RandomColors;
use common\models\spaces\Spaces;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class Apps extends Model
{
    public $app_name;
    public $app_description;
    public $logo;
    public $elements;
    public $assigned_to;
    public $assigned_users;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['app_name', 'elements', 'assigned_to'], 'required'],
            [['app_description', 'logo', 'assigned_users'], 'safe'],
            [['app_name', 'app_description'], 'trim'],
            [['app_name'], 'string', 'max' => 150],
        ];
    }


    public function add($user)
    {
        // starting transaction
        $transaction = Yii::$app->db->beginTransaction();
        try {

            // saving data in organization apps
            $model = new OrganizationApps();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->app_enc_id = $utilitiesModel->encrypt();
            $model->organization_enc_id = $user->organization_enc_id;
            $model->app_name = $this->app_name;
            $model->app_description = $this->app_description;
            $model->assigned_to = $this->assigned_to;

            // if logo exists
            if ($this->logo) {
                $model->app_icon = Yii::$app->getSecurity()->generateRandomString() . '.' . $this->logo->extension;
                $model->app_icon_location = Yii::$app->getSecurity()->generateRandomString() . '/';

                // uploading file
                $this->fileUpload($model->app_icon, $model->app_icon_location);
            }

            $model->created_by = $user->user_enc_id;
            $model->created_on = date('Y-m-d H:i:s');
            if (!$model->save()) {
                $transaction->rollBack();
                return ['status' => 500, 'message' => 'an error occurred', 'error' => $model->getErrors()];
            }

            // decoding assigned users
            $assigned_users = json_decode($this->assigned_users, true);

            // if assigned users exists then saving them to organization app users
            if ($assigned_users) {
                foreach ($assigned_users as $val) {
                    $assigned_user = new OrganizationAppUsers();
                    $assigned_user->assigned_user_enc_id = Yii::$app->getSecurity()->generateRandomString();
                    $assigned_user->app_enc_id = $model->app_enc_id;
                    $assigned_user->user_enc_id = $val;
                    $assigned_user->created_by = $user->user_enc_id;
                    $assigned_user->created_on = date('Y-m-d H:i:s');
                    if (!$assigned_user->save()) {
                        $transaction->rollBack();
                        return ['status' => 500, 'message' => 'an error occurred', 'error' => $assigned_user->getErrors()];
                    }
                }
            }

            // decoding elements
            $elems = json_decode($this->elements, true);

            // if elements exists then saving them to organization app fields
            if ($elems) {
                foreach ($elems as $key => $arr) {
                    $app_fields = new OrganizationAppFields();
                    $app_fields->field_enc_id = Yii::$app->getSecurity()->generateRandomString();
                    $app_fields->app_enc_id = $model->app_enc_id;
                    $app_fields->field_title = $arr['name'];
                    $app_fields->sequence = $key;
                    $app_fields->link = $arr['link'];
                    $app_fields->field_type = $arr['field_type'];
                    $app_fields->created_by = $user->user_enc_id;
                    $app_fields->created_on = date('Y-m-d H:i:s');
                    if (!$app_fields->save()) {
                        $transaction->rollBack();
                        return ['status' => 500, 'message' => 'an error occurred', 'error' => $app_fields->getErrors()];
                    }
                }
            }

            // commiting code
            $transaction->commit();
            return ['status' => 201, 'message' => 'successfully saved'];


        } catch (\Exception $exception) {
            $transaction->rollBack();
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $exception->getMessage()];
        }
    }

    // uploading file/logo
    private function fileUpload($icon, $icon_location)
    {

        $base_path = Yii::$app->params->upload_directories->form_apps->logo . $icon_location;
        $type = $this->logo->type;

        // creating spaces object
        $spaces = new Spaces(Yii::$app->params->digitalOcean->accessKey, Yii::$app->params->digitalOcean->secret);
        $my_space = $spaces->space(Yii::$app->params->digitalOcean->sharingSpace);
        $result = $my_space->uploadFileSources($this->logo->tempName, Yii::$app->params->digitalOcean->rootDirectory . $base_path . $icon, "private", ['params' => ['ContentType' => $type]]);
        if (!$result) {
            throw new \Exception('error occurred while uploading logo');
        }
    }
}