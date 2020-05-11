<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%top_organizations_blogs_list}}".
 *
 * @property int $id
 * @property string $top_organizations_blogs_list_enc_id
 * @property string $top_organizations_blogs_enc_id
 * @property string $blog_information_enc_id
 * @property int $sequence
 * @property string $created_on
 * @property string $created_by
 *
 * @property Users $createdBy
 * @property OrganizationBlogInformation $blogInformationEnc
 * @property TopOrganizationsBlogs $topOrganizationsBlogsEnc
 */
class TopOrganizationsBlogsList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%top_organizations_blogs_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['top_organizations_blogs_list_enc_id', 'top_organizations_blogs_enc_id', 'blog_information_enc_id', 'sequence'], 'required'],
            [['sequence'], 'integer'],
            [['created_on'], 'safe'],
            [['top_organizations_blogs_list_enc_id', 'top_organizations_blogs_enc_id', 'blog_information_enc_id', 'created_by'], 'string', 'max' => 100],
            [['top_organizations_blogs_list_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['blog_information_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationBlogInformation::className(), 'targetAttribute' => ['blog_information_enc_id' => 'blog_information_enc_id']],
            [['top_organizations_blogs_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => TopOrganizationsBlogs::className(), 'targetAttribute' => ['top_organizations_blogs_enc_id' => 'top_organizations_blogs_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

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
    public function getBlogInformationEnc()
    {
        return $this->hasOne(OrganizationBlogInformation::className(), ['blog_information_enc_id' => 'blog_information_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopOrganizationsBlogsEnc()
    {
        return $this->hasOne(TopOrganizationsBlogs::className(), ['top_organizations_blogs_enc_id' => 'top_organizations_blogs_enc_id']);
    }
}
