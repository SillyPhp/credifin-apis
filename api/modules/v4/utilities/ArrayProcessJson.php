<?php

namespace api\modules\v4\utilities;
class ArrayProcessJson
{
    public static function Parse($list){
        foreach ($list as $key => $lst){
            $list[$key]['SMAO']['total_cases_count'] = $lst['total_cases_count_SMA0'];
            $list[$key]['SMAO']['collected_cases_count'] = $lst['collected_cases_count_SMA0'];
            $list[$key]['SMAO']['target_amount'] = $lst['target_amount_SMA0'];
            $list[$key]['SMAO']['collected_verified_amoun'] = $lst['collected_verified_amount_SMA0'];
            $list[$key]['SMAO']['collected_unverified_amount'] = $lst['collected_unverified_amount_SMA0'];

            unset($list[$key]['total_cases_count_SMA0']);
            unset($list[$key]['collected_cases_count_SMA0']);
            unset($list[$key]['target_amount_SMA0']);
            unset($list[$key]['collected_verified_amount_SMA0']);
            unset($list[$key]['collected_unverified_amount_SMA0']);

            $list[$key]['SMA1']['total_cases_count'] = $lst['total_cases_count_SMA1'];
            $list[$key]['SMA1']['collected_cases_count'] = $lst['collected_cases_count_SMA1'];
            $list[$key]['SMA1']['target_amount'] = $lst['target_amount_SMA1'];
            $list[$key]['SMA1']['collected_verified_amoun'] = $lst['collected_verified_amount_SMA1'];
            $list[$key]['SMA1']['collected_unverified_amount'] = $lst['collected_unverified_amount_SMA1'];

            unset($list[$key]['total_cases_count_SMA1']);
            unset($list[$key]['collected_cases_count_SMA1']);
            unset($list[$key]['target_amount_SMA1']);
            unset($list[$key]['collected_verified_amount_SMA1']);
            unset($list[$key]['collected_unverified_amount_SMA1']);

            $list[$key]['SMA2']['total_cases_count'] = $lst['total_cases_count_SMA2'];
            $list[$key]['SMA2']['collected_cases_count'] = $lst['collected_cases_count_SMA2'];
            $list[$key]['SMA2']['target_amount'] = $lst['target_amount_SMA2'];
            $list[$key]['SMA2']['collected_verified_amoun'] = $lst['collected_verified_amount_SMA2'];
            $list[$key]['SMA2']['collected_unverified_amount'] = $lst['collected_unverified_amount_SMA2'];

            unset($list[$key]['total_cases_count_SMA2']);
            unset($list[$key]['collected_cases_count_SMA2']);
            unset($list[$key]['target_amount_SMA2']);
            unset($list[$key]['collected_verified_amount_SMA2']);
            unset($list[$key]['collected_unverified_amount_SMA2']);

            $list[$key]['NPA']['total_cases_count'] = $lst['total_cases_count_NPA'];
            $list[$key]['NPA']['collected_cases_count'] = $lst['collected_cases_count_NPA'];
            $list[$key]['NPA']['target_amount'] = $lst['target_amount_NPA'];
            $list[$key]['NPA']['collected_verified_amoun'] = $lst['collected_verified_amount_NPA'];
            $list[$key]['NPA']['collected_unverified_amount'] = $lst['collected_unverified_amount_NPA'];

            unset($list[$key]['total_cases_count_NPA']);
            unset($list[$key]['collected_cases_count_NPA']);
            unset($list[$key]['target_amount_NPA']);
            unset($list[$key]['collected_verified_amount_NPA']);
            unset($list[$key]['collected_unverified_amount_NPA']);

            $list[$key]['OnTime']['total_cases_count'] = $lst['total_cases_count_OnTime'];
            $list[$key]['OnTime']['collected_cases_count'] = $lst['collected_cases_count_OnTime'];
            $list[$key]['OnTime']['target_amount'] = $lst['target_amount_OnTime'];
            $list[$key]['OnTime']['collected_verified_amoun'] = $lst['collected_verified_amount_OnTime'];
            $list[$key]['OnTime']['collected_unverified_amount'] = $lst['collected_unverified_amount_OnTime'];

            unset($list[$key]['total_cases_count_OnTime']);
            unset($list[$key]['collected_cases_count_OnTime']);
            unset($list[$key]['target_amount_OnTime']);
            unset($list[$key]['collected_verified_amount_OnTime']);
            unset($list[$key]['collected_unverified_amount_OnTime']);
        }
        return $list;
    }
}