<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%loan_documents}}".
 *
 * @property int $id
 * @property string $document_enc_id
 * @property string $name
 * @property string $visible_for
 * @property string $created_by
 * @property string $created_on
 * @property int $is_deleted 0 false,1 true
 */
class LoanDocuments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%loan_documents}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_enc_id', 'name', 'visible_for', 'created_by'], 'required'],
            [['visible_for'], 'string'],
            [['created_on'], 'safe'],
            [['is_deleted'], 'integer'],
            [['document_enc_id', 'created_by'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 20],
            [['document_enc_id'], 'unique'],
        ];
    }
}
