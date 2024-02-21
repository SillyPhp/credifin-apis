<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_types}}".
 *
 * @property int $id Primary Key
 * @property string $organization_type_enc_id Organization Type Encrypted ID
 * @property string $organization_type Organization Type Name
 *
 * @property Organizations[] $organizations
 */
class OrganizationTypes extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%organization_types}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['organization_type_enc_id', 'organization_type'], 'required'],
            [['organization_type_enc_id'], 'string', 'max' => 100],
            [['organization_type'], 'string', 'max' => 30],
            [['organization_type_enc_id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations() {
        return $this->hasMany(Organizations::className(), ['organization_type_enc_id' => 'organization_type_enc_id']);
    }

}
