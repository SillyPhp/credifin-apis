<?php

namespace common\models;

/**
 * This is the model class for table "{{%subscribers}}".
 *
 * @property int $id Primary Key
 * @property string $subscriber_enc_id Subscriber Encrypted ID
 * @property string $first_name First Name
 * @property string $last_name Last Name
 * @property string $email Email
 * @property int $is_verified Is Email Verified (1 is True, 0 is False)
 */
class Subscribers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscribers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subscriber_enc_id', 'email'], 'required'],
            [['is_verified'], 'integer'],
            [['subscriber_enc_id'], 'string', 'max' => 100],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 50],
            [['subscriber_enc_id'], 'unique'],
            [['email'], 'unique'],
        ];
    }
}
