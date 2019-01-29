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
            ->select(['a.application_enc_id application_id', 'e.location_enc_id location_id', 'm.value as salary', 'a.last_date', 'i.name category', 'l.designation', 'CONCAT("/job/", a.slug) link', 'd.initials_color color', 'CONCAT("/company/", d.slug) organization_link', 'a.experience', "g.name as city", 'c.name as title', 'd.name as organization_name', 'CASE WHEN d.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", d.logo_location, "/", d.logo) ELSE NULL END logo'])
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
            ->innerJoin(ApplicationOptions::tableName() . 'as m', 'm.application_enc_id = a.application_enc_id')
            ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0, 'm.option_name' => 'salary']);

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

        return $cards->orderBy(['a.id' => SORT_DESC])->asArray()->all();
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