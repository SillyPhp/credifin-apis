<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;

class ApplicationsForm extends Model {

    public $first_name;
    public $last_name;
    public $email;
    public $contact;
    public $qualification_enc_id;
    public $college;
    public $city_enc_id;
    public $answers;

    public function rules() {
        return [
            [['first_name', 'last_name', 'email', 'contact',], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'first_name' => Yii::t('frontend', 'First Name'),
            'last_name' => Yii::t('frontend', 'Last Name'),
            'email' => Yii::t('frontend', 'Email'),
            'contact' => Yii::t('frontend', 'Contact'),
        ];
    }


}
