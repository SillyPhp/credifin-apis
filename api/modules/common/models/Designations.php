<?php

namespace common\models;

/**
 * This is the model class for table "{{%designations}}".
 *
 * @property int $id Primary Key
 * @property string $designation_enc_id Designation Encrypted ID
 * @property string $designation Designation
 * @property string $slug Slug
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property string $created_on On which date Designation information was added to database
 * @property string $created_by By which User Designation information was added
 * @property string $last_updated_on On which date Designation information was updated
 * @property string $last_updated_by By which User Designation information was updated
 * @property string $status Designation Status (Publish, Pending)
 * @property int $is_deleted Is Designation Deleted (0 As False, 1 As True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Organizations $organizationEnc
 * @property EmployerApplications[] $employerApplications
 */
class Designations extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%designations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['designation_enc_id', 'designation', 'slug', 'created_on', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['is_deleted'], 'integer'],
            [['designation_enc_id', 'designation', 'slug', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['designation_enc_id'], 'unique'],
            [['designation'], 'unique'],
            [['slug'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc() {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications() {
        return $this->hasMany(EmployerApplications::className(), ['designation_enc_id' => 'designation_enc_id']);
    }

}
