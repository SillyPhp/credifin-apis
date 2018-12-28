<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class AddEmployeeBenefitForm extends Model {

    public $benefit;

    public function rules() {
        return [
//            [['location'], 'required'],
//            ['present', 'boolean'],
//            [['company'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels() {
        return [
            'benefit' => Yii::t('frontend', 'Add New Benefit'),
        ];
    }


}
