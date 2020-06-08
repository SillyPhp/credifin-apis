<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinar_registrations}}".
 *
 * @property int $id Primary Key
 * @property string $register_enc_id Webinar Registration Encrypted Encrypted ID
 * @property string $webinar_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $status 0 as Pending, 1 as Approved, 2 as Rejected, 3 as Failed
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Webinars $webinarEnc
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 */
class WebinarRegistrations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar_registrations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['register_enc_id', 'webinar_enc_id', 'created_by', 'status'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['register_enc_id', 'webinar_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['register_enc_id'], 'unique'],
            [['webinar_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinars::className(), 'targetAttribute' => ['webinar_enc_id' => 'webinar_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEnc()
    {
        return $this->hasOne(Webinars::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
