<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%quiz_registration}}".
 *
 * @property int $id Primary Key
 * @property string $register_enc_id Quiz Registration Encrypted ID
 * @property string $quiz_enc_id
 * @property string $referral_enc_id
 * @property int $status 0 as Pending 1 as Approved
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property QuizPayments[] $quizPayments
 * @property Quizzes $quizEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class QuizRegistration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quiz_registration}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['register_enc_id', 'quiz_enc_id', 'created_by'], 'required'],
            [['status', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['register_enc_id', 'quiz_enc_id', 'referral_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['register_enc_id'], 'unique'],
            [['quiz_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quizzes::className(), 'targetAttribute' => ['quiz_enc_id' => 'quiz_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizPayments()
    {
        return $this->hasMany(QuizPayments::className(), ['registration_enc_id' => 'register_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizEnc()
    {
        return $this->hasOne(Quizzes::className(), ['quiz_enc_id' => 'quiz_enc_id']);
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
