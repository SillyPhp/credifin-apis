<?php

namespace common\models;

/**
 * This is the model class for table "{{%online_calss_enquiries}}".
 *
 * @property int $id Primary Key
 * @property string $enquiry_enc_id User Encrypted ID
 * @property string $full_name Full Name
 * @property string $email Email
 * @property string $phone Phone
 * @property string $organization_name
 * @property string $designation
 * @property string $enquiry_for
 * @property string $created_on On which date User information was added to database
 * @property string $last_updated_on On which date User information was updated
 * @property int $is_deleted Is User Deleted (0 as False, 1 as True)
 */
class OnlineCalssEnquiries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%online_calss_enquiries}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enquiry_enc_id', 'full_name', 'email', 'phone', 'organization_name', 'designation', 'enquiry_for'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['enquiry_enc_id', 'organization_name', 'designation', 'enquiry_for'], 'string', 'max' => 100],
            [['full_name'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
            [['enquiry_enc_id'], 'unique'],
        ];
    }
}
