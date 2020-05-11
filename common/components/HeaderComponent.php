<?php

namespace common\components;

use common\models\AssignedHeader;
use common\models\HeaderMenuItems;
use Yii;
use yii\base\Component;

class HeaderComponent extends Component
{

    public function getMenuHeader($route, $menu_of = 1)
    {
        $header = AssignedHeader::find()
            ->select(['header_enc_id'])
            ->where(['route' => $route])
            ->asArray()
            ->one();
        return $this->getMenuList($header['header_enc_id']);
    }

    public function getMenuList($header_id, $parent = null)
    {
        $model = HeaderMenuItems::find()->alias('a')
            ->select(['a.item_enc_id', 'b.name', 'a.parent_enc_id','b.route','a.icon'])
            ->where(['a.header_enc_id' => $header_id])
            ->andWhere(['a.parent_enc_id' => $parent]);
        if(Yii::$app->user->identity->organization->organization_enc_id){
            $model->andWhere([
                'or',
                ['a.is_visible_for' => 0],
                ['a.is_visible_for' => 2]
            ]);
        } elseif (Yii::$app->user->identity->type->user_type === 'Individual'){
            $model->andWhere([
                'or',
                ['a.is_visible_for' => 0],
                ['a.is_visible_for' => 1]
            ]);
        } else{
            $model->andWhere([
                'or',
                ['a.is_visible_for' => 0]
            ]);
        }
        $result = $model->innerJoinWith(['itemEnc b'], false)
            ->orderBy(['a.sequence' => SORT_ASC])
            ->asArray()->all();

        $arr = [];
        foreach ($result as $key) {
            if ($key['parent_enc_id'] == $parent) {
                $c = [];
                $element = $this->getMenuList($header_id, $key['item_enc_id']);
                $c['value'] = $key;
                if ($element) {
                    $c['childs'] = $element;
                }
                $arr[] = $c;
            }
        }
        return $arr;
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