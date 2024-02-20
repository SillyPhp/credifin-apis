<?php

namespace common\models;

/**
 * This is the model class for table "{{%application_reminder}}".
 *
 * @property int $id Primary Key
 * @property string $reminder_enc_id Reminder Encrypted ID
 * @property string $application_name Application Name
 * @property string $organization_name Organization Name
 * @property string $applied_platform Platform name where job applied
 * @property string $description Reminder Description
 * @property string $link Applied Application Link
 * @property string $date Applied Application Date
 * @property double $salary Application Salary
 * @property string $status Application Status
 * @property int $is_deleted Is Reminder Deleted (0 as False & 1 as True)
 * @property string $created_on On which date Reminder was added to database
 * @property string $created_by By which User Reminder was added
 * @property string $last_updated_on On which date Reminder was updated
 * @property string $last_updated_by By which User Reminder was updated
 */
class ApplicationReminder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application_reminder}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reminder_enc_id', 'application_name', 'organization_name', 'applied_platform', 'link', 'date', 'salary', 'status', 'created_on', 'created_by'], 'required'],
            [['description', 'status'], 'string'],
            [['date', 'created_on', 'last_updated_on'], 'safe'],
            [['salary'], 'number'],
            [['is_deleted'], 'integer'],
            [['reminder_enc_id', 'application_name', 'organization_name', 'applied_platform', 'link', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['reminder_enc_id'], 'unique'],
        ];
    }
}
