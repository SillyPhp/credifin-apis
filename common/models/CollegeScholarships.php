<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_scholarships}}".
 *
 * @property int $id
 * @property string $college_scholarship_enc_id scholarship encrypted id
 * @property string $college_enc_id college id
 * @property string $title schoralship title
 * @property int $amount schoralship amount
 * @property string $detail schoralship detail
 * @property string $apply_link schoralship apply link
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property Organizations $collegeEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class CollegeScholarships extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%college_scholarships}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['college_scholarship_enc_id', 'college_enc_id', 'title', 'amount', 'detail', 'apply_link', 'created_by'], 'required'],
            [['amount', 'is_deleted'], 'integer'],
            [['detail'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['college_scholarship_enc_id', 'college_enc_id', 'title', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['apply_link'], 'string', 'max' => 255],
            [['college_scholarship_enc_id'], 'unique'],
            [['college_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['college_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'college_enc_id']);
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
