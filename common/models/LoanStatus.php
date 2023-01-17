<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_status}}".
 *
 * @property int $id
 * @property string $loan_status_enc_id loan status enc id
 * @property string $loan_status loan status name
 * @property string $created_by created by
 * @property string $created_on created on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property Users $createdBy
 */
class LoanStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_status}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_status_enc_id', 'loan_status', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['loan_status_enc_id', 'loan_status', 'created_by'], 'string', 'max' => 100],
            [['loan_status_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
