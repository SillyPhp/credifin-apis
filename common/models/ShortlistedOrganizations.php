<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shortlisted_organizations}}".
 *
 * @property int $id Primary Key
 * @property string $shortlisted_enc_id Shortlisted Encrypted ID
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property int $shortlisted Shortlisted Status (0 as Not Shortlisted, 1 as Shortlisted)
 * @property string $created_on On which date Organization Shortlisted information was added to database
 * @property string $created_by By which User Organization Shortlisted information was added
 * @property string $last_updated_on On which date Organization Shortlisted information was updated
 * @property string $last_updated_by By which User Organization Shortlisted information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Organizations $organizationEnc
 */
class ShortlistedOrganizations extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%shortlisted_organizations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['shortlisted_enc_id', 'organization_enc_id', 'created_on', 'created_by'], 'required'],
            [['shortlisted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['shortlisted_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['shortlisted_enc_id'], 'unique'],
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

}
