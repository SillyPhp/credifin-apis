<?php

namespace frontend\models\nearme;

use common\models\EmployerApplications;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;

class ApplicationCards
{
    public static function cards($lat,$long,$radius,$num,$keyword,$type,$walkin)
    {
        return self::_getCardsFromJobs($lat,$long,$radius,$num,$keyword,$type,$walkin);
    }

    private static function _getCardsFromJobs($lat,$long,$radius,$num,$keyword,$type,$walkin)
    {
        $data = EmployerApplications::find()
            ->alias('a')
            ->select([
                'a.application_enc_id',
                'a.type',
                'i.slug as organization_slug',
                'a.experience',
                'h.name as job_title',
                'a.slug',
                'a.last_date',
                'e.name as city_name',
                'c.location_name',
                'c.location_enc_id',
                'i.name',
                'f.wage_type',
                'c.latitude',
                'c.longitude',
                '(CASE
                        WHEN a.experience = "0" THEN "No Experience"
                        WHEN a.experience = "1" THEN "Less Than 1 Year Experience"
                        WHEN a.experience = "2" THEN "1 Year Experience"
                        WHEN a.experience = "3" THEN "2-3 Years Experience"
                        WHEN a.experience = "3-5" THEN "3-5 Years Experience"
                        WHEN a.experience = "5-10" THEN "5-10 Years Experience"
                        WHEN a.experience = "10-20" THEN "10-20 Years Experience"
                        WHEN a.experience = "20+" THEN "More Than 20 Years Experience"
                        ELSE "No Experience"
                        END) as experience',
                'f.fixed_wage as fixed_salary',
                'f.wage_type salary_type',
                'f.max_wage as max_salary',
                'f.min_wage as min_salary',
                'f.wage_duration as salary_duration',
                'i.initials_color as color',
                'CASE WHEN i.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", i.logo_location, "/", i.logo) ELSE NULL END logo',
                "( 6371 * acos( cos( radians('$lat') ) * cos( radians( c.latitude ) ) * cos( radians( c.longitude ) - radians('$long') ) + sin( radians('$lat') ) * sin( radians( c.latitude ) ) ) )  distance",
            ]);
        if($walkin){
            $data->joinWith(['applicationInterviewLocations as b'=>function($x){
                $x->joinWith(['locationEnc as c'=>function($y){
                    $y->joinWith(['cityEnc as e']);
                }],false);
            }],false, 'INNER JOIN');
        }else{
            $data->joinWith(['applicationPlacementLocations as b'=>function($x){
                $x->joinWith(['locationEnc as c'=>function($y){
                    $y->joinWith(['cityEnc as e']);
                }],false);
            }],false, 'INNER JOIN');
        }

            $data->joinWith(['applicationOptions as f'],false)
            ->joinWith(['title g'=>function($z){
                $z->joinWith(['categoryEnc as h'],false);
                $z->joinWith(['parentEnc p'], false);
            }],false)
            ->joinWith(['organizationEnc as i'])
            ->joinWith(['applicationTypeEnc as j'])
            ->joinWith(['designationEnc l'], false)
            ->joinWith(['preferredIndustry o'], false)
            ->having(['<', 'distance', $radius])
            ->where(['j.name' => $type, 'a.status' => 'Active', 'a.is_deleted' => 0]);
        if (!empty($keyword)) {
            $data->andWhere([
                'or',
                ['like', 'l.designation',$keyword],
                ['like', 'a.type', $keyword],
                ['like', 'h.name', $keyword],
                ['like', 'o.industry', $keyword],
                ['like', 'p.name', $keyword],
            ]);
        }
        $result = $data->limit(20)->offset($num)->asArray()
            ->all();

        if($type == 'Jobs') {
            $i = 0;
            foreach ($result as $val) {
                $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
                if ($val['salary_type'] == "Fixed") {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 40 * 52 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 52 . ' p.a.';
                    } else {
                        $result[$i]['salary'] = $val['fixed_salary'] . ' p.a.';
                    }
                } elseif ($val['salary_type'] == "Negotiable") {
                    if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12 . ' p.a.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52) . ' p.a.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52) . ' p.a.';
                        } else {
                            $result[$i]['salary'] = (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']) . ' p.a.';
                        }
                    } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['min_salary'] * 12 . ' p.a.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . ' p.a.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 52) . ' p.a.';
                        } else {
                            $result[$i]['salary'] = (string)($val['min_salary']) . ' p.a.';
                        }
                    } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['max_salary'] * 12 . ' p.a.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['max_salary'] * 40 * 52) . ' p.a.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['max_salary'] * 52) . ' p.a.';
                        } else {
                            $result[$i]['salary'] = (string)($val['max_salary']) . ' p.a.';
                        }
                    }
                }
                $i++;
            }
        }elseif ($type == 'Internships'){
            $i = 0;
            foreach ($result as $val) {
                $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
                if ($val['salary_type'] == "Fixed") {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $val['fixed_salary'] . ' p.m.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 40 * 4 . ' p.m.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 4 . ' p.m.';
                    } else {
                        $result[$i]['salary'] = $val['fixed_salary'] . ' p.m.';
                    }
                } elseif ($val['salary_type'] == "Negotiable") {
                    if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['min_salary'] . " - ₹" . (string)$val['max_salary'] . ' p.m.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 4) . " - ₹" . (string)($val['max_salary'] * 40 * 4) . ' p.m.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 4) . " - ₹" . (string)($val['max_salary'] * 4) . ' p.m.';
                        } else {
                            $result[$i]['salary'] = (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']) . ' p.m.';
                        }
                    } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['min_salary'] . ' p.m.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 4) . ' p.m.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 4) . ' p.m.';
                        } else {
                            $result[$i]['salary'] = (string)($val['min_salary']) . ' p.m.';
                        }
                    } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['max_salary'] . ' p.m.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['max_salary'] * 40 * 4) . ' p.m.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['max_salary'] * 4) . ' p.m.';
                        } else {
                            $result[$i]['salary'] = (string)($val['max_salary']) . ' p.m.';
                        }
                    }
                }
                $i++;
            }
        }

        return json_encode($result);
    }
}
