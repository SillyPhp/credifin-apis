<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%reviews}}".
 *
 * @property int $id
 * @property string $reviews_enc_id
 * @property string $review_type_enc_id
 * @property string $claimed_organization_enc_id
 * @property string $unclaimed_organization_enc_id
 * @property int $is_deleted
 * @property string $created_on
 * @property string $created_by
 *
 * @property CollegeStudentsReview[] $collegeStudentsReviews
 * @property EmployerReviews[] $employerReviews
 * @property InstituteStudentsReview[] $instituteStudentsReviews
 * @property ReviewsType $reviewTypeEnc
 * @property Organizations $claimedOrganizationEnc
 * @property UnclaimedOrganizations $unclaimedOrganizationEnc
 * @property Users $createdBy
 * @property SchoolStudentsReview[] $schoolStudentsReviews
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reviews}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reviews_enc_id', 'review_type_enc_id', 'created_by'], 'required'],
            [['is_deleted'], 'integer'],
            [['created_on'], 'safe'],
            [['reviews_enc_id', 'review_type_enc_id', 'claimed_organization_enc_id', 'unclaimed_organization_enc_id', 'created_by'], 'string', 'max' => 100],
            [['reviews_enc_id'], 'unique'],
            [['review_type_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReviewsType::className(), 'targetAttribute' => ['review_type_enc_id' => 'review_type_enc_id']],
            [['claimed_organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['claimed_organization_enc_id' => 'organization_enc_id']],
            [['unclaimed_organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimedOrganizations::className(), 'targetAttribute' => ['unclaimed_organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollegeStudentsReviews()
    {
        return $this->hasMany(CollegeStudentsReview::className(), ['review_enc_id' => 'reviews_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployerReviews()
    {
        return $this->hasMany(EmployerReviews::className(), ['review_enc_id' => 'reviews_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInstituteStudentsReviews()
    {
        return $this->hasMany(InstituteStudentsReview::className(), ['review_enc_id' => 'reviews_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReviewTypeEnc()
    {
        return $this->hasOne(ReviewsType::className(), ['review_type_enc_id' => 'review_type_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimedOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'claimed_organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimedOrganizationEnc()
    {
        return $this->hasOne(UnclaimedOrganizations::className(), ['organization_enc_id' => 'unclaimed_organization_enc_id']);
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
    public function getSchoolStudentsReviews()
    {
        return $this->hasMany(SchoolStudentsReview::className(), ['review_enc_id' => 'reviews_enc_id']);
    }
}
