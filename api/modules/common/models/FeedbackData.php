<?php

namespace common\models;

/**
 * This is the model class for table "{{%feedback_data}}".
 *
 * @property int $id Primary Key
 * @property string $feedback_enc_id Feedback Encrypted ID
 * @property string $name Name
 * @property string $email Email
 * @property string $phone Phone
 * @property string $subject Subject
 * @property string $feedback Feedback
 * @property string $created_on On which date Feedback information was added to database
 * @property string $last_updated_on On which date Feedback information was updated
 */
class FeedbackData extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%feedback_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['feedback_enc_id', 'name', 'email', 'subject', 'feedback', 'created_on'], 'required'],
            [['feedback'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['feedback_enc_id', 'name', 'subject'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['feedback_enc_id'], 'unique'],
        ];
    }

}
