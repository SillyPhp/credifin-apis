<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%departments}}".
 *
 * @property int $id
 * @property string $department_enc_id
 * @property string $name
 * @property int $is_deleted 0 as False, 1 as True
 *
 * @property UserOtherDetails[] $userOtherDetails
 */
class Departments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%departments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_enc_id', 'name'], 'required'],
            [['is_deleted'], 'integer'],
            [['department_enc_id', 'name'], 'string', 'max' => 100],
            [['department_enc_id'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserOtherDetails()
    {
        return $this->hasMany(UserOtherDetails::className(), ['department_enc_id' => 'department_enc_id']);
    }
}
