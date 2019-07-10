<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%interviewer_detail}}".
 *
 * @property int $id
 * @property string $interviewer_detail_enc_id
 * @property string $interviewer_enc_id
 * @property string $name
 * @property string $email
 * @property string $phone
 *
 * @property Interviewers $interviewerEnc
 */
class InterviewerDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%interviewer_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['interviewer_detail_enc_id', 'interviewer_enc_id', 'name', 'email', 'phone'], 'required'],
            [['interviewer_detail_enc_id', 'interviewer_enc_id', 'name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 15],
            [['interviewer_detail_enc_id'], 'unique'],
            [['interviewer_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Interviewers::className(), 'targetAttribute' => ['interviewer_enc_id' => 'interviewer_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInterviewerEnc()
    {
        return $this->hasOne(Interviewers::className(), ['interviewer_enc_id' => 'interviewer_enc_id']);
    }
}
