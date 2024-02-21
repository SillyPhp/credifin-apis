<?php

namespace common\models;

/**
 * This is the model class for table "{{%partnership_data}}".
 *
 * @property int $id Primary Key
 * @property string $request_enc_id Partnership Data Encrypted ID
 * @property string $name Name
 * @property string $email Email
 * @property string $phone Phone
 * @property string $subject Subject
 * @property string $message Message
 * @property string $organization_name Organization Name
 * @property string $created_on On which date Partnership information was added to database
 * @property string $last_updated_on On which date Partnership information was updated
 */
class PartnershipData extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%partnership_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['request_enc_id', 'name', 'email', 'phone', 'subject', 'message', 'created_on'], 'required'],
            [['message'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['request_enc_id', 'name', 'subject'], 'string', 'max' => 100],
            [['email', 'organization_name'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 15],
        ];
    }

}
