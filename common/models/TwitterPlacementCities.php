<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%twitter_placement_cities}}".
 *
 * @property int $id Primary Key
 * @property string $placement_cities_enc_id Placement Cities Encrypted ID
 * @property string $tweet_enc_id Foreign Key To twitter Applications Table
 * @property string $city_enc_id Foreign Key To Employer Cities Table
 * @property string $created_on On which date Wage information was added to database
 * @property string $created_by By which User Wage information was added
 * @property int $is_deleted
 * @property string $last_updated_on On which date Wage information was updated
 * @property string $last_updated_by By which User Wage information was updated
 *
 * @property TwitterJobs $tweetEnc
 * @property Cities $cityEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class TwitterPlacementCities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%twitter_placement_cities}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['placement_cities_enc_id', 'tweet_enc_id', 'city_enc_id'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['placement_cities_enc_id', 'tweet_enc_id', 'city_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['placement_cities_enc_id'], 'unique'],
            [['tweet_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => TwitterJobs::className(), 'targetAttribute' => ['tweet_enc_id' => 'tweet_enc_id']],
            [['city_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_enc_id' => 'city_enc_id']],
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
    public function getTweetEnc()
    {
        return $this->hasOne(TwitterJobs::className(), ['tweet_enc_id' => 'tweet_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'city_enc_id']);
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
