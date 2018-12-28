<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class ProfileLogoForm extends Model {

    public $logo;

    public function rules() {
        return [
            [['logo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
        ];
    }

    public function attributeLabels() {
        return[
            'logo' => Yii::t('frontend', 'Logo'),
        ];
    }

}
