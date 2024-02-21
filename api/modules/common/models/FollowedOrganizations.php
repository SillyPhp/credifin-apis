<?php

namespace common\models;

/**
 * This is the model class for table "{{%followed_organizations}}".
 *
 * @property int $id Primary Key
 * @property string $followed_enc_id Followed Encrypted ID
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $user_enc_id Foreign Key to Users Table
 * @property int $followed Is Organization Followed (0 as No, 1 as Yes)
 * @property string $created_on On which date Organization Followed information was added to database
 * @property string $created_by By which User Organization Followed information was added
 * @property string $last_updated_on On which date Organization Followed information was updated
 * @property string $last_updated_by By which User Organization Followed information was updated
 *
 * @property Organizations $organizationEnc
 * @property Users $userEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class FollowedOrganizations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%followed_organizations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['followed_enc_id', 'organization_enc_id', 'user_enc_id', 'created_by'], 'required'],
            [['followed'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['followed_enc_id', 'organization_enc_id', 'user_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['followed_enc_id'], 'unique'],
            [['organization_enc_id', 'user_enc_id'], 'unique', 'targetAttribute' => ['organization_enc_id', 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
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
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
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
