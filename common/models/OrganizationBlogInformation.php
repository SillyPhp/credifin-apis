<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_blog_information}}".
 *
 * @property int $id
 * @property string $blog_information_enc_id
 * @property string $title
 * @property string $description
 * @property string $organization_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property int $is_deleted
 *
 * @property OrganizationBlogInfoLocations[] $organizationBlogInfoLocations
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property OrganizationBlogInformationImages[] $organizationBlogInformationImages
 */
class OrganizationBlogInformation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_blog_information}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_information_enc_id', 'title', 'description'], 'required'],
            [['title', 'description'], 'string'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['blog_information_enc_id', 'organization_enc_id', 'created_by'], 'string', 'max' => 100],
            [['blog_information_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationBlogInfoLocations()
    {
        return $this->hasMany(OrganizationBlogInfoLocations::className(), ['blog_information_enc_id' => 'blog_information_enc_id']);
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
    public function getOrganizationBlogInformationImages()
    {
        return $this->hasMany(OrganizationBlogInformationImages::className(), ['blog_information_enc_id' => 'blog_information_enc_id']);
    }
}
