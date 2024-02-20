<?php
namespace common\models;


/**
 * This is the model class for table "{{%credentials}}".
 *
 * @property int $id Primary Key
 * @property string $credentials_enc_id Encrypted ID
 * @property string $api_key Encrypted key
 * @property string $api_secret Encrypted secret
 * @property string $env Enviroment Mode
 * @property string $cred_for
 * @property string $organization_enc_id Organization Enc Id
 * @property string $access_token_expiration
 * @property string $passphrase
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
class Credentials extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%credentials}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['credentials_enc_id', 'api_key', 'api_secret', 'cred_for', 'organization_enc_id', 'passphrase', 'created_by'], 'required'],
            [['env', 'cred_for'], 'string'],
            [['access_token_expiration', 'created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['credentials_enc_id', 'api_key', 'api_secret', 'organization_enc_id', 'passphrase', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['credentials_enc_id'], 'unique'],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
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
