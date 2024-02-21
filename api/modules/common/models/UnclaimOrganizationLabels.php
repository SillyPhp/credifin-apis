<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%unclaim_organization_labels}}".
 *
 * @property int $id Primary Key
 * @property string $org_label_enc_id Organization Label Encrypted ID
 * @property string $label_enc_id Relation with Labels table
 * @property string $organization_enc_id Relation with Unclaimed org table
 * @property int $label_for 0 for EY, 1 for MEC
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted
 *
 * @property Labels $labelEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property UnclaimedOrganizations $organizationEnc
 */
class UnclaimOrganizationLabels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%unclaim_organization_labels}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_label_enc_id', 'label_enc_id', 'organization_enc_id', 'created_by'], 'required'],
            [['label_for', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['org_label_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['label_enc_id', 'organization_enc_id'], 'string', 'max' => 50],
            [['org_label_enc_id'], 'unique'],
            [['label_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Labels::className(), 'targetAttribute' => ['label_enc_id' => 'label_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimedOrganizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabelEnc()
    {
        return $this->hasOne(Labels::className(), ['label_enc_id' => 'label_enc_id']);
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(UnclaimedOrganizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}
