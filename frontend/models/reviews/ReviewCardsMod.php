<?php

namespace frontend\models\reviews;

use common\models\ApplicationPlacementCities;
use common\models\ApplicationPlacementLocations;
use common\models\ApplicationTypes;
use common\models\ApplicationUnclaimOptions;
use common\models\BusinessActivities;
use common\models\Cities;
use common\models\EmployerApplications;
use common\models\NewOrganizationReviews;
use common\models\OrganizationLocations;
use common\models\OrganizationReviews;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use yii\helpers\Url;
use Yii;

class ReviewCardsMod
{

    public function getAllCompanies($options = [])
    {
        if (isset($options['limit'])) {
            $limit = $options['limit'];
            $offset = ($options['page'] - 1) * $options['limit'];
        }
        $q1 = (new \yii\db\Query())
            ->select(['a.slug','(CASE WHEN a.is_featured = "1" THEN "1"
                ELSE NULL   
                END) as is_featured','a.organization_enc_id','a.name','a.initials_color color',
                'a.created_on','COUNT(CASE WHEN h.name = "Jobs" THEN 1 END) as total_jobs',
                'COUNT(CASE WHEN h.name = "Internships" THEN 1 END) as total_internships',
                'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '",a.logo_location, "/", a.logo) END logo',
                'y.business_activity','COUNT(distinct z.review_enc_id) total_reviews',
                'a.slug profile_link','CONCAT(a.slug, "/reviews") review_link',
                'ROUND((skill_development+work+work_life+compensation+organization_culture+job_security+growth)/7) rating',
                'SUM(e.positions) total_vaccency'])
            ->distinct()
            ->from(Organizations::tableName() . 'as a')
            ->leftJoin(EmployerApplications::tableName() . 'as b', 'b.organization_enc_id = a.organization_enc_id')
            ->leftJoin(ApplicationTypes::tableName() . 'as h', 'h.application_type_enc_id = b.application_type_enc_id')
            ->leftJoin(ApplicationPlacementLocations::tableName() . 'as e', 'e.application_enc_id = b.application_enc_id AND e.is_deleted = 0')
            ->leftJoin(OrganizationLocations::tableName() . 'as f', 'f.location_enc_id = e.location_enc_id')
            ->leftJoin(ApplicationPlacementCities::tableName() . 'as t', 't.application_enc_id = b.application_enc_id AND t.is_deleted = 0')
            ->leftJoin(Cities::tableName() . 'as g', 'g.city_enc_id = f.city_enc_id')
            ->leftJoin(Cities::tableName() . 'as x', 'x.city_enc_id = t.city_enc_id')
            ->leftJoin(BusinessActivities::tableName() . 'as y', 'y.business_activity_enc_id = a.business_activity_enc_id')
            ->leftJoin(OrganizationReviews::tableName() . 'as z', 'z.organization_enc_id = a.organization_enc_id')
            ->where(['a.is_deleted' => 0])
            ->andWhere(['a.status' => 'Active','b.is_deleted'=>0])
            ->groupBy(['a.organization_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC]);

        if (isset($options['business_activity'])) {
            $q1->andWhere([
                'or',
                ['in', 'y.business_activity', $options['business_activity']]
            ]);
        }
        if (isset($options['keyword'])) {
            $search = trim($options['keyword']);
            $search_pattern = self::makeSQL_search_pattern($search);
            $q1->andWhere([
                'or',
                ['REGEXP', 'a.name', $search_pattern],
                ['REGEXP', 'g.name', $search_pattern],
                ['REGEXP', 'x.name', $search_pattern],
            ]);
        }
        if (isset($options['city'])) {
            $q1->andWhere([
                'or',
                ['like', 'g.name', $options['city']],
                ['like', 'x.name', $options['city']],
            ]);
        }
        if (isset($options['sortBy'])) {
            $q1->andWhere('a.name LIKE "'.$options['sortBy'].'%"');
        }
        if (isset($options['most_reviewed'])) {
            $q1->orderBy(['total_reviews' => SORT_DESC]);
        }
        if (isset($options['rating'])) {
            $q1->orFilterHaving(['ROUND(AVG(z.average_rating))' => $options['rating']]);
        }

        $q2 = (new \yii\db\Query())
            ->select(['a.slug','(CASE WHEN a.is_featured = "1" THEN "1"
                ELSE NULL   
                END) as is_featured','a.organization_enc_id','a.name','a.initials_color color',
                'a.created_on','COUNT(CASE WHEN h.name = "Jobs" THEN 1 END) as total_jobs',
                'COUNT(CASE WHEN h.name = "Internships" THEN 1 END) as total_internships',
                'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",a.logo_location, "/", a.logo) END logo',
                'y.business_activity','COUNT(distinct z.review_enc_id) total_reviews',
                'CONCAT(a.slug, "/reviews") profile_link','CONCAT(a.slug, "/reviews") review_link',
                'ROUND(average_rating) rating','u.positions total_vaccency'])
            ->distinct()
            ->from(UnclaimedOrganizations::tableName() . 'as a')
            ->leftJoin(EmployerApplications::tableName() . 'as b', 'b.unclaimed_organization_enc_id = a.organization_enc_id')
            ->leftJoin(ApplicationUnclaimOptions::tableName() . 'as u', 'u.application_enc_id = b.application_enc_id')
            ->leftJoin(ApplicationTypes::tableName() . 'as h', 'h.application_type_enc_id = b.application_type_enc_id')
            ->leftJoin(ApplicationPlacementCities::tableName() . 'as t', 't.application_enc_id = b.application_enc_id AND t.is_deleted = 0')
            ->leftJoin(Cities::tableName() . 'as x', 'x.city_enc_id = t.city_enc_id')
            ->leftJoin(BusinessActivities::tableName() . 'as y', 'y.business_activity_enc_id = a.organization_type_enc_id')
            ->leftJoin(NewOrganizationReviews::tableName() . 'as z', 'z.organization_enc_id = a.organization_enc_id')
            ->where(['a.is_deleted' => 0])
            ->andWhere(['b.is_deleted'=>0])
            ->groupBy(['a.organization_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC]);
        if (isset($options['business_activity'])) {
            $q2->andWhere([
                'or',
                ['in', 'y.business_activity', $options['business_activity']]
            ]);
        }
        if (isset($options['keyword'])) {
            $search = trim($options['keyword']);
            $search_pattern = self::makeSQL_search_pattern($search);
            $q2->andWhere([
                'or',
                ['REGEXP', 'a.name', $search_pattern],
                ['REGEXP', 'x.name', $search_pattern],
            ]);
        }
        if (isset($options['most_reviewed'])) {
            $q2->orderBy(['total_reviews' => SORT_DESC]);

        }
        if (isset($options['sortBy'])) {
            $q2->andWhere('a.name LIKE "'.$options['sortBy'].'%"');
        }
        if (isset($options['city'])) {
            $q2->andWhere([
                'or',
                ['like', 'x.name', $options['city']],
            ]);
        }
        if (isset($options['rating'])) {
            $q2->orFilterHaving(['ROUND(AVG(c.average_rating))' => $options['rating']]);
        }
        $count = $q2->count()+$q1->count();
        $q  = (new \yii\db\Query())
            ->from([
                $q1->union($q2),
            ])
            ->limit($limit)
            ->offset($offset)
            ->orderBy(['is_featured'=>SORT_DESC])
            ->all();
        return [
            'total' => $count,
            'cards' => $q
        ];
    }
    public static function makeSQL_search_pattern($search)
    {
        if ($search==null||empty($search)){
            return "";
        }
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