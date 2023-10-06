<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%employees_cash_report}}".
 *
 * @property int $id
 * @property string $employees_cash_report_enc_id
 * @property string $organization_enc_id
 * @property string $user_enc_id
 * @property double $amount
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_on
 * @property string $updated_by
 * @property int $is_deleted
 *
 * @property Users $updatedBy
 * @property Users $createdBy
 * @property Organizations $organizationEnc
 * @property Users $userEnc
 */
class EmployeesCashReport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%employees_cash_report}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employees_cash_report_enc_id', 'organization_enc_id', 'user_enc_id', 'amount', 'created_on', 'created_by', 'updated_on', 'updated_by'], 'required'],
            [['amount'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['employees_cash_report_enc_id', 'organization_enc_id', 'user_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['employees_cash_report_enc_id'], 'unique'],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }
}
