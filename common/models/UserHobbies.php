<?php

namespace common\models;

/**
 * This is the model class for table "{{%user_hobbies}}".
 *
 * @property int $id Primary Key
 * @property string $user_hobby_enc_id User Hobby Encrypted ID
 * @property string $hobby Hobby
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $created_on On which date User Hobby information was added to database
 * @property string $created_by By which User Hobby information was added
 * @property string $last_updated_on On which date User Hobby information was updated
 * @property string $last_updated_by By which User Hobby information was updated
 * @property int $is_deleted Is User Hobby Deleted (0 As False, 1 As True)
 */
class UserHobbies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_hobbies}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_hobby_enc_id', 'hobby', 'user_enc_id', 'created_by'], 'required'],
            [['hobby'], 'string'],
            [['created_on', 'last_updated_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['user_hobby_enc_id', 'user_enc_id', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
        ];
    }
}
