<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_blog_info_locations}}".
 *
 * @property int $id
 * @property string $blog_information_location_enc_id
 * @property string $blog_information_enc_id
 * @property string $city_enc_id
 * @property string $created_on
 * @property string $created_by
 *
 * @property OrganizationBlogInformation $blogInformationEnc
 * @property Users $createdBy
 * @property Cities $cityEnc
 */
class OrganizationBlogInfoLocations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_blog_info_locations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['blog_information_location_enc_id', 'blog_information_enc_id', 'city_enc_id'], 'required'],
            [['created_on'], 'safe'],
            [['blog_information_location_enc_id', 'blog_information_enc_id', 'city_enc_id', 'created_by'], 'string', 'max' => 100],
            [['blog_information_location_enc_id'], 'unique'],
            [['blog_information_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationBlogInformation::className(), 'targetAttribute' => ['blog_information_enc_id' => 'blog_information_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
    }
}
