<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_types_1}}".
 *
 * @property int $id
 * @property string $loan_type_enc_id
 * @property string $name
 * @property string $tags
 * @property string $value
 * @property string $acronym
 * @property string $created_on
 * @property string $created_by
 * @property int $is_deleted 0 as false, 1 as true
 *
 * @property Users $createdBy
 */
class LoanTypes1 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%loan_types_1}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_type_enc_id', 'name', 'created_by'], 'required'],
            [['tags'], 'string'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['loan_type_enc_id', 'name', 'created_by'], 'string', 'max' => 100],
            [['value'], 'string', 'max' => 5],
            [['acronym'], 'string', 'max' => 25],
            [['loan_type_enc_id'], 'unique'],
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
