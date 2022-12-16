<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%certificate_types}}".
 *
 * @property int $id
 * @property string $certificate_type_enc_id
 * @property string $name
 * @property int $assigned_to 1 customer, 2 company
 *
 * @property LoanCertificates[] $loanCertificates
 */
class CertificateTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%certificate_types}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['certificate_type_enc_id', 'name'], 'required'],
            [['assigned_to'], 'integer'],
            [['certificate_type_enc_id'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 50],
            [['certificate_type_enc_id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanCertificates()
    {
        return $this->hasMany(LoanCertificates::className(), ['certificate_type_enc_id' => 'certificate_type_enc_id']);
    }
}
