<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%hiring_process_templates}}".
 *
 * @property int $id Primary Key
 * @property string $hiring_process_enc_id Hiring Process Encrypted ID
 * @property string $process_name Hiring Process Name
 * @property string $created_on On which date Hiring Process information was added to database
 * @property string $created_by By which User Hiring Process information was added
 * @property string $last_updated_on On which date Hiring Process information was updated
 * @property string $last_updated_by By which User Hiring Process information was updated
 * @property int $is_deleted Is Hiring Process Deleted (0 as False, 1 as True)
 *
 * @property BookmarkedHiringTemplates[] $bookmarkedHiringTemplates
 * @property Organizations[] $organizationEncs
 * @property HiringProcessTemplateFields[] $hiringProcessTemplateFields
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class HiringProcessTemplates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hiring_process_templates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hiring_process_enc_id', 'process_name', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['hiring_process_enc_id', 'process_name', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['hiring_process_enc_id'], 'unique'],
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
    public function getBookmarkedHiringTemplates()
    {
        return $this->hasMany(BookmarkedHiringTemplates::className(), ['hiring_process_enc_id' => 'hiring_process_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEncs()
    {
        return $this->hasMany(Organizations::className(), ['organization_enc_id' => 'organization_enc_id'])->viaTable('{{%bookmarked_hiring_templates}}', ['hiring_process_enc_id' => 'hiring_process_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHiringProcessTemplateFields()
    {
        return $this->hasMany(HiringProcessTemplateFields::className(), ['hiring_process_enc_id' => 'hiring_process_enc_id']);
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
