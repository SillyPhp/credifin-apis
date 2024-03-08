<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_app_fields}}".
 *
 * @property int $id
 * @property string $field_enc_id field encrypted id
 * @property string $app_enc_id app id
 * @property string $field_title field title
 * @property string $field_description field description
 * @property string $field_value field value
 * @property string $field_type type of field
 * @property string $link form link
 * @property string $file_name file name
 * @property string $file_location file location
 * @property int $sequence Field Display Sequence
 * @property int $is_required Is Field Required (0 As No, 1 As Yes)
 * @property string $created_by created by
 * @property string $created_on created on
 * @property string $updated_by updated by
 * @property string $updated_on updated on
 * @property int $is_deleted 0 false, 1 true
 *
 * @property OrganizationApps $appEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class OrganizationAppFields extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization_app_fields}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['field_enc_id', 'app_enc_id', 'field_title', 'field_type', 'created_by'], 'required'],
            [['field_type'], 'string'],
            [['sequence', 'is_required', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['field_enc_id', 'app_enc_id', 'field_title', 'file_name', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['field_description'], 'string', 'max' => 150],
            [['field_value'], 'string', 'max' => 250],
            [['link', 'file_location'], 'string', 'max' => 200],
            [['field_enc_id'], 'unique'],
            [['app_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrganizationApps::className(), 'targetAttribute' => ['app_enc_id' => 'app_enc_id']],
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
