<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%hiring_process_notes}}".
 *
 * @property int $id Primary Key
 * @property string $notes_enc_id Notes Encrypted ID
 * @property string $notes Notes
 * @property string $applied_application_enc_id Foreign Key to Applied Applications Table
 * @property string $created_on On which date Note was added to database
 * @property string $created_by By which User Note was added
 * @property string $last_updated_on On which date Note was updated
 * @property string $last_updated_by By which User Note was updated
 *
 * @property AppliedApplications $appliedApplicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class HiringProcessNotes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%hiring_process_notes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notes_enc_id', 'applied_application_enc_id', 'created_by'], 'required'],
            [['notes'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['notes_enc_id', 'applied_application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['notes_enc_id'], 'unique'],
            [['applied_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppliedApplications::className(), 'targetAttribute' => ['applied_application_enc_id' => 'applied_application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'notes_enc_id' => Yii::t('app', 'Notes Enc ID'),
            'notes' => Yii::t('app', 'Notes'),
            'applied_application_enc_id' => Yii::t('app', 'Applied Application Enc ID'),
            'created_on' => Yii::t('app', 'Created On'),
            'created_by' => Yii::t('app', 'Created By'),
            'last_updated_on' => Yii::t('app', 'Last Updated On'),
            'last_updated_by' => Yii::t('app', 'Last Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationEnc()
    {
        return $this->hasOne(AppliedApplications::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
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
