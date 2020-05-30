<?php

namespace common\models;

/**
 * This is the model class for table "{{%assigned_webinar_topics}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_topics_enc_id Assigned Webinar Topics Encrypted Encrypted ID
 * @property string $webinar_enc_id
 * @property string $topic_enc_id
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Webinars $webinarEnc
 * @property WebinarTopics $topicEnc
 * @property Users $lastUpdatedBy
 * @property Users $createdBy
 */
class AssignedWebinarTopics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_webinar_topics}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_topics_enc_id', 'webinar_enc_id', 'topic_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['assigned_topics_enc_id', 'webinar_enc_id', 'topic_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['assigned_topics_enc_id'], 'unique'],
            [['webinar_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinars::className(), 'targetAttribute' => ['webinar_enc_id' => 'webinar_enc_id']],
            [['topic_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => WebinarTopics::className(), 'targetAttribute' => ['topic_enc_id' => 'topic_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWebinarEnc()
    {
        return $this->hasOne(Webinars::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicEnc()
    {
        return $this->hasOne(WebinarTopics::className(), ['topic_enc_id' => 'topic_enc_id']);
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
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
