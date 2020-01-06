<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%currencies}}".
 *
 * @property int $id Primary Key
 * @property string $currency_enc_id Currency Encrypted ID
 * @property string $country country name
 * @property string $name Name
 * @property string $code code
 * @property string $html_code html code
 * @property string $created_on
 * @property string $created_by
 */
class Currencies extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currencies}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['currency_enc_id', 'country', 'name', 'created_by'], 'required'],
            [['created_on'], 'safe'],
            [['currency_enc_id', 'code', 'html_code', 'created_by'], 'string', 'max' => 100],
            [['country', 'name'], 'string', 'max' => 255],
            [['currency_enc_id'], 'unique'],
            [['country', 'code'], 'unique', 'targetAttribute' => ['country', 'code']],
        ];
    }

    /**
     * @inheritdoc
     */
}
