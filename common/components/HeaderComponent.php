<?php

namespace common\components;

use common\models\AssignedHeader;
use common\models\HeaderMenuItems;
use Yii;
use yii\base\Component;

class HeaderComponent extends Component
{

    public function getMenuHeader($route, $menu_of = 1, $name = 'Common')
    {
        return '';
//        $header = HeaderMenuItems::find()
//            ->alias('a')
//            ->innerJoinWith(['headerEnc b'], false)
//            ->innerJoinWith(['parentEnc c' => function($c){
//                $c->joinWith(['']);
//            }])
//            ->where(['b.name' => $name, 'b.status' => 1])
//            ->groupBy(['a.parent_enc_id'])
//            ->asArray()
//            ->all();
//        print_r($header);
//        exit();
//        $children = AssignedHeader::find()
//            ->alias('a')
//            ->joinWith(['headerEnc b' => function ($b) {
//                $b->joinWith(['headerMenuEnc c' => function ($c) {
////                    $c->joinWith(['itemEnc d']);
//                    $c->innerJoinWith(['parentEnc e']);
//                }]);
//            }])
////            ->select(['menu_item_enc_id', 'name', 'parent_enc_id', 'route'])
////            ->where(['menu_of' => $menu_of])
////            ->orderBy(['sequence' => SORT_ASC])
//            ->groupBy('a.assigned_header_enc_id')
//            ->asArray()
//            ->all();
//        return $children;
//
//        foreach ($children as $all) {
//            if (in_array($route, $all)) {
//                $menu = $all['menu_item_enc_id'];
//            }
//        }
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

    public function getMenuByRoute($route, $isParent = 1)
    {
        $menuItems = AssignedHeader::find()
            ->alias("a")
            ->innerJoinWith(["headerEnc b" => function ($b) {
                $b->innerJoinWith(['headerMenuEnc c' => function ($c) {
                    $c->innerJoinWith(['parentEnc d' => function ($d) {
                        $d->andWhere([
                            "or",
                            ["c.parent_enc_id" => NULL],
                            ["c.parent_enc_id" => ""],
                        ]);
                    }]);
//                    $c->andOnCondition([
//                        "or",
//                        ["c.parent_enc_id" => NULL],
//                        ["c.parent_enc_id" => ""],
//                    ]);
                }]);
            }])
            ->where([
                "a.route" => $route,
                "a.is_parent" => $isParent,
            ]);

        return $menuItems->asArray()->all();
    }

    private function _getParents()
    {

    }
}