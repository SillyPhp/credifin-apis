<?php

namespace common\models;

/**
 * This is the model class for table "{{%pool_webinar_outcomes}}".
 *
 * @property int $id Primary Key
 * @property string $outcome_pool_enc_id Encrypted Encrypted ID
 * @property string $name Outtcome title
 * @property string $icon
 * @property string $icon_location
 * @property string $bg_colour
 * @property string $created_on
 * @property string $created_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Users $createdBy
 * @property WebinarOutcomes[] $webinarOutcomes
 */
class PoolWebinarOutcomes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pool_webinar_outcomes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['outcome_pool_enc_id', 'name', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['outcome_pool_enc_id', 'icon', 'icon_location', 'created_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
            [['bg_colour'], 'string', 'max' => 6],
            [['outcome_pool_enc_id'], 'unique'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarOutcomes()
    {
        return $this->hasMany(WebinarOutcomes::className(), ['outcome_pool_enc_id' => 'outcome_pool_enc_id']);
    }
}
