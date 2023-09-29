<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_application_pendency_documents}}".
 *
 * @property int $id
 * @property string $pendency_documents_enc_id
 * @property string $loan_pendency_enc_id
 * @property string $name
 * @property string $image
 * @property string $image_location
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_on
 * @property string $updated_by
 * @property int $is_deleted
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property LoanApplicationPendencies $loanPendencyEnc
 */
class LoanApplicationPendencyDocuments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_application_pendency_documents}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pendency_documents_enc_id', 'loan_pendency_enc_id', 'name', 'image_location', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['pendency_documents_enc_id', 'loan_pendency_enc_id', 'image', 'image_location', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['pendency_documents_enc_id'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['loan_pendency_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanApplicationPendencies::className(), 'targetAttribute' => ['loan_pendency_enc_id' => 'loan_pendency_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
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
    public function getLoanPendencyEnc()
    {
        return $this->hasOne(LoanApplicationPendencies::className(), ['loan_pendency_enc_id' => 'loan_pendency_enc_id']);
    }
}
