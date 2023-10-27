<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%email_schedule}}".
 *
 * @property int $id
 * @property string $enc_id
 * @property string $template_enc_id
 * @property string $user_type_enc_id
 * @property string $email_name
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_on
 * @property string $updated_by
 * @property int $is_deleted 0 as false, 1 as true
 *
 * @property EmailTemplates $templateEnc
 * @property UserTypes $userTypeEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class EmailSchedule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%email_schedule}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['enc_id', 'template_enc_id', 'email_name', 'created_by'], 'required'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['enc_id', 'template_enc_id', 'user_type_enc_id', 'email_name', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['template_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmailTemplates::className(), 'targetAttribute' => ['template_enc_id' => 'template_enc_id']],
            [['user_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserTypes::className(), 'targetAttribute' => ['user_type_enc_id' => 'user_type_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateEnc()
    {
        return $this->hasOne(EmailTemplates::className(), ['template_enc_id' => 'template_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTypeEnc()
    {
        return $this->hasOne(UserTypes::className(), ['user_type_enc_id' => 'user_type_enc_id']);
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
