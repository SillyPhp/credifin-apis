<?php

namespace common\models;

/**
 * This is the model class for table "{{%organization_employees}}".
 *
 * @property int $id Primary Key
 * @property string $employee_enc_id Employee Encrypted ID
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $first_name First Name
 * @property string $last_name Last Name
 * @property string $image Employee Image
 * @property string $image_location Location of the Employee Image
 * @property string $facebook Facebook URL
 * @property string $twitter Twitter URL
 * @property string $linkedin Linkedin URL
 * @property string $created_on On which date Employee information was added to database
 * @property string $created_by By which User Employee information was added
 * @property string $last_updated_on On which date Employee information was updated
 * @property string $last_updated_by By which User Employee information was updated
 * @property int $is_deleted Is Employee Deleted (0 as False, 1 as True)
 * @property string $designation
 *
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class OrganizationEmployees extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%organization_employees}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['employee_enc_id', 'organization_enc_id', 'first_name', 'last_name', 'created_by', 'designation'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['employee_enc_id', 'organization_enc_id', 'image', 'image_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['first_name', 'last_name'], 'string', 'max' => 30],
            [['facebook', 'twitter', 'linkedin', 'designation'], 'string', 'max' => 50],
            [['employee_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
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
