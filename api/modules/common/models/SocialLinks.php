<?php

namespace common\models;

/**
 * This is the model class for table "{{%social_links}}".
 *
 * @property int $id Primary Key
 * @property string $social_enc_id Social Page Encrypted ID
 * @property string $group_enc_id Page Username
 * @property string $platform_enc_id Handlers
 * @property string $link Social Page Link
 * @property string $title Page Name
 * @property string $created_on On which date Social Page information was added to database
 * @property string $created_by By which User Social Page information was added
 * @property string $last_updated_on On which date Social Page information was updated
 * @property string $last_updated_by By which User Social Page information was updated
 * @property int $is_deleted Is Social Page Deleted (0 as False, 1 as True)
 *
 * @property SocialGroups $groupEnc
 * @property SocialPlatforms $platformEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class SocialLinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%social_links}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['social_enc_id', 'group_enc_id', 'platform_enc_id', 'link', 'title', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['social_enc_id', 'group_enc_id', 'platform_enc_id', 'title', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['link'], 'string', 'max' => 200],
            [['social_enc_id'], 'unique'],
            [['link', 'group_enc_id', 'platform_enc_id', 'is_deleted'], 'unique', 'targetAttribute' => ['link', 'group_enc_id', 'platform_enc_id', 'is_deleted']],
            [['group_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocialGroups::className(), 'targetAttribute' => ['group_enc_id' => 'group_enc_id']],
            [['platform_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SocialPlatforms::className(), 'targetAttribute' => ['platform_enc_id' => 'platform_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroupEnc()
    {
        return $this->hasOne(SocialGroups::className(), ['group_enc_id' => 'group_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatformEnc()
    {
        return $this->hasOne(SocialPlatforms::className(), ['platform_enc_id' => 'platform_enc_id']);
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
