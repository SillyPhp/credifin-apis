<?php
namespace common\models;

/**
 * This is the model class for table "{{%drop_resume_applied_titles}}".
 *
 * @property int $id Primary Key
 * @property string $applied_title_enc_id Application Encrypted ID
 * @property string $applied_application_enc_id
 * @property string $assigned_category_enc_id assigned_category_enc_id
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property int $status Application Status (0 as Pending, 1 as Shortlisted, 2 as Rejected)
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property AssignedCategories $assignedCategoryEnc
 * @property DropResumeAppliedApplications $appliedApplicationEnc
 */
class DropResumeAppliedTitles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%drop_resume_applied_titles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['applied_title_enc_id', 'applied_application_enc_id', 'assigned_category_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['applied_title_enc_id', 'applied_application_enc_id', 'assigned_category_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['applied_title_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['assigned_category_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => AssignedCategories::className(), 'targetAttribute' => ['assigned_category_enc_id' => 'assigned_category_enc_id']],
            [['applied_application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => DropResumeAppliedApplications::className(), 'targetAttribute' => ['applied_application_enc_id' => 'applied_application_enc_id']],
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
    public function getAssignedCategoryEnc()
    {
        return $this->hasOne(AssignedCategories::className(), ['assigned_category_enc_id' => 'assigned_category_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppliedApplicationEnc()
    {
        return $this->hasOne(DropResumeAppliedApplications::className(), ['applied_application_enc_id' => 'applied_application_enc_id']);
    }
}
