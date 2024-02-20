<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%seo}}".
 *
 * @property int $id Primary Key
 * @property string $seo_enc_id SEO Encrypted ID
 * @property string $route URL Route
 * @property string $title Title
 * @property string $keywords Keywords
 * @property string $description Description
 * @property string $canonical Canonical URL
 * @property string $featured_image Featured Image
 * @property string $featured_image_location Featured Image Location
 * @property string $twitter_card Twitter Card
 * @property string $twitter_title Twitter Title
 * @property string $twitter_site Twitter Site
 * @property string $twitter_creator Twitter Creator
 * @property string $twitter_image Twitter Image
 * @property string $twitter_image_location
 * @property string $og_locale OG Locale
 * @property string $og_type OG Type
 * @property string $og_site_name OG Site Name
 * @property string $og_url OG URL
 * @property string $og_title OG Title
 * @property string $og_description OG Description
 * @property string $og_image OG Image
 * @property string $og_image_location OG Image Location
 * @property string $created_on On which date SEO information was added to database
 * @property string $created_by By which User SEO  information was added
 * @property string $last_updated_on On which date SEO information was updated
 * @property string $last_updated_by By which User SEO information was updated
 * @property int $status Status (0 as Inactive, 1 as Active)
 * @property int $is_deleted Is SEO Information Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seo_enc_id', 'route', 'title', 'keywords', 'description', 'twitter_title', 'og_title', 'og_description', 'created_by'], 'required'],
            [['keywords'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['seo_enc_id', 'route', 'canonical', 'featured_image', 'featured_image_location', 'twitter_image', 'twitter_image_location', 'og_url', 'og_image', 'og_image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['title', 'twitter_title', 'og_title'], 'string', 'max' => 70],
            [['description', 'og_description'], 'string', 'max' => 160],
            [['twitter_card', 'og_type'], 'string', 'max' => 20],
            [['twitter_site', 'twitter_creator', 'og_site_name'], 'string', 'max' => 50],
            [['og_locale'], 'string', 'max' => 10],
            [['seo_enc_id'], 'unique'],
            [['route'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
}