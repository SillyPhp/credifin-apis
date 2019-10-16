<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_blog_information_images}}".
 *
 * @property int $id
 * @property string $image_enc_id
 * @property string $blog_information_enc_id
 * @property string $image
 * @property string $image_location
 * @property string $created_on
 * @property string $created_by
 *
 * @property OrganizationBlogInformation $blogInformationEnc
 * @property Users $createdBy
 */
class OrganizationBlogInformationImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_blog_information_images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_enc_id', 'blog_information_enc_id', 'image', 'image_location'], 'required'],
            [['created_on'], 'safe'],
            [['image_enc_id', 'blog_information_enc_id', 'image', 'image_location', 'created_by'], 'string', 'max' => 100],
            [['image_enc_id'], 'unique'],
            [['blog_information_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationBlogInformation::className(), 'targetAttribute' => ['blog_information_enc_id' => 'blog_information_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogInformationEnc()
    {
        return $this->hasOne(OrganizationBlogInformation::className(), ['blog_information_enc_id' => 'blog_information_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
