<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%learning_video_likes}}".
 *
 * @property int $id Primary Key
 * @property string $like_enc_id Video Like Encrypted ID
 * @property string $video_enc_id Foreign Key to Learning Videos Table
 * @property string $user_enc_id Foreign Key to Users Table
 * @property int $status Status (0 as Nothing, 1 as Like, 2 as Dislike)
 * @property string $created_on On which date Video Like information was added to database
 * @property string $last_updated_on On which date Video Like information was updated
 * @property int $is_deleted Is Like Deleted (0 as False, 1 as True)
 *
 * @property LearningVideos $videoEnc
 * @property Users $userEnc
 */
class LearningVideoLikes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%learning_video_likes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['like_enc_id', 'video_enc_id', 'user_enc_id', 'status'], 'required'],
            [['status', 'is_deleted'], 'integer'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['like_enc_id', 'video_enc_id', 'user_enc_id'], 'string', 'max' => 100],
            [['like_enc_id'], 'unique'],
            [['video_enc_id', 'user_enc_id', 'is_deleted'], 'unique', 'targetAttribute' => ['video_enc_id', 'user_enc_id', 'is_deleted']],
            [['video_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LearningVideos::className(), 'targetAttribute' => ['video_enc_id' => 'video_enc_id']],
            [['user_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_enc_id' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoEnc()
    {
        return $this->hasOne(LearningVideos::className(), ['video_enc_id' => 'video_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
    }
}
