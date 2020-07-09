<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mock_levels}}".
 *
 * @property int $id Primary Key
 * @property string $level_enc_id
 * @property string $name Name
 * @property int $sequence
 * @property int $assigned_to 1 as School, 2 as College, 3 as Competitive
 * @property string $created_on On which date was added to database
 * @property string $created_by By which User was added
 *
 * @property MockLabels[] $mockLabels
 * @property Users $createdBy
 */
class MockLevels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mock_levels}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_enc_id', 'name', 'sequence', 'assigned_to', 'created_by'], 'required'],
            [['sequence', 'assigned_to'], 'integer'],
            [['created_on'], 'safe'],
            [['level_enc_id', 'created_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
            [['level_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockLabels()
    {
        return $this->hasMany(MockLabels::className(), ['level_enc_id' => 'level_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'created_by']);
    }
}
