<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%webhook_test}}".
 *
 * @property int $id
 * @property string $json_body
 */
class WebhookTest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%webhook_test}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['json_body'], 'required'],
            [['json_body'], 'string'],
        ];
    }
}
