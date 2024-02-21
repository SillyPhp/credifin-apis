<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_education}}".
 *
 * @property int $id Primary Key
 * @property string $education_enc_id Education Encrypted ID
 * @property string $user_enc_id Foreign Key to Users Table
 * @property string $institute School/College/University Name
 * @property string $field Field
 * @property string $degree Degree
 * @property double $cgpa cgpa
 * @property string $from_date From Date
 * @property string $to_date To Date
 * @property string $created_on On which date User Education information was added to database
 * @property string $created_by By which User Education information was added
 * @property string $last_updated_on On which date User Education information was updated
 * @property string $last_updated_by By which User User Education information was updated
 */
class UserEducation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_education}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['education_enc_id', 'user_enc_id', 'institute', 'degree', 'from_date', 'created_by'], 'required'],
            [['degree'], 'string'],
            [['cgpa'], 'number'],
            [['from_date', 'to_date', 'created_on', 'last_updated_on'], 'safe'],
            [['education_enc_id', 'user_enc_id', 'institute', 'created_by', 'last_updated_by'], 'string', 'max' => 100],
            [['field'], 'string', 'max' => 50],
            [['education_enc_id'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserEnc()
    {
        return $this->hasOne(Users::className(), ['user_enc_id' => 'user_enc_id']);
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
