<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%credit_response_data}}".
 *
 * @property int $id table id
 * @property string $response_enc_id table primary key and encrypted key
 * @property string $request_enc_id request enc id
 * @property string $response_body response body data in json
 * @property string $file_url response pdf link file
 * @property string $filename filename unique name
 * @property string $created_on current datetime of the entry
 * @property string $created_by user id of the user who created the entry
 * @property int $is_deleted 1 as deleted and 0 as not deleted
 *
 * @property CreditLoanApplicationReports[] $creditLoanApplicationReports
 * @property CreditRequestedData $requestEnc
 * @property Users $createdBy
 */
class CreditResponseData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%credit_response_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['response_enc_id', 'request_enc_id', 'response_body', 'created_by'], 'required'],
            [['response_body'], 'string'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['response_enc_id', 'request_enc_id', 'created_by'], 'string', 'max' => 100],
            [['file_url', 'filename'], 'string', 'max' => 250],
            [['response_enc_id'], 'unique'],
            [['request_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CreditRequestedData::className(), 'targetAttribute' => ['request_enc_id' => 'request_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreditLoanApplicationReports()
    {
        return $this->hasMany(CreditLoanApplicationReports::className(), ['response_enc_id' => 'response_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestEnc()
    {
        return $this->hasOne(CreditRequestedData::className(), ['request_enc_id' => 'request_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
