<?php

namespace frontend\models\skillsUp;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Organizations;
use common\models\OrganizationEmployees;

class AddSourceForm extends Model
{

    public $source_name;
    public $image;
    public $link;
    public $description;

    public function rules()
    {
        return [
            [['source_name', 'link','image'], 'required'],
            [['link'], 'url', 'defaultScheme' => 'http'],
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
            [['source_name', 'link', 'description'], 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'source_name' => Yii::t('frontend', 'Source Name'),
            'link' => Yii::t('frontend', 'Link'),
            'description' => Yii::t('frontend', 'Description'),
        ];
    }


    public function save(){
        if (!$this->validate()) {
            return false;
        }
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);

        return true;
    }
}