<?php

namespace common\models;

/**
 * This is the model class for table "{{%shell_exce_test}}".
 *
 * @property int $id Primary Key
 * @property string $name
 * @property string $address
 */
class ShellExceTest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shell_exce_test}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address'], 'required'],
            [['name', 'address'], 'string', 'max' => 255],
        ];
    }

}
