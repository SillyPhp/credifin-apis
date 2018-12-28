<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%organization_images}}".
 *
 * @property int $id Primary Key
 * @property string $image_enc_id Image Encrypted ID
 * @property string $company_enc_id Foreign Key to Companies Table
 * @property string $image Image
 * @property string $image_location Image Location
 * @property string $title Image Title
 * @property string $alt Alternative Text of Image
 * @property string $created_on On which date Image information was added to database
 * @property string $created_by By which User Image information was added
 * @property string $last_updated_on On which date Image information was updated
 * @property string $last_updated_by By which User Image information was updated
 *
 * @property Companies $companyEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class OrganizationImages extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%organization_images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['image_enc_id', 'company_enc_id', 'image', 'image_location', 'created_on', 'created_by'], 'required'],
            [['image'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['image_enc_id', 'company_enc_id', 'title', 'alt', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['image_location'], 'string', 'max' => 200],
            [['image_enc_id'], 'unique'],
            [['company_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Companies::className(), 'targetAttribute' => ['company_enc_id' => 'company_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyEnc() {
        return $this->hasOne(Companies::className(), ['company_enc_id' => 'company_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastUpdatedBy() {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

}
