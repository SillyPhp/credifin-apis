<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%mock_quiz_pool}}".
 *
 * @property int $id Primary Key
 * @property string $quiz_pool_enc_id
 * @property string $label_enc_id Foreign Key to MockLabels table
 * @property string $organization_enc_id Foreign Key to Organization table
 * @property string $name Name
 * @property string $keywords Quiz Keywords
 * @property string $description Quiz Description
 * @property string $created_on On which date was added to database
 * @property string $created_by By which User was added
 * @property int $status 0 as Pending, 1 as Approved
 * @property int $is_pinned 0 as false, 1 as true
 *
 * @property Users $createdBy
 * @property MockLabels $labelEnc
 * @property Organizations $organizationEnc
 * @property MockQuizQuestionsPool[] $mockQuizQuestionsPools
 */
class MockQuizPool extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%mock_quiz_pool}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz_pool_enc_id', 'label_enc_id', 'name', 'created_by'], 'required'],
            [['keywords', 'description'], 'string'],
            [['created_on'], 'safe'],
            [['status', 'is_pinned'], 'integer'],
            [['quiz_pool_enc_id', 'label_enc_id', 'organization_enc_id', 'created_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
            [['quiz_pool_enc_id'], 'unique'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['label_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MockLabels::className(), 'targetAttribute' => ['label_enc_id' => 'label_enc_id']],
            [['organization_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organizations::className(), 'targetAttribute' => ['organization_enc_id' => 'organization_enc_id']],
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
    public function getLabelEnc()
    {
        return $this->hasOne(MockLabels::className(), ['label_enc_id' => 'label_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrganizationEnc()
    {
        return $this->hasOne(Organizations::className(), ['organization_enc_id' => 'organization_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMockQuizQuestionsPools()
    {
        return $this->hasMany(MockQuizQuestionsPool::className(), ['quiz_pool_enc_id' => 'quiz_pool_enc_id']);
    }
}
