<?php

namespace common\models;

/**
 * This is the model class for table "{{%user_access_tokens}}".
 *
 * @property int $id Primary Key
 * @property string $access_token_enc_id Access Token Encrypted ID
 * @property string $access_token Access Token
 * @property string $auto_login_token
 * @property string $access_token_expiration Expiration Time of Access Token
 * @property string $refresh_token Refresh Token
 * @property string $refresh_token_expiration Refresh Token Expiration Time
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $created_on On which date Access Token information was added to database
 * @property string $last_updated_on On which date Access Token information was updated
 * @property string $source Source
 * @property int $is_deleted Is Access Token Deleted (0 As False, 1 As True)
 *
 * @property Users $userEnc
 */
class UserAccessTokens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_access_tokens}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['access_token_enc_id', 'access_token', 'refresh_token', 'user_enc_id'], 'required'],
            [['access_token_expiration', 'refresh_token_expiration', 'created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['access_token_enc_id', 'access_token', 'auto_login_token', 'refresh_token', 'user_enc_id'], 'string', 'max' => 100],
            [['source'], 'string', 'max' => 50],
            [['refresh_token'], 'unique'],
            [['access_token'], 'unique'],
            [['access_token_enc_id'], 'unique'],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }
}