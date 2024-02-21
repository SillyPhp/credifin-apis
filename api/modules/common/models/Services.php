<?php

namespace common\models;

/**
 * This is the model class for table "{{%services}}".
 *
 * @property int $id Primary Key
 * @property string $service_enc_id Service Encrypted ID
 * @property string $name Service Name
 * @property string $link Service Link
 * @property string $icon Service Icon
 * @property string $class CSS Class
 * @property string $parent_enc_id Foreign Key to Services Table
 *
 * @property SelectedServices[] $selectedServices
 */
class Services extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%services}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['service_enc_id', 'name', 'link'], 'required'],
            [['service_enc_id', 'name', 'link', 'parent_enc_id'], 'string', 'max' => 100],
            [['icon'], 'string', 'max' => 50],
            [['class'], 'string', 'max' => 30],
            [['service_enc_id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSelectedServices() {
        return $this->hasMany(SelectedServices::className(), ['service_enc_id' => 'service_enc_id']);
    }

}
