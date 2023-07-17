<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%payment_credentials}}".
 *
 * @property int $id Primary Key
 * @property string $credentials_enc_id Encrypted ID
 * @property string $api_key Encrypted key
 * @property string $api_secret Encrypted secret
 * @property string $env Enviroment Mode
 * @property string $organization_enc_id Organization Enc Id
 * @property string $created_on On which date Route information was added to database
 * @property string $created_by By which User Route information was added
 * @property string $last_updated_on On which date Route information was updated
 * @property string $last_updated_by By which User Route information was updated
 * @property int $is_deleted Is Route Deleted (0 as False, 1 as True)
 *
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 * @property Organizations $organizationEnc
 */
class PaymentCredentials extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%payment_credentials}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['credentials_enc_id', 'api_key', 'api_secret', 'organization_enc_id', 'created_by'], 'required'],
            [['env'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['credentials_enc_id', 'api_key', 'api_secret', 'organization_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['credentials_enc_id'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'credentials_enc_id' => 'Credentials Enc ID',
            'api_key' => 'Api Key',
            'api_secret' => 'Api Secret',
            'env' => 'Env',
            'organization_enc_id' => 'Organization Enc ID',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'last_updated_on' => 'Last Updated On',
            'last_updated_by' => 'Last Updated By',
            'is_deleted' => 'Is Deleted',
        ];
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}
