<?php

namespace common\models;

/**
 * This is the model class for table "{{%usernames}}".
 *
 * @property int $id Primary Key
 * @property string $username Username
 * @property int $assigned_to Username assigned to (0 as Unassigned, 1 as Assigned to User, 2 as Assigned to Organization)
 */
class Usernames extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%usernames}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['assigned_to'], 'integer'],
            [['username'], 'string', 'max' => 50],
            [['username'], 'unique'],
        ];
    }

}