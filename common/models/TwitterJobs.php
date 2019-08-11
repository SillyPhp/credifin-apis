<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%twitter_jobs}}".
 *
 * @property int $id Primary Key
 * @property string $tweet_enc_id Route Encrypted Encrypted ID
 * @property string $profile job profile
 * @property string $job_title job title
 * @property string $job_type job type
 * @property string $url url
 * @property string $contact_email
 * @property string $apply_url
 * @property string $author_name Name
 * @property string $author_url author url
 * @property string $html_code html code
 * @property string $created_on On which date information was added to database
 * @property string $created_by By which User information was added
 * @property string $last_updated_on On which date information was updated
 * @property string $last_updated_by By which User information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class TwitterJobs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%twitter_jobs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tweet_enc_id', 'profile', 'job_title', 'job_type', 'url', 'author_name', 'author_url', 'html_code', 'created_by'], 'required'],
            [['job_type'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['tweet_enc_id', 'profile', 'job_title', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['url', 'contact_email', 'apply_url', 'author_name', 'author_url', 'html_code'], 'string', 'max' => 255],
            [['tweet_enc_id'], 'unique'],
            [['url'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }
}
