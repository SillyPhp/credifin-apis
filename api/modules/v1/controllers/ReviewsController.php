<?php


namespace api\modules\v1\controllers;


use account\models\applications\ApplicationForm;
use api\modules\v1\models\Candidates;
use common\models\FollowedOrganizations;
use common\models\NewOrganizationReviews;
use common\models\OrganizationReviews;
use common\models\Organizations;
use common\models\UnclaimedFollowedOrganizations;
use common\models\UnclaimedOrganizations;
use common\models\UserAccessTokens;
use frontend\models\reviews\EditReview;
use frontend\models\reviews\ReviewCards;
use yii\filters\auth\HttpBearerAuth;
use Yii;
use yii\helpers\Url;

class ReviewsController extends ApiBaseController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'except' => [
                'review',
            ],
            'class' => HttpBearerAuth::className()
        ];
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => []
        ];
        return $behaviors;
    }

    private function userId()
    {

        $token_holder_id = UserAccessTokens::find()
            ->where(['access_token' => explode(" ", Yii::$app->request->headers->get('Authorization'))[1]])
            ->andWhere(['source' => Yii::$app->request->headers->get('source')])
            ->one();

        $user = Candidates::findOne([
            'user_enc_id' => $token_holder_id->user_enc_id
        ]);

        return $user;
    }

    public function actionReview()
    {

        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        $data = [];

        $editReviewForm = new EditReview;
        $model = new ApplicationForm();
        $primary_cat = $model->getPrimaryFields();

        if (isset($parameters['slug']) && !empty($parameters['slug'])) {
            $slug = $parameters['slug'];
        } else {
            return $this->response(422);
        }

        $org = Organizations::find()
            ->select(['organization_enc_id', 'slug', 'initials_color', 'name', 'website', 'email', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
            ->where(['slug' => $slug, 'is_deleted' => 0])
            ->asArray()
            ->one();

        $unclaimed_org = UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'b.business_activity', 'a.slug', 'a.initials_color', 'a.name', 'a.website', 'a.email', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE NULL END logo'])
            ->joinWith(['organizationTypeEnc b'], false)
            ->where([
                'slug' => $slug,
                'status' => 1
            ])
            ->asArray()
            ->one();

        if (!empty($org)) {
            $review_type = 'claimed';
            $reviews = OrganizationReviews::find()
                ->alias('a')
                ->select(['a.show_user_details', 'a.review_enc_id', 'a.status', 'ROUND(a.average_rating) average', 'c.name profile', 'a.created_on', 'a.is_current_employee', 'a.overall_experience', 'a.skill_development', 'a.work_life', 'a.compensation', 'a.organization_culture', 'a.job_security', 'a.growth', 'a.work', 'a.likes', 'a.dislikes', 'a.from_date', 'a.to_date', 'b.first_name', 'b.last_name', 'b.image user_logo', 'b.image_location user_logo_location', 'b.initials_color'])
                ->where(['a.organization_enc_id' => $org['organization_enc_id'], 'a.status' => 1])
                ->joinWith(['createdBy b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . $candidate->user_enc_id . '") DESC, a.created_on DESC')])
                ->asArray()
                ->all();

            if ($candidate->user_enc_id) {
                $follow = FollowedOrganizations::find()
                    ->select('followed')
                    ->where(['created_by' => $candidate->user_enc_id, 'organization_enc_id' => $org['organization_enc_id']])
                    ->asArray()
                    ->one();
            }

            $stats = OrganizationReviews::find()
                ->select(['ROUND(AVG(job_security)) job_avg', 'ROUND(AVG(growth)) growth_avg', 'ROUND(AVG(organization_culture)) avg_cult', 'ROUND(AVG(compensation)) avg_compensation', 'ROUND(AVG(work)) avg_work', 'ROUND(AVG(work_life)) avg_work_life', 'ROUND(AVG(skill_development)) avg_skill'])
                ->where(['organization_enc_id' => $org['organization_enc_id'], 'status' => 1])
                ->asArray()
                ->one();

            $data['claimed_org_detail'] = $org;
            $data['reviews'] = $reviews;
            $data['follow'] = $follow;
            if ($data['follow'] == null) {
                $data['follow'] = $follow = [];
            }
            $data['overall_rating'] = $stats;

            if (!empty($data)) {
                return $this->response(200, $data);
            } else {
                return $this->response(404);
            }

        } elseif (!empty($unclaimed_org)) {
            $obj = new ReviewCards();
            $review_type = 'unclaimed';

            $emp_stats = NewOrganizationReviews::find()
                ->select(['ROUND(AVG(job_security)) job_avg', 'ROUND(AVG(growth)) growth_avg', 'ROUND(AVG(organization_culture)) avg_cult', 'ROUND(AVG(compensation)) avg_compensation', 'ROUND(AVG(work)) avg_work', 'ROUND(AVG(work_life)) avg_work_life', 'ROUND(AVG(skill_development)) avg_skill'])
                ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
                ->andWhere(['in', 'reviewer_type', [0, 1]])
                ->asArray()
                ->one();

            $emp_reviews = NewOrganizationReviews::find()
                ->alias('a')
                ->select([
                    'a.average_rating',
                    'a.job_security',
                    'a.growth',
                    'a.organization_culture',
                    'a.compensation',
                    'a.work',
                    'a.work_life',
                    'a.skill_development',
                    'a.likes',
                    'a.dislikes',
                    'c.name profile',
                    'd.designation',
                    'a.created_on',
                    'a.reviewer_type',
                    'a.show_user_details',
                    'b.first_name',
                    'b.last_name',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", image) ELSE NULL END image',
                    'b.initials_color'
                ])
                ->joinWith(['createdBy b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->joinWith(['designationEnc d'], false)
                ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
                ->andWhere(['in', 'a.reviewer_type', [0, 1]])
                ->asArray()
                ->all();

            if ($unclaimed_org['business_activity'] == 'College') {
                $stats_students = NewOrganizationReviews::find()
                    ->select(['ROUND(AVG(academics)) academics', 'ROUND(AVG(faculty_teaching_quality)) faculty_teaching_quality', 'ROUND(AVG(infrastructure)) infrastructure', 'ROUND(AVG(accomodation_food)) accomodation_food', 'ROUND(AVG(placements_internships)) placements_internships', 'ROUND(AVG(social_life_extracurriculars)) social_life_extracurriculars', 'ROUND(AVG(culture_diversity)) culture_diversity'])
                    ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
                    ->andWhere(['in', 'reviewer_type', [2, 3]])
                    ->asArray()
                    ->one();

                $reviews_students = NewOrganizationReviews::find()
                    ->alias('a')
                    ->select([
                        'a.average_rating',
                        'a.academics',
                        'a.faculty_teaching_quality',
                        'a.infrastructure',
                        'a.accomodation_food',
                        'a.placements_internships',
                        'a.social_life_extracurriculars',
                        'a.culture_diversity',
                        'a.likes',
                        'a.dislikes',
                        'a.created_on',
                        'a.show_user_details',
                        'a.reviewer_type',
                        'b.first_name',
                        'b.last_name',
                        'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", image) ELSE NULL END image',
                        'b.initials_color',
                        'c.name'
                    ])
                    ->joinWith(['createdBy b'], false)
                    ->joinWith(['educationalStreamEnc c'], false)
                    ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
                    ->andWhere(['in', 'a.reviewer_type', [2, 3]])
                    ->asArray()
                    ->all();
            } elseif ($unclaimed_org['business_activity'] == 'School') {

                $stats_students = NewOrganizationReviews::find()
                    ->select(['ROUND(AVG(student_engagement)) student_engagement', 'ROUND(AVG(school_infrastructure)) school_infrastructure', 'ROUND(AVG(faculty)) faculty', 'ROUND(AVG(accessibility_of_faculty)) accessibility_of_faculty', 'ROUND(AVG(co_curricular_activities)) co_curricular_activities', 'ROUND(AVG(leadership_development)) leadership_development', 'ROUND(AVG(sports)) sports'])
                    ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
                    ->andWhere(['in', 'reviewer_type', [4, 5]])
                    ->asArray()
                    ->one();

                $reviews_students = NewOrganizationReviews::find()
                    ->alias('a')
                    ->select([
                        'a.average_rating',
                        'a.student_engagement',
                        'a.school_infrastructure',
                        'a.faculty',
                        'a.accessibility_of_faculty',
                        'a.co_curricular_activities',
                        'a.leadership_development',
                        'a.sports',
                        'a.likes',
                        'a.dislikes',
                        'a.created_on',
                        'a.show_user_details',
                        'a.reviewer_type',
                        'b.first_name',
                        'b.last_name',
                        'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", image) ELSE NULL END image',
                        'b.initials_color',
                        'c.name'
                    ])
                    ->joinWith(['createdBy b'], false)
                    ->joinWith(['educationalStreamEnc c'], false)
                    ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
                    ->andWhere(['in', 'a.reviewer_type', [4, 5]])
                    ->asArray()
                    ->all();
            } elseif ($unclaimed_org['business_activity'] == 'Educational Institute') {

                $stats_students = NewOrganizationReviews::find()
                    ->select(['ROUND(AVG(student_engagement)) student_engagement', 'ROUND(AVG(school_infrastructure)) school_infrastructure', 'ROUND(AVG(faculty)) faculty', 'ROUND(AVG(value_for_money)) value_for_money', 'ROUND(AVG(teaching_style)) teaching_style', 'ROUND(AVG(coverage_of_subject_matter)) coverage_of_subject_matter', 'ROUND(AVG(accessibility_of_faculty)) accessibility_of_faculty'])
                    ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1])
                    ->andWhere(['in', 'reviewer_type', [6, 7]])
                    ->asArray()
                    ->one();

                $reviews_students = NewOrganizationReviews::find()
                    ->alias('a')
                    ->select([
                        'a.average_rating',
                        'a.student_engagement',
                        'a.school_infrastructure',
                        'a.faculty',
                        'a.value_for_money',
                        'a.teaching_style',
                        'a.coverage_of_subject_matter',
                        'a.accessibility_of_faculty',
                        'a.likes',
                        'a.dislikes',
                        'a.created_on',
                        'a.show_user_details',
                        'a.reviewer_type',
                        'b.first_name',
                        'b.last_name',
                        'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", image) ELSE NULL END image',
                        'b.initials_color',
                        'c.name'
                    ])
                    ->joinWith(['createdBy b'], false)
                    ->joinWith(['educationalStreamEnc c'], false)
                    ->where(['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1])
                    ->andWhere(['in', 'a.reviewer_type', [6, 7]])
                    ->asArray()
                    ->all();
            }
            if ($candidate->user_enc_id) {
                $follow = UnclaimedFollowedOrganizations::find()
                    ->select('followed')
                    ->where(['created_by' => $candidate->user_enc_id, 'organization_enc_id' => $unclaimed_org['organization_enc_id']])
                    ->asArray()
                    ->one();
            }
            $org = $unclaimed_org;

            $data['unclaimed_org_detail'] = $org;
            $data['reviews'] = $reviews_students;
            $data['follow'] = $follow;
            if ($data['follow'] == null) {
                $data['follow'] = $follow = [];
            }
            $data['overall_rating'] = $stats_students;
            $data['employee_overall_rating'] = $emp_stats;
            $data['employee_reviews'] = $emp_reviews;

            if ($org['business_activity'] == 'College' || $org['business_activity'] == 'School' || $org['business_activity'] == 'Educational Institute') {
                if (!empty($data)) {
                    return $this->response(200, $data);
                } else {
                    return $this->response(404);
                }
            }
        }
    }

}