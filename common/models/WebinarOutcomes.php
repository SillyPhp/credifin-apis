<?php
namespace common\models;


/**
 * This is the model class for table "{{%webinar_outcomes}}".
 *
 * @property int $id Primary Key
 * @property string $outcome_enc_id Encrypted Encrypted ID
 * @property string $webinar_enc_id
 * @property string $outcome_pool_enc_id Webinar Title
 * @property string $created_on
 * @property string $created_by
 * @property string $last_updated_on
 * @property string $last_updated_by
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property PoolWebinarOutcomes $outcomePoolEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 * @property Webinar $webinarEnc
 */
class WebinarOutcomes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%webinar_outcomes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['outcome_enc_id', 'webinar_enc_id', 'outcome_pool_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['outcome_enc_id', 'webinar_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['outcome_pool_enc_id'], 'string', 'max' => 255],
            [['outcome_enc_id'], 'unique'],
            [['outcome_pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => PoolWebinarOutcomes::className(), 'targetAttribute' => ['outcome_pool_enc_id' => 'outcome_pool_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
            [['webinar_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Webinar::className(), 'targetAttribute' => ['webinar_enc_id' => 'webinar_enc_id']],
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOutcomePoolEnc()
    {
        return $this->hasOne(PoolWebinarOutcomes::className(), ['outcome_pool_enc_id' => 'outcome_pool_enc_id']);
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
    public function getWebinarEnc()
    {
        return $this->hasOne(Webinar::className(), ['webinar_enc_id' => 'webinar_enc_id']);
    }
}
