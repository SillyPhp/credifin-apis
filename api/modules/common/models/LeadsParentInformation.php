<?php

namespace common\models;

/**
 * This is the model class for table "{{%leads_parent_information}}".
 *
 * @property int $id Primary Key
 * @property string $lead_parent_enc_id Encrypted Key
 * @property string $application_enc_id application_enc_id
 * @property string $name
 * @property string $relation_with_student
 * @property string $mobile_number
 * @property double $annual_income
 * @property string $created_on
 * @property string $created_by may be null or not , filler id who has filled the form
 * @property string $last_updated_by
 * @property string $last_updated_on
 *
 * @property LeadsApplications $applicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class LeadsParentInformation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%leads_parent_information}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lead_parent_enc_id', 'application_enc_id'], 'required'],
            [['annual_income'], 'number'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['lead_parent_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['name', 'relation_with_student'], 'string', 'max' => 200],
            [['mobile_number'], 'string', 'max' => 15],
            [['lead_parent_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeadsApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
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
    public function getApplicationEnc()
    {
        return $this->hasOne(LeadsApplications::className(), ['application_enc_id' => 'application_enc_id']);
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
