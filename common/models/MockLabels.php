<?php
namespace common\models;
/**
 * This is the model class for table "{{%mock_labels}}".
 *
 * @property int $id Primary Key
 * @property string $label_enc_id
 * @property string $pool_enc_id Foreign Key to MockLabelPool
 * @property string $parent_enc_id Foreign Key to MockLabels
 * @property string $level_enc_id Foreign Key to MockLavels
 * @property string $created_on On which date was added to database
 * @property string $created_by By which User was added
 * @property int $is_deleted 0 as false, 1 as true
 *
 * @property MockLabelPool $poolEnc
 * @property MockLabels $parentEnc
 * @property MockLabels[] $mockLabels
 * @property MockLevels $levelEnc
 * @property Users $createdBy
 */
class MockLabels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mock_labels}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label_enc_id', 'pool_enc_id', 'level_enc_id', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['label_enc_id', 'pool_enc_id', 'parent_enc_id', 'level_enc_id', 'created_by'], 'string', 'max' => 100],
            [['label_enc_id'], 'unique'],
            [['pool_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockLabelPool::className(), 'targetAttribute' => ['pool_enc_id' => 'pool_enc_id']],
            [['parent_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockLabels::className(), 'targetAttribute' => ['parent_enc_id' => 'label_enc_id']],
            [['level_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockLevels::className(), 'targetAttribute' => ['level_enc_id' => 'level_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPoolEnc()
    {
        return $this->hasOne(MockLabelPool::className(), ['pool_enc_id' => 'pool_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentEnc()
    {
        return $this->hasOne(MockLabels::className(), ['label_enc_id' => 'parent_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockLabels()
    {
        return $this->hasMany(MockLabels::className(), ['parent_enc_id' => 'label_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevelEnc()
    {
        return $this->hasOne(MockLevels::className(), ['level_enc_id' => 'level_enc_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}