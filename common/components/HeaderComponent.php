<?php

namespace common\components;

use common\models\HeaderMenuItems;
use Yii;
use yii\base\Component;

class HeaderComponent extends Component
{

    public function getMenuHeader($route, $menu_of = 1)
    {
        $childrens = HeaderMenuItems::find()
            ->select(['menu_item_enc_id', 'name', 'parent_enc_id','route'])
            ->where(['menu_of' => $menu_of])
            ->orderBy(['sequence'=> SORT_ASC])
            ->asArray()
            ->all();
//        $parentID = HeaderMenuItems::find()
//            ->select(['menu_item_enc_id'])
//            ->where(['route' => $route])
//            ->asArray()
//            ->one();
        foreach ($childrens as $all){
            if(in_array($route, $all)){
                $menu = $all['menu_item_enc_id'];
            }
        }
        return $this->findChild($childrens, $menu);
    }

    private function findChild($childrens, $parentValue = 0)
    {
        $result = [];
        foreach ($childrens as $c) {
            if($c['parent_enc_id']  == $parentValue && !empty($parentValue)){
                $element = $this->findChild($childrens, $c['menu_item_enc_id']);
                if($element){
                    $c['baby'] = $element;
                }
                $result[] = $c;
            }
        }
        return $result;
    }
}