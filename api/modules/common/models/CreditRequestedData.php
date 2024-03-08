<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%credit_requested_data}}".
 *
 * @property int $id table id
 * @property string $request_enc_id table primary key and encrypted key
 * @property string $request_body request body data
 * @property string $request_source request source from where the request shoud be made
 * @property string $created_on current datetime of the entry
 * @property string $created_by user id of the user who created the entry
 * @property int $is_deleted 1 as deleted and 0 as not deleted
 *
 * @property Users $createdBy
 * @property CreditResponseData[] $creditResponseDatas
 */
class CreditRequestedData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%credit_requested_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_enc_id', 'request_body', 'request_source', 'created_by'], 'required'],
            [['request_body', 'request_source'], 'string'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['request_enc_id', 'created_by'], 'string', 'max' => 100],
            [['request_enc_id'], 'unique'],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreditResponseDatas()
    {
        return $this->hasMany(CreditResponseData::className(), ['request_enc_id' => 'request_enc_id']);
    }
}
