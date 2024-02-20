<?php

namespace common\models;

/**
 * This is the model class for table "{{%user_verification_tokens}}".
 *
 * @property int $id Primary Key
 * @property string $token_enc_id Token Encrypted ID
 * @property string $token Token
 * @property int $verification_type Token Verification Type (1 as Reset Password, 2 as Email Verification)
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Verification Token information was added to database
 * @property string $created_by By which User Verification Token information was added
 * @property string $last_updated_on On which date Verification Token information was updated
 * @property string $last_updated_by By which User Verification Token information was updated
 * @property string $status Verification Token Status (Pending, Verified)
 * @property int $is_deleted Is Verification Token Deleted (0 As False, 1 As True)
 *
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class UserVerificationTokens extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_verification_tokens}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token_enc_id', 'token', 'verification_type', 'created_by'], 'required'],
            [['verification_type', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['token_enc_id', 'token', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['token_enc_id'], 'unique'],
            [['token'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
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