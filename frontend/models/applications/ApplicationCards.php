<?php

namespace frontend\models\applications;

use Yii;
use yii\helpers\Url;
use common\models\Organizations;
use common\models\OrganizationLocations;
use common\models\Cities;
use common\models\EmployerApplications;
use common\models\ApplicationPlacementLocations;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\ApplicationTypes;
use common\models\Industries;
use common\models\Designations;
use common\models\ApplicationOptions;

class ApplicationCards
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
                'e.location_enc_id location_id',
                'a.last_date',
                'a.type',
                'i.name category',
                'l.designation',
                'CONCAT("/job/", a.slug) link',
                'd.initials_color color',
                'CONCAT("/", d.slug) organization_link',
                "g.name as city",
                'c.name as title',
                'i.icon',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
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
            ->joinWith(['title b' => function ($x) {
                $x->joinWith(['categoryEnc c'], false);
                $x->joinWith(['parentEnc i'], false);
            }], false)
            ->joinWith(['organizationEnc d'=>function($a){
                $a->where(['d.is_deleted'=>0]);
            }], false)
            ->joinWith(['applicationPlacementLocations e' => function ($x) {
                $x->joinWith(['locationEnc f' => function ($x) {
                    $x->joinWith(['cityEnc g'=>function($x)
                    {
                        $x->joinWith(['stateEnc s'],false);
                    }], false);
                }], false);
            }], false)
            ->joinWith(['preferredIndustry h'], false)
            ->joinWith(['designationEnc l'], false)
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->joinWith(['applicationOptions m'], false)
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0]);

        if (isset($options['company'])) {
            $cards->andWhere([
                'or',
                ['like', 'd.name', $options['company']]
            ]);
        }
        if (isset($options['slug'])) {
            $cards->andWhere([
                'or',
                ($options['slug']) ? ['like', 'd.slug', $options['slug']] : ''
            ]);
        }
        if (isset($options['location'])) {
            $cards->andWhere([
                'or',
                ['g.name' => $options['location']],
                ['s.name' => $options['location']]
            ]);
        }

        if (!isset($options['for_careers']) || !(int)$options['for_careers'] || $options['for_careers'] !== 1) {
            $options['for_careers'] = 0;
        }

        $cards->andWhere([
            'or',
            ['a.for_careers' => $options['for_careers']]
        ]);

        if (isset($options['category'])) {
            $cards->andWhere([
                'or',
                ['like', 'd.name', $options['category']],
                ['like', 'l.designation', $options['category']],
                ['like', 'a.type', $options['category']],
                ['like', 'c.name', $options['category']],
                ['like', 'h.industry', $options['category']],
                ['like', 'i.name', $options['category']],
            ]);
        }
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

        $result = null;
        if(isset($options['similar_jobs'])){
            $cards->andWhere(['in', 'c.name', $options['similar_jobs']]);
            $cards->andWhere(['in', 'i.name', $options['similar_jobs']]);
            $result = $cards->orderBy(new \yii\db\Expression('rand()'))->asArray()->all();
        }else {
            $result = $cards->orderBy(['a.id' => SORT_DESC])->asArray()->all();
        }

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
                'f.location_enc_id location_id',
                'a.last_date',
                'i.name category',
                'CONCAT("/internship/", a.slug) link',
                'd.initials_color color',
                'CONCAT("/", d.slug) organization_link',
                "g.name as city",
                'a.type',
                'm.fixed_wage as fixed_salary',
                'm.wage_type salary_type',
                'm.max_wage as max_salary',
                'm.min_wage as min_salary',
                'm.wage_duration as salary_duration',
                'c.name as title',
                'i.icon',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo'])
            ->joinWith(['title b' => function ($x) {
                $x->joinWith(['categoryEnc c'], false);
                $x->joinWith(['parentEnc i'], false);
            }], false)
            ->joinWith(['organizationEnc d'=>function($a){
                $a->where(['d.is_deleted'=>0]);
            }], false)
            ->joinWith(['applicationPlacementLocations e' => function ($x) {
                $x->joinWith(['locationEnc f' => function ($x) {
                    $x->joinWith(['cityEnc g'], false);
                }], false);
            }], false)
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->joinWith(['applicationOptions m'], false)
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0]);
        if (isset($options['company'])) {
            $cards->andWhere([
                'or',
                ['like', 'd.name', $options['company']]
            ]);
        }
        if (isset($options['slug'])) {
            $cards->andWhere([
                'or',
                ($options['slug']) ? ['like', 'd.slug', $options['slug']] : ''
            ]);
        }

        if (!isset($options['for_careers']) || !(int)$options['for_careers'] || $options['for_careers'] !== 1) {
            $options['for_careers'] = 0;
        }

        $cards->andWhere([
            'or',
            ['a.for_careers' => $options['for_careers']]
        ]);

        if (isset($options['category'])) {
            $cards->andWhere([
                'or',
                ['like', 'd.name', $options['category']],
                ['like', 'a.type', $options['category']],
                ['like', 'c.name', $options['category']],
                ['like', 'i.name', $options['category']],
            ]);
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
                ['like', 'd.name', $options['keyword']]
            ]);
        }
        if (isset($options['limit'])) {
            $cards->limit = $options['limit'];
            $cards->offset = ($options['page'] - 1) * $options['limit'];
        }

        $result = null;
        if(isset($options['similar_jobs'])){
            $cards->andWhere(['in', 'c.name', $options['similar_jobs']]);
            $cards->andWhere(['in', 'i.name', $options['similar_jobs']]);
            $result = $cards->orderBy(new \yii\db\Expression('rand()'))->asArray()->all();
        }else {
            $result = $cards->orderBy(['a.id' => SORT_DESC])->asArray()->all();
        }
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
                        $result[$i]['salary'] = (string)$val['min_salary']  . ' p.m.';
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
        return $result;
    }
}