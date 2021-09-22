<?php

namespace common\models;

/**
 * This is the model class for table "{{%webinar_topics}}".
 *
 * @property int $id Primary Key
 * @property string $topic_enc_id Webinar Topics Encrypted Encrypted ID
 * @property string $name Name
 * @property string $created_on
 * @property string $created_by
 * @property int $status 0 as pending, 1 as approved,2 as Rejected
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property AssignedWebinarTopics[] $assignedWebinarTopics
 * @property Users $createdBy
 */
class WebinarTopics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar_topics}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_enc_id', 'name', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['status', 'is_deleted'], 'integer'],
            [['topic_enc_id', 'created_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
            [['topic_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedWebinarTopics()
    {
        return $this->hasMany(AssignedWebinarTopics::className(), ['topic_enc_id' => 'topic_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
