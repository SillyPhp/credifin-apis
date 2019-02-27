<?php

namespace common\models;

/**
 * This is the model class for table "{{%user_coaching_tutorials}}".
 *
 * @property int $id Primary Key
 * @property string $user_coaching_tutorial_enc_id User Coaching Encrypted ID
 * @property string $tutorial_enc_id Foreign Key to Widget Tutorials Table
 * @property string $created_on On which date Tutorial information was added to database
 * @property string $created_by By which User Tutorial  information was added
 * @property string $last_updated_on On which date Tutorial  information was updated
 * @property string $last_updated_by By which User Tutorial  information was updated
 * @property int $is_viewed Is Tutorial Viewed (0 as No, 1 as Yes)
 *
 * @property WidgetTutorials $tutorialEnc
 * @property Users $createdBy
 * @property Users $lastUpdatedBy
 */
class UserCoachingTutorials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_coaching_tutorials}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_coaching_tutorial_enc_id', 'tutorial_enc_id', 'created_by'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_viewed'], 'integer'],
            [['user_coaching_tutorial_enc_id', 'tutorial_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['user_coaching_tutorial_enc_id'], 'unique'],
            [['tutorial_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => WidgetTutorials::className(), 'targetAttribute' => ['tutorial_enc_id' => 'tutorial_enc_id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['created_by' => 'user_enc_id']],
            [['last_updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['last_updated_by' => 'user_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTutorialEnc()
    {
        return $this->hasOne(WidgetTutorials::className(), ['tutorial_enc_id' => 'tutorial_enc_id']);
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
    
}