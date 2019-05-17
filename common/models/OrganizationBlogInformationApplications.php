<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_blog_information_applications}}".
 *
 * @property int $id
 * @property string $Information_application_enc_id
 * @property string $application_enc_id
 * @property string $blog_information_enc_id
 * @property string $created_on
 * @property string $created_by
 *
 * @property Users $applicationEnc
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
            [['Information_application_enc_id', 'application_enc_id', 'blog_information_enc_id', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['Information_application_enc_id', 'application_enc_id', 'blog_information_enc_id', 'created_by'], 'string', 'max' => 100],
            [['Information_application_enc_id'], 'unique'],
            [['application_enc_id', 'created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id', 'created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(Users::className(), ['application_enc_id' => 'application_enc_id', 'user_enc_id' => 'created_by']);
    }
}
