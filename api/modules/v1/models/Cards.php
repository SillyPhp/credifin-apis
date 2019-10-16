<?php

namespace api\modules\v1\models;

use Yii;
use yii\helpers\Url;
use common\models\EmployerApplications;
use common\models\ApplicationTypes;

class Cards
{
    public static function jobs($options = [])
    {
        return self::_getCardsFromJobs($options);
    }

    private static function _getCardsFromJobs($options)
    {
        $cards = EmployerApplications::find()
            ->alias('a')
            ->select([
                'a.application_enc_id application_id',
                'a.type',
                'a.last_date',
                'l.designation',
                'd.initials_color color',
                'd.organization_enc_id',
                "g.name as city",
                "g.city_enc_id as city_id",
                'c.name as title',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
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
                'm.fixed_wage as fixed_salary',
                'm.wage_type salary_type',
                'm.max_wage as max_salary',
                'm.min_wage as min_salary',
                'm.wage_duration as salary_duration'
            ])
            ->innerJoinWith(['title b' => function ($x) {
                $x->joinWith(['categoryEnc c'], false);
                $x->joinWith(['parentEnc i'], false);
            }], false)
            ->innerJoinWith(['organizationEnc d'=>function($d){
                $d->onCondition(['d.is_deleted'=>0]);
            }], false)
            ->innerJoinWith(['applicationPlacementLocations e' => function ($x) {
                $x->innerJoinWith(['locationEnc f' => function ($x) {
                    $x->innerJoinWith(['cityEnc g'], false);
                }], false);
            }], false)
            ->innerJoinWith(['preferredIndustry h'], false)
            ->innerJoinWith(['designationEnc l'], false)
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->innerJoinWith(['applicationOptions m'], false)
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0]);

        if (isset($options['company'])) {
            $cards->andWhere([
                'or',
                ['like', 'd.name', $options['company']]
            ]);
        }

        if (isset($options['organization_id'])) {
            $cards->andWhere(['d.organization_enc_id' => $options['organization_id']]);
        }

        if (isset($options['location'])) {
            $cards->andWhere([
                'or',
                ['g.name' => $options['location']]
            ]);
        }

        if (!isset($options['for_careers']) || !(int)$options['for_careers'] || $options['for_careers'] !== 1) {
            $options['for_careers'] = 0;
        }

        $cards->andWhere([
            'or',
            ['a.for_careers' => $options['for_careers']]
        ]);

        if (isset($options['keyword'])) {
            $cards->andWhere([
                'or',
                ['like', 'l.designation', $options['keyword']],
                ['like', 'a.type', $options['keyword']],
                ['like', 'c.name', $options['keyword']],
                ['like', 'h.industry', $options['keyword']],
                ['like', 'i.name', $options['keyword']],
                ['like', 'd.name', $options['keyword']]
            ]);
        }


        if (isset($options['limit'])) {
            $cards->limit = $options['limit'];
            $cards->offset = ($options['page'] - 1) * $options['limit'];
        }

        $result = $cards->orderBy(['a.id' => SORT_DESC])->asArray()->all();
        $i = 0;
        foreach ($result as $val) {
            if ($val['salary_type'] == "Fixed") {
                if ($val['salary_duration'] == "Monthly") {
                    $result[$i]['salary'] = "₹" . (string)$val['fixed_salary'] * 12 . ' p.a.';
                } elseif ($val['salary_duration'] == "Hourly") {
                    $result[$i]['salary'] = "₹" . (string)$val['fixed_salary'] * 40 * 52 . ' p.a.';
                } elseif ($val['salary_duration'] == "Weekly") {
                    $result[$i]['salary'] = "₹" . (string)$val['fixed_salary'] * 52 . ' p.a.';
                } else {
                    $result[$i]['salary'] = "₹" . (string)$val['fixed_salary'] . ' p.a.';
                }
            } elseif ($val['salary_type'] == "Negotiable") {
                if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹" . (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹" . (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52) . ' p.a.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹" . (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52) . ' p.a.';
                    } else {
                        $result[$i]['salary'] = "₹" . (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']) . ' p.a.';
                    }
                } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹" . (string)$val['min_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹" . (string)($val['min_salary'] * 40 * 52) . ' p.a.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹" . (string)($val['min_salary'] * 52) . ' p.a.';
                    } else {
                        $result[$i]['salary'] = "₹" . (string)($val['min_salary']) . ' p.a.';
                    }
                } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹" . (string)$val['max_salary'] * 12 . ' p.a.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹" . (string)($val['max_salary'] * 40 * 52) . ' p.a.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹" . (string)($val['max_salary'] * 52) . ' p.a.';
                    } else {
                        $result[$i]['salary'] = "₹" . (string)($val['max_salary']) . ' p.a.';
                    }
                } else {
                    $result[$i]['salary'] = "Negotiable";
                }
            }
            unset($result[$i]['max_salary']);
            unset($result[$i]['min_salary']);
            unset($result[$i]['salary_duration']);
            $i++;
        }
        return $result;
    }

    public static function internships($options = [])
    {
        return self::_getCardsFromInternships($options);
    }

    private static function _getCardsFromInternships($options)
    {
        $cards = EmployerApplications::find()
            ->alias('a')
            ->select([
                'a.application_enc_id application_id',
                'a.last_date',
                'd.initials_color color',
                'd.organization_enc_id',
                "g.name as city",
                'a.type',
                'm.fixed_wage as fixed_salary',
                'm.wage_type salary_type',
                'm.max_wage as max_salary',
                'm.min_wage as min_salary',
                'm.wage_duration as salary_duration',
                'c.name as title',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", d.logo_location, "/", d.logo) ELSE NULL END logo'])
            ->innerJoinWith(['title b' => function ($x) {
                $x->joinWith(['categoryEnc c'], false);
                $x->joinWith(['parentEnc i'], false);
            }], false)
            ->innerJoinWith(['organizationEnc d'=>function($d){
                $d->onCondition(['d.is_deleted'=>0]);
            }], false)
            ->innerJoinWith(['applicationPlacementLocations e' => function ($x) {
                $x->innerJoinWith(['locationEnc f' => function ($x) {
                    $x->innerJoinWith(['cityEnc g'], false);
                }], false);
            }], false)
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->innerJoinWith(['applicationOptions m'], false)
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0]);

        if (isset($options['company'])) {
            $cards->andWhere([
                'or',
                ['like', 'd.name', $options['company']]
            ]);
        }

        if (!isset($options['for_careers']) || !(int)$options['for_careers'] || $options['for_careers'] !== 1) {
            $options['for_careers'] = 0;
        }

        $cards->andWhere([
            'or',
            ['a.for_careers' => $options['for_careers']]
        ]);

        if (isset($options['organization_id'])) {
            $cards->andWhere(['d.organization_enc_id' => $options['organization_id']]);
        }

        if (isset($options['location'])) {
            $cards->andWhere([
                'or',
                ['g.name' => $options['location']]
            ]);
        }
        if (isset($options['keyword'])) {
            $cards->andWhere([
                'or',
                ['like', 'a.type', $options['keyword']],
                ['like', 'c.name', $options['keyword']],
                ['like', 'i.name', $options['keyword']],
                ['like', 'd.name', $options['keyword']],
            ]);
        }

        if (isset($options['limit'])) {
            $cards->limit = $options['limit'];
            $cards->offset = ($options['page'] - 1) * $options['limit'];
        }

        $result = $cards->orderBy(['a.id' => SORT_DESC])->asArray()->all();

        $i = 0;
        foreach ($result as $val) {
            $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
            if ($val['salary_type'] == "Fixed") {
                if ($val['salary_duration'] == "Monthly") {
                    $result[$i]['salary'] = "₹" . $val['fixed_salary'] . ' p.m.';
                } elseif ($val['salary_duration'] == "Hourly") {
                    $result[$i]['salary'] = "₹" . $val['fixed_salary'] * 730 . ' p.m.';
                } elseif ($val['salary_duration'] == "Weekly") {
                    $result[$i]['salary'] = "₹" . (int)$val['fixed_salary'] / 7 * 30 . ' p.m.';
                } else {
                    $result[$i]['salary'] = "₹" . (int)$val['fixed_salary'] / 12 . ' p.m.';
                }
            } elseif ($val['salary_type'] == "Negotiable" || $val['salary_type'] == "Performance Based") {
                if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹" . (string)$val['min_salary'] . " - ₹" . (string)$val['max_salary'] . ' p.m.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹" . (string)($val['min_salary'] * 730) . " - ₹" . (string)($val['max_salary'] * 730) . ' p.m.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹" . (int)($val['min_salary'] / 7 * 30) . " - ₹" . (int)($val['max_salary'] / 7 * 30) . ' p.m.';
                    } else {
                        $result[$i]['salary'] = "₹" . (int)($val['min_salary']) / 12 . " - ₹" . (int)($val['max_salary']) / 12 . ' p.m.';
                    }
                } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹" . (string)$val['min_salary'] . ' p.m.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹" . (string)($val['min_salary'] * 730) . ' p.m.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹" . (int)($val['min_salary'] / 7 * 30) . ' p.m.';
                    } else {
                        $result[$i]['salary'] = "₹" . (int)($val['min_salary']) / 12 . ' p.m.';
                    }
                } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = "₹" . (string)$val['max_salary'] . ' p.m.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = "₹" . (string)($val['max_salary'] * 730) . ' p.m.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = "₹" . (int)($val['max_salary'] / 7 * 30) . ' p.m.';
                    } else {
                        $result[$i]['salary'] = "₹" . (int)($val['max_salary']) / 12 . ' p.m.';
                    }
                }
            }
            if (empty($result[$i]['salary'])) {
                $result[$i]['salary'] = "Unpaid";
            }
            unset($result[$i]['max_salary']);
            unset($result[$i]['min_salary']);
            unset($result[$i]['salary_duration']);
            $i++;
        }
        return $result;
    }

    public static function jobsNearMe($options = [])
    {
        return self::_getCardsFromJobsNearMe($options);
    }

    private static function _getCardsFromJobsNearMe($options)
    {

        $lat = $options['latitude'];
        $long = $options['longitude'];
        $radius = $options['radius'];
        $date = Date('Y-m-d H:i:s');

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
                'CASE WHEN i.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", i.logo_location, "/", i.logo) ELSE NULL END logo',
                "( 6371 * acos( cos( radians('$lat') ) * cos( radians( c.latitude ) ) * cos( radians( c.longitude ) - radians('$long') ) + sin( radians('$lat') ) * sin( radians( c.latitude ) ) ) )  distance",
            ]);
        if ($options['walkin']) {
            $data->joinWith(['applicationInterviewLocations as b' => function ($x) {
                $x->joinWith(['locationEnc as c' => function ($y) {
                    $y->joinWith(['cityEnc as e']);
                }], false);
            }], false, 'INNER JOIN');

            $data->joinWith(['applicationOptions as q' => function ($q) use ($date) {
                $q->andWhere(['<=', 'q.interview_start_date', $date]);
                $q->andWhere(['>=', 'q.interview_end_date', $date]);
            }], false);

        } else {
            $data->joinWith(['applicationPlacementLocations as b' => function ($x) {
                $x->joinWith(['locationEnc as c' => function ($y) {
                    $y->joinWith(['cityEnc as e']);
                }], false);
            }], false, 'INNER JOIN');
        }

        $data->joinWith(['applicationOptions as f'], false)
            ->joinWith(['title g' => function ($z) {
                $z->joinWith(['categoryEnc as h'], false);
                $z->joinWith(['parentEnc p'], false);
            }], false)
            ->joinWith(['organizationEnc as i'])
            ->joinWith(['applicationTypeEnc as j'])
            ->joinWith(['designationEnc l'], false)
            ->joinWith(['preferredIndustry o'], false)
            ->having(['<', 'distance', $radius])
            ->where(['j.name' => $options['type'], 'a.status' => 'Active', 'a.for_careers' => 0, 'a.is_deleted' => 0]);

        if (!empty($options['keyword'])) {
            $data->andWhere([
                'or',
                ['like', 'l.designation', $options['keyword']],
                ['like', 'a.type', $options['keyword']],
                ['like', 'h.name', $options['keyword']],
                ['like', 'o.industry', $options['keyword']],
                ['like', 'p.name', $options['keyword']],
            ]);
        }


        $result = $data->limit(10)->offset(($options['page'] - 1) * 10)->asArray()
            ->all();

        if ($options['type'] == 'Jobs' || $options['type'] == 'jobs') {
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
        } elseif ($options['type'] == 'Internships' || $options['type'] == 'internships') {
            $i = 0;
            foreach ($result as $val) {
                $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
                if ($val['salary_type'] == "Fixed") {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $val['fixed_salary'] . ' p.m.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 730 . ' p.m.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = (int)$val['fixed_salary'] / 7 * 30 . ' p.m.';
                    } else {
                        $result[$i]['salary'] = (int)$val['fixed_salary'] / 12 . ' p.m.';
                    }
                } elseif ($val['salary_type'] == "Negotiable" || $val['salary_type'] == "Performance Based") {
                    if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['min_salary'] . " - ₹" . (string)$val['max_salary'] . ' p.m.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 730) . " - ₹" . (string)($val['max_salary'] * 730) . ' p.m.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (int)($val['min_salary'] / 7 * 30) . " - ₹" . (int)($val['max_salary'] / 7 * 30) . ' p.m.';
                        } else {
                            $result[$i]['salary'] = (int)($val['min_salary']) / 12 . " - ₹" . (int)($val['max_salary']) / 12 . ' p.m.';
                        }
                    } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['min_salary'] . ' p.m.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 730) . ' p.m.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (int)($val['min_salary'] / 7 * 30) . ' p.m.';
                        } else {
                            $result[$i]['salary'] = (int)($val['min_salary']) / 12 . ' p.m.';
                        }
                    } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['max_salary'] . ' p.m.';
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['max_salary'] * 730) . ' p.m.';
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (int)($val['max_salary'] / 7 * 30) . ' p.m.';
                        } else {
                            $result[$i]['salary'] = (int)($val['max_salary']) / 12 . ' p.m.';
                        }
                    }
                }
                $i++;
            }
        }

        return $result;
    }

}
