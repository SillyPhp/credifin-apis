<?php
namespace common\models;


/**
 * This is the model class for table "{{%class_access}}".
 *
 * @property int $id Primary Key
 * @property string $access_enc_id Encrypted Key
 * @property string $session_enc_id
 * @property string $user_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property int $is_access
 *
 * @property VideoSessions $sessionEnc
 * @property Users $userEnc
 * @property Users $createdBy
 */
class ClassAccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%class_access}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['access_enc_id', 'session_enc_id', 'user_enc_id', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_access'], 'integer'],
            [['access_enc_id', 'session_enc_id', 'user_enc_id', 'created_by'], 'string', 'max' => 100],
            [['access_enc_id'], 'unique'],
            [['session_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => VideoSessions::className(), 'targetAttribute' => ['session_enc_id' => 'session_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessionEnc()
    {
        return $this->hasOne(VideoSessions::className(), ['session_enc_id' => 'session_enc_id']);
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
}
