<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%states}}".
 *
 * @property int $id Primary Key
 * @property string $state_enc_id State Encrypted ID
 * @property string $name State Name
 * @property string $abbreviation
 * @property int $state_code state code
 * @property string $country_enc_id Foreign Key to Countries Table
 *
 * @property Cities[] $cities
 * @property ClaimServiceableLocations[] $claimServiceableLocations
 * @property LoanApplicantResidentialInfo[] $loanApplicantResidentialInfos
 * @property MockBoards[] $mockBoards
 * @property Countries $countryEnc
 * @property UnclaimServiceableLocations[] $unclaimServiceableLocations
 */
class States extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%states}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state_enc_id', 'name', 'country_enc_id'], 'required'],
            [['state_code'], 'integer'],
            [['state_enc_id', 'country_enc_id'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 30],
            [['abbreviation'], 'string', 'max' => 3],
            [['state_enc_id'], 'unique'],
            [['country_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::className(), 'targetAttribute' => ['country_enc_id' => 'country_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(Cities::className(), ['state_enc_id' => 'state_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClaimServiceableLocations()
    {
        return $this->hasMany(ClaimServiceableLocations::className(), ['state_enc_id' => 'state_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoanApplicantResidentialInfos()
    {
        return $this->hasMany(LoanApplicantResidentialInfo::className(), ['state_enc_id' => 'state_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockBoards()
    {
        return $this->hasMany(MockBoards::className(), ['state_enc_id' => 'state_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryEnc()
    {
        return $this->hasOne(Countries::className(), ['country_enc_id' => 'country_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnclaimServiceableLocations()
    {
        return $this->hasMany(UnclaimServiceableLocations::className(), ['state_enc_id' => 'state_enc_id']);
    }
}
