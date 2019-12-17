<?php

namespace common\models;

/**
 * This is the model class for table "{{%application_edu_req_template}}".
 *
 * @property int $id Primary Key
 * @property string $application_educational_requirement_enc_id Option Encrypted ID
 * @property string $educational_requirement_enc_id
 * @property string $application_enc_id
 * @property string $created_on On which date Option information was added to database
 * @property string $created_by By which User Option information was added
 * @property string $last_updated_on On which date Option information was updated
 * @property string $last_updated_by By which User Option information was updated
 * @property int $is_deleted 0 as true, 1 as false
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property ApplicationTemplates $applicationEnc
 * @property EducationalRequirements $educationalRequirementEnc
 */
class ApplicationEduReqTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application_edu_req_template}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_educational_requirement_enc_id', 'educational_requirement_enc_id', 'application_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['application_educational_requirement_enc_id', 'educational_requirement_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_educational_requirement_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationTemplates::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['educational_requirement_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EducationalRequirements::className(), 'targetAttribute' => ['educational_requirement_enc_id' => 'educational_requirement_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('dsbedutech', 'ID'),
            'application_educational_requirement_enc_id' => Yii::t('dsbedutech', 'Application Educational Requirement Enc ID'),
            'educational_requirement_enc_id' => Yii::t('dsbedutech', 'Educational Requirement Enc ID'),
            'application_enc_id' => Yii::t('dsbedutech', 'Application Enc ID'),
            'created_on' => Yii::t('dsbedutech', 'Created On'),
            'created_by' => Yii::t('dsbedutech', 'Created By'),
            'last_updated_on' => Yii::t('dsbedutech', 'Last Updated On'),
            'last_updated_by' => Yii::t('dsbedutech', 'Last Updated By'),
            'is_deleted' => Yii::t('dsbedutech', 'Is Deleted'),
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
    public function getApplicationEnc()
    {
        return $this->hasOne(ApplicationTemplates::className(), ['application_enc_id' => 'application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalRequirementEnc()
    {
        return $this->hasOne(EducationalRequirements::className(), ['educational_requirement_enc_id' => 'educational_requirement_enc_id']);
    }
}
