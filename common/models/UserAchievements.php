<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_achievements}}".
 *
 * @property int $id Primary Key
 * @property string $user_achievement_enc_id User Achievement Encrypted ID
 * @property string $achievement Interest
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $created_on On which date User Achievement information was added to database
 * @property string $created_by By which User Achievement information was added
 * @property string $last_updated_on On which date User Achievement information was updated
 * @property string $last_updated_by By which User Achievement information was updated
 * @property int $is_deleted Is User Achievement Deleted (0 As False, 1 As True)
 *
 * @property Users $userEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class UserAchievements extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_achievements}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_achievement_enc_id', 'achievement', 'user_enc_id', 'created_by'], 'required'],
            [['achievement'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['user_achievement_enc_id', 'user_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['user_achievement_enc_id'], 'unique'],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
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
