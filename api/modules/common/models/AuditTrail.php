<?php

namespace common\models;
use Yii;

/**
 * This is the model class for table "{{%audit_trail}}".
 *
 * @property int $id
 * @property string $old_value
 * @property string $new_value
 * @property string $action
 * @property string $model
 * @property string $field
 * @property string $stamp
 * @property int $user_id
 * @property string $model_id
 *
 * @property Users $user
 */
class AuditTrail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%audit_trail}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['old_value', 'new_value'], 'string'],
            [['action', 'model', 'stamp', 'model_id'], 'required'],
            [['stamp'], 'safe'],
            [['user_id'], 'integer'],
            [['action', 'model', 'field', 'model_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'old_value' => Yii::t('app', 'Old Value'),
            'new_value' => Yii::t('app', 'New Value'),
            'action' => Yii::t('app', 'Action'),
            'model' => Yii::t('app', 'Model'),
            'field' => Yii::t('app', 'Field'),
            'stamp' => Yii::t('app', 'Stamp'),
            'user_id' => Yii::t('app', 'User ID'),
            'model_id' => Yii::t('app', 'Model ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}