<?php

namespace common\models;

/**
 * This is the model class for table "{{%application_answers}}".
 *
 * @property int $id Primary Key
 * @property string $application_answer_enc_id Application Answer Encrypted ID
 * @property string $application_enc_id Foreign Key to Applications Table
 * @property string $application_question_enc_id Foreign Key to Applications Questions Table
 * @property string $answer Answer
 *
 * @property ApplicationQuestions $applicationQuestionEnc
 * @property Applications $applicationEnc
 */
class ApplicationAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%application_answers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['application_answer_enc_id', 'application_enc_id', 'application_question_enc_id', 'answer'], 'required'],
            [['answer'], 'string'],
            [['application_answer_enc_id', 'application_enc_id', 'application_question_enc_id'], 'string', 'max' => 100],
            [['application_answer_enc_id'], 'unique'],
            [['application_question_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ApplicationQuestions::className(), 'targetAttribute' => ['application_question_enc_id' => 'application_question_enc_id']],
            [['application_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Applications::className(), 'targetAttribute' => ['application_enc_id' => 'application_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationQuestionEnc()
    {
        return $this->hasOne(ApplicationQuestions::className(), ['application_question_enc_id' => 'application_question_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplicationEnc()
    {
        return $this->hasOne(Applications::className(), ['application_enc_id' => 'application_enc_id']);
    }
}
