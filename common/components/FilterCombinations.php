<?php

namespace common\components;

use common\models\UserPreferences;
use common\models\Users;
use Yii;
use yii\helpers\Url;
use yii\base\Component;

class FilterCombinations extends Component
{

    public function getFilterCombos($filter_keys)
    {
        $result = [];
        $count = count($filter_keys);
        if ($count <= 1) {
            $result = $filter_keys;
        } else {
            for ($i = 0; $i < $count; $i++) {
                $filter_key = array_diff($filter_keys, [$filter_keys[$i]]);
                array_push($result, $filter_key);
                $result = self::getFilterCombosRecursive($filter_key, $i, $result, $filter_keys);
            }
        }

        for ($i = 0; $i < count($result); $i++) {
            $sortArray[$i] = count($result[$i]);
        }
        asort($sortArray);
        $i = 0;
        foreach ($sortArray as $key => $value) {
            $filterCombos[$i] = $result[$key];
            $i++;
        }
        return $filterCombos;
    }

    public function getFilterCombosRecursive($filter_key, $i, $result, $filter_keys)
    {
        if ($i > 0) {
            for ($j = 0; $j < $i; $j++) {
                $filter_keyy = array_diff($filter_key, [$filter_key[$j]]);
                if ($filter_keyy) {
                    array_push($result, $filter_keyy);
                    $result = self::getFilterCombosRecursive($filter_keyy, $j, $result, $filter_keys);
                } else {
                    array_push($result, $filter_keys);
                }
            }
        }
        return $result;
    }

}