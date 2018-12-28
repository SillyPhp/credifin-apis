<?php

namespace common\models;

/**
 * This is the model class for table "{{%selected_services}}".
 *
 * @property int $id Primary Key
 * @property string $selected_service_enc_id Selected Service Encrypted ID
 * @property string $service_enc_id Foreign Key to Services Table
 * @property string $organization_enc_id Foreign Key to Organizations Table
 * @property int $is_selected Is Service Used (0 as False, 1 as True)
 * @property string $created_on On which date Service information was added to database
 * @property string $created_by By which User Service information was added
 * @property string $last_updated_on On which date Service information was updated
 * @property string $last_updated_by By which User Service information was updated
 *
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Services $serviceEnc
 */
class SelectedServices extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%selected_services}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['selected_service_enc_id', 'service_enc_id', 'created_on', 'created_by'], 'required'],
            [['is_selected'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['selected_service_enc_id', 'service_enc_id', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['selected_service_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['service_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::className(), 'targetAttribute' => ['service_enc_id' => 'service_enc_id']],
        ];
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
    public function getServiceEnc() {
        return $this->hasOne(Services::className(), ['service_enc_id' => 'service_enc_id']);
    }

}
