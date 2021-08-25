<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%college_placement_highlights}}".
 *
 * @property int $id
 * @property string $college_placement_highlight_enc_id Placement Highlights encrypted id
 * @property string $college_enc_id
 * @property int $companies_visited No. of Companies visited
 * @property string $top_recruiter Top Recruiter
 * @property int $companies_offering_dream_packages No. of Companies Offering Dream Packages
 * @property double $highest_stipend_offered Highest Stipend Offered
 * @property double $highest_placement_package Highest placement package
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 *
 * @property Organizations $collegeEnc
 * @property Users $createdBy
 * @property Users $updatedBy
 */
class CollegePlacementHighlights extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%college_placement_highlights}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['college_placement_highlight_enc_id', 'college_enc_id', 'created_by'], 'required'],
            [['companies_visited', 'companies_offering_dream_packages'], 'integer'],
            [['highest_stipend_offered', 'highest_placement_package'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['college_placement_highlight_enc_id', 'college_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['top_recruiter'], 'string', 'max' => 500],
            [['college_placement_highlight_enc_id'], 'unique'],
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
