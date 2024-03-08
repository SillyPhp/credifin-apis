<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_audit_trail}}".
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
 * @property string $foreign_id
 *
 * @property Users $user
 */
class LoanAuditTrail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_audit_trail}}';
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
            [['action', 'model', 'field', 'model_id', 'foreign_id'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
