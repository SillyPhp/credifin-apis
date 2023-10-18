<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%vehicle_repo_comments}}".
 *
 * @property int $id Primary Key
 * @property string $vehicle_repo_comment_enc_id Comment Encrypted ID
 * @property string $vehicle_repossession_enc_id
 * @property string $comment Post Comment
 * @property string $reply_to Reply to Comment
 * @property string $created_on On which date Post Comment information was added to database
 * @property string $created_by Foreign Key to Users Table
 * @property string $updated_on On which date Post Comment information was updated
 * @property string $updated_by
 * @property int $is_deleted Is Comment Deleted (0 as False, 1 as True)
 *
 * @property Users $createdBy
 * @property Users $updatedBy
 * @property VehicleRepossession $vehicleRepossessionEnc
 * @property VehicleRepoComments $replyTo
 * @property VehicleRepoComments[] $vehicleRepoComments
 */
class VehicleRepoComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%vehicle_repo_comments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vehicle_repo_comment_enc_id', 'vehicle_repossession_enc_id', 'comment', 'created_by'], 'required'],
            [['comment'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['vehicle_repo_comment_enc_id', 'vehicle_repossession_enc_id', 'reply_to', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['vehicle_repo_comment_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['updated_by' => 'user_enc_id']],
            [['vehicle_repossession_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleRepossession::className(), 'targetAttribute' => ['vehicle_repossession_enc_id' => 'vehicle_repossession_enc_id']],
            [['reply_to'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleRepoComments::className(), 'targetAttribute' => ['reply_to' => 'vehicle_repo_comment_enc_id']],
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
    public function getUpdatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleRepossessionEnc()
    {
        return $this->hasOne(VehicleRepossession::className(), ['vehicle_repossession_enc_id' => 'vehicle_repossession_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReplyTo()
    {
        return $this->hasOne(VehicleRepoComments::className(), ['vehicle_repo_comment_enc_id' => 'reply_to']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleRepoComments()
    {
        return $this->hasMany(VehicleRepoComments::className(), ['reply_to' => 'vehicle_repo_comment_enc_id']);
    }
}
