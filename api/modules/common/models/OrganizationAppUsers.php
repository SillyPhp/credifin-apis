<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_app_users}}".
 *
 * @property int $id
 * @property string $assigned_user_enc_id
 * @property string $app_enc_id app id
 * @property string $user_enc_id assigned user id
 * @property string $created_by user created by
 * @property string $created_on created on time
 * @property string $updated_by updated by user
 * @property string $updated_on updated on time
 * @property int $is_deleted 0 false, 1 true
 *
 * @property OrganizationApps $appEnc
 * @property Users $userEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class OrganizationAppUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization_app_users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assigned_user_enc_id', 'app_enc_id', 'user_enc_id', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_user_enc_id', 'app_enc_id', 'user_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['assigned_user_enc_id'], 'unique'],
            [['app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationApps::className(), 'targetAttribute' => ['app_enc_id' => 'app_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppEnc()
    {
        return $this->hasOne(OrganizationApps::className(), ['app_enc_id' => 'app_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
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
