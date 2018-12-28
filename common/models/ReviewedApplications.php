<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%reviewed_applications}}".
 *
 * @property int $id Primary Key
 * @property string $review_enc_id Review Encrypted ID
 * @property string $application_enc_id Foreign Key to Employer Applications Table
 * @property int $review Review Status (0 as Not Shortlisted, 1 as Shortlisted)
 * @property string $created_on On which date Application Review information was added to database
 * @property string $created_by By which User Application Review information was added
 * @property string $last_updated_on On which date Application Review information was updated
 * @property string $last_updated_by By which User Application Review information was updated
 *
 * @property EmployerApplications $applicationEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class ReviewedApplications extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%reviewed_applications}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['review_enc_id', 'application_enc_id', 'created_on', 'created_by'], 'required'],
            [['review'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['review_enc_id', 'application_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['review_enc_id'], 'unique'],
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
