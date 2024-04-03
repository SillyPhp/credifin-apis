<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_locations}}".
 *
 * @property int $id
 * @property string $user_location_enc_id
 * @property double $latitude Location Latitude
 * @property double $longitude Location Longitude
 * @property string $page_location
 * @property string $created_by
 * @property string $created_on
 *
 * @property Users $createdBy
 */
class UserLocations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_locations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_location_enc_id', 'latitude', 'longitude', 'created_by', 'created_on'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['created_on'], 'safe'],
            [['user_location_enc_id', 'page_location', 'created_by'], 'string', 'max' => 100],
            [['user_location_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
