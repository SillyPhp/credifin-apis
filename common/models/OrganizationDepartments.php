<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_departments}}".
 *
 * @property int $id
 * @property string $department_enc_id department enc id
 * @property string $department department name
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $update_on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class OrganizationDepartments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization_departments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['department_enc_id', 'department', 'created_by', 'created_on'], 'required'],
            [['created_on', 'update_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['department_enc_id', 'department', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['department_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
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
}
