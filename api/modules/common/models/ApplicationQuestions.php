<?php

namespace common\models;

/**
 * This is the model class for table "{{%application_questions}}".
 *
 * @property int $id Primary Key
 * @property string $application_question_enc_id Question Encrypted ID
 * @property string $question Question
 * @property string $application_type_enc_id Foreign Key to Application Types Table
 *
 * @property ApplicationAnswers[] $applicationAnswers
 * @property ApplicationTypes $applicationTypeEnc
 */
class ApplicationQuestions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application_questions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'application_question_enc_id', 'question', 'application_type_enc_id'], 'required'],
            [['id'], 'integer'],
            [['question'], 'string'],
            [['application_question_enc_id', 'application_type_enc_id'], 'string', 'max' => 100],
            [['application_question_enc_id'], 'unique'],
            [['id'], 'unique'],
            [['application_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationTypes::className(), 'targetAttribute' => ['application_type_enc_id' => 'application_type_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationAnswers()
    {
        return $this->hasMany(ApplicationAnswers::className(), ['application_question_enc_id' => 'application_question_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationTypeEnc()
    {
        return $this->hasOne(ApplicationTypes::className(), ['application_type_enc_id' => 'application_type_enc_id']);
    }
}
