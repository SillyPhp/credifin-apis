<?php

namespace common\models;

/**
 * This is the model class for table "{{%social_platforms}}".
 *
 * @property int $id Primary Key
 * @property string $platform_enc_id Handlers
 * @property string $link Platform  Link
 * @property string $name Platform Name
 * @property string $icon
 * @property string $icon_location
 * @property string $created_on On which date Social Page information was added to database
 * @property string $created_by By which User Social Page information was added
 * @property string $last_updated_on On which date Social Page information was updated
 * @property string $last_updated_by By which User Social Page information was updated
 * @property int $is_deleted Is Social Page Deleted (0 as False, 1 as True)
 *
 * @property SocialLinks[] $socialLinks
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class SocialPlatforms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%social_platforms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['platform_enc_id', 'link', 'name', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['platform_enc_id', 'name', 'icon', 'icon_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['link'], 'string', 'max' => 200],
            [['link'], 'unique'],
            [['platform_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocialLinks()
    {
        return $this->hasMany(SocialLinks::className(), ['platform_enc_id' => 'platform_enc_id']);
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
