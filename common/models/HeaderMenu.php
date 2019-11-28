<?php

namespace common\models;

/**
 * This is the model class for table "{{%header_menu}}".
 *
 * @property int $id Primary Key
 * @property string $header_menu_enc_id Menu Item Encrypted ID
 * @property string $name Name of Header Menu
 * @property int $status
 *
 * @property AssignedHeader[] $assignedHeaders
 * @property HeaderMenuItems $headerMenuEnc
 */
class HeaderMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%header_menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['header_menu_enc_id', 'name', 'status'], 'required'],
            [['status'], 'integer'],
            [['header_menu_enc_id', 'name'], 'string', 'max' => 100],
            [['header_menu_enc_id'], 'unique'],
            [['header_menu_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => HeaderMenuItems::className(), 'targetAttribute' => ['header_menu_enc_id' => 'header_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedHeaders()
    {
        return $this->hasMany(AssignedHeader::className(), ['header_enc_id' => 'header_menu_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaderMenuEnc()
    {
        return $this->hasOne(HeaderMenuItems::className(), ['header_enc_id' => 'header_menu_enc_id']);
    }
}
