<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_qualification_type}}".
 *
 * @property int $id
 * @property string $qualification_enc_id
 * @property string $name
 *
 * @property LoanCandidateEducation[] $loanCandidateEducations
 */
class LoanQualificationType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loan_qualification_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['qualification_enc_id', 'name'], 'required'],
            [['qualification_enc_id', 'name'], 'string', 'max' => 100],
            [['qualification_enc_id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanCandidateEducations()
    {
        return $this->hasMany(LoanCandidateEducation::className(), ['qualification_enc_id' => 'qualification_enc_id']);
    }
}
