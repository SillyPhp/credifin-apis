<?php

namespace api\modules\v1\models;

use common\models\ApplicationOptions;
use common\models\ApplicationPlacementCities;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationSkills;
use common\models\ApplicationUnclaimOptions;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Cities;
use common\models\Designations;
use common\models\Industries;
use common\models\OrganizationLocations;
use common\models\Organizations;
use common\models\Skills;
use common\models\States;
use common\models\UnclaimedOrganizations;
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

        $cards1 = (new \yii\db\Query())
            ->distinct()
            ->from(EmployerApplications::tableName() . 'as a')
            ->select(['a.created_on', 'GROUP_CONCAT(DISTINCT(y.skill) SEPARATOR ",") skill', 'a.application_enc_id application_id', 'a.type',
                'd.initials_color color',
                'c.name as title',
                'a.last_date',
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
               END) as experience', 'a.organization_enc_id', 'a.unclaimed_organization_enc_id',
                'm.fixed_wage as fixed_salary',
                'm.wage_type salary_type',
                'm.max_wage as max_salary',
                'm.min_wage as min_salary',
                'm.wage_duration as salary_duration',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
                '(CASE WHEN g.name IS NOT NULL THEN g.name ELSE x.name END) as city'
            ])
            ->leftJoin(ApplicationSkills::tableName() . 'as u', 'u.application_enc_id = a.application_enc_id AND u.is_deleted = 0')
            ->leftJoin(Skills::tableName() . 'as y', 'y.skill_enc_id = u.skill_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(ApplicationOptions::tableName() . 'as m', 'm.application_enc_id = a.application_enc_id')
            ->innerJoin(Organizations::tableName() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->leftJoin(Designations::tableName() . 'as l', 'l.designation_enc_id = a.designation_enc_id')
            ->leftJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as e', 'e.application_enc_id = a.application_enc_id AND e.is_deleted = 0')
            ->leftJoin(OrganizationLocations::tableName() . 'as f', 'f.location_enc_id = e.location_enc_id')
            ->leftJoin(ApplicationPlacementCities::tableName() . 'as t', 't.application_enc_id = a.application_enc_id')
            ->leftJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
            ->leftJoin(Cities::tableName() . 'as x', 'x.city_enc_id = t.city_enc_id')
            ->leftJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->leftJoin(States::tableName() . 'as v', 'v.state_enc_id = x.state_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy(['g.city_enc_id', 'x.city_enc_id', 'a.application_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC]);

        $cards2 = (new \yii\db\Query())
            ->from(EmployerApplications::tableName() . 'as a')
            ->distinct()
            ->select(['a.created_on', 'GROUP_CONCAT(DISTINCT(y.skill) SEPARATOR ",") skill', 'a.application_enc_id application_id', 'a.type',
                'd.initials_color color',
                'c.name as title',
                'a.last_date',
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
               END) as experience', 'a.organization_enc_id', 'a.unclaimed_organization_enc_id',
                'v.fixed_wage as fixed_salary',
                'v.wage_type salary_type',
                'v.max_wage as max_salary',
                'v.min_wage as min_salary',
                'v.wage_duration as salary_duration',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
                'g.name city'
            ])
            ->leftJoin(ApplicationSkills::tableName() . 'as u', 'u.application_enc_id = a.application_enc_id AND u.is_deleted = 0')
            ->leftJoin(Skills::tableName() . 'as y', 'y.skill_enc_id = u.skill_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(ApplicationUnclaimOptions::tableName() . 'as v', 'v.application_enc_id = a.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->innerJoin(UnclaimedOrganizations::tableName() . 'as d', 'd.organization_enc_id = a.unclaimed_organization_enc_id')
            ->leftJoin(ApplicationPlacementCities::tableName() . 'as x', 'x.application_enc_id = a.application_enc_id AND x.is_deleted = 0')
            ->leftJoin(Cities::tableName() . 'as g', 'g.city_enc_id = x.city_enc_id')
            ->leftJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy(['g.city_enc_id', 'a.application_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC]);

        if (isset($options['company'])) {
            $cards1->andWhere([
                'or',
                ['like', 'd.name', $options['company']]
            ]);
            $cards2->andWhere([
                'or',
                ['like', 'd.name', $options['company']]
            ]);
        }

        if (isset($options['organization_id'])) {
            $cards1->andWhere(['a.organization_enc_id'=>$options['organization_id']]);
            $cards2->andWhere(['a.organization_enc_id'=>$options['organization_id']]);
        }

        if (isset($options['slug'])) {
            $cards1->andWhere([
                'or',
                ($options['slug']) ? ['like', 'd.slug', $options['slug']] : ''
            ]);
            $cards2->andWhere([
                'or',
                ($options['slug']) ? ['like', 'd.slug', $options['slug']] : ''
            ]);
        }
        if (isset($options['location'])) {
            $cards1->andWhere([
                'or',
                ['g.name' => $options['location']],
                ['s.name' => $options['location']],
                ['v.name' => $options['location']],
                ['x.name' => $options['location']]
            ]);
            $cards2->andWhere([
                'or',
                ['g.name' => $options['location']],
                ['s.name' => $options['location']]
            ]);
        }

        if (!isset($options['for_careers']) || !(int)$options['for_careers'] || $options['for_careers'] !== 1) {
            $options['for_careers'] = 0;
        }

        $cards1->andWhere([
            'or',
            ['a.for_careers' => $options['for_careers']]
        ]);
        $cards2->andWhere([
            'or',
            ['a.for_careers' => $options['for_careers']]
        ]);

        if (isset($options['category'])) {
            $cards1->andWhere([
                'or',
                ['like', 'd.name', $options['category']],
                ['like', 'l.designation', $options['category']],
                ['like', 'a.type', $options['category']],
                ['like', 'c.name', $options['category']],
                ['like', 'h.industry', $options['category']],
                ['like', 'i.name', $options['category']],
            ]);
            $cards2->andWhere([
                'or',
                ['like', 'd.name', $options['category']],
                ['like', 'a.type', $options['category']],
                ['like', 'c.name', $options['category']],
                ['like', 'i.name', $options['category']],
            ]);
        }
        if (isset($options['keyword'])) {
            $search = trim($options['keyword'], " ");
            $search_pattern = self::makeSQL_search_pattern($search);
            $cards1->andFilterWhere([
                'or',
                ['REGEXP', 'g.name', $search_pattern],
                ['REGEXP', 'v.name', $search_pattern],
                ['REGEXP', 's.name', $search_pattern],
                ['REGEXP', 'x.name', $search_pattern],
                ['REGEXP', 'l.designation', $search_pattern],
                ['REGEXP', 'a.type', $search_pattern],
                ['REGEXP', 'c.name', $search_pattern],
                ['REGEXP', 'h.industry', $search_pattern],
                ['REGEXP', 'i.name', $search_pattern],
                ['REGEXP', 'd.name', $search_pattern],
                ['REGEXP', 'a.slug', $search_pattern]
            ]);
            $cards2->andFilterWhere([
                'or',
                ['REGEXP', 'g.name', $search_pattern],
                ['REGEXP', 's.name', $search_pattern],
                ['REGEXP', 'a.type', $search_pattern],
                ['REGEXP', 'c.name', $search_pattern],
                ['REGEXP', 'i.name', $search_pattern],
                ['REGEXP', 'd.name', $search_pattern],
                ['REGEXP', 'a.slug', $search_pattern]
            ]);
        }
        $result = null;
        if (isset($options['similar_jobs'])) {
            $cards1->andWhere(['in', 'c.name', $options['similar_jobs']]);
            $cards2->andWhere(['in', 'i.name', $options['similar_jobs']]);
            $result = (new \yii\db\Query())
                ->from([
                    $cards1->union($cards2),
                ])
                ->limit($options['limit'])
                ->offset(($options['page'] - 1) * $options['limit'])
                ->orderBy(new \yii\db\Expression('rand()'))
                ->all();
        } else {
            $result = (new \yii\db\Query())
                ->from([
                    $cards1->union($cards2),
                ])
                ->limit($options['limit'])
                ->offset(($options['page'] - 1) * $options['limit'])
                ->orderBy(['created_on' => SORT_DESC])
                ->all();
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
                } else {
                    $result[$i]['salary'] = "Negotiable";
                }
            }
            unset($result[$i]['max_salary']);
            unset($result[$i]['min_salary']);
            unset($result[$i]['salary_duration']);
            unset($result[$i]['fixed_salary']);
            unset($result[$i]['salary_type']);
            unset($result[$i]['created_on']);
            unset($result[$i]['organization_enc_id']);
            unset($result[$i]['unclaimed_organization_enc_id']);
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
        if (isset($options['limit'])) {
            $limit = $options['limit'];
            $offset = ($options['page'] - 1) * $options['limit'];
        }
        $cards1 = (new \yii\db\Query())
            ->distinct()
            ->from(EmployerApplications::tableName() . 'as a')
            ->select(['a.created_on', 'GROUP_CONCAT(DISTINCT(y.skill) SEPARATOR ",") skill', 'a.application_enc_id application_id', 'a.type',
                'd.initials_color color',
                'c.name as title',
                'a.last_date',
                'a.organization_enc_id', 'a.unclaimed_organization_enc_id',
                'm.fixed_wage as fixed_salary',
                'm.wage_type salary_type',
                'm.max_wage as max_salary',
                'm.min_wage as min_salary',
                'm.wage_duration as salary_duration',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
                '(CASE WHEN g.name IS NOT NULL THEN g.name ELSE x.name END) as city'
            ])
            ->leftJoin(ApplicationSkills::tableName() . 'as u', 'u.application_enc_id = a.application_enc_id AND u.is_deleted = 0')
            ->leftJoin(Skills::tableName() . 'as y', 'y.skill_enc_id = u.skill_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(ApplicationOptions::tableName() . 'as m', 'm.application_enc_id = a.application_enc_id')
            ->innerJoin(Organizations::tableName() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->leftJoin(Designations::tableName() . 'as l', 'l.designation_enc_id = a.designation_enc_id')
            ->leftJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as e', 'e.application_enc_id = a.application_enc_id AND e.is_deleted = 0')
            ->leftJoin(OrganizationLocations::tableName() . 'as f', 'f.location_enc_id = e.location_enc_id')
            ->leftJoin(ApplicationPlacementCities::tableName() . 'as t', 't.application_enc_id = a.application_enc_id')
            ->leftJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
            ->leftJoin(Cities::tableName() . 'as x', 'x.city_enc_id = t.city_enc_id')
            ->leftJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->leftJoin(States::tableName() . 'as v', 'v.state_enc_id = x.state_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy(['g.city_enc_id', 'x.city_enc_id', 'a.application_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC]);

        $cards2 = (new \yii\db\Query())
            ->from(EmployerApplications::tableName() . 'as a')
            ->distinct()
            ->select(['a.created_on', 'GROUP_CONCAT(DISTINCT(y.skill) SEPARATOR ",") skill', 'a.application_enc_id application_id', 'a.type',
                'd.initials_color color',
                'c.name as title',
                'a.last_date',
                'a.organization_enc_id', 'a.unclaimed_organization_enc_id',
                'v.fixed_wage as fixed_salary',
                'v.wage_type salary_type',
                'v.max_wage as max_salary',
                'v.min_wage as min_salary',
                'v.wage_duration as salary_duration',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo, true) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
                'g.name city'
            ])
            ->leftJoin(ApplicationSkills::tableName() . 'as u', 'u.application_enc_id = a.application_enc_id AND u.is_deleted = 0')
            ->leftJoin(Skills::tableName() . 'as y', 'y.skill_enc_id = u.skill_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(ApplicationUnclaimOptions::tableName() . 'as v', 'v.application_enc_id = a.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->innerJoin(UnclaimedOrganizations::tableName() . 'as d', 'd.organization_enc_id = a.unclaimed_organization_enc_id')
            ->leftJoin(ApplicationPlacementCities::tableName() . 'as x', 'x.application_enc_id = a.application_enc_id AND x.is_deleted = 0')
            ->leftJoin(Cities::tableName() . 'as g', 'g.city_enc_id = x.city_enc_id')
            ->leftJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy(['g.city_enc_id', 'a.application_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC]);

        if (isset($options['company'])) {
            $cards1->andWhere([
                'or',
                ['like', 'd.name', $options['company']]
            ]);
            $cards2->andWhere([
                'or',
                ['like', 'd.name', $options['company']]
            ]);
        }

        if (isset($options['organization_id'])) {
            $cards1->andWhere(['a.organization_enc_id'=>$options['organization_id']]);
            $cards2->andWhere(['a.organization_enc_id'=>$options['organization_id']]);
        }

        if (isset($options['slug'])) {
            $cards1->andWhere([
                'or',
                ($options['slug']) ? ['like', 'd.slug', $options['slug']] : ''
            ]);
            $cards2->andWhere([
                'or',
                ($options['slug']) ? ['like', 'd.slug', $options['slug']] : ''
            ]);
        }

        if (!isset($options['for_careers']) || !(int)$options['for_careers'] || $options['for_careers'] !== 1) {
            $options['for_careers'] = 0;
        }

        $cards1->andWhere([
            'or',
            ['a.for_careers' => $options['for_careers']]
        ]);

        $cards2->andWhere([
            'or',
            ['a.for_careers' => $options['for_careers']]
        ]);

        if (isset($options['category'])) {
            $cards1->andWhere([
                'or',
                ['like', 'd.name', $options['category']],
                ['like', 'a.type', $options['category']],
                ['like', 'c.name', $options['category']],
                ['like', 'i.name', $options['category']],
            ]);

            $cards2->andWhere([
                'or',
                ['like', 'd.name', $options['category']],
                ['like', 'a.type', $options['category']],
                ['like', 'c.name', $options['category']],
                ['like', 'i.name', $options['category']],
            ]);
        }
        if (isset($options['location'])) {
            $cards1->andWhere([
                'or',
                ['g.name' => $options['location']],
                ['s.name' => $options['location']],
                ['v.name' => $options['location']],
                ['x.name' => $options['location']],
            ]);
            $cards2->andWhere([
                'or',
                ['g.name' => $options['location']],
                ['s.name' => $options['location']],
            ]);
        }
        if (isset($options['keyword'])) {
            $options['keyword'] = trim($options['keyword'], " ");
            $search_pattern = self::makeSQL_search_pattern($options['keyword']);
            $cards1->andFilterWhere([
                'or',
                ['REGEXP', 'g.name', $search_pattern],
                ['REGEXP', 's.name', $search_pattern],
                ['REGEXP', 'v.name', $search_pattern],
                ['REGEXP', 'x.name', $search_pattern],
                ['REGEXP', 'a.type', $search_pattern],
                ['REGEXP', 'c.name', $search_pattern],
                ['REGEXP', 'i.name', $search_pattern],
                ['REGEXP', 'd.name', $search_pattern],
                ['REGEXP', 'a.slug', $search_pattern]
            ]);

            $cards2->andFilterWhere([
                'or',
                ['REGEXP', 'g.name', $search_pattern],
                ['REGEXP', 's.name', $search_pattern],
                ['REGEXP', 'a.type', $search_pattern],
                ['REGEXP', 'c.name', $search_pattern],
                ['REGEXP', 'i.name', $search_pattern],
                ['REGEXP', 'd.name', $search_pattern],
                ['REGEXP', 'a.slug', $search_pattern]
            ]);
        }

        $result = null;
        if (isset($options['similar_jobs'])) {
            $cards1->andWhere(['in', 'c.name', $options['similar_jobs']]);
            $cards2->andWhere(['in', 'i.name', $options['similar_jobs']]);
            $result = (new \yii\db\Query())
                ->from([
                    $cards1->union($cards2),
                ])
                ->limit($limit)
                ->offset($offset)
                ->orderBy(new \yii\db\Expression('rand()'))
                ->all();
        } else {
            $result = (new \yii\db\Query())
                ->from([
                    $cards1->union($cards2),
                ])
                ->limit($limit)
                ->offset($offset)
                ->orderBy(['created_on' => SORT_DESC])
                ->all();
        }
        $i = 0;
        foreach ($result as $val) {
            $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
            if ($val['salary_type'] == "Fixed") {
                if ($val['salary_duration'] == "Monthly") {
                    $result[$i]['salary'] = round($val['fixed_salary']) . ' p.m.';
                } elseif ($val['salary_duration'] == "Hourly") {
                    $result[$i]['salary'] = round($val['fixed_salary'] * 730) . ' p.m.';
                } elseif ($val['salary_duration'] == "Weekly") {
                    $result[$i]['salary'] = round((int)$val['fixed_salary'] / 7 * 30) . ' p.m.';
                } else {
                    $result[$i]['salary'] = round((int)$val['fixed_salary'] / 12) . ' p.m.';
                }
            } elseif ($val['salary_type'] == "Negotiable" || $val['salary_type'] == "Performance Based") {
                if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = round((string)$val['min_salary']) . " - ₹" . round((string)$val['max_salary']) . ' p.m.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = round((string)($val['min_salary'] * 730)) . " - ₹" . round((string)($val['max_salary'] * 730)) . ' p.m.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = round((int)($val['min_salary'] / 7 * 30)) . " - ₹" . round((int)($val['max_salary'] / 7 * 30)) . ' p.m.';
                    } else {
                        $result[$i]['salary'] = round((int)($val['min_salary']) / 12) . " - ₹" . round((int)($val['max_salary']) / 12) . ' p.m.';
                    }
                } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = round((string)$val['min_salary']) . ' p.m.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = round((string)($val['min_salary'] * 730)) . ' p.m.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = round((int)($val['min_salary'] / 7 * 30)) . ' p.m.';
                    } else {
                        $result[$i]['salary'] = round((int)($val['min_salary']) / 12) . ' p.m.';
                    }
                } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = round((string)$val['max_salary']) . ' p.m.';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = round((string)($val['max_salary'] * 730)) . ' p.m.';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = round((int)($val['max_salary'] / 7 * 30)) . ' p.m.';
                    } else {
                        $result[$i]['salary'] = round((int)($val['max_salary']) / 12) . ' p.m.';
                    }
                } else {
                    $result[$i]['salary'] = "Negotiable";
                }
            } elseif ($val['salary_type'] == "Unpaid") {
                $result[$i]['salary'] = "Unpaid";
            }
            unset($result[$i]['max_salary']);
            unset($result[$i]['min_salary']);
            unset($result[$i]['salary_duration']);
            unset($result[$i]['fixed_salary']);
            unset($result[$i]['salary_type']);
            unset($result[$i]['created_on']);
            unset($result[$i]['organization_enc_id']);
            unset($result[$i]['unclaimed_organization_enc_id']);
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

    private static function makeSQL_search_pattern($search)
    {
        $search_pattern = false;
        $wordArray = preg_split('/[^-\w\']+/', $search, -1, PREG_SPLIT_NO_EMPTY);
        $search = self::optimizeSearchString($wordArray);
        $search = str_replace('"', "''", $search);
        $search = str_replace('^', "\\^", $search);
        $search = str_replace('$', "\\$", $search);
        $search = str_replace('.', "\\.", $search);
        $search = str_replace('[', "\\[", $search);
        $search = str_replace(']', "\\]", $search);
        $search = str_replace('|', "\\|", $search);
        $search = str_replace('*', "\\*", $search);
        $search = str_replace('+', "\\+", $search);
        $search = str_replace('{', "\\{", $search);
        $search = str_replace('}', "\\}", $search);
        $search = preg_split('/ /', $search, null, PREG_SPLIT_NO_EMPTY);
        for ($i = 0; $i < count($search); $i++) {
            if ($i > 0 && $i < count($search)) {
                $search_pattern .= "|";
            }
            $search_pattern .= $search[$i];
        }
        return $search_pattern;
    }

    private static function optimizeSearchString($wordArray)
    {
        $articles = ['in', 'is', 'jobs', 'job', 'internship', 'internships'];
        $newArray = array_udiff($wordArray, $articles, 'strcasecmp');
        if (!empty($newArray))
            return implode(" ", $newArray);
        else
            return "";
    }

}
