<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assign_telegram_groups}}".
 *
 * @property int $id Auto increament id
 * @property string $assign_group_enc_id Table encrypted id
 * @property string $group_enc_id foreign key with telegram group table
 * @property string $tag assign tags
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property TelegramGroups $groupEnc
 */
class AssignTelegramGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%assign_telegram_groups}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assign_group_enc_id', 'group_enc_id', 'tag', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assign_group_enc_id', 'group_enc_id'], 'string', 'max' => 200],
            [['tag', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assign_group_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['group_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => TelegramGroups::className(), 'targetAttribute' => ['group_enc_id' => 'telegram_enc_id']],
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupEnc()
    {
        return $this->hasOne(TelegramGroups::className(), ['telegram_enc_id' => 'group_enc_id']);
    }
}
