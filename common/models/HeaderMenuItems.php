<?php

namespace common\models;

/**
 * This is the model class for table "{{%header_menu_items}}".
 *
 * @property int $id Primary Key
 * @property string $menu_item_enc_id Menu Item Encrypted ID
 * @property string $name Name of Menu Item
 * @property string $route Menu Item Route Path
 * @property string $parent_enc_id Foreign Key to Header Menu Items Table
 * @property int $sequence Sequence
 * @property int $menu_of Menu For (1 for Frontend, 2 for Account)
 * @property int $status Menu Status (0 as Inactive, 1 as Active)
 * @property int $is_deleted Is Menu Deleted (0 as False, 1 as True)
 *
 * @property HeaderMenuItems $parentEnc
 * @property HeaderMenuItems[] $headerMenuItems
 */
class HeaderMenuItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%header_menu_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_item_enc_id', 'name', 'route'], 'required'],
            [['sequence', 'menu_of', 'status', 'is_deleted'], 'integer'],
            [['menu_item_enc_id', 'name', 'route', 'parent_enc_id'], 'string', 'max' => 100],
            [['menu_item_enc_id'], 'unique'],
            [['route', 'menu_of'], 'unique', 'targetAttribute' => ['route', 'menu_of']],
            [['parent_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => HeaderMenuItems::className(), 'targetAttribute' => ['parent_enc_id' => 'menu_item_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentEnc()
    {
        return $this->hasOne(HeaderMenuItems::className(), ['menu_item_enc_id' => 'parent_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaderMenuItems()
    {
        return $this->hasMany(HeaderMenuItems::className(), ['parent_enc_id' => 'menu_item_enc_id']);
    }
}
