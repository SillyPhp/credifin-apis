<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_images}}".
 *
 * @property int $id Primary Key
 * @property string $image_enc_id Image Encrypted ID
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $image Image
 * @property string $image_location Image Location
 * @property string $title Image Title
 * @property string $alt Alternative Text of Image
 * @property string $created_on On which date Image information was added to database
 * @property string $created_by By which User Image information was added
 * @property string $last_updated_on On which date Image information was updated
 * @property string $last_updated_by By which User Image information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Organizations $organizationEnc
 */
class OrganizationImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_enc_id', 'organization_enc_id', 'image', 'image_location', 'created_by'], 'required'],
            [['image'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['image_enc_id', 'organization_enc_id', 'title', 'alt', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['image_location'], 'string', 'max' => 200],
            [['image_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}
