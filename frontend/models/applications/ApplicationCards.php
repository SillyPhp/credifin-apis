<?php

namespace frontend\models\applications;

use common\models\ApplicationPlacementCities;
use common\models\ApplicationSkills;
use common\models\ApplicationUnclaimOptions;
use common\models\BusinessActivities;
use common\models\Skills;
use common\models\States;
use common\models\TrainingProgramApplication;
use common\models\TrainingProgramBatches;
use common\models\UnclaimedOrganizations;
use Yii;
use yii\helpers\Url;
use yii\db\Expression;
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
        if (isset($options['limit'])) {
            $limit = $options['limit'];
            $offset = ($options['page'] - 1) * $options['limit'];
        }
        $cards1 = (new \yii\db\Query())
            ->distinct()
            ->from(EmployerApplications::tableName() . 'as a')
            ->select(['a.created_on','GROUP_CONCAT(DISTINCT(y.skill) SEPARATOR ",") skill','a.application_enc_id application_id','a.type','i.name category',
                'CONCAT("/job/", a.slug) link',
                'CONCAT("/", d.slug) organization_link',
                'd.initials_color color',
                'c.name as title',
                'a.last_date',
                'i.icon','(CASE
                WHEN a.experience = "0" THEN "No Experience"
                WHEN a.experience = "1" THEN "Less Than 1 Year Experience"
                WHEN a.experience = "2" THEN "1 Year Experience"
                WHEN a.experience = "3" THEN "2-3 Years Experience"
                WHEN a.experience = "3-5" THEN "3-5 Years Experience"
                WHEN a.experience = "5-10" THEN "5-10 Years Experience"
                WHEN a.experience = "10-20" THEN "10-20 Years Experience"
                WHEN a.experience = "20+" THEN "More Than 20 Years Experience"
                ELSE "No Experience"
               END) as experience','a.organization_enc_id','a.unclaimed_organization_enc_id',
                'm.fixed_wage as fixed_salary',
                'm.wage_type salary_type',
                'm.max_wage as max_salary',
                'm.min_wage as min_salary',
                'm.wage_duration as salary_duration',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
                'g.name city'
                ])
            ->leftJoin(ApplicationSkills::tableName() . 'as u', 'u.application_enc_id = a.application_enc_id AND u.is_deleted = 0')
            ->innerJoin(Skills::tableName() . 'as y', 'y.skill_enc_id = u.skill_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(ApplicationOptions::tableName() . 'as m', 'm.application_enc_id = a.application_enc_id')
            ->innerJoin(Organizations::tableName() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->leftJoin(Designations::tableName() . 'as l', 'l.designation_enc_id = a.designation_enc_id')
            ->leftJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as e', 'e.application_enc_id = a.application_enc_id')
            ->leftJoin(OrganizationLocations::tableName() . 'as f', 'f.location_enc_id = e.location_enc_id')
            ->leftJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
            ->leftJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->leftJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy('a.application_enc_id')
            ->orderBy(['a.created_on'=>SORT_DESC])
            ->limit($limit)
            ->offset($offset);

        $cards2 = (new \yii\db\Query())
            ->from(EmployerApplications::tableName() . 'as a')
            ->distinct()
            ->select(['a.created_on','GROUP_CONCAT(DISTINCT(y.skill) SEPARATOR ",") skill','a.application_enc_id application_id','a.type','i.name category',
                'CONCAT("/job/", a.slug) link',
                'CONCAT("/job/", a.slug) organization_link',
                'd.initials_color color',
                'c.name as title',
                'a.last_date',
                'i.icon','(CASE
                WHEN a.experience = "0" THEN "No Experience"
                WHEN a.experience = "1" THEN "Less Than 1 Year Experience"
                WHEN a.experience = "2" THEN "1 Year Experience"
                WHEN a.experience = "3" THEN "2-3 Years Experience"
                WHEN a.experience = "3-5" THEN "3-5 Years Experience"
                WHEN a.experience = "5-10" THEN "5-10 Years Experience"
                WHEN a.experience = "10-20" THEN "10-20 Years Experience"
                WHEN a.experience = "20+" THEN "More Than 20 Years Experience"
                ELSE "No Experience"
               END) as experience','a.organization_enc_id','a.unclaimed_organization_enc_id',
                'v.fixed_wage as fixed_salary',
                'v.wage_type salary_type',
                'v.max_wage as max_salary',
                'v.min_wage as min_salary',
                'v.wage_duration as salary_duration',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
                'g.name city'
            ])
            ->leftJoin(ApplicationSkills::tableName() . 'as u', 'u.application_enc_id = a.application_enc_id AND u.is_deleted = 0')
            ->innerJoin(Skills::tableName() . 'as y', 'y.skill_enc_id = u.skill_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(ApplicationUnclaimOptions::tableName() . 'as v', 'v.application_enc_id = a.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->innerJoin(UnclaimedOrganizations::tableName() . 'as d', 'd.organization_enc_id = a.unclaimed_organization_enc_id')
            ->innerJoin(ApplicationPlacementCities::tableName() . 'as x', 'x.application_enc_id = a.application_enc_id')
            ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = x.city_enc_id')
            ->innerJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy('a.application_enc_id')
            ->orderBy(['a.created_on'=>SORT_DESC])
            ->limit($limit)
            ->offset($offset);

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
                ['s.name' => $options['location']]
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
            $cards1->andFilterWhere([
                'or',
                'l.designation LIKE "%' . $options['keyword'] . '%"',
                'a.type LIKE "%' . $options['keyword'] . '%"',
                'c.name LIKE "%' . $options['keyword'] . '%"',
                'h.industry LIKE "%' . $options['keyword'] . '%"',
                'i.name LIKE "%' . $options['keyword'] . '%"',
                'd.name LIKE "%' . $options['keyword'] . '%"',
                'a.slug LIKE "%' . $options['keyword'] . '%"'
            ]);
            $cards2->andFilterWhere([
                'or',
                'a.type LIKE "%' . $options['keyword'] . '%"',
                'c.name LIKE "%' . $options['keyword'] . '%"',
                'i.name LIKE "%' . $options['keyword'] . '%"',
                'd.name LIKE "%' . $options['keyword'] . '%"',
                'a.slug LIKE "%' . $options['keyword'] . '%"'
            ]);
        }
        $result = null;
        if(isset($options['similar_jobs'])){
            $cards1->andWhere(['in', 'c.name', $options['similar_jobs']]);
            $cards2->andWhere(['in', 'i.name', $options['similar_jobs']]);
            $result  = (new \yii\db\Query())
                ->from([
                    $cards1->union($cards2),
                ])
                ->limit($limit)
                ->offset($offset)
                ->orderBy(new \yii\db\Expression('rand()'))
                ->all();
        }else {
            $result =  (new \yii\db\Query())
                ->from([
                    $cards1->union($cards2),
                ])
                ->limit($limit)
                ->offset($offset)
                ->orderBy(['created_on'=>SORT_DESC])
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
        if (isset($options['limit'])) {
            $limit = $options['limit'];
            $offset = ($options['page'] - 1) * $options['limit'];
        }
        $cards1 = (new \yii\db\Query())
            ->distinct()
            ->from(EmployerApplications::tableName() . 'as a')
            ->select(['a.created_on','GROUP_CONCAT(DISTINCT(y.skill) SEPARATOR ",") skill','a.application_enc_id application_id','a.type','i.name category',
                'CONCAT("/internship/", a.slug) link',
                'CONCAT("/", d.slug) organization_link',
                'd.initials_color color',
                'c.name as title',
                'a.last_date',
                'i.icon','a.organization_enc_id','a.unclaimed_organization_enc_id',
                'm.fixed_wage as fixed_salary',
                'm.wage_type salary_type',
                'm.max_wage as max_salary',
                'm.min_wage as min_salary',
                'm.wage_duration as salary_duration',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
                'g.name city'
            ])
            ->leftJoin(ApplicationSkills::tableName() . 'as u', 'u.application_enc_id = a.application_enc_id AND u.is_deleted = 0')
            ->innerJoin(Skills::tableName() . 'as y', 'y.skill_enc_id = u.skill_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(ApplicationOptions::tableName() . 'as m', 'm.application_enc_id = a.application_enc_id')
            ->innerJoin(Organizations::tableName() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->leftJoin(Designations::tableName() . 'as l', 'l.designation_enc_id = a.designation_enc_id')
            ->leftJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as e', 'e.application_enc_id = a.application_enc_id')
            ->leftJoin(OrganizationLocations::tableName() . 'as f', 'f.location_enc_id = e.location_enc_id')
            ->leftJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
            ->leftJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->leftJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy('a.application_enc_id')
            ->orderBy(['a.created_on'=>SORT_DESC])
            ->limit($limit)
            ->offset($offset);

        $cards2 = (new \yii\db\Query())
            ->from(EmployerApplications::tableName() . 'as a')
            ->distinct()
            ->select(['a.created_on','GROUP_CONCAT(DISTINCT(y.skill) SEPARATOR ",") skill','a.application_enc_id application_id','a.type','i.name category',
                'CONCAT("/internship/", a.slug) link',
                'CONCAT("/internship/", a.slug) organization_link',
                'd.initials_color color',
                'c.name as title',
                'a.last_date',
                'i.icon','a.organization_enc_id','a.unclaimed_organization_enc_id',
                'v.fixed_wage as fixed_salary',
                'v.wage_type salary_type',
                'v.max_wage as max_salary',
                'v.min_wage as min_salary',
                'v.wage_duration as salary_duration',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
                'g.name city'
            ])
            ->leftJoin(ApplicationSkills::tableName() . 'as u', 'u.application_enc_id = a.application_enc_id AND u.is_deleted = 0')
            ->innerJoin(Skills::tableName() . 'as y', 'y.skill_enc_id = u.skill_enc_id')
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(ApplicationUnclaimOptions::tableName() . 'as v', 'v.application_enc_id = a.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->innerJoin(UnclaimedOrganizations::tableName() . 'as d', 'd.organization_enc_id = a.unclaimed_organization_enc_id')
            ->innerJoin(ApplicationPlacementCities::tableName() . 'as x', 'x.application_enc_id = a.application_enc_id')
            ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = x.city_enc_id')
            ->innerJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy('a.application_enc_id')
            ->orderBy(['a.created_on'=>SORT_DESC])
            ->limit($limit)
            ->offset($offset);

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
                ['g.name' => $options['location']]
            ]);
            $cards2->andWhere([
                'or',
                ['g.name' => $options['location']]
            ]);
        }
        if (isset($options['keyword'])) {
            $cards1->andFilterWhere([
                'or',
                'a.type LIKE "%' . $options['keyword'] . '%"',
                'c.name LIKE "%' . $options['keyword'] . '%"',
                'i.name LIKE "%' . $options['keyword'] . '%"',
                'd.name LIKE "%' . $options['keyword'] . '%"',
                'a.slug LIKE "%' . $options['keyword'] . '%"'
            ]);

            $cards2->andFilterWhere([
                'or',
                'a.type LIKE "%' . $options['keyword'] . '%"',
                'c.name LIKE "%' . $options['keyword'] . '%"',
                'i.name LIKE "%' . $options['keyword'] . '%"',
                'd.name LIKE "%' . $options['keyword'] . '%"',
                'a.slug LIKE "%' . $options['keyword'] . '%"'
            ]);
        }

        $result = null;
        if(isset($options['similar_jobs'])){
            $cards1->andWhere(['in', 'c.name', $options['similar_jobs']]);
            $cards2->andWhere(['in', 'c.name', $options['similar_jobs']]);
            $cards1->andWhere(['in', 'i.name', $options['similar_jobs']]);
            $cards2->andWhere(['in', 'i.name', $options['similar_jobs']]);
            $result  = (new \yii\db\Query())
                ->from([
                    $cards1->union($cards2),
                ])
                ->limit($limit)
                ->offset($offset)
                ->orderBy(new \yii\db\Expression('rand()'))
                ->all();
        }else {
            $result =  (new \yii\db\Query())
                ->from([
                    $cards1->union($cards2),
                ])
                ->limit($limit)
                ->offset($offset)
                ->orderBy(['created_on'=>SORT_DESC])
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
                        $result[$i]['salary'] = round((string)$val['min_salary'])  . ' p.m.';
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
                }
            }
            $i++;
        }
        return $result;
    }

    public static function TraininingCards($options = [])
    {
        return self::_getCardsFromTrainings($options);
    }
    public static function InstitutesCards($options = [])
    {
        $cards = (new \yii\db\Query())
            ->distinct()
            ->from(Organizations::tableName().'as a')
            ->select(['name','initials_color','a.slug','CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", a.logo_location, "/", a.logo) ELSE NULL END image', 'b.business_activity'])
            ->innerJoin(BusinessActivities::tableName().'as b','b.business_activity_enc_id = a.business_activity_enc_id')
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0])
            ->andWhere(['not',['logo'=>null]]);

        if (isset($options['limit'])) {
            $limit = $options['limit'];
        }
        if (isset($options['type'])) {
            $cards->andWhere(['in', 'business_activity', ['Educational Institute']]);
        }
        $result = $cards->limit($limit)
            ->orderBy(new \yii\db\Expression('rand()'))
            ->all();
        return $result;
    }
    private static function _getCardsFromTrainings($options)
    {
        $cards = (new \yii\db\Query())
            ->distinct()
            ->from(TrainingProgramApplication::tableName() . 'as a')
            ->select(['a.id','a.application_enc_id application_id','i.name category',
                'CONCAT("/training/", a.slug) link',
                'CONCAT("/", d.slug) organization_link','d.initials_color color',
                'c.name as title','i.icon',
                'd.name as organization_name',
                'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
                'g.name city',
                '(CASE
                WHEN a.training_duration_type = "1" THEN CONCAT(a.training_duration,"  Month(s)")
                WHEN a.training_duration_type = "2" THEN CONCAT(a.training_duration," Week(s)")
                WHEN a.training_duration_type = "3" THEN CONCAT(a.training_duration," Year(s)")
                ELSE "N/A"
               END) as duration'
                ,'(CASE
                WHEN t.fees_methods = "1" AND t.fees >0 THEN CONCAT(t.fees," / Month")
                WHEN t.fees_methods = "2" AND t.fees >0 THEN CONCAT(t.fees," / Week")
                WHEN t.fees_methods = "3" AND t.fees >0 THEN CONCAT(t.fees," / Annually")
                WHEN t.fees_methods = "4" AND t.fees >0 THEN CONCAT(t.fees,"(One Time)")
                ELSE "No Fees" 
               END) as fees','(CASE
                WHEN COUNT(t.start_time) > 1 THEN "Multiple Timings"
                ELSE CONCAT(TIME_FORMAT(t.start_time,"%h:%i:%p"),"-",TIME_FORMAT(t.end_time,"%h:%i:%p")) 
               END) as timings'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(Organizations::tableName() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->leftJoin(TrainingProgramBatches::tableName() . 'as t', 't.application_enc_id = a.application_enc_id')
            ->leftJoin(Cities::tableName() . 'as g', 'g.city_enc_id = t.city_enc_id')
            ->leftJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->leftJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => 'Trainings','a.is_deleted' => 0])
            ->groupBy(['a.application_enc_id','t.city_enc_id']);

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

        if (isset($options['limit'])) {
            $limit = $options['limit'];
            $offset = ($options['page'] - 1) * $options['limit'];
        }

        if (isset($options['category'])) {
            $cards->andWhere([
                'or',
                ['like', 'd.name', $options['category']],
                ['like', 'c.name', $options['category']],
                ['like', 'i.name', $options['category']],
            ]);
        }
        if (isset($options['location'])) {
            $cards->andWhere([
                'or',
                ['g.name' => $options['location']],
                ['s.name' => $options['location']]
            ]);
        }
        if (isset($options['keyword'])) {
            $cards->andWhere([
                'or',
                ['like', 'c.name', $options['keyword']],
                ['like', 'i.name', $options['keyword']],
                ['like', 'd.name', $options['keyword']]
            ]);
        }

       $result = $cards->limit($limit)
            ->offset($offset)
            ->orderBy(['id' => SORT_DESC])
            ->all();
        return $result;
    }

}