<?php

namespace common\models;

/**
 * This is the model class for table "{{%spoken_languages}}".
 *
 * @property int $id Primary Key
 * @property string $language_enc_id Language Encrypted ID
 * @property string $language Language
 * @property string $created_on On which date Language information was added to database
 * @property string $created_by By which User Language information was added
 * @property string $last_updated_on On which date Language information was updated
 * @property string $last_updated_by By which User Language information was updated
 * @property string $status Language Status (Publish, Pending)
 * @property int $is_deleted Is Language Deleted (0 As False, 1 As True)
 *
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property UserSpokenLanguages[] $userSpokenLanguages
 */
class SpokenLanguages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%spoken_languages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['language_enc_id', 'language', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['status'], 'string'],
            [['is_deleted'], 'integer'],
            [['language_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['language'], 'string', 'max' => 50],
            [['language_enc_id'], 'unique'],
            [['language'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
    public function getUserSpokenLanguages()
    {
        return $this->hasMany(UserSpokenLanguages::className(), ['language_enc_id' => 'language_enc_id']);
    }
}