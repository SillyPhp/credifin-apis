<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%email_type}}".
 *
 * @property int $id
 * @property string $email_type_enc_id
 * @property string $name
 */
class EmailType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_type_enc_id', 'name'], 'required'],
            [['email_type_enc_id', 'name'], 'string', 'max' => 100],
        ];
    }
}
