<?php

namespace common\models;

/**
 * This is the model class for table "{{%speakers}}".
 *
 * @property int $id
 * @property string $speaker_enc_id
 * @property string $user_enc_id
 * @property string $unclaimed_org_id
 * @property string $designation_enc_id
 * @property int $is_star 0 as false, 1 as True
 * @property string $created_by
 * @property string $created_on
 * @property string $updated_by
 * @property string $updated_on
 * @property int $is_deleted 0 false,1 true
 *
 * @property SpeakerExpertises[] $speakerExpertises
 * @property Users $createdBy
 * @property Designations $designationEnc
 * @property UnclaimedOrganizations $unclaimedOrg
 * @property Users $userEnc
 * @property Users $updatedBy
 * @property WebinarModerators[] $webinarModerators
 * @property WebinarRequestSpeakers[] $webinarRequestSpeakers
 * @property WebinarSpeakers[] $webinarSpeakers
 */
class Speakers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%speakers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speaker_enc_id', 'user_enc_id', 'created_by'], 'required'],
            [['is_star', 'is_deleted'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['speaker_enc_id', 'user_enc_id', 'unclaimed_org_id', 'designation_enc_id', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['speaker_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['designation_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designations::className(), 'targetAttribute' => ['designation_enc_id' => 'designation_enc_id']],
            [['unclaimed_org_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimedOrganizations::className(), 'targetAttribute' => ['unclaimed_org_id' => 'organization_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpeakerExpertises()
    {
        return $this->hasMany(SpeakerExpertises::className(), ['speaker_enc_id' => 'speaker_enc_id']);
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
    public function getDesignationEnc()
    {
        return $this->hasOne(Designations::className(), ['designation_enc_id' => 'designation_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedOrg()
    {
        return $this->hasOne(UnclaimedOrganizations::className(), ['organization_enc_id' => 'unclaimed_org_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarModerators()
    {
        return $this->hasMany(WebinarModerators::className(), ['speaker_enc_id' => 'speaker_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarRequestSpeakers()
    {
        return $this->hasMany(WebinarRequestSpeakers::className(), ['speaker_enc_id' => 'speaker_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarSpeakers()
    {
        return $this->hasMany(WebinarSpeakers::className(), ['speaker_enc_id' => 'speaker_enc_id']);
    }
}
