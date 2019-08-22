<?php

namespace common\components;

use common\models\HeaderMenuItems;
use Yii;
use yii\base\Component;

class HeaderComponent extends Component
{

    public function getMenuHeader($route, $menu_of = 1)
    {
        $children = HeaderMenuItems::find()
            ->select(['menu_item_enc_id', 'name', 'parent_enc_id', 'route'])
            ->where(['menu_of' => $menu_of])
            ->orderBy(['sequence' => SORT_ASC])
            ->asArray()
            ->all();
        
        foreach ($children as $all) {
            if (in_array($route, $all)) {
                $menu = $all['menu_item_enc_id'];
            }
        }
        return $this->findChild($children, $menu);
    }

    private function findChild($children, $parentValue = 0)
    {
        $result = [];
        foreach ($children as $c) {
            if ($c['parent_enc_id'] == $parentValue && !empty($parentValue)) {
                $element = $this->findChild($children, $c['menu_item_enc_id']);
                if ($element) {
                    $c['baby'] = $element;
                }
                $result[] = $c;
            }
        }
        return $result;
    }
}