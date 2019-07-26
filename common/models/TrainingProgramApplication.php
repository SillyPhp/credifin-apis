<?php

namespace common\models;

/**
 * This is the model class for table "{{%training_program_application}}".
 *
 * @property int $id Primary Key
 * @property string $application_enc_id Application Encrypted ID
 * @property string $profie_enc_id Foreign Key to Organizations Table
 * @property string $assigned_category_id
 * @property string $application_type_enc_id Foreign Key to Application Types Table
 * @property string $slug Application Slug
 * @property string $description Application Description
 * @property string $fees Foreign Key to Assigned Categories Table
 * @property string $fees_type Preferred Gender (1 as Male, 2 as Female, 3 as Both)
 * @property string $training_duration
 * @property string $training_duration_type
 * @property string $created_on On which date Application information was added to database
 * @property string $created_by By which User Application information was added
 * @property string $last_updated_on On which date Application information was updated
 * @property string $last_updated_by By which User Application information was updated
 * @property int $is_deleted Is Application Deleted (0 as False, 1 as True)
 */
class TrainingProgramApplication extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%training_program_application}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_enc_id', 'profie_enc_id', 'assigned_category_id', 'application_type_enc_id', 'slug', 'fees', 'fees_type', 'training_duration', 'training_duration_type', 'created_by'], 'required'],
            [['description', 'fees_type', 'training_duration_type'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['application_enc_id', 'profie_enc_id', 'assigned_category_id', 'application_type_enc_id', 'slug', 'fees', 'training_duration', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['application_enc_id'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

}
