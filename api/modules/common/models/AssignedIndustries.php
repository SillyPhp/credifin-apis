<?php

namespace common\models;

/**
 * This is the model class for table "{{%assigned_industries}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_industry_enc_id Assigned Industry Encrypted ID
 * @property string $industry_enc_id Foreign Key to Industries Table
 * @property string $business_activity_enc_id Foreign Key to Business Activities Table
 * @property string $created_on On which date Industry information was added to database
 * @property string $created_by By which User Industry information was added
 * @property string $last_updated_on On which date Industry information was updated
 * @property string $last_updated_by By which User Industry information was updated
 *
 * @property BusinessActivities $businessActivityEnc
 * @property Industries $industryEnc
 * @property Users $createdBy
 * @property Users $industryEnc0
 */
class AssignedIndustries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_industries}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_industry_enc_id', 'industry_enc_id', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['assigned_industry_enc_id', 'industry_enc_id', 'business_activity_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['assigned_industry_enc_id'], 'unique'],
            [['business_activity_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessActivities::className(), 'targetAttribute' => ['business_activity_enc_id' => 'business_activity_enc_id']],
            [['industry_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['industry_enc_id' => 'industry_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['industry_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['industry_enc_id' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessActivityEnc()
    {
        return $this->hasOne(BusinessActivities::className(), ['business_activity_enc_id' => 'business_activity_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustryEnc()
    {
        return $this->hasOne(Industries::className(), ['industry_enc_id' => 'industry_enc_id']);
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
    public function getIndustryEnc0()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'industry_enc_id']);
    }
}
