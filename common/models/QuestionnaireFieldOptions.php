<?php
namespace common\models;

/**
 * This is the model class for table "{{%questionnaire_field_options}}".
 *
 * @property int $id Primary Key
 * @property string $field_option_enc_id Field Option Encrypted ID
 * @property string $field_option Field Option
 * @property string $field_enc_id Foreign Key to Questionnaire Fields Table
 * @property string $created_on On which date Questionnaire Field Option information was added to database
 * @property string $created_by By which User Questionnaire Field Option information was added
 * @property string $last_updated_on On which date Questionnaire Field Option information was updated
 * @property string $last_updated_by By which User Questionnaire Field Option information was updated
 * @property int $is_deleted Is Questionnaire Field Option Deleted (0 As False, 1 As True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property QuestionnaireFields $fieldEnc
 */
class QuestionnaireFieldOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%questionnaire_field_options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_option_enc_id', 'field_option', 'field_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['field_option_enc_id', 'field_option', 'field_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['field_option_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['field_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => QuestionnaireFields::className(), 'targetAttribute' => ['field_enc_id' => 'field_enc_id']],
        ];
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
    public function getLastUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'last_updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFieldEnc()
    {
        return $this->hasOne(QuestionnaireFields::className(), ['field_enc_id' => 'field_enc_id']);
    }
}
