<?php
namespace frontend\models\xml;
use common\models\ApplicationEducationalRequirements;
use common\models\ApplicationJobDescription;
use common\models\AssignedJobDescription;
use common\models\EducationalRequirements;
use common\models\JobDescription;
use Yii;
use common\models\ApplicationOptions;
use common\models\ApplicationPlacementCities;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\ApplicationUnclaimOptions;
use common\models\AssignedCategories;
use common\models\Categories;
use common\models\Cities;
use common\models\Countries;
use common\models\Currencies;
use common\models\Designations;
use common\models\EmployerApplications;
use common\models\Industries;
use common\models\OrganizationLocations;
use common\models\Organizations;
use common\models\States;
use common\models\UnclaimedOrganizations;
use yii\db\Expression;
use yii\helpers\Url;

class ApplicationFeeds
{
    public function getApplications($options)
    {
        if (isset($options['limit'])) {
            $limit = $options['limit'];
            $offset = $options['offset'];
        }
        $cards1 = (new \yii\db\Query())
            ->distinct()
            ->from(EmployerApplications::tableName() . 'as a')
            ->select(['xt.html_code','a.application_number id',
                'CONCAT("https://empoweryouth.com","/job/",a.slug) link',
                'c.name as name',
                '(CASE WHEN g.name IS NOT NULL THEN g.name ELSE x.name END) as city',
                '(CASE WHEN ct.name IS NOT NULL THEN ct.name ELSE cy.name END) as country',
                'm.fixed_wage as fixed_salary',
                'm.wage_type salary_type',
                'm.max_wage as max_salary',
                'm.min_wage as min_salary',
                'm.wage_duration as salary_duration',
                'GROUP_CONCAT(DISTINCT CONCAT("<p>",jd.job_description,"</p>") SEPARATOR "<br>") as description',
                'GROUP_CONCAT(DISTINCT CONCAT("<p>",ed.educational_requirement,"</p>") SEPARATOR "<br>") as education_req',
                'd.name as organization_name',
                'a.created_on as pubdate',
                'a.last_date as expire',
                'a.last_updated_on as updated',
                'a.type',
                'a.created_on'
            ])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(ApplicationOptions::tableName() . 'as m', 'm.application_enc_id = a.application_enc_id')
            ->leftJoin(Currencies::tableName() . 'as xt', 'xt.currency_enc_id = m.currency_enc_id')
            ->innerJoin(Organizations::tableName() . 'as d', 'd.organization_enc_id = a.organization_enc_id')
            ->leftJoin(Designations::tableName() . 'as l', 'l.designation_enc_id = a.designation_enc_id')
            ->leftJoin(Industries::tableName() . 'as h', 'h.industry_enc_id = a.preferred_industry')
            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as e', 'e.application_enc_id = a.application_enc_id AND e.is_deleted = 0')
            ->leftJoin(OrganizationLocations::tableName() . 'as f', 'f.location_enc_id = e.location_enc_id')
            ->leftJoin(ApplicationPlacementCities::tableName() . 'as t', 't.application_enc_id = a.application_enc_id')
            ->leftJoin(ApplicationJobDescription::tableName() . 'as ajd', 'ajd.application_enc_id = a.application_enc_id')
            ->leftJoin(JobDescription::tableName() . 'as jd', 'jd.job_description_enc_id = ajd.job_description_enc_id')
            ->leftJoin(ApplicationEducationalRequirements::tableName() . 'as aer', 'aer.application_enc_id = a.application_enc_id')
            ->leftJoin(EducationalRequirements::tableName() . 'as ed', 'ed.educational_requirement_enc_id = aer.educational_requirement_enc_id')
            ->leftJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
            ->leftJoin(Cities::tableName() . 'as x', 'x.city_enc_id = t.city_enc_id')
            ->leftJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->leftJoin(States::tableName() . 'as v', 'v.state_enc_id = x.state_enc_id')
            ->leftJoin(Countries::tableName() . 'as ct', 'ct.country_enc_id = s.country_enc_id')
            ->leftJoin(Countries::tableName() . 'as cy', 'cy.country_enc_id = v.country_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->where(['j.name' => $options['type'], 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy(['g.city_enc_id', 'x.city_enc_id', 'a.application_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC]);

        $cards2 = (new \yii\db\Query())
            ->from(EmployerApplications::tableName() . 'as a')
            ->distinct()
            ->select(['xt.html_code','a.application_number id',
                'CONCAT("https://empoweryouth.com","/job/",a.slug) link',
                'c.name as name',
                'g.name city',
                'ct.name country',
                'v.fixed_wage as fixed_salary',
                'v.wage_type salary_type',
                'v.max_wage as max_salary',
                'v.min_wage as min_salary',
                'v.wage_duration as salary_duration',
                'a.description',
                new Expression('NULL as education_req'),
                'd.name as organization_name',
                'a.created_on as pubdate',
                'a.last_date expire',
                'a.last_updated_on as updated',
                'a.type',
                'a.created_on',
            ])
            ->innerJoin(AssignedCategories::tableName() . 'as b', 'b.assigned_category_enc_id = a.title')
            ->innerJoin(Categories::tableName() . 'as c', 'c.category_enc_id = b.category_enc_id')
            ->innerJoin(Categories::tableName() . 'as i', 'b.parent_enc_id = i.category_enc_id')
            ->innerJoin(ApplicationUnclaimOptions::tableName() . 'as v', 'v.application_enc_id = a.application_enc_id')
            ->leftJoin(Currencies::tableName() . 'as xt', 'xt.currency_enc_id = v.currency_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as j', 'j.application_type_enc_id = a.application_type_enc_id')
            ->innerJoin(UnclaimedOrganizations::tableName() . 'as d', 'd.organization_enc_id = a.unclaimed_organization_enc_id')
            ->leftJoin(ApplicationPlacementCities::tableName() . 'as x', 'x.application_enc_id = a.application_enc_id AND x.is_deleted = 0')
            ->leftJoin(Cities::tableName() . 'as g', 'g.city_enc_id = x.city_enc_id')
            ->leftJoin(States::tableName() . 'as s', 's.state_enc_id = g.state_enc_id')
            ->leftJoin(Countries::tableName() . 'as ct', 'ct.country_enc_id = s.country_enc_id')
            ->where(['j.name' => $options['type'], 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy(['g.city_enc_id', 'a.application_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC]);

        $result = (new \yii\db\Query())
            ->from([
                $cards1->union($cards2),
            ])
            ->limit($limit)
            ->offset($offset)
            ->orderBy(['created_on' => SORT_DESC])
            ->all();
        $i = 0;
        foreach ($result as $val) {
            $result[$i]['expire'] = date('d.m.Y', strtotime($val['expire']));
            $result[$i]['pubdate'] = date('d.m.Y', strtotime($val['pubdate']));
            $result[$i]['updated'] = date('d.m.Y', strtotime($val['updated']));
            $result[$i]['description'] = utf8_encode(html_entity_decode($result[$i]['description']));
            $result[$i]['education_req'] = utf8_encode(html_entity_decode($result[$i]['education_req']));
            $result[$i]['organization_name'] = utf8_encode(html_entity_decode($result[$i]['organization_name']));
            $date=date_create($result[$i]['expire']);
            date_add($date,date_interval_create_from_date_string("60 days"));
            $result[$i]['expire'] = date_format($date,"d.m.Y");
            $currency = (($val['html_code']) ? $val['html_code'] : '₹ ');
            if ($val['salary_type'] == "Fixed") {
                if ($val['salary_duration'] == "Monthly") {
                    $result[$i]['salary'] = $currency . $val['fixed_salary'] * 12 . ' Per Annum';
                } elseif ($val['salary_duration'] == "Hourly") {
                    $result[$i]['salary'] = $currency . $val['fixed_salary'] . ' Per Hour';
                } elseif ($val['salary_duration'] == "Weekly") {
                    $result[$i]['salary'] = $currency . $val['fixed_salary'] . ' Per Week';
                } else {
                    $result[$i]['salary'] = $currency . $val['fixed_salary'] . ' Per Annum';
                }
            } elseif ($val['salary_type'] == "Negotiable") {
                if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $currency . (string)$val['min_salary'] * 12 . " - " . $currency . (string)$val['max_salary'] * 12 . ' Per Annum';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . " - " . $currency . (string)($val['max_salary']) . ' Per Hour';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . " - " . $currency . (string)($val['max_salary']) . ' Per Week';
                    } else {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . " - " . $currency . (string)($val['max_salary']) . ' Per Annum';
                    }
                } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $currency . (string)$val['min_salary'] * 12 . ' Per Annum';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . ' Per Hour';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . ' Per Week';
                    } else {
                        $result[$i]['salary'] = $currency . (string)($val['min_salary']) . ' Per Annum';
                    }
                } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $currency . (string)$val['max_salary'] * 12 . ' Per Annum';
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $currency . (string)($val['max_salary']) . ' Per Hour';
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = $currency . (string)($val['max_salary']) . ' Per Week';
                    } else {
                        $result[$i]['salary'] = $currency . (string)($val['max_salary']) . ' Per Annum';
                    }
                }
            }
            unset($result[$i]['fixed_salary']);
            unset($result[$i]['salary_type']);
            unset($result[$i]['max_salary']);
            unset($result[$i]['min_salary']);
            unset($result[$i]['salary_duration']);
            $i++;
        }
        return $result;
    }

    private  function utf8ize($mixed) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->utf8ize($value);
            }
        } elseif (is_string($mixed)) {
            return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
        }
        return $mixed;
    }
}
