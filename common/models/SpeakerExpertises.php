<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%speaker_expertises}}".
 *
 * @property int $id
 * @property string $expertise_enc_id
 * @property string $skill_enc_id
 * @property string $speaker_enc_id
 * @property string $created_by
 * @property string $created_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property Speakers $speakerEnc
 * @property Users $createdBy
 * @property Skills $skillEnc
 */
class SpeakerExpertises extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%speaker_expertises}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['expertise_enc_id', 'skill_enc_id', 'speaker_enc_id', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['expertise_enc_id', 'skill_enc_id', 'speaker_enc_id', 'created_by'], 'string', 'max' => 100],
            [['expertise_enc_id'], 'unique'],
            [['speaker_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Speakers::className(), 'targetAttribute' => ['speaker_enc_id' => 'speaker_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['skill_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Skills::className(), 'targetAttribute' => ['skill_enc_id' => 'skill_enc_id']],
        ];
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeakerEnc()
    {
        return $this->hasOne(Speakers::className(), ['speaker_enc_id' => 'speaker_enc_id']);
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
    public function getSkillEnc()
    {
        return $this->hasOne(Skills::className(), ['skill_enc_id' => 'skill_enc_id']);
    }
}
