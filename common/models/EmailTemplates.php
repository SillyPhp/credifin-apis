<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%email_templates}}".
 *
 * @property int $id Primary Key
 * @property string $template_enc_id Email Template Encrypted ID
 * @property string $template_name Name of the Template
 * @property resource $content Template Html Content
 * @property string $subject
 * @property string $purpose
 * @property string $template_type
 * @property string $created_on On which date User Work Experience information was added to database
 * @property string $created_by By which User Work Experience information was added
 * @property string $last_updated_on On which date User Work Experience information was updated
 * @property string $last_updated_by By which User User Work Experience information was updated
 * @property int $is_deleted 0 as true, 1 as false
 *
 * @property AssignEmailGroups[] $assignEmailGroups
 * @property EmailSchedule[] $emailSchedules
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property MisEmailLogs[] $misEmailLogs
 */
class EmailTemplates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%email_templates}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_enc_id', 'template_name', 'content', 'created_by'], 'required'],
            [['content', 'template_type'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['template_enc_id', 'template_name', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['subject', 'purpose'], 'string', 'max' => 200],
            [['template_enc_id'], 'unique'],
            [['template_name'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignEmailGroups()
    {
        return $this->hasMany(AssignEmailGroups::className(), ['template_enc_id' => 'template_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmailSchedules()
    {
        return $this->hasMany(EmailSchedule::className(), ['template_enc_id' => 'template_enc_id']);
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
    public function getMisEmailLogs()
    {
        return $this->hasMany(MisEmailLogs::className(), ['template_enc_id' => 'template_enc_id']);
    }
}
