<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%labels}}".
 *
 * @property int $id Primary Key
 * @property string $label_enc_id Label Encrypted ID
 * @property string $name Label Name
 * @property string $icon
 * @property string $icon_location
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property OrganizationLabels[] $organizationLabels
 * @property UnclaimOrganizationLabels[] $unclaimOrganizationLabels
 */
class Labels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%labels}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label_enc_id', 'name', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['label_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['name', 'icon', 'icon_location'], 'string', 'max' => 50],
            [['label_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationLabels()
    {
        return $this->hasMany(OrganizationLabels::className(), ['label_enc_id' => 'label_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimOrganizationLabels()
    {
        return $this->hasMany(UnclaimOrganizationLabels::className(), ['label_enc_id' => 'label_enc_id']);
    }
}
