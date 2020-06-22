<?php
namespace common\models;
/**
 * This is the model class for table "{{%unclaim_assigned_industries}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_industry_enc_id Assigned Industry Encrypted ID
 * @property string $industry_enc_id Foreign Key to Industries Table
 * @property string $industry_string_value Industry String Value For Future Reference
 * @property string $unclaim_oragnizations_enc_id Foreign Key to Unclaim OrganizationTable
 * @property string $created_on On which date Industry information was added to database
 * @property string $created_by By which User Industry information was added
 * @property string $last_updated_on On which date Industry information was updated
 * @property string $last_updated_by By which User Industry information was updated
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property UnclaimedOrganizations $unclaimOragnizationsEnc
 * @property Industries $industryEnc
 */
class UnclaimAssignedIndustries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%unclaim_assigned_industries}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_industry_enc_id', 'industry_string_value', 'unclaim_oragnizations_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['assigned_industry_enc_id', 'industry_enc_id', 'unclaim_oragnizations_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['industry_string_value'], 'string', 'max' => 200],
            [['assigned_industry_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['unclaim_oragnizations_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => UnclaimedOrganizations::className(), 'targetAttribute' => ['unclaim_oragnizations_enc_id' => 'organization_enc_id']],
            [['industry_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Industries::className(), 'targetAttribute' => ['industry_enc_id' => 'industry_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

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
    public function getUnclaimOragnizationsEnc()
    {
        return $this->hasOne(UnclaimedOrganizations::className(), ['organization_enc_id' => 'unclaim_oragnizations_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIndustryEnc()
    {
        return $this->hasOne(Industries::className(), ['industry_enc_id' => 'industry_enc_id']);
    }
}
