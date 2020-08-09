<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mock_label_pool}}".
 *
 * @property int $id Primary Key
 * @property string $pool_enc_id
 * @property string $name Name
 * @property string $created_on On which date was added to database
 * @property string $created_by By which User was added
 *
 * @property Users $createdBy
 * @property MockLabels[] $mockLabels
 */
class MockLabelPool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mock_label_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pool_enc_id', 'name', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['pool_enc_id', 'created_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
            [['pool_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
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
    public function getMockLabels()
    {
        return $this->hasMany(MockLabels::className(), ['pool_enc_id' => 'pool_enc_id']);
    }
}
