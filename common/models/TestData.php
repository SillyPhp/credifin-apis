<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%test_data}}".
 *
 * @property int $id Primary Id
 * @property string $loan_account_number Loan Account Number
 * @property string $created_on Created On
 */
class TestData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%test_data}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loan_account_number'], 'required'],
            [['created_on'], 'safe'],
            [['loan_account_number'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loan_account_number' => 'Loan Account Number',
            'created_on' => 'Created On',
        ];
    }
}
?>