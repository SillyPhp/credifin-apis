<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_blog_information_applications}}".
 *
 * @property int $id
 * @property string $blog_information_applications_enc_id
 * @property string $application_enc_id
 * @property string $blog_information_enc_id
 * @property string $created_on
 * @property string $created_by
 *
 * @property OrganizationBlogInformation $blogInformationEnc
 * @property EmployerApplications $applicationEnc
 * @property Users $createdBy
 */
class OrganizationBlogInformationApplications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_blog_information_applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_information_applications_enc_id', 'application_enc_id', 'blog_information_enc_id'], 'required'],
            [['created_on'], 'safe'],
            [['blog_information_applications_enc_id', 'application_enc_id', 'blog_information_enc_id', 'created_by'], 'string', 'max' => 100],
            [['blog_information_applications_enc_id'], 'unique'],
            [['blog_information_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationBlogInformation::className(), 'targetAttribute' => ['blog_information_enc_id' => 'blog_information_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogInformationEnc()
    {
        return $this->hasOne(Users::className(), ['blog_information_enc_id' => 'blog_information_enc_id', 'application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}