<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_infrastructure}}".
 *
 * @property int $id
 * @property string $college_infrastructure_enc_id
 * @property string $infra_name
 * @property string $icon
 * @property string $icon_location
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property CollegeInfrastructureDetail[] $collegeInfrastructureDetails
 */
class CollegeInfrastructure extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%college_infrastructure}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['college_infrastructure_enc_id', 'infra_name', 'icon', 'icon_location', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['college_infrastructure_enc_id', 'infra_name', 'icon', 'icon_location', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['college_infrastructure_enc_id'], 'unique'],
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
    public function getCollegeInfrastructureDetails()
    {
        return $this->hasMany(CollegeInfrastructureDetail::className(), ['college_infrastructure_enc_id' => 'college_infrastructure_enc_id']);
    }
}
