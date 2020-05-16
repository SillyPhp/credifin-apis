<?php

namespace common\models;

/**
 * This is the model class for table "{{%user_spoken_languages}}".
 *
 * @property int $id Primary Key
 * @property string $user_language_enc_id User Language Encrypted ID
 * @property string $language_enc_id Foreign Key to Spoken Languages Table
 * @property string $created_on On which date User Language information was added to database
 * @property string $created_by By which User Language information was added
 * @property string $last_updated_on On which date User Language information was updated
 * @property string $last_updated_by By which User Language information was updated
 * @property int $is_deleted Is User Language Deleted (0 As False, 1 As True)
 *
 * @property SpokenLanguages $languageEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class UserSpokenLanguages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_spoken_languages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_language_enc_id', 'language_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['user_language_enc_id', 'language_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['user_language_enc_id'], 'unique'],
            [['language_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => SpokenLanguages::className(), 'targetAttribute' => ['language_enc_id' => 'language_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguageEnc()
    {
        return $this->hasOne(SpokenLanguages::className(), ['language_enc_id' => 'language_enc_id']);
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
}
