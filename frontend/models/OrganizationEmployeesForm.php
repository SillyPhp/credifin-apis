<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Organizations;
use common\models\OrganizationEmployees;

class OrganizationEmployeesForm extends Model{

    public $first_name;
    public $last_name;
    public $image;
    public $facebook;
    public $twitter;
    public $linkedin;
    public $designation;

    public function rules() {
        return [
            [['first_name','last_name','designation'], 'required'],
            [['facebook','twitter','linkedin'], 'url', 'defaultScheme' => 'http'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
            [['first_name','last_name','facebook','twitter','linkedin'], 'trim'],
        ];
    }

    public function attributeLabels() {
        return [
            'first_name' => Yii::t('frontend', 'First Name'),
            'last_name' => Yii::t('frontend', 'Last Name'),
            'facebook' => Yii::t('frontend', 'Facebook Url'),
            'twitter' => Yii::t('frontend', 'Twitter Url'),
            'linkedin' => Yii::t('frontend', 'Linkedin Url'),
            'designation' => Yii::t('frontend', 'Designation'),
        ];
    }


    public function save() {
        if ($this->validate()) {
            $utilitiesModel = new Utilities();
            $organizationsModel = new Organizations();
            $organizationEmployeesModel = new OrganizationEmployees();
            $organization = $organizationsModel->find()
                ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'is_deleted' => 0])
                ->one();
            if ($organization) {
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $organizationEmployeesModel->employee_enc_id = $utilitiesModel->encrypt();
                $organizationEmployeesModel->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
                $organizationEmployeesModel->image_location = Yii::$app->getSecurity()->generateRandomString();
                $base_path = $organizationEmployeesModel->image_location;
                $organizationEmployeesModel->image = Yii::$app->getSecurity()->generateRandomString() . '.' . $this->image->extension;
                $organizationEmployeesModel->first_name = $this->first_name;
                $organizationEmployeesModel->last_name = $this->last_name;
                $organizationEmployeesModel->designation = $this->designation;
                $organizationEmployeesModel->facebook = $this->facebook;
                $organizationEmployeesModel->twitter = $this->twitter;
                $organizationEmployeesModel->linkedin = $this->linkedin;
                $organizationEmployeesModel->created_by = Yii::$app->user->identity->user_enc_id;
                if (!is_dir($base_path)) {
                    if (mkdir($base_path, 0755, true)) {
                        if ($this->image->saveAs($base_path . DIRECTORY_SEPARATOR . $organizationEmployeesModel->image)) {
                            if ($organizationEmployeesModel->validate() && $organizationEmployeesModel->save()) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}