<?php

namespace frontend\models\reviews;

use common\models\NewOrganizationReviews;
use common\models\Organizations;
use common\models\UnclaimedOrganizations;
use yii\helpers\Url;
use Yii;

class ReviewCards
{

    public function getReviewCards($options = [])
    {
        if (isset($options['limit'])) {
            $limit = $options['limit'];
            $offset = ($options['page'] - 1) * $options['limit'];
        }
        $q1 = Organizations::find()->alias('a')
            ->select(['a.organization_enc_id','a.is_featured','a.name','COUNT(CASE WHEN h.name = "Jobs" THEN 1 END) as total_jobs','COUNT(CASE WHEN h.name = "Internships" THEN 1 END) as total_internships','a.initials_color color', 'a.created_on', 'COUNT(distinct c.review_enc_id) total_reviews', 'a.slug profile_link', 'CONCAT(a.slug, "/reviews") review_link', 'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '",a.logo_location, "/", a.logo) END logo','b.business_activity', 'ROUND((skill_development+work+work_life+compensation+organization_culture+job_security+growth)/7) rating','SUM(i.positions) total_vaccency'])
            ->where(['a.is_deleted' => 0])
            ->andWhere(['a.status' => 'Active'])
            ->joinWith(['businessActivityEnc b'], false)
            ->joinWith(['organizationReviews c'], false)
            ->joinWith(['employerApplications e' => function ($x) {
                $x->joinWith(['applicationTypeEnc h'], false);
                $x->joinWith(['applicationPlacementLocations i'], false);
                $x->onCondition(['e.is_deleted' => 0]);
                $x->groupBy(['e.organization_enc_id']);
            }], false)
            ->joinWith(['organizationLocations d' => function ($x) {
                $x->joinWith(['cityEnc g'], false);
            }], false)
            ->groupBy('a.organization_enc_id')
            ->orderBy(['a.created_on' => SORT_DESC]);
        if (isset($options['business_activity'])) {
            $q1->andWhere([
                'or',
                ['in', 'b.business_activity', $options['business_activity']]
            ]);
        }
        if (isset($options['keyword'])) {
            $search = trim($options['keyword']);
            $search_pattern = self::makeSQL_search_pattern($search);
            $q1->andWhere([
                'or',
                ['REGEXP', 'a.name', $search_pattern],
                ['REGEXP', 'g.name', $search_pattern],
            ]);
        }
        if (isset($options['city'])) {
            $q1->andWhere([
                'or',
                ['like', 'g.name', $options['city']],
            ]);
        }
        if (isset($options['sortBy'])) {
            $q1->andWhere('a.name LIKE "'.$options['sortBy'].'%"');
        }
        if (isset($options['most_reviewed'])) {
            $q1->orderBy(['total_reviews' => SORT_DESC]);

        }
        if (isset($options['rating'])) {
            $q1->orFilterHaving(['ROUND(AVG(c.average_rating))' => $options['rating']]);
        }
        $q2 = UnclaimedOrganizations::find()->alias('a')
            ->select(['a.organization_enc_id','a.is_featured','a.name','COUNT(CASE WHEN h.name = "Jobs" THEN 1 END) as total_jobs','COUNT(CASE WHEN h.name = "Internships" THEN 1 END) as total_internships','a.initials_color color', 'a.created_on', 'COUNT(distinct c.review_enc_id) total_reviews', 'CONCAT(a.slug, "/reviews") profile_link', 'CONCAT(a.slug, "/reviews") review_link', 'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",a.logo_location, "/", a.logo) END logo','b.business_activity', 'ROUND(average_rating) rating','SUM(i.positions) total_vaccency'])
            ->joinWith(['organizationTypeEnc b'], false)
            ->joinWith(['newOrganizationReviews c' => function ($b) {
                $b->joinWith(['cityEnc d'], false);
            }], false)
            ->joinWith(['employerApplications e' => function ($x) {
                $x->joinWith(['applicationTypeEnc h'], false);
                $x->joinWith(['applicationUnclaimOptions i'], false);
                $x->onCondition(['e.is_deleted' => 0]);
                $x->groupBy('e.organization_enc_id');
            }], false)
            ->where(['a.is_deleted' => 0])
            ->groupBy(['a.organization_enc_id'])
            ->orderBy(['a.created_on' => SORT_DESC]);
        if (isset($options['business_activity'])) {
            $q2->andWhere([
                'or',
                ['in', 'b.business_activity', $options['business_activity']]
            ]);
        }
        if (isset($options['keyword'])) {
            $search = trim($options['keyword']);
            $search_pattern = self::makeSQL_search_pattern($search);
            $q2->andWhere([
                'or',
                ['REGEXP', 'a.name', $search_pattern],
                ['REGEXP', 'd.name', $search_pattern],
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
                ['like', 'd.name', $options['city']],
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
            ->orderBy(['created_on' => SORT_DESC])
            ->all();
        return [
            'total' => $count,
            'cards' => $q
        ];
    }

    public function getCompaniesCard($options = [])
    {
        $cards = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.name', 'a.initials_color color', 'COUNT(distinct c.review_enc_id) total_reviews', 'max(c.created_on) created_on', 'a.slug as profile_link', 'CONCAT(a.slug, "/reviews") review_link', 'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '",a.logo_location, "/", a.logo) END logo', 'b.business_activity_enc_id', 'b.business_activity', 'ROUND((skill_development+work+work_life+compensation+organization_culture+job_security+growth)/7) rating'])
            ->where(['a.is_deleted' => 0])
            ->andWhere(['a.status' => 'Active'])
            ->joinWith(['businessActivityEnc b'], false)
            ->joinWith(['organizationReviews c'], false)
            ->joinWith(['employerApplications e' => function ($x) {
                $x->select(['e.organization_enc_id', 'COUNT(CASE WHEN h.name = "Jobs" THEN 1 END) as total_jobs', 'COUNT(CASE WHEN h.name = "Internships" THEN 1 END) as total_internships']);
                $x->joinWith(['applicationTypeEnc h'], false);
                $x->onCondition(['e.is_deleted' => 0]);
                $x->groupBy(['e.organization_enc_id']);
            }], true)
            ->joinWith(['organizationLocations d' => function ($x) {
                $x->joinWith(['cityEnc g'], false);
            }], false)
            ->groupBy('a.organization_enc_id');
        if (isset($options['business_activity'])) {
            $cards->andWhere([
                'or',
                ['in', 'b.business_activity', $options['business_activity']]
            ]);
        }
        if (isset($options['keywords'])) {
            $cards->andWhere([
                'or',
                ['like', 'a.name', $options['keywords']],
            ]);
        }
        if (isset($options['city'])) {
            $cards->andWhere([
                'or',
                ['like', 'g.name', $options['city']],
            ]);
        }
        if (isset($options['sort'])) {
            $cards->orderBy(['c.created_on' => SORT_DESC]);

        }
        if (isset($options['most_reviewed'])) {
            $cards->orderBy(['total_reviews' => SORT_DESC]);

        }
        if (isset($options['rating'])) {
            $cards->orFilterHaving(['ROUND(AVG(c.average_rating))' => $options['rating']]);
        }
        $total_cards = $cards->count();
        $data = $cards->limit($options['limit'])->offset($options['offset'])->asArray()->all();

        return [
            'total' => $total_cards,
            'cards' => $data
        ];
    }

    public function getReviewUncliamedCards($options = [])
    {
        $card_query = UnclaimedOrganizations::find()
            ->alias('a');
        $cards = $card_query->select(['a.organization_enc_id', 'COUNT(distinct c.review_enc_id) total_reviews', 'max(c.created_on) created_on', 'a.name', 'a.initials_color color', 'CONCAT(a.slug, "/reviews") profile_link', 'CONCAT(a.slug, "/reviews") review_link', 'CASE WHEN a.logo IS NOT NULL THEN  CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->unclaimed_organizations->logo) . '",a.logo_location, "/", a.logo) END logo', 'b.business_activity_enc_id', 'b.business_activity', 'ROUND(average_rating) rating']);
        $cards->where(['a.is_deleted' => 0])
            ->joinWith(['organizationTypeEnc b'], false)
            ->joinWith(['newOrganizationReviews c'], false)
            ->groupBy('a.organization_enc_id');
        if (isset($options['business_activity'])) {
            $cards->andWhere([
                'or',
                ['in', 'b.business_activity', $options['business_activity']]
            ]);
        }
        if (isset($options['keywords'])) {
            $cards->where('replace(name, ".", "") LIKE "%' . $options['keywords'] . '%"');
        }
        if (isset($options['rating'])) {
            $cards->orFilterHaving(['ROUND(AVG(c.average_rating))' => $options['rating']]);
        }
        if (isset($options['rating'])) {
            $cards->orFilterHaving(['ROUND(AVG(c.average_rating))' => $options['rating']]);
        }
        if (isset($options['sort'])) {
            $cards->orderBy(['c.created_on' => SORT_DESC]);

        }
        if (isset($options['most_reviewed'])) {
            $cards->orderBy(['total_reviews' => SORT_DESC]);

        }
        $total_cards = $cards->count();
        $data = $cards->limit($options['limit'])->offset($options['offset'])->asArray()->all();

        return [
            'total' => $total_cards,
            'cards' => $data
        ];
    }

    public function getReviewsCount($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->alias('a')
            ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
            ->andWhere(['in', 'reviewer_type', [0, 1]])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
            ->count();
    }

    public function getCollegeReviewsCount($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->alias('a')
            ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
            ->andWhere(['in', 'reviewer_type', [2, 3]])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
            ->count();
    }

    public function getSchoolReviewsCount($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->alias('a')
            ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
            ->andWhere(['in', 'reviewer_type', [4, 5]])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
            ->count();
    }

    public function getInstituteReviewsCount($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->alias('a')
            ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
            ->andWhere(['in', 'reviewer_type', [6, 7]])
            ->joinWith(['createdBy b'], false)
            ->joinWith(['categoryEnc c'], false)
            ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . Yii::$app->user->identity->user_enc_id . '") DESC, a.created_on DESC')])
            ->count();
    }

    public function getReviewStats($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->select(['ROUND(AVG(job_security)) job_avg', 'ROUND(AVG(growth)) growth_avg', 'ROUND(AVG(organization_culture)) avg_cult', 'ROUND(AVG(compensation)) avg_compensation', 'ROUND(AVG(work)) avg_work', 'ROUND(AVG(work_life)) avg_work_life', 'ROUND(AVG(skill_development)) avg_skill'])
            ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
            ->andWhere(['in', 'reviewer_type', [0, 1]])
            ->asArray()
            ->one();
    }

    public function getCollegeReviewStats($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->select(['ROUND(AVG(academics)) academics', 'ROUND(AVG(faculty_teaching_quality)) faculty_teaching_quality', 'ROUND(AVG(infrastructure)) infrastructure', 'ROUND(AVG(accomodation_food)) accomodation_food', 'ROUND(AVG(placements_internships)) placements_internships', 'ROUND(AVG(social_life_extracurriculars)) social_life_extracurriculars', 'ROUND(AVG(culture_diversity)) culture_diversity'])
            ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
            ->andWhere(['in', 'reviewer_type', [2, 3]])
            ->asArray()
            ->one();
    }

    public function getSchoolReviewStats($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->select(['ROUND(AVG(student_engagement)) student_engagement', 'ROUND(AVG(school_infrastructure)) school_infrastructure', 'ROUND(AVG(faculty)) faculty', 'ROUND(AVG(accessibility_of_faculty)) accessibility_of_faculty', 'ROUND(AVG(co_curricular_activities)) co_curricular_activities', 'ROUND(AVG(leadership_development)) leadership_development', 'ROUND(AVG(sports)) sports'])
            ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
            ->andWhere(['in', 'reviewer_type', [4, 5]])
            ->asArray()
            ->one();
    }

    public function getInstituteReviewStats($unclaimed_org)
    {
        return NewOrganizationReviews::find()
            ->select(['ROUND(AVG(student_engagement)) student_engagement', 'ROUND(AVG(school_infrastructure)) school_infrastructure', 'ROUND(AVG(faculty)) faculty', 'ROUND(AVG(value_for_money)) value_for_money', 'ROUND(AVG(teaching_style)) teaching_style', 'ROUND(AVG(coverage_of_subject_matter)) coverage_of_subject_matter', 'ROUND(AVG(accessibility_of_faculty)) accessibility_of_faculty'])
            ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
            ->andWhere(['in', 'reviewer_type', [6, 7]])
            ->asArray()
            ->one();
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