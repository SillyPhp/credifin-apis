<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_videos}}".
 *
 * @property int $id Primary Key
 * @property string $video_enc_id Video Encrypted ID
 * @property string $name Video Name
 * @property string $link Video Link
 * @property string $cover_image Video Cover Image
 * @property string $description Video Description
 * @property string $display Show Video (Yes, No)
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Video information was added to database
 * @property string $created_by By which User Video information was added
 * @property string $last_updated_on On which date Video information was updated
 * @property string $last_updated_by By which User Video information was updated
 * @property int $is_deleted Is Video Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Organizations $organizationEnc
 */
class OrganizationVideos extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%organization_videos}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['video_enc_id', 'name', 'link', 'cover_image', 'organization_enc_id', 'created_on', 'created_by'], 'required'],
            [['description', 'display'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['video_enc_id', 'name', 'link', 'cover_image', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['link'], 'unique'],
            [['video_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc() {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

}
