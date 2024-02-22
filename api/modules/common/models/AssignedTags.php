<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%assigned_tags}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_tag_enc_id Assigned Tag Encrypted ID
 * @property string $tag_enc_id Foreign Key to Tags Table
 * @property int $assigned_to Assigned To (1 as Posts, 2 as Videos)
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Tag information was added to database
 * @property string $created_by By which User Tag information was added
 * @property string $last_updated_on On which date Tag information was updated
 * @property string $last_updated_by By which User Tag information was updated
 * @property string $status Assigned Tag Status (Approved, Pending)
 * @property int $is_deleted Is Assigned Tag Deleted (0 as False, 1 as True)
 *
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Tags $tagEnc
 */
class AssignedTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_tag_enc_id', 'tag_enc_id', 'assigned_to', 'created_by'], 'required'],
            [['assigned_to', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['assigned_tag_enc_id', 'tag_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['tag_enc_id', 'assigned_to', 'is_deleted'], 'unique', 'targetAttribute' => ['tag_enc_id', 'assigned_to', 'is_deleted']],
            [['assigned_tag_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['tag_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tag_enc_id' => 'tag_enc_id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagEnc()
    {
        return $this->hasOne(Tags::className(), ['tag_enc_id' => 'tag_enc_id']);
    }
}
