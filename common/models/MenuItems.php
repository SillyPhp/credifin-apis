<?php

namespace common\models;

/**
 * This is the model class for table "{{%menu_items}}".
 *
 * @property int $id Primary Key
 * @property string $item_enc_id Menu Item Encrypted ID
 * @property string $name Name of Menu Item
 * @property string $route Menu Item Route Path
 * @property int $status Menu Status (0 as Inactive, 1 as Active)
 * @property int $is_deleted Is Menu Deleted (0 as False, 1 as True)
 *
 * @property HeaderMenuItems $headerMenuItems
 * @property HeaderMenuItems[] $headerMenuItems0
 */
class MenuItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_enc_id', 'name', 'route'], 'required'],
            [['status', 'is_deleted'], 'integer'],
            [['item_enc_id', 'name', 'route'], 'string', 'max' => 100],
            [['item_enc_id'], 'unique'],
            [['route'], 'unique'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaderMenuItems()
    {
        return $this->hasOne(HeaderMenuItems::className(), ['item_enc_id' => 'item_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaderMenuItems0()
    {
        return $this->hasMany(HeaderMenuItems::className(), ['parent_enc_id' => 'item_enc_id']);
    }
}