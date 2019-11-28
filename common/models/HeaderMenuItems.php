<?php

namespace common\models;

/**
 * This is the model class for table "{{%header_menu_items}}".
 *
 * @property int $id Primary Key
 * @property string $menu_item_enc_id
 * @property string $item_enc_id Menu Item Encrypted ID
 * @property string $parent_enc_id Foreign Key to Header Menu Items Table
 * @property string $header_enc_id
 * @property string $css_class css classes of menus
 * @property string $icon icon of menu item
 * @property string $target menu item target type
 * @property int $sequence Sequence
 * @property int $is_visible_for 0 for All, 1 for Candidate and 2 for Companies
 *
 * @property HeaderMenu $headerMenu
 * @property MenuItems $itemEnc
 * @property MenuItems $parentEnc
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
            [['menu_item_enc_id', 'item_enc_id'], 'required'],
            [['target'], 'string'],
            [['sequence', 'is_visible_for'], 'integer'],
            [['menu_item_enc_id', 'item_enc_id', 'parent_enc_id', 'header_enc_id', 'css_class', 'icon'], 'string', 'max' => 100],
            [['item_enc_id'], 'unique'],
            [['item_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItems::className(), 'targetAttribute' => ['item_enc_id' => 'item_enc_id']],
            [['parent_enc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItems::className(), 'targetAttribute' => ['parent_enc_id' => 'item_enc_id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaderMenu()
    {
        return $this->hasOne(HeaderMenu::className(), ['header_menu_enc_id' => 'header_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemEnc()
    {
        return $this->hasOne(MenuItems::className(), ['item_enc_id' => 'item_enc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentEnc()
    {
        return $this->hasOne(MenuItems::className(), ['item_enc_id' => 'parent_enc_id']);
    }
}
