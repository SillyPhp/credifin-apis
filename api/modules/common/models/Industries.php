<?php

namespace common\models;

/**
 * This is the model class for table "{{%industries}}".
 *
 * @property int $id Primary Key
 * @property string $industry_enc_id Industry Encrypted ID
 * @property string $industry Industry Name
 * @property string $slug Slug
 *
 * @property EmployerApplications[] $employerApplications
 * @property Organizations[] $organizations
 * @property UserPreferredIndustries[] $userPreferredIndustries
 */
class Industries extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%industries}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['industry_enc_id', 'industry', 'slug'], 'required'],
            [['industry_enc_id', 'slug'], 'string', 'max' => 100],
            [['industry'], 'string', 'max' => 50],
            [['industry_enc_id'], 'unique'],
            [['industry'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerApplications() {
        return $this->hasMany(EmployerApplications::className(), ['preferred_industry' => 'industry_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizations() {
        return $this->hasMany(Organizations::className(), ['industry_enc_id' => 'industry_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPreferredIndustries() {
        return $this->hasMany(UserPreferredIndustries::className(), ['industry_enc_id' => 'industry_enc_id']);
    }

}
