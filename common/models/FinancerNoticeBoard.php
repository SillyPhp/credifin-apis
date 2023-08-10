<?php

namespace common\models;

/**
 * This is the model class for table "{{%financer_notice_board}}".
 *
 * @property int $id Primary Key
 * @property string $notice_enc_id Notice Enc Id
 * @property string $image Image
 * @property string $image_location Image Location
 * @property string $financer_enc_id Financer Enc Id
 * @property string $status Status
 * @property int $type Type
 * @property string $notice Notice message
 * @property string $created_on Created on
 * @property string $created_by Created by
 * @property string $updated_on Updated on
 * @property string $updated_by Updated by
 * @property int $is_deleted Is Deleted
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property Organizations $financerEnc
 */
class FinancerNoticeBoard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%financer_notice_board}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notice_enc_id', 'financer_enc_id', 'type', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['status', 'notice'], 'string'],
            [['type', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['notice_enc_id', 'image', 'image_location', 'financer_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['notice_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['financer_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['financer_enc_id' => 'organization_enc_id']],
        ];
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinancerEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'financer_enc_id']);
    }
}
