<?php

namespace common\models;

/**
 * This is the model class for table "{{%sharing_links}}".
 *
 * @property int $id Primary Key
 * @property string $link_enc_id Link Encrypted ID
 * @property string $user Name of the associated person
 * @property string $title Title
 * @property string $keywords Keywords
 * @property string $description Description
 * @property string $sharing_description Sharing Description
 * @property string $image Image
 * @property string $image_location Image Location
 * @property string $redirect_url Redirect URL
 * @property string $created_on On which date Link information was added to database
 * @property string $created_by By which User Link information was added
 * @property string $last_updated_on On which date Link information was updated
 * @property string $last_updated_by By which User Link information was updated
 * @property int $is_deleted Is Link Deleted (0 as False, 1 as True)
 *
 * @property SharedLinksCounter[] $sharedLinksCounters
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class SharingLinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%sharing_links}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['link_enc_id', 'user', 'title', 'keywords', 'image', 'image_location', 'redirect_url', 'created_by'], 'required'],
            [['sharing_description'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['link_enc_id', 'title', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['user'], 'string', 'max' => 50],
            [['keywords', 'redirect_url'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 160],
            [['link_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSharedLinksCounters()
    {
        return $this->hasMany(SharedLinksCounter::className(), ['link_enc_id' => 'link_enc_id']);
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