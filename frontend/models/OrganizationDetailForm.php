<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Organizations;

class OrganizationDetailForm extends Model {

    public $logo;
    public $cover;
    public $facebook;
    public $twitter;
    public $instagram;
    public $google;
    public $youtube;
    public $linkedin;

    public function rules() {
        return [
            [['logo','cover'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'mimeTypes' => 'image/jpeg, image/png', 'maxSize' => 1024 * 1024 * 1],
            [['facebook', 'instagram', 'linkedin','twitter','google','youtube'], 'trim'],
        ];
    }

    public function attributeLabels() {
        return[
            'facebook' => Yii::t('frontend', 'Facebook'),
            'instagram' => Yii::t('frontend', 'Instagram'),
            'twitter' => Yii::t('frontend', 'Twitter'),
            'google' => Yii::t('frontend', 'Google'),
            'youtube' => Yii::t('frontend', 'Youtube'),
            'linkedin' => Yii::t('frontend', 'Linkedin'),
        ];
    }


}
