<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%telegram_groups}}".
 *
 * @property int $id auto increament id
 * @property string $telegram_enc_id table encripted id
 * @property string $name name of the telegram group
 * @property string $group_id telegram group id for which message set
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 1 as deleted, 0 as not deleted
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class TelegramGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%telegram_groups}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telegram_enc_id', 'name', 'group_id', 'created_by', 'is_deleted'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['telegram_enc_id', 'name', 'group_id'], 'string', 'max' => 200],
            [['created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['telegram_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }
}
