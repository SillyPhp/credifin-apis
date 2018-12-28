<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_types}}".
 *
 * @property integer $id
 * @property string $user_type_enc_id
 * @property string $user_type
 *
 * @property Users[] $users
 */
class UserTypes extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_type_enc_id', 'user_type'], 'required'],
            [['user_type_enc_id'], 'string', 'max' => 100],
            [['user_type'], 'string', 'max' => 30],
            [['user_type_enc_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_type_enc_id' => Yii::t('common', 'User Type Enc ID'),
            'user_type' => Yii::t('common', 'User Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(Users::className(), ['user_type' => 'user_type_enc_id']);
    }

}
