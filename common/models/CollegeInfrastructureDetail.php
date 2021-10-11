<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_infrastructure_detail}}".
 *
 * @property int $id
 * @property string $college_infrastructure_detail_enc_id
 * @property string $college_infrastructure_enc_id
 * @property string $college_enc_id
 * @property string $description
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property CollegeInfrastructure $collegeInfrastructureEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Organizations $collegeEnc
 */
class CollegeInfrastructureDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%college_infrastructure_detail}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['college_infrastructure_detail_enc_id', 'college_infrastructure_enc_id', 'college_enc_id', 'description', 'created_by'], 'required'],
            [['description'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['college_infrastructure_detail_enc_id', 'college_infrastructure_enc_id', 'college_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['college_infrastructure_detail_enc_id'], 'unique'],
            [['college_infrastructure_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => CollegeInfrastructure::className(), 'targetAttribute' => ['college_infrastructure_enc_id' => 'college_infrastructure_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeInfrastructureEnc()
    {
        return $this->hasOne(CollegeInfrastructure::className(), ['college_infrastructure_enc_id' => 'college_infrastructure_enc_id']);
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
    public function getCollegeEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'college_enc_id']);
    }
}
