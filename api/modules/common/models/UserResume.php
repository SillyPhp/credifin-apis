<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_resume}}".
 *
 * @property int $id Primary Key
 * @property string $resume_enc_id Resume Encrypted ID
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $resume Resume
 * @property string $resume_location Resume Location
 * @property string $title Resume Title
 * @property string $alt Alternative Text of Resume
 * @property string $created_on On which date Resume information was added to database
 * @property string $created_by By which User Resume information was added
 * @property string $last_updated_on On which date Resume information was updated
 * @property string $last_updated_by By which User Resume information was updated
 *
 * @property Users $userEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class UserResume extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%user_resume}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['resume_enc_id', 'user_enc_id', 'resume', 'resume_location', 'created_on', 'created_by'], 'required'],
            [['resume'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['resume_enc_id', 'user_enc_id', 'title', 'alt', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['resume_location'], 'string', 'max' => 200],
            [['resume_enc_id'], 'unique'],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
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
