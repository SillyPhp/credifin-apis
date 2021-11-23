<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%quiz_rewards}}".
 *
 * @property int $id
 * @property string $quiz_reward_enc_id reward table encripted id
 * @property string $quiz_enc_id Foreign Key to quizzes table
 * @property string $position_enc_id Foreign Key to rewards position pool table
 * @property string $amount reward amount in string
 * @property double $price reward price in number
 * @property string $created_by
 * @property string $created_on
 * @property string $last_updated_by
 * @property string $last_updated_on
 * @property int $is_deleted
 *
 * @property QuizRewardCertificates[] $quizRewardCertificates
 * @property Quizzes $quizEnc
 * @property RewardPositionPool $positionEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class QuizRewards extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quiz_rewards}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['quiz_reward_enc_id', 'quiz_enc_id', 'position_enc_id', 'created_by'], 'required'],
            [['price'], 'number'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['quiz_reward_enc_id', 'quiz_enc_id', 'position_enc_id', 'amount', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['quiz_reward_enc_id'], 'unique'],
            [['quiz_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Quizzes::className(), 'targetAttribute' => ['quiz_enc_id' => 'quiz_enc_id']],
            [['position_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => RewardPositionPool::className(), 'targetAttribute' => ['position_enc_id' => 'position_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizRewardCertificates()
    {
        return $this->hasMany(QuizRewardCertificates::className(), ['quiz_reward_enc_id' => 'quiz_reward_enc_id']);
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
    public function getPositionEnc()
    {
        return $this->hasOne(RewardPositionPool::className(), ['position_enc_id' => 'position_enc_id']);
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
