<?php

namespace api\modules\v4\utilities;
class ArrayProcessJson
{
    public static function Parse($list){
        $arrayVal = ['SMA0','SMA1','SMA2','NPA','OnTime'];
        foreach ($list as $key => $lst){

            $total = 0;
            $collectes_cases = 0;
            $target = 0;
            $verified = 0;
            $unverified = 0;
            foreach ($arrayVal as $value){
                //getting total of all buckets
                $total += $lst['total_cases_count_'.$value];
                $collectes_cases += $lst['collected_cases_count_'.$value];
                $target += $lst['target_amount_'.$value];
                $verified += $lst['collected_verified_amount_'.$value];
                $unverified += $lst['collected_unverified_amount_'.$value];

                $list[$key]['Total']['total_cases_count'] = $total;
                $list[$key]['Total']['collected_cases_count'] = $collectes_cases;
                $list[$key]['Total']['target_amount'] = $target;
                $list[$key]['Total']['collected_verified_amount'] = $verified;
                $list[$key]['Total']['collected_unverified_amount'] = $unverified;

                //getting bucket wise values
                $list[$key][$value]['total_cases_count'] = $lst['total_cases_count_'.$value];
                $list[$key][$value]['collected_cases_count'] = $lst['collected_cases_count_'.$value];
                $list[$key][$value]['target_amount'] = $lst['target_amount_'.$value];
                $list[$key][$value]['collected_verified_amount'] = $lst['collected_verified_amount_'.$value];
                $list[$key][$value]['collected_unverified_amount'] = $lst['collected_unverified_amount_'.$value];
                //unset all the values
                unset($list[$key]['total_cases_count_'.$value]);
                unset($list[$key]['collected_cases_count_'.$value]);
                unset($list[$key]['target_amount_'.$value]);
                unset($list[$key]['collected_verified_amount_'.$value]);
                unset($list[$key]['collected_unverified_amount_'.$value]);
            }
        }
        return $list;
    }
}