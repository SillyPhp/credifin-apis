<?php

namespace common\models;

/**
 * This is the model class for table "{{%widget_tutorials}}".
 *
 * @property int $id Primary Key
 * @property string $tutorial_enc_id Tutorial Encrypted ID
 * @property string $name Tutorial Name
 * @property string $created_on On which date Tutorial information was added to database
 * @property string $last_updated_on On which date Tutorial information was updated
 *
 * @property UserCoachingTutorials[] $userCoachingTutorials
 */
class WidgetTutorials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%widget_tutorials}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tutorial_enc_id', 'name'], 'required'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['tutorial_enc_id', 'name'], 'string', 'max' => 100],
            [['tutorial_enc_id'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserCoachingTutorials()
    {
        return $this->hasMany(UserCoachingTutorials::className(), ['tutorial_enc_id' => 'tutorial_enc_id']);
    }
}