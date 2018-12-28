<?php

namespace common\models;

/**
 * This is the model class for table "{{%applied_application_process}}".
 *
 * @property int $id Primary Key
 * @property string $process_enc_id Process Encrypted ID
 * @property string $applied_application_enc_id Foreign Key to Applied Applications Table
 * @property string $field_enc_id Foreign Key to Interview Process Fields Table
 * @property int $is_completed Is Process Completed (0 as False, 1 as True)
 * @property string $comments Process Comments
 * @property string $created_on On which date Applied Application Process information was added to database
 * @property string $created_by By which User Applied Application Process information was added
 * @property string $last_updated_on On which date Applied Application Process information was updated
 * @property string $last_updated_by By which User Applied Application Process information was updated
 * @property string $status Application Process Status ('Pending', 'On Hold', 'Rejected', 'Approved')
 * @property int $is_deleted Is Applied Application Process Deleted (0 as False, 1 as True)
 *
 * @property AppliedApplications $appliedApplicationEnc
 * @property InterviewProcessFields $fieldEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class AppliedApplicationProcess extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%applied_application_process}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['process_enc_id', 'applied_application_enc_id', 'field_enc_id', 'created_on', 'created_by'], 'required'],
            [['is_completed', 'is_deleted'], 'integer'],
            [['comments', 'status'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['process_enc_id', 'applied_application_enc_id', 'field_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['process_enc_id'], 'unique'],
            [['applied_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppliedApplications::className(), 'targetAttribute' => ['applied_application_enc_id' => 'applied_application_enc_id']],
            [['field_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => InterviewProcessFields::className(), 'targetAttribute' => ['field_enc_id' => 'field_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationEnc() {
        return $this->hasOne(AppliedApplications::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldEnc() {
        return $this->hasOne(InterviewProcessFields::className(), ['field_enc_id' => 'field_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

}
