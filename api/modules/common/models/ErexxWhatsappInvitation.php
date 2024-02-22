<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%erexx_whatsapp_invitation}}".
 *
 * @property int $id Primary Key
 * @property string $invitation_enc_id Encrypted Key
 * @property int $invitation_type 1 erexx invitation
 * @property string $name Receiver Name
 * @property string $phone Receiver phone number
 * @property string $user_enc_id User who has been sent the message
 * @property string $organization_enc_id
 * @property string $created_on
 * @property string $last_updated_on
 *
 * @property Users $userEnc
 * @property Organizations $organizationEnc
 */
class ErexxWhatsappInvitation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%erexx_whatsapp_invitation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invitation_enc_id', 'invitation_type', 'phone', 'user_enc_id'], 'required'],
            [['invitation_type'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['invitation_enc_id', 'name', 'user_enc_id', 'organization_enc_id'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 15],
            [['invitation_enc_id'], 'unique'],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
        ];
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
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }
}
