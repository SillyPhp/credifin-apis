<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_certificates_images}}".
 *
 * @property int $id
 * @property string $certificate_image_enc_id
 * @property string $certificate_enc_id
 * @property string $image
 * @property string $image_location
 * @property string $created_by
 * @property string $created_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property LoanCertificates $certificateEnc
 * @property Users $createdBy
 */
class LoanCertificatesImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_certificates_images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['certificate_image_enc_id', 'certificate_enc_id', 'image', 'image_location', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['certificate_image_enc_id', 'certificate_enc_id', 'image', 'image_location', 'created_by'], 'string', 'max' => 100],
            [['certificate_image_enc_id'], 'unique'],
            [['certificate_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoanCertificates::className(), 'targetAttribute' => ['certificate_enc_id' => 'certificate_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCertificateEnc()
    {
        return $this->hasOne(LoanCertificates::className(), ['certificate_enc_id' => 'certificate_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
