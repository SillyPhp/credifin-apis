<?php


namespace api\modules\v1\controllers;


use account\models\applications\ApplicationForm;
use api\modules\v1\models\Candidates;
use api\modules\v1\models\Reviews;
use common\models\Categories;
use common\models\Designations;
use common\models\FollowedOrganizations;
use common\models\NewOrganizationReviews;
use common\models\OrganizationReviewFeedback;
use common\models\OrganizationReviewLikeDislike;
use common\models\OrganizationReviews;
use common\models\Organizations;
use common\models\Qualifications;
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
                'review-fields'
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

    private function __unclaimedReviews($options)
    {
        $primary_result = NewOrganizationReviews::find();

        if ($options['main']['alias']) {
            $primary_result->alias($options['main']['alias'])
                ->select($options['main']['selections']);
        } else {
            $primary_result->alias($options['main']['selections']);
        }

        if (count($options['joins']['created_by']) > 0) {
            $primary_result->joinWith(['createdBy ' . $options['joins']['created_by']['alias']], false);
        }

        if ($options['joins']['educational_stream']) {
            $primary_result->joinWith(['educationalStreamEnc ' . $options['joins']['educational_stream']['alias']], false);
        }

        if ($options['joins']['category']) {
            $primary_result->joinWith(['categoryEnc ' . $options['joins']['category']['alias']], false);
        }

        if ($options['joins']['designation']) {
            $primary_result->joinWith(['designationEnc ' . $options['joins']['designation']['alias']], false);
        }

        $primary_result->where($options['condition'][0]);

        if (count($options['condition']) > 1) {
            for ($i = 1; $i < count($options['condition']); $i++) {
                $primary_result->andWhere($options['condition'][$i]);
            }
        }

        $result = null;

        if ($options['quant'] == 'one') {
            $result = $primary_result->asArray()->one();
        } else {
            $result = $primary_result
                ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . $options['user_id'] . '") DESC, a.created_on DESC')])
                ->asArray()->all();
        }

        return $result;
    }

    public function actionReview()
    {

        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        $data = [];

        if (isset($parameters['org_enc_id']) && !empty($parameters['org_enc_id'])) {
            $org_enc_id = $parameters['org_enc_id'];
        } else {
            return $this->response(422);
        }

        $org = Organizations::find()
            ->select(['organization_enc_id', 'slug', 'initials_color', 'name', 'website', 'email', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
            ->where(['organization_enc_id' => $org_enc_id, 'is_deleted' => 0])
            ->asArray()
            ->one();

        $unclaimed_org = UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'b.business_activity', 'a.slug', 'a.initials_color', 'a.name', 'a.website', 'a.email', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE NULL END logo'])
            ->joinWith(['organizationTypeEnc b'], false)
            ->where([
                'a.organization_enc_id' => $org_enc_id,
                'a.status' => 1
            ])
            ->asArray()
            ->one();

        if (!empty($org)) {
            $review_type = 'claimed';
            $reviews = OrganizationReviews::find()
                ->alias('a')
                ->select([])
                ->select([
                    'a.show_user_details',
                    'a.review_enc_id',
                    'ROUND(a.average_rating) average_rating',
                    'c.name profile',
                    'e.designation',
                    'd.feedback_type',
                    'a.created_on',
                    'a.is_current_employee reviewer_type',
                    'a.job_security',
                    'a.growth career_growth',
                    'a.organization_culture company_culture',
                    'a.compensation salary_and_benefits',
                    'a.work work_satisfaction',
                    'a.work_life work_life_balance',
                    'a.skill_development',
                    'a.likes',
                    'a.dislikes',
                    'a.from_date',
                    'a.to_date',
                    'b.first_name',
                    'b.last_name',
                    'b.initials_color',
                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END image'])
                ->where(['a.organization_enc_id' => $org['organization_enc_id'], 'a.status' => 1])
                ->joinWith(['createdBy b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->joinWith(['organizationReviewLikeDislikes d'], false)
                ->joinWith(['designationEnc e'], false)
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
                ->select([
                    'ROUND(AVG(job_security)) Job_Security',
                    'ROUND(AVG(growth)) Career_Growth',
                    'ROUND(AVG(organization_culture)) Company_Culture',
                    'ROUND(AVG(compensation)) Salary_And_Benefits',
                    'ROUND(AVG(work)) Work_Satisfaction',
                    'ROUND(AVG(work_life)) Work_Life_Balance',
                    'ROUND(AVG(skill_development)) Skill_Development'])
                ->where(['organization_enc_id' => $org['organization_enc_id'], 'status' => 1])
                ->asArray()
                ->one();


            $data['org_detail'] = $org;
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
            $review_type = 'unclaimed';


            $options = [];
            $options['main'] = [
                'alias' => 'a',
                'selections' => [
                    'ROUND(AVG(a.job_security)) Job_Security',
                    'ROUND(AVG(a.growth)) Career_Growth',
                    'ROUND(AVG(a.organization_culture)) Company_Culture',
                    'ROUND(AVG(a.compensation)) Salary_And_Benefits',
                    'ROUND(AVG(a.work)) Work_Satisfaction',
                    'ROUND(AVG(a.work_life)) Work_Life_Balance',
                    'ROUND(AVG(a.skill_development)) Skill_Development'
                ]
            ];

            $options['condition'][] = ['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1];
            $options['condition'][] = ['in', 'a.reviewer_type', [0, 1]];

            $options['quant'] = 'one';

            $emp_stats = $this->__unclaimedReviews($options);

            $options = [];
            $options['main'] = [
                'alias' => 'a',
                'selections' => [
                    'a.review_enc_id',
                    'a.average_rating',
                    'a.job_security',
                    'a.growth career_growth',
                    'a.organization_culture company_culture',
                    'a.compensation salary_and_benefits',
                    'a.work work_satisfaction',
                    'a.work_life work_life_balance',
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
                ]
            ];

            $options['joins']['created_by'] = [
                'alias' => 'b'
            ];

            $options['joins']['category'] = [
                'alias' => 'c'
            ];

            $options['joins']['designation'] = [
                'alias' => 'd'
            ];

            $options['condition'][] = ['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1];
            $options['condition'][] = ['in', 'a.reviewer_type', [0, 1]];

            $options['user_id'] = $candidate->user_enc_id;

            $options['quant'] = 'all';

            $emp_reviews = $this->__unclaimedReviews($options);

            if ($unclaimed_org['business_activity'] == 'College') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'ROUND(AVG(academics)) Academics',
                        'ROUND(AVG(faculty_teaching_quality)) Faculty_Teaching_Quality',
                        'ROUND(AVG(infrastructure)) Infrastructure',
                        'ROUND(AVG(accomodation_food)) Accomodation_Food',
                        'ROUND(AVG(placements_internships)) Placements_Internships',
                        'ROUND(AVG(social_life_extracurriculars)) Social_Life_Extracurriculars',
                        'ROUND(AVG(culture_diversity)) Culture_Diversity'
                    ]
                ];

                $options['condition'][] = ['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1];
                $options['condition'][] = ['in', 'reviewer_type', [2, 3]];


                $options['quant'] = 'one';

                $stats_students = $this->__unclaimedReviews($options);

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
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
                        'c.name profile'
                    ]
                ];

                $options['joins']['created_by'] = [
                    'alias' => 'b'
                ];

                $options['joins']['educational_stream'] = [
                    'alias' => 'c'
                ];


                $options['condition'][] = ['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1];
                $options['condition'][] = ['in', 'a.reviewer_type', [2, 3]];
                $options['user_id'] = $candidate->user_enc_id;
                $options['quant'] = 'all';

                $reviews_students = $this->__unclaimedReviews($options);


            } elseif ($unclaimed_org['business_activity'] == 'School') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'ROUND(AVG(student_engagement)) Student_Engagement',
                        'ROUND(AVG(school_infrastructure)) School_Infrastructure',
                        'ROUND(AVG(faculty)) Faculty',
                        'ROUND(AVG(accessibility_of_faculty)) Accessibility_Of_Faculty',
                        'ROUND(AVG(co_curricular_activities)) Co_Curricular_Activities',
                        'ROUND(AVG(leadership_development)) Leadership_Development',
                        'ROUND(AVG(sports)) Sports'
                    ]
                ];

                $options['condition'][] = ['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1];
                $options['condition'][] = ['in', 'reviewer_type', [4, 5]];

                $options['quant'] = 'one';

                $stats_students = $this->__unclaimedReviews($options);


                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.average_rating',
                        'a.student_engagement',
                        'a.school_infrastructure infrastructure',
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
                    ]
                ];

                $options['joins']['created_by'] = [
                    'alias' => 'b'
                ];

                $options['joins']['educational_stream'] = [
                    'alias' => 'c'
                ];

                $options['condition'][] = ['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1];
                $options['condition'][] = ['in', 'a.reviewer_type', [4, 5]];
                $options['user_id'] = $candidate->user_enc_id;
                $options['quant'] = 'all';

                $reviews_students = $this->__unclaimedReviews($options);


            } elseif ($unclaimed_org['business_activity'] == 'Educational Institute') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'ROUND(AVG(student_engagement)) Student_Engagement',
                        'ROUND(AVG(school_infrastructure)) School_Infrastructure',
                        'ROUND(AVG(faculty)) Faculty',
                        'ROUND(AVG(value_for_money)) Value_For_Money',
                        'ROUND(AVG(teaching_style)) Teaching_Style',
                        'ROUND(AVG(coverage_of_subject_matter)) Coverage_Of_Subject_Matter',
                        'ROUND(AVG(accessibility_of_faculty)) Accessibility_Of_Faculty'
                    ]
                ];

                $options['condition'][] = ['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1];
                $options['condition'][] = ['in', 'reviewer_type', [6, 7]];

                $options['quant'] = 'one';

                $stats_students = $this->__unclaimedReviews($options);

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
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
                    ]
                ];

                $options['joins']['created_by'] = [
                    'alias' => 'b'
                ];

                $options['joins']['educational_stream'] = [
                    'alias' => 'c'
                ];


                $options['condition'][] = ['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1];
                $options['condition'][] = ['in', 'a.reviewer_type', [6, 7]];
                $options['user_id'] = $candidate->user_enc_id;
                $options['quant'] = 'all';

                $reviews_students = $this->__unclaimedReviews($options);

            }
            if ($candidate->user_enc_id) {
                $follow = UnclaimedFollowedOrganizations::find()
                    ->select('followed')
                    ->where(['created_by' => $candidate->user_enc_id, 'organization_enc_id' => $unclaimed_org['organization_enc_id']])
                    ->asArray()
                    ->one();
            }
            $org = $unclaimed_org;

            $data['org_detail'] = $org;
            $data['reviews'] = $emp_reviews;
            $data['follow'] = $follow;
            if ($data['follow'] == null) {
                $data['follow'] = $follow = [];
            }
            $data['overall_rating'] = $emp_stats;
            $data['student_overall_rating'] = $stats_students;
            $data['student_reviews'] = $reviews_students;

            if ($org['business_activity'] == 'College' || $org['business_activity'] == 'School' || $org['business_activity'] == 'Educational Institute') {
                if (!empty($data)) {
                    return $this->response(200, $data);
                } else {
                    return $this->response(404);
                }
            }
        } else {
            return $this->response(404);
        }
    }

    public function actionReviewFields()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        $data = [];

        if (isset($parameters['org_enc_id']) && !empty($parameters['org_enc_id'])) {
            $org_enc_id = $parameters['org_enc_id'];
        } else {
            return $this->response(422);
        }

        $org = Organizations::find()
            ->select(['organization_enc_id', 'slug', 'initials_color', 'name', 'website', 'email', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
            ->where(['organization_enc_id' => $org_enc_id, 'is_deleted' => 0])
            ->asArray()
            ->one();

        $unclaimed_org = UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'b.business_activity', 'a.slug', 'a.initials_color', 'a.name', 'a.website', 'a.email', 'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE NULL END logo'])
            ->joinWith(['organizationTypeEnc b'], false)
            ->where([
                'a.organization_enc_id' => $org_enc_id,
                'a.status' => 1
            ])
            ->asArray()
            ->one();

        if (!empty($org)) {
            $review_type = 'claimed';
            $reviews = OrganizationReviews::find()
                ->alias('a')
                ->select([])
                ->select([
                    'a.job_security Job_Security',
                    'a.growth Career_Growth',
                    'a.organization_culture Company_Culture',
                    'a.compensation Salary_And_Benefits',
                    'a.work Work_Satisfaction',
                    'a.work_life Work_Life_Balance',
                    'a.skill_development Skill_Development',
                ])
                ->where(['a.organization_enc_id' => $org['organization_enc_id'], 'a.status' => 1])
                ->joinWith(['createdBy b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->joinWith(['organizationReviewLikeDislikes d'], false)
                ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . $candidate->user_enc_id . '") DESC, a.created_on DESC')])
                ->asArray()
                ->all();

            $data['reviews'] = $reviews;

            if (!empty($data)) {
                return $this->response(200, $data);
            } else {
                return $this->response(404);
            }

        } elseif (!empty($unclaimed_org)) {
            $review_type = 'unclaimed';


            $options = [];
            $options['main'] = [
                'alias' => 'a',
                'selections' => [
                    'a.job_security Job_Security',
                    'a.growth Career_Growth',
                    'a.organization_culture Company_Culture',
                    'a.compensation Salary_And_Benefits',
                    'a.work Work_Satisfaction',
                    'a.work_life Work_Life_Balance',
                    'a.skill_development Skill_Development',
                ]
            ];

            $options['joins']['created_by'] = [
                'alias' => 'b'
            ];

            $options['joins']['category'] = [
                'alias' => 'c'
            ];

            $options['joins']['designation'] = [
                'alias' => 'd'
            ];

            $options['condition'][] = ['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1];
            $options['condition'][] = ['in', 'a.reviewer_type', [0, 1]];

            $options['user_id'] = $candidate->user_enc_id;

            $options['quant'] = 'all';

            $emp_reviews = $this->__unclaimedReviews($options);

            if ($unclaimed_org['business_activity'] == 'College') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.academics Academics',
                        'a.faculty_teaching_quality Faculty_Teaching_Quality',
                        'a.infrastructure Infrastructure',
                        'a.accomodation_food Accomodation_Food',
                        'a.placements_internships Placements_Internships',
                        'a.social_life_extracurriculars Social_Life_Extracurriculars',
                        'a.culture_diversity Culture_Diversity',
                    ]
                ];

                $options['joins']['created_by'] = [
                    'alias' => 'b'
                ];

                $options['joins']['educational_stream'] = [
                    'alias' => 'c'
                ];


                $options['condition'][] = ['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1];
                $options['condition'][] = ['in', 'a.reviewer_type', [2, 3]];
                $options['user_id'] = $candidate->user_enc_id;
                $options['quant'] = 'all';

                $reviews_students = $this->__unclaimedReviews($options);


            } elseif ($unclaimed_org['business_activity'] == 'School') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.student_engagement Student_Engagement',
                        'a.school_infrastructure School_Infrastructure',
                        'a.faculty Faculty',
                        'a.accessibility_of_faculty Accessibility_Of_Faculty',
                        'a.co_curricular_activities Co_Curricular_Activities',
                        'a.leadership_development Leadership_Development',
                        'a.sports Sports',
                    ]
                ];

                $options['joins']['created_by'] = [
                    'alias' => 'b'
                ];

                $options['joins']['educational_stream'] = [
                    'alias' => 'c'
                ];

                $options['condition'][] = ['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1];
                $options['condition'][] = ['in', 'a.reviewer_type', [4, 5]];
                $options['user_id'] = $candidate->user_enc_id;
                $options['quant'] = 'all';

                $reviews_students = $this->__unclaimedReviews($options);


            } elseif ($unclaimed_org['business_activity'] == 'Educational Institute') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.student_engagement Student_Engagement',
                        'a.school_infrastructure School_Infrastructure',
                        'a.faculty Faculty',
                        'a.value_for_money Value_For_Money',
                        'a.teaching_style Teaching_Style',
                        'a.coverage_of_subject_matter Coverage_Of_Subject_Matter',
                        'a.accessibility_of_faculty Accessibility_Of_Faculty',
                    ]
                ];

                $options['joins']['created_by'] = [
                    'alias' => 'b'
                ];

                $options['joins']['educational_stream'] = [
                    'alias' => 'c'
                ];


                $options['condition'][] = ['a.organization_enc_id' => $unclaimed_org['organization_enc_id'], 'a.status' => 1];
                $options['condition'][] = ['in', 'a.reviewer_type', [6, 7]];
                $options['user_id'] = $candidate->user_enc_id;
                $options['quant'] = 'all';

                $reviews_students = $this->__unclaimedReviews($options);

            }

            $org = $unclaimed_org;

            $data['reviews'] = $emp_reviews;
            $data['student_reviews'] = $reviews_students;

            if ($org['business_activity'] == 'College' || $org['business_activity'] == 'School' || $org['business_activity'] == 'Educational Institute') {
                if (!empty($data)) {
                    return $this->response(200, $data);
                } else {
                    return $this->response(404);
                }
            }
        } else {
            return $this->response(404);
        }
    }

    public function actionLikeDislike()
    {

        $parameters = Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['review_enc_id']) && !empty($parameters['review_enc_id'])) {
            $review_enc_id = $parameters['review_enc_id'];
        } else {
            return $this->response(422);
        }

        if (isset($parameters['value']) && !empty($parameters['value'])) {
            $value = $parameters['value'];
            if ($value == 'zero' || $value == 'one') {
                if ($value == 'zero') {
                    $val = 0;
                } elseif ($value == 'one') {
                    $val = 1;
                }
            } else {
                return $this->response(422);
            }
        } else {
            return $this->response(422);
        }

        $chk = OrganizationReviewLikeDislike::find()
            ->select(['feedback_type'])
            ->where(['created_by' => $candidate->user_enc_id, 'review_enc_id' => $review_enc_id])
            ->asArray()
            ->one();

        if ($chk == null) {

            $model = new OrganizationReviewLikeDislike();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->feedback_enc_id = $utilitiesModel->encrypt();
            $model->feedback_type = $val;
            $model->review_enc_id = $review_enc_id;
            $model->created_by = $candidate->user_enc_id;
            $model->created_on = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->response(201);
            } else {
                return $this->response(500);
            }
        } elseif ($chk) {
            $chkk = OrganizationReviewLikeDislike::find()
                ->select(['*'])
                ->where(['created_by' => $candidate->user_enc_id, 'review_enc_id' => $review_enc_id])
                ->one();

            $chkk->feedback_type = $val;
            $chkk->last_updated_on = date('Y-m-d H:i:s');
            $chkk->last_updated_by = $candidate->user_enc_id;

            if ($chkk->update()) {
                return $this->response(201);
            } else {
                return $this->response(500);
            }
        } else {
            return $this->response(500);
        }

    }

    public function actionReport()
    {

        $parameters = Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['review_enc_id']) && !empty($parameters['review_enc_id'])) {
            $review_enc_id = $parameters['review_enc_id'];
        } else {
            return $this->response(422);
        }

        if (isset($parameters['value']) && !empty($parameters['value'])) {
            $value = (int)$parameters['value'];
            if ($value == 1 || $value == 2 || $value == 3 || $value == 4) {
                $val = $value;
            } else {
                return $this->response(422);
            }
        } else {
            return $this->response(422);
        }

        $chk = OrganizationReviewFeedback::find()
            ->select(['feedback_type', 'feedback'])
            ->where(['created_by' => $candidate->user_enc_id, 'review_enc_id' => $review_enc_id, 'is_deleted' => 0])
            ->asArray()
            ->one();

        if (empty($chk)) {

            $model = new OrganizationReviewFeedback();

            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->feedback_enc_id = $utilitiesModel->encrypt();
            $model->review_enc_id = $review_enc_id;
            $model->feedback_type = 1;
            $model->feedback = $val;
            $model->user_enc_id = $candidate->user_enc_id;
            $model->created_on = date('Y-m-d H:i:s');
            $model->created_by = $candidate->user_enc_id;

            if ($model->save()) {
                return $this->response(201);
            } else {
                return $this->response(500);
            }
        } elseif ($chk) {

            $chkk = OrganizationReviewFeedback::find()
                ->select(['*'])
                ->where(['created_by' => $candidate->user_enc_id, 'review_enc_id' => $review_enc_id, 'is_deleted' => 0])
                ->one();

            $chkk->feedback = $val;
            $chkk->last_updated_on = date('Y-m-d H:i:s');
            $chkk->last_updated_by = $candidate->user_enc_id;

            if ($chkk->update()) {
                return $this->response(201);
            } else {
                return $this->response(500);
            }

        } else {
            return $this->response(500);
        }

    }

    public function actionWriteClaimedOrgReview()
    {

        $candidate = $this->userId();

        $model = new Reviews(['scenario'=>'employee-review']);


        if ($model->load(\Yii::$app->request->post(), '')) {

            if ($model->validate()) {
                $avg_rating = null;
                $current_emp = null;
                $show_user_detail = null;

                if ($model->current_employee == 'one') {
                    $current_emp = 1;
                } elseif ($model->current_employee == 'zero') {
                    $current_emp = 0;
                }

                if ($model->user_detail == 'one') {
                    $show_user_detail = 1;
                } elseif ($model->user_detail == 'zero') {
                    $show_user_detail = 0;
                }

                $rating = [$model->skill_development + $model->work_life_balance + $model->salary_benefits + $model->company_culture + $model->job_security + $model->career_growth + $model->work_satisfaction];
                $avg_rating = array_sum($rating) / 7;
                $avg_rating = number_format($avg_rating, 2);

                $chk = OrganizationReviews::find()
                    ->select(['*'])
                    ->where(['organization_enc_id' => $model->org_enc_id, 'created_by' => $candidate->user_enc_id])
                    ->asArray()
                    ->one();

                if (!empty($chk)) {
                    return $this->response(409);
                }


                $data = new OrganizationReviews();

                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $data->review_enc_id = $utilitiesModel->encrypt();
                $data->organization_enc_id = $model->org_enc_id;
                $data->average_rating = $avg_rating;
                $data->is_current_employee = $current_emp;
                $data->skill_development = $model->skill_development;
                $data->work_life = $model->work_life_balance;
                $data->compensation = $model->salary_benefits;
                $data->organization_culture = $model->company_culture;
                $data->job_security = $model->job_security;
                $data->growth = $model->career_growth;
                $data->work = $model->work_satisfaction;
                $data->city_enc_id = $model->location;
                $data->category_enc_id = $this->__addCategory($model->department);
                $data->designation_enc_id = $this->__addDesignation($model->designation);
                $data->likes = $model->like;
                $data->dislikes = $model->dislike;
                $data->from_date = $model->from;
                if ($model->to) {
                    $data->to_date = $model->to;
                }
                $data->show_user_details = $show_user_detail;
                $data->created_by = $candidate->user_enc_id;
                $data->created_on = date('Y-m-d H:i:s');
                $data->status = 1;
                if ($data->save()) {
                    return $this->response(201);
                } else {
                    return $this->response(500);
                }
            }else{
                return $this->response(422);
            }
        } else {
            return $this->response(422);
        }
    }

    private function __addCategory($name)
    {

        $candidate = $this->userId();

        $cat = Categories::find()
            ->select(['category_enc_id', 'name'])
            ->where(['name' => $name])
            ->asArray()
            ->one();

        if (!empty($cat)) {
            return $cat['category_enc_id'];
        } else {
            $model = new Categories();

            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->category_enc_id = $utilitiesModel->encrypt();
            $model->name = $name;
            $utilitiesModel->variables['name'] = $name;
            $utilitiesModel->variables['table_name'] = Categories::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $model->slug = $utilitiesModel->create_slug();
            $model->created_by = $candidate->user_enc_id;
            $model->created_on = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $model->category_enc_id;
            } else {
                return $this->response(500);
            }
        }
    }

    private function __addDesignation($designation)
    {

        $candidate = $this->userId();

        $des = Designations::find()
            ->select(['designation_enc_id', 'designation'])
            ->where(['designation' => $designation])
            ->asArray()
            ->one();

        if (!empty($des)) {
            return $des['designation_enc_id'];
        } else {
            $model = new Designations();

            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->designation_enc_id = $utilitiesModel->encrypt();
            $model->designation = $designation;
            $utilitiesModel->variables['name'] = $designation;
            $utilitiesModel->variables['table_name'] = Designations::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $model->slug = $utilitiesModel->create_slug();
            $model->created_on = date('Y-m-d H:i:s');
            $model->created_by = $candidate->user_enc_id;
            if ($model->save()) {
                return $model->designation_enc_id;
            } else {
                return $this->response(500);
            }
        }

    }

    public function actionWriteUnclaimedOrgReview(){

        $candidate = $this->userId();

        $model = new Reviews(['scenario'=>'unclaimed_employee_review']);

        if ($model->load(\Yii::$app->request->post(), '')) {

            if ($model->validate()) {
                $avg_rating = null;
                $reviewer_type = null;
                $show_user_detail = null;

                if ($model->current_employee == 'zero') {
                    $reviewer_type = 0;
                } else {
                    $reviewer_type = $model->current_employee;
                }

                if ($model->user_detail == 'one') {
                    $show_user_detail = 1;
                } elseif ($model->user_detail == 'zero') {
                    $show_user_detail = 0;
                }

                $rating = [$model->skill_development, $model->work_life_balance, $model->salary_benefits , $model->company_culture , $model->job_security , $model->career_growth , $model->work_satisfaction];
                $avg_rating = array_sum($rating) / 7;
                $avg_rating = number_format($avg_rating, 2);

                $chk = OrganizationReviews::find()
                    ->select(['*'])
                    ->where(['organization_enc_id' => $model->org_enc_id, 'created_by' => $candidate->user_enc_id])
                    ->asArray()
                    ->one();

                if (!empty($chk)) {
                    return $this->response(409);
                }else{
                    print_r($model);
                }

            }else{
                return $this->response(422);
            }
        } else {
            return $this->response(422);
        }

    }

    private function __saveData($options,$model){

        $data = new NewOrganizationReviews();

        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $data->review_enc_id = $utilitiesModel->encrypt();
        $data->organization_enc_id = $model->org_enc_id;
        $data->average_rating = $model;
        $data->reviewer_type = '';
        $data->city_enc_id = '';
        $data->likes = '';
        $data->dislikes = '';
        $data->from_date = '';
        $data->to_date = '';
        $data->show_user_details = '';
        $data->created_by = '';
        $data->created_on = '';
        $options;
        print_r($data);
        die();
        if($data->save()){
            return $this->response(201);
        }



    }

    private function __eduStream($name){

        $chk = Qualifications::find()
            ->select(['qualification_enc_id'])
            ->where(['name'=>$name])
            ->asArray()
            ->one();

        if(!empty($chk)){
            return $chk['qualification_enc_id'];
        }else{
            $model = new Qualifications();

            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->qualification_enc_id = $utilitiesModel->encrypt();
            $model->name = $name;
            $utilitiesModel->variables['name'] = $name;
            $utilitiesModel->variables['table_name'] = Qualifications::tableName();
            $utilitiesModel->variables['field_name'] = 'slug';
            $model->slug = $utilitiesModel->create_slug();
            if($model->save()){
                return $model->qualification_enc_id;
            }else{
                return $this->response(500);
            }
        }

    }

}