<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
//use common\models\FreelancersData;

class OrgAutoBlogForm extends Model {

    public $name;
    public $desc;
    public $title;
    public $images;

    public function rules() {
        return [
            [['name', 'title', 'desc', 'images'], 'required'],
            [['name', 'title', 'desc', 'images'], 'trim'],
            [['portfolio'], 'url', 'defaultScheme' => 'http'],
            [['desc'], 'string'],
            [['images'], 'file', 'skipOnEmpty' => false, 'maxFiles' => 4, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('frontend', 'Name'),
            'desc' => Yii::t('frontend', 'Description'),
            'title' => Yii::t('frontend', 'Title'),
            'images' => Yii::t('frontend', 'Images'),
        ];
    }

    public function save() {
        if ($this->validate()) {
            $freelancersDataModel = new FreelancersData();
            $utilitiesModel = new Utilities();
            $freelancersDataModel->first_name = $this->first_name;
            $freelancersDataModel->last_name = $this->last_name;
            $freelancersDataModel->email = $this->email;
            $freelancersDataModel->phone = $this->phone;
            $freelancersDataModel->portfolio = $this->portfolio;
            $freelancersDataModel->description = $this->description;
            $freelancersDataModel->skills = $this->skills;
            if ($this->job_profile == 'Others') {
                $freelancersDataModel->job_type = $this->job_profile2;
            } else {
                $freelancersDataModel->job_type = $this->job_profile;
            }
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $freelancersDataModel->freelancer_data_enc_id = $utilitiesModel->encrypt();
            $freelancersDataModel->created_on = date('Y-m-d H:i:s');
            if ($freelancersDataModel->validate() && $freelancersDataModel->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
