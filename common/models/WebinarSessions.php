<?php
namespace common\models;


/**
 * This is the model class for table "{{%webinar_sessions}}".
 *
 * @property int $id Primary Key
 * @property string $session_enc_id
 * @property string $session_id
 * @property string $join_code
 * @property string $created_on
 * @property string $created_by
 * @property int $status 1 as running, 2 as finished
 * @property int $is_deleted
 *
 * @property WebinarEvents[] $webinarEvents
 * @property Users $createdBy
 */
class WebinarSessions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar_sessions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['session_enc_id', 'join_code'], 'required'],
            [['created_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['session_enc_id', 'session_id', 'join_code', 'created_by'], 'string', 'max' => 100],
            [['session_enc_id'], 'unique'],
            [['session_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEvents()
    {
        return $this->hasMany(WebinarEvents::className(), ['session_enc_id' => 'session_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
