<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_other_details}}".
 *
 * @property int $id
 * @property string $organization_other_details_enc_id
 * @property string $organization_enc_id Organization enc id
 * @property string $location_enc_id location enc id
 * @property string $affiliated_to university name
 * @property string $accredited_to
 * @property string $entrance_exam
 * @property int $total_programs
 * @property string $popular_course
 * @property string $top_recruiter
 * @property string $brochure
 * @property string $established_in
 * @property string $university_type
 * @property string $application_mode
 * @property string $fees
 * @property string $updated_on
 *
 * @property Organizations $organizationEnc
 * @property Cities $locationEnc
 */
class OrganizationOtherDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization_other_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['organization_other_details_enc_id', 'organization_enc_id'], 'required'],
            [['total_programs'], 'integer'],
            [['application_mode'], 'string'],
            [['updated_on'], 'safe'],
            [['organization_other_details_enc_id', 'organization_enc_id', 'location_enc_id', 'affiliated_to', 'accredited_to', 'established_in'], 'string', 'max' => 100],
            [['entrance_exam', 'popular_course', 'top_recruiter', 'brochure', 'university_type', 'fees'], 'string', 'max' => 255],
            [['organization_other_details_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['location_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['location_enc_id' => 'city_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocationEnc()
    {
        return $this->hasOne(Cities::className(), ['city_enc_id' => 'location_enc_id']);
    }
}
