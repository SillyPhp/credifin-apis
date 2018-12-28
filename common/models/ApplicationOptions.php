<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%application_options}}".
 *
 * @property int $id Primary Key
 * @property string $option_enc_id Option Encrypted ID
 * @property string $application_enc_id Foreign Key To Employer Applications Table
 * @property string $option_name Option
 * @property string $value Option Value
 * @property string $created_on On which date Option information was added to database
 * @property string $created_by By which User Option information was added
 * @property string $last_updated_on On which date Option information was updated
 * @property string $last_updated_by By which User Option information was updated
 *
 * @property EmployerApplications $applicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ApplicationOptions extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%application_options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['option_enc_id', 'application_enc_id', 'option_name', 'created_on', 'created_by'], 'required'],
            [['option_name'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['option_enc_id', 'application_enc_id', 'value', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['option_enc_id'], 'unique'],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployerApplications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc() {
        return $this->hasOne(EmployerApplications::className(), ['application_enc_id' => 'application_enc_id']);
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
