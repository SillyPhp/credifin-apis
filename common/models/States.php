<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%states}}".
 *
 * @property integer $id
 * @property string $state_enc_id
 * @property string $name
 * @property string $country_enc_id
 *
 * @property Countries $countryEnc
 */
class States extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%states}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['state_enc_id', 'name', 'country_enc_id'], 'required'],
            [['state_enc_id', 'country_enc_id'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 30],
            [['state_enc_id'], 'unique'],
            [['country_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_enc_id' => 'country_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'state_enc_id' => Yii::t('common', 'State'),
            'name' => Yii::t('common', 'State'),
            'country_enc_id' => Yii::t('common', 'Country'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryEnc() {
        return $this->hasOne(Countries::className(), ['country_enc_id' => 'country_enc_id']);
    }

}
