<?php


namespace api\modules\v1\controllers;


use account\models\applications\ApplicationForm;
use api\modules\v1\models\Candidates;
use common\models\FollowedOrganizations;
use common\models\NewOrganizationReviews;
use common\models\OrganizationReviewFeedback;
use common\models\OrganizationReviewLikeDislike;
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
                    'ROUND(a.average_rating) average',
                    'c.name profile',
                    'd.feedback_type',
                    'a.created_on',
                    'a.is_current_employee',
                    'a.overall_experience',
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
                ->select(['ROUND(AVG(job_security)) job_security', 'ROUND(AVG(growth)) career_growth', 'ROUND(AVG(organization_culture)) company_culture', 'ROUND(AVG(compensation)) salary_and_benefits', 'ROUND(AVG(work)) work_satisfaction', 'ROUND(AVG(work_life)) work_life_balance', 'ROUND(AVG(skill_development)) skill_development'])
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
                    'ROUND(AVG(a.job_security)) job_security',
                    'ROUND(AVG(a.growth)) career_growth',
                    'ROUND(AVG(a.organization_culture)) company_culture',
                    'ROUND(AVG(a.compensation)) salary_and_benefits',
                    'ROUND(AVG(a.work)) work_satisfaction',
                    'ROUND(AVG(a.work_life)) work_life_balance',
                    'ROUND(AVG(a.skill_development)) skill_development'
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
                        'ROUND(AVG(academics)) academics',
                        'ROUND(AVG(faculty_teaching_quality)) faculty_teaching_quality',
                        'ROUND(AVG(infrastructure)) infrastructure',
                        'ROUND(AVG(accomodation_food)) accomodation_food',
                        'ROUND(AVG(placements_internships)) placements_internships',
                        'ROUND(AVG(social_life_extracurriculars)) social_life_extracurriculars',
                        'ROUND(AVG(culture_diversity)) culture_diversity'
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
                        'ROUND(AVG(student_engagement)) student_engagement',
                        'ROUND(AVG(school_infrastructure)) school_infrastructure',
                        'ROUND(AVG(faculty)) faculty',
                        'ROUND(AVG(accessibility_of_faculty)) accessibility_of_faculty',
                        'ROUND(AVG(co_curricular_activities)) co_curricular_activities',
                        'ROUND(AVG(leadership_development)) leadership_development',
                        'ROUND(AVG(sports)) sports'
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
                        'ROUND(AVG(student_engagement)) student_engagement',
                        'ROUND(AVG(school_infrastructure)) school_infrastructure',
                        'ROUND(AVG(faculty)) faculty',
                        'ROUND(AVG(value_for_money)) value_for_money',
                        'ROUND(AVG(teaching_style)) teaching_style',
                        'ROUND(AVG(coverage_of_subject_matter)) coverage_of_subject_matter',
                        'ROUND(AVG(accessibility_of_faculty)) accessibility_of_faculty'
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

    public function actionReviewFields(){
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
                    'a.job_security',
                    'a.growth career_growth',
                    'a.organization_culture company_culture',
                    'a.compensation salary_and_benefits',
                    'a.work work_satisfaction',
                    'a.work_life work_life_balance',
                    'a.skill_development',
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

            if ($unclaimed_org['business_activity'] == 'College') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.academics',
                        'a.faculty_teaching_quality',
                        'a.infrastructure',
                        'a.accomodation_food',
                        'a.placements_internships',
                        'a.social_life_extracurriculars',
                        'a.culture_diversity',
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
                        'a.student_engagement',
                        'a.school_infrastructure',
                        'a.faculty',
                        'a.accessibility_of_faculty',
                        'a.co_curricular_activities',
                        'a.leadership_development',
                        'a.sports',
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
                        'a.student_engagement',
                        'a.school_infrastructure',
                        'a.faculty',
                        'a.value_for_money',
                        'a.teaching_style',
                        'a.coverage_of_subject_matter',
                        'a.accessibility_of_faculty',
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

            $data['reviews'] = $reviews_students;

            if ($org['business_activity'] == 'College' || $org['business_activity'] == 'School' || $org['business_activity'] == 'Educational Institute') {
                if (!empty($data)) {
                    return $this->response(200, $data);
                } else {
                    return $this->response(404);
                }
            }
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
            $value = $parameters['value'];
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

        $parameters = Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['job_security']) && !empty($parameters['job_security'])) {
            $job_security = $parameters['job_security'];
        } else {
            return $this->response(422);
        }

        return $this->response(200, $job_security);

    }

}