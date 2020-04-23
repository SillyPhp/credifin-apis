<?php

namespace common\models;

/**
 * This is the model class for table "{{%assigned_header}}".
 *
 * @property int $id Primary Key
 * @property string $assigned_header_enc_id Menu Item Encrypted ID
 * @property string $header_enc_id Foreign Key to Header Menu Items Table
 * @property string $route Menu Item Route Path
 * @property int $is_parent item is parent(0 as false, 1 as True)
 *
 * @property HeaderMenu $headerEnc
 */
class AssignedHeader extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%assigned_header}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['assigned_header_enc_id', 'header_enc_id', 'route'], 'required'],
            [['is_parent'], 'integer'],
            [['assigned_header_enc_id', 'header_enc_id', 'route'], 'string', 'max' => 100],
            [['assigned_header_enc_id'], 'unique'],
            [['route'], 'unique'],
            [['header_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => HeaderMenu::className(), 'targetAttribute' => ['header_enc_id' => 'header_menu_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaderEnc()
    {
        return $this->hasOne(HeaderMenu::className(), ['header_menu_enc_id' => 'header_enc_id']);
    }
}
