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
            ->select(['a.application_enc_id application_id', 'e.location_enc_id location_id', 'a.last_date', 'i.name category', 'l.designation', 'CONCAT("/job/", a.slug) link', 'd.initials_color color', 'CONCAT("/company/", d.slug) organization_link', "g.name as city", 'c.name as title', 'd.name as organization_name', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo',
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
                'm.value as fixed_salary',
                'o.value salary_type',
                'q.value as max_salary',
                'p.value as min_salary',
                'n.value as salary_duration'
            ])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'i.category_enc_id = b.parent_enc_id')
            ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
            ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
            ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
            ->innerJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->innerJoin(Designations::tableName() . 'as l', 'l.designation_enc_id = a.designation_enc_id')
//            ->innerJoin(ApplicationOptions::tableName() . 'as m', 'm.application_enc_id = a.application_enc_id')
            ->joinWith(['applicationOptions m' => function ($m) {
                $m->where(['m.option_name' => 'salary']);
            }], false)
            ->joinWith(['applicationOptions n' => function ($n) {
                $n->where(['n.option_name' => 'salary_duration']);
            }], false)
            ->joinWith(['applicationOptions o' => function ($o) {
                $o->where(['o.option_name' => 'salary_type']);
            }], false)
            ->joinWith(['applicationOptions p' => function ($p) {
                $p->where(['p.option_name' => 'min_salary']);
            }], false)
            ->joinWith(['applicationOptions q' => function ($q) {
                $q->where(['q.option_name' => 'max_salary']);
            }], false)
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0]);

        if (isset($options['company'])) {
            $cards->andWhere([
                'or',
                ($options['company']) ? ['like', 'd.name', $options['company']] : ''
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
                ['like', 'l.designation', $options['keyword']],
                ['like', 'a.type', $options['keyword']],
                ['like', 'c.name', $options['keyword']],
                ['like', 'h.industry', $options['keyword']],
                ['like', 'i.name', $options['keyword']],
            ]);
        }

        if (isset($options['limit'])) {
            $cards->limit = $options['limit'];
        }

        if (isset($options['limit'])) {
            $cards->limit = $options['limit'];
            $cards->offset = ($options['page'] - 1) * $options['limit'];
        }

        $result = $cards->orderBy(['a.id' => SORT_DESC])->asArray()->all();
        $i = 0;
        foreach ($result as $val){
            if($val['salary_type'] == 1){
                if($val['salary_duration'] == "monthly") {
                    $result[$i]['salary'] = $val['fixed_salary'] * 12;
                }elseif ($val['salary_duration'] == "hourly"){
                    $result[$i]['salary'] = $val['fixed_salary'] * 40 * 52;
                }elseif ($val['salary_duration'] == "weekly"){
                    $result[$i]['salary'] = $val['fixed_salary'] * 52;
                }
            } elseif ($val['salary_type'] == 2){
                if(!empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "monthly") {
                        $result[$i]['salary'] = (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12;
                    } elseif ($val['salary_duration'] == "hourly") {
                        $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52);
                    } elseif ($val['salary_duration'] == "weekly") {
                        $result[$i]['salary'] = (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52);
                    }
                }elseif (!empty($val['min_salary']) && empty($val['max_salary'])){
                    if ($val['salary_duration'] == "monthly") {
                        $result[$i]['salary'] = (string)$val['min_salary'] * 12;
                    } elseif ($val['salary_duration'] == "hourly") {
                        $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 52);
                    } elseif ($val['salary_duration'] == "weekly") {
                        $result[$i]['salary'] = (string)($val['min_salary'] * 52);
                    }
                }elseif (empty($val['min_salary']) && !empty($val['max_salary'])){
                    if ($val['salary_duration'] == "monthly") {
                        $result[$i]['salary'] = (string)$val['max_salary'] * 12;
                    } elseif ($val['salary_duration'] == "hourly") {
                        $result[$i]['salary'] = (string)($val['max_salary'] * 40 * 52);
                    } elseif ($val['salary_duration'] == "weekly") {
                        $result[$i]['salary'] = (string)($val['max_salary'] * 52);
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
            ->select(['a.application_enc_id application_id', 'f.location_enc_id location_id', 'a.created_on', 'i.name category', 'CONCAT("/internship/", a.slug) link', 'd.initials_color color', 'CONCAT("/company/", d.slug) organization_link', 'a.experience', "g.name as city", 'a.type', 'c.name as title', 'd.name as organization_name', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo'])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'i.category_enc_id = b.parent_enc_id')
            ->innerJoin(Organizations::tablename() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->innerJoin(ApplicationPlacementLocations::tablename() . 'as e', 'e.application_enc_id = a.application_enc_id')
            ->innerJoin(OrganizationLocations::tablename() . 'as f', 'f.location_enc_id = e.location_enc_id')
            ->innerJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => 'Internships', 'a.status' => 'Active', 'a.is_deleted' => 0]);

        if (isset($options['company'])) {
            $cards->andWhere([
                'or',
                ($options['company']) ? ['like', 'd.name', $options['company']] : ''
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
            ]);
        }

        if (isset($options['limit'])) {
            $cards->limit = $options['limit'];
            $cards->offset = ($options['page'] - 1) * $options['limit'];
        }

        return $cards->orderBy(['a.id' => SORT_DESC])->asArray()->all();
    }

}