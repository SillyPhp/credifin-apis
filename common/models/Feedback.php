<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%feedback}}".
 *
 * @property int $id Primary Key
 * @property string $feedback_enc_id Feedback Encrypted ID
 * @property string $feedback Feedback
 * @property string $created_on On which date Feedback information was added to database
 * @property string $created_by By which User Feedback information was added
 * @property string $last_updated_on On which date Feedback information was updated
 * @property string $last_updated_by By which User Feedback information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class Feedback extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%feedback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['feedback_enc_id', 'feedback', 'created_on', 'created_by'], 'required'],
            [['feedback'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['feedback_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['feedback_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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

}
