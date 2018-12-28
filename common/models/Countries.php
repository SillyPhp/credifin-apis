<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%countries}}".
 *
 * @property integer $id
 * @property string $country_enc_id
 * @property string $name
 * @property string $abbreviation
 * @property integer $phonecode
 *
 * @property States[] $states
 */
class Countries extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%countries}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['country_enc_id', 'name', 'abbreviation', 'phonecode'], 'required'],
            [['phonecode'], 'integer'],
            [['country_enc_id', 'name'], 'string', 'max' => 100],
            [['abbreviation'], 'string', 'max' => 3],
            [['country_enc_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'country_enc_id' => Yii::t('common', 'Country'),
            'name' => Yii::t('common', 'Country'),
            'abbreviation' => Yii::t('common', 'Abbreviation'),
            'phonecode' => Yii::t('common', 'Phonecode'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStates() {
        return $this->hasMany(States::className(), ['country_enc_id' => 'country_enc_id']);
    }

}
