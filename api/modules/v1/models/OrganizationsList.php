<?php

namespace api\modules\v1\models;

use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use yii\db\Expression;
use yii\helpers\Url;
use Yii;

class OrganizationsList
{
    public function getAllCompanies($options = [])
    {
        if (isset($options['limit'])) {
            $limit = $options['limit'];
            $offset = ($options['page'] - 1) * $options['limit'];
        }

        $q1 = Organizations::find()
            ->distinct()
            ->alias('a')
            ->select([new Expression(' "1" as is_claimed'), '(CASE
                WHEN fo.followed = "1" THEN fo.followed ELSE "0"
               END) as is_followed', 'a.slug',
                'a.organization_enc_id', 'a.name', 'a.initials_color color',
                '(CASE WHEN count(CASE WHEN le.name = "Featured" THEN "1" ELSE NULL END) = 0  THEN "0" ELSE "1" END) as is_featured',
                '(CASE WHEN count(CASE WHEN le.name = "Trending" THEN "1" ELSE NULL END) = 0  THEN "0" ELSE "1" END) as is_trending',
                '(CASE WHEN count(CASE WHEN le.name = "New" THEN "1" ELSE NULL END) = 0  THEN "0" ELSE "1" END) as is_new',
                '(CASE WHEN count(CASE WHEN le.name = "Promoted" THEN "1" ELSE NULL END) = 0  THEN "0" ELSE "1" END) as is_promoted',
                '(CASE WHEN count(CASE WHEN le.name = "Hot" THEN "1" ELSE NULL END) = 0  THEN "0" ELSE "1" END) as is_hot',
                'a.created_on', 'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '",a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=true&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo',
                'y.business_activity', 'COUNT(distinct z.review_enc_id) total_reviews',
                'a.slug profile_link', 'CONCAT(a.slug, "/reviews") review_link',
                'ROUND((skill_development+work+work_life+compensation+organization_culture+job_security+growth)/7) rating',
                '(SUM(IFNULL(e.positions, 0))+IFNULL(ab.positions, 0)) as total_vacancy'])
            ->joinWith(['businessActivityEnc y'], false)
            ->joinWith(['organizationReviews z'], false)
            ->joinWith(['employerApplications b' => function ($x) {
                $x->joinWith(['applicationPlacementLocations e' => function ($x) {
                    $x->joinWith(['locationEnc f' => function ($x) {
                        $x->joinWith(['cityEnc g'], false);
                    }]);
                }], false);
                $x->joinWith(['applicationPlacementCities t' => function ($x) {
                    $x->joinWith(['cityEnc x'], false);
                }], false);
                $x->select(['b.organization_enc_id', 'h.name', 'COUNT(distinct b.application_enc_id) as total_application']);
                $x->joinWith(['applicationOptions ab'], false);
                $x->joinWith(['applicationTypeEnc h' => function ($x) {
                    $x->groupBy(['h.name']);
                    $x->orderBy([new \yii\db\Expression('FIELD (h.name, "Jobs") DESC, h.name DESC')]);
                }], false);
                $x->onCondition(['b.is_deleted' => 0, 'b.application_for' => 1, 'b.status' => 'ACTIVE']);
                $x->groupBy(['b.organization_enc_id']);
            }], true)
            ->joinWith(['followedOrganizations fo' => function ($x) use ($options) {
                $x->onCondition(['fo.created_by' => $options['user_id']]);
            }], false)
            ->joinWith(['organizationLabels ol' => function ($x) {
                $x->select(['ol.organization_enc_id', 'ol.org_label_enc_id', 'ol.label_enc_id', 'le.name label_name']);
                $x->onCondition(['ol.label_for' => 0, 'ol.is_deleted' => 0]);
                $x->joinWith(['labelEnc le' => function ($l) {
                    $l->onCondition(['le.is_deleted' => 0]);
                }], false);
            }], false)
            ->andWhere(['a.is_deleted' => 0])
            ->andWhere(['a.status' => 'Active'])
            ->orderBy(['is_featured' => SORT_DESC, 'a.created_on' => SORT_DESC]);
        if (isset($options['business_activity'])) {
            $q1->andWhere([
                'or',
                ['in', 'y.business_activity', $options['business_activity']]
            ]);
        }
        if (isset($options['keyword'])) {
            $search = trim($options['keyword']);
            $q1->andWhere([
                'or',
                ['like', 'a.name', $search],
                ['like', 'x.name', $search],
                ['like', 'g.name', $search],
                ['like', 'a.slug', $search],
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
            $q1->andWhere('a.name LIKE "' . $options['sortBy'] . '%"');
        }
        if (isset($options['most_reviewed'])) {
            $q1->orderBy(['total_reviews' => SORT_DESC]);
        }
        if (isset($options['rating'])) {
            $q1->orFilterHaving(['ROUND(AVG(z.average_rating))' => $options['rating']]);
        }

        $q2 = UnclaimedOrganizations::find()
            ->distinct()
            ->alias('a')
            ->select([new Expression(' "0" as is_claimed'), '(CASE
                WHEN fo.followed = "1" THEN fo.followed ELSE "0"
               END) as is_followed', 'a.slug',
                'a.organization_enc_id', 'a.name', 'a.initials_color color',
                '(CASE WHEN count(CASE WHEN le.name = "Featured" THEN "1" ELSE NULL END) = 0  THEN "0" ELSE "1" END) as is_featured',
                '(CASE WHEN count(CASE WHEN le.name = "Trending" THEN "1" ELSE NULL END) = 0  THEN "0" ELSE "1" END) as is_trending',
                '(CASE WHEN count(CASE WHEN le.name = "New" THEN "1" ELSE NULL END) = 0  THEN "0" ELSE "1" END) as is_new',
                '(CASE WHEN count(CASE WHEN le.name = "Promoted" THEN "1" ELSE NULL END) = 0  THEN "0" ELSE "1" END) as is_promoted',
                '(CASE WHEN count(CASE WHEN le.name = "Hot" THEN "1" ELSE NULL END) = 0  THEN "0" ELSE "1" END) as is_hot',
                'a.created_on',
                'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=true&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo',
                'y.business_activity', 'COUNT(distinct z.review_enc_id) total_reviews',
                'CONCAT(a.slug, "/reviews") profile_link', 'CONCAT(a.slug, "/reviews") review_link',
                'ROUND(average_rating) rating', 'IFNULL(u.positions, 0) total_vacancy'])
            ->joinWith(['organizationTypeEnc y'], false)
            ->joinWith(['newOrganizationReviews z' => function ($b) {
                $b->joinWith(['cityEnc d'], false);
            }], false)
            ->joinWith(['employerApplications b' => function ($x) {
                $x->joinWith(['applicationTypeEnc h' => function ($x) {
                    $x->groupBy(['h.name']);
                    $x->orderBy([new \yii\db\Expression('FIELD (h.name, "Jobs") DESC, h.name DESC')]);
                }], false);
                $x->select(['b.unclaimed_organization_enc_id', 'h.name', 'COUNT(distinct b.application_enc_id) as total_application']);
                $x->joinWith(['applicationUnclaimOptions u'], false);
                $x->joinWith(['applicationPlacementCities t' => function ($x) {
                    $x->joinWith(['cityEnc x'], false);
                }], false);
                $x->onCondition(['b.is_deleted' => 0, 'b.status' => 'ACTIVE']);
                $x->groupBy('b.organization_enc_id');
            }], true)
            ->joinWith(['unclaimedFollowedOrganizations fo' => function ($x) use ($options) {
                $x->onCondition(['fo.created_by' => $options]);
            }], false)
            ->joinWith(['unclaimOrganizationLabels ul' => function ($x) {
                $x->select(['ul.organization_enc_id', 'ul.org_label_enc_id', 'ul.label_enc_id', 'le.name label_name']);
                $x->onCondition(['ul.label_for' => 0, 'ul.is_deleted' => 0]);
                $x->joinWith(['labelEnc le' => function ($le) {
                    $le->onCondition(['le.is_deleted' => 0]);
                }], false);
            }], false)
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['is_featured' => SORT_DESC, 'a.created_on' => SORT_DESC]);
        if (isset($options['business_activity'])) {
            $q2->andWhere([
                'or',
                ['in', 'y.business_activity', $options['business_activity']]
            ]);
        }
        if (isset($options['keyword'])) {
            $search = trim($options['keyword']);
            $q2->andWhere([
                'or',
                ['like', 'a.name', $search],
                ['like', 'x.name', $search],
                ['like', 'a.slug', $search],
            ]);
        }
        if (isset($options['most_reviewed'])) {
            $q2->orderBy(['total_reviews' => SORT_DESC]);

        }
        if (isset($options['sortBy'])) {
            $q2->andWhere('a.name LIKE "' . $options['sortBy'] . '%"');
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

        $q1 = $q1->groupBy(['a.organization_enc_id'])->limit($limit)
            ->offset($offset);

        $q2 = $q2->groupBy(['a.organization_enc_id'])->limit($limit)
            ->offset($offset);
        $q = $q1->union($q2)
            ->distinct()
            ->asArray()
            ->all();

        foreach ($q as $key => $val) {
            $q[$key]['Jobs'] = '0';
            $q[$key]['Internships'] = '0';
            foreach ($val['employerApplications'] as $t) {
                $q[$key][$t['name']] = $t['total_application'];
            }
            unset($q[$key]['employerApplications']);
            if ($q[$key]['rating'] == null) {
                $q[$key]['rating'] = '0';
            }
        }

        return $q;
    }

    public static function makeSQL_search_pattern($search)
    {
        if ($search == null || empty($search)) {
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