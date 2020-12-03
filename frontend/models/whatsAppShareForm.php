<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class whatsAppShareForm extends Model {

    public $phone;

//    public $user_type;

    public function rules() {
        return [
            [['phone'], 'safe'],
            [['phone'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'phone' => Yii::t('frontend', 'Phone'),
        ];
    }

}
