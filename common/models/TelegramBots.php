<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%telegram_bots}}".
 *
 * @property int $id
 * @property string $bot_enc_id
 * @property string $bot_name
 * @property string $bot_username
 * @property string $bot_api_key
 * @property string $created_on
 * @property string $created_by
 * @property int $is_deleted 0 as false, 1 as True
 *
 * @property Users $createdBy
 */
class TelegramBots extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%telegram_bots}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bot_enc_id', 'bot_name', 'bot_username', 'bot_api_key', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['bot_enc_id', 'created_by'], 'string', 'max' => 100],
            [['bot_name', 'bot_username', 'bot_api_key'], 'string', 'max' => 255],
            [['bot_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
