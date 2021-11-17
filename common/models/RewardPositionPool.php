<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%reward_position_pool}}".
 *
 * @property int $id
 * @property string $position_enc_id reward pool table encripted id
 * @property string $name position name
 * @property string $created_on
 * @property string $created_by
 * @property int $is_deleted
 *
 * @property QuizRewards[] $quizRewards
 * @property Users $createdBy
 */
class RewardPositionPool extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%reward_position_pool}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position_enc_id', 'name', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['position_enc_id', 'name', 'created_by'], 'string', 'max' => 100],
            [['position_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuizRewards()
    {
        return $this->hasMany(QuizRewards::className(), ['position_enc_id' => 'position_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
