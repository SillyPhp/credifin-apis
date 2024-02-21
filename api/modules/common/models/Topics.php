<?php
namespace common\models;
use Yii;
/**
 * This is the model class for table "{{%topics}}".
 *
 * @property int $id Primary Key
 * @property string $topic_enc_id Webinar Topics Encrypted Encrypted ID
 * @property string $name Name
 * @property string $created_on
 * @property string $created_by
 * @property string $assigned_to
 * @property int $status 0 as pending, 1 as approved,2 as Rejected
 * @property int $is_recommend
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property Users $createdBy
 */
class Topics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%topics}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['topic_enc_id', 'name', 'created_by', 'assigned_to'], 'required'],
            [['created_on'], 'safe'],
            [['assigned_to'], 'string'],
            [['status', 'is_recommend', 'is_deleted'], 'integer'],
            [['topic_enc_id', 'created_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
            [['topic_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
