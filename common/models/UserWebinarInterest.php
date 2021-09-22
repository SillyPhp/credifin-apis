<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_webinar_interest}}".
 *
 * @property int $id Primary Key
 * @property string $webinar_interest_enc_id Webinar Registration Encrypted Encrypted ID
 * @property string $webinar_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $interest_status 1 interested,2 not interested,3 attending
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Webinar $webinarEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class UserWebinarInterest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_webinar_interest}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['webinar_interest_enc_id', 'webinar_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['interest_status', 'is_deleted'], 'integer'],
            [['webinar_interest_enc_id', 'webinar_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['webinar_interest_enc_id'], 'unique'],
            [['webinar_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinar::className(), 'targetAttribute' => ['webinar_enc_id' => 'webinar_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEnc()
    {
        return $this->hasOne(Webinar::className(), ['webinar_enc_id' => 'webinar_enc_id']);
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
