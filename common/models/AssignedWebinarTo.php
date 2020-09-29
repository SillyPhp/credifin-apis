<?php
namespace common\models;


/**
 * This is the model class for table "{{%assigned_webinar_to}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_to_enc_id Assigned Webinar to  Encrypted Encrypted ID
 * @property string $webinar_enc_id
 * @property string $organization_enc_id College or Organization which assign to webinar
 * @property string $created_on
 * @property string $created_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Organizations $organizationEnc
 * @property Users $createdBy
 * @property Webinar $webinarEnc
 */
class AssignedWebinarTo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_webinar_to}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_to_enc_id', 'webinar_enc_id', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_to_enc_id', 'webinar_enc_id', 'organization_enc_id', 'created_by'], 'string', 'max' => 100],
            [['assigned_to_enc_id'], 'unique'],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['webinar_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinar::className(), 'targetAttribute' => ['webinar_enc_id' => 'webinar_enc_id']],
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEnc()
    {
        return $this->hasOne(Webinar::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }
}
