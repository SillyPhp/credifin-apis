<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webinar_request}}".
 *
 * @property int $id
 * @property string $request_enc_id
 * @property string $title
 * @property string $date
 * @property int $seats
 * @property string $objectives
 * @property string $created_by
 * @property string $created_on
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property WebinarRequestSpeakers[] $webinarRequestSpeakers
 */
class WebinarRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar_request}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_enc_id', 'title', 'created_by'], 'required'],
            [['date', 'created_on', 'last_updated_on'], 'safe'],
            [['seats', 'is_deleted'], 'integer'],
            [['objectives'], 'string'],
            [['request_enc_id', 'title', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['request_enc_id'], 'unique'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRequestSpeakers()
    {
        return $this->hasMany(WebinarRequestSpeakers::className(), ['webinar_request_enc_id' => 'request_enc_id']);
    }
}
