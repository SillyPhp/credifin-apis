<?php

namespace common\models;

/**
 * This is the model class for table "{{%leads_college_preference}}".
 *
 * @property int $id Primary Key
 * @property string $preference_enc_id preference enc id of college
 * @property string $application_enc_id Encrypted Key
 * @property string $college_name
 * @property string $sequence
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_by
 * @property string $last_updated_on
 *
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 * @property LeadsApplications $applicationEnc
 */
class LeadsCollegePreference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%leads_college_preference}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['preference_enc_id', 'application_enc_id', 'college_name'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['preference_enc_id', 'application_enc_id', 'college_name', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['sequence'], 'string', 'max' => 50],
            [['preference_enc_id'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeadsApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(LeadsApplications::className(), ['application_enc_id' => 'application_enc_id']);
    }
}
