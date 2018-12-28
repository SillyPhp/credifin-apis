<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;

class AddSkillForm extends Model {

    public $name;
//    public $range;

    public function rules() {
        return [
            [['name'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => Yii::t('frontend', 'Enter Name of Skill'),
//            'range' => Yii::t('frontend', 'Chose your skill range'),
        ];
    }


}
