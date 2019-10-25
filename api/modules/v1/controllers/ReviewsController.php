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
                'reviews',
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

    //Global query to get unclaimed org data
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

    //get organization reviews
    public function actionReview()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        $data = [];

        //check parameter is empty or not
        if (isset($parameters['org_enc_id']) && !empty($parameters['org_enc_id'])) {
            $org_enc_id = $parameters['org_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }


        //if parameter not empty then find data of organization claimed
        $org = Organizations::find()
            ->select(['organization_enc_id', 'slug', 'initials_color', 'name', 'website', 'email', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
            ->where(['organization_enc_id' => $org_enc_id, 'is_deleted' => 0])
            ->asArray()
            ->one();


        //if parameter not empty then find data of organization un_claimed
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
            if ($candidate->user_enc_id) {
                $follow = FollowedOrganizations::find()
                    ->select('followed')
                    ->where(['created_by' => $candidate->user_enc_id, 'organization_enc_id' => $org['organization_enc_id']])
                    ->one();

                $hasReviewed = OrganizationReviews::find()
                    ->select(['organization_enc_id'])
                    ->where(['organization_enc_id' => $org['organization_enc_id'], 'created_by' => $candidate->user_enc_id])
                    ->exists();
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

            $overall = OrganizationReviews::find()
                ->select(['ROUND(average_rating) average_rating', 'COUNT(review_enc_id) reviews_cnt'])
                ->where(['organization_enc_id' => $org['organization_enc_id'], 'status' => 1, 'is_deleted' => 0])
                ->asArray()
                ->one();

            $data['org_detail'] = $org;
            if ($follow->followed == 1) {
                $data['follow'] = true;
            } else {
                $data['follow'] = false;
            }
            $data['hasReviewed'] = $hasReviewed;
            $data['total_reviewers'] = $overall['reviews_cnt'];
            $data['reviews_count'] = $overall['average_rating'];
            $data['overall_rating'] = $stats;

            if (!empty($data)) {
                return $this->response(200, $data);
            } else {
                return $this->response(404, 'Not Found');
            }
        } elseif (!empty($unclaimed_org)) {
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

            }

            if ($candidate->user_enc_id) {
                $follow = UnclaimedFollowedOrganizations::find()
                    ->select('followed')
                    ->where(['created_by' => $candidate->user_enc_id, 'organization_enc_id' => $unclaimed_org['organization_enc_id']])
                    ->one();

                $hasReviewed = NewOrganizationReviews::find()
                    ->select(['organization_enc_id'])
                    ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'created_by' => $candidate->user_enc_id])
                    ->exists();

                if ($hasReviewed) {

                    $type = NewOrganizationReviews::find()
                        ->select(['reviewer_type'])
                        ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'created_by' => $candidate->user_enc_id])
                        ->asArray()
                        ->one();

                    $type = $type['reviewer_type'];

                    if ($type == 0 || $type == 1) {
                        $reviewed_in = 'company';
                    } elseif ($type == 2 || $type == 3) {
                        $reviewed_in = 'college';
                    } elseif ($type == 4 || $type == 5) {
                        $reviewed_in = 'school';
                    } elseif ($type == 6 || $type == 7) {
                        $reviewed_in = 'institute';
                    }
                }
            }

            $overall = NewOrganizationReviews::find()
                ->select(['ROUND(average_rating) average_rating', 'COUNT(review_enc_id) reviews_cnt'])
                ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'status' => 1, 'is_deleted' => 0])
                ->asArray()
                ->one();


            $org = $unclaimed_org;

            $data['overall_rating'] = $emp_stats;
            $data['student_overall_rating'] = $stats_students;
            $data['org_detail'] = $org;
            $data['total_reviewers'] = $overall['reviews_cnt'];
            $data['reviews_count'] = $overall['average_rating'];
            $data['follow'] = $follow->followed;
            $data['hasReviewed'] = $hasReviewed;
            $data['review_type'] = $reviewed_in;
            if ($org['business_activity'] == 'College' || $org['business_activity'] == 'School' || $org['business_activity'] == 'Educational Institute') {
                if (!empty($data)) {
                    return $this->response(200, $data);
                } else {
                    return $this->response(404, 'Not Found');
                }
            }
        } else {
            return $this->response(404, 'Not Found');
        }
    }

    public function actionReviews()
    {
        $parameters = \Yii::$app->request->post();
        $candidate = $this->userId();

        $data = [];

        //check parameter is empty or not
        if (isset($parameters['org_enc_id']) && !empty($parameters['org_enc_id'])) {
            $org_enc_id = $parameters['org_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        if (isset($parameters['limit']) && !empty($parameters['limit'])) {
            $limit = $parameters['limit'];
        }

        //if parameter not empty then find data of organization claimed
        $org = Organizations::find()
            ->select(['organization_enc_id', 'slug', 'initials_color', 'name', 'website', 'email', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
            ->where(['organization_enc_id' => $org_enc_id, 'is_deleted' => 0])
            ->asArray()
            ->one();


        //if parameter not empty then find data of organization un_claimed
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

        //if claimed organization true then get all reviews data of organization
        if (!empty($org)) {

            $reviews = OrganizationReviews::find()
                ->alias('a')
                ->distinct()
                ->where(['a.organization_enc_id' => $org_enc_id, 'a.status' => 1])
                ->joinWith(['createdBy b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->joinWith(['organizationReviewLikeDislikes d' => function ($d) use($candidate) {
                    $d->onCondition(['d.created_by' => $candidate->user_enc_id]);
                }], false)
                ->joinWith(['organizationReviewFeedbacks f'=>function($f) use($candidate){
                    $f->onCondition(['f.created_by' => $candidate->user_enc_id]);
                }],false)
                ->joinWith(['designationEnc e'], false);
            $reviews->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . $candidate->user_enc_id . '") DESC, a.created_on DESC')]);
            if ($limit) {
                $reviews->limit($limit);
            }
            $rating = $reviews->Select([
                'a.job_security Job_Security',
                'a.growth Career_Growth',
                'a.organization_culture Company_Culture',
                'a.compensation Salary_And_Benefits',
                'a.work Work_Satisfaction',
                'a.work_life Work_Life_Balance',
                'a.skill_development Skill_Development',
                ])->asArray()->all();
            $result = $reviews->Select([
                'a.show_user_details',
                'a.review_enc_id',
                'ROUND(a.average_rating) average_rating',
                'c.name profile',
                'e.designation',
                'f.feedback report',
                'd.feedback_type',
                'a.created_on',
                'a.is_current_employee reviewer_type',
                'a.likes',
                'a.dislikes',
                'a.from_date',
                'a.to_date',
                'a.created_by',
                'b.first_name',
                'b.last_name',
                'b.initials_color',
                'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END image'])->asArray()
                ->all();

            for ($i = 0; $i < count($result); $i++) {
                $result[$i]['rating'] = $rating[$i];
            }

            $data['reviews'] = $result;
            if (!empty($data)) {
                return $this->response(200, $data);
            } else {
                return $this->response(404, 'not found');
            }


        } elseif (!empty($unclaimed_org)) {

            if (isset($parameters['type']) && !empty($parameters['type'])) {
                $type = $parameters['type'];
            } else {
                return $this->response(422, 'Missing Information');
            }

            if ($type == 'employee') {
                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.average_rating',
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

                $emp_rating = $this->__unclaimedReviews($options);

                for ($i = 0; $i < count($emp_reviews); $i++) {
                    $emp_reviews[$i]['rating'] = $emp_rating[$i];
                }

                $data['reviews'] = $emp_reviews;

                if (!empty($data)) {
                    return $this->response(200, $data);
                } else {
                    return $this->response(404, 'Not Found');
                }
            }


            if ($unclaimed_org['business_activity'] == 'College' && $type == 'student') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.average_rating',
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

                $rating_students = $this->__unclaimedReviews($options);

                for ($i = 0; $i < count($reviews_students); $i++) {
                    $reviews_students[$i]['rating'] = $rating_students[$i];
                }

            } elseif ($unclaimed_org['business_activity'] == 'School' && $type == 'student') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.average_rating',
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
                $options['condition'][] = ['in', 'a.reviewer_type', [4, 5]];
                $options['user_id'] = $candidate->user_enc_id;
                $options['quant'] = 'all';

                $reviews_students = $this->__unclaimedReviews($options);

                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.student_engagement Student_Engagement',
                        'a.school_infrastructure Infrastructure',
                        'a.faculty Faculty',
                        'a.accessibility_of_faculty Accessibility_Of_Faculty',
                        'a.co_curricular_activities Co_Curricular_Activities',
                        'a.leadership_development Leadership_Development',
                        'a.sports Sports',
                    ]
                ];

                $rating_students = $this->__unclaimedReviews($options);

                for ($i = 0; $i < count($reviews_students); $i++) {
                    $reviews_students[$i]['rating'] = $rating_students[$i];
                }

            } elseif ($unclaimed_org['business_activity'] == 'Educational Institute' && $type == 'student') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.average_rating',
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
                $options['condition'][] = ['in', 'a.reviewer_type', [6, 7]];
                $options['user_id'] = $candidate->user_enc_id;
                $options['quant'] = 'all';

                $reviews_students = $this->__unclaimedReviews($options);

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

                $rating_students = $this->__unclaimedReviews($options);

                for ($i = 0; $i < count($reviews_students); $i++) {
                    $reviews_students[$i]['rating'] = $rating_students[$i];
                }

            }

            $data['reviews'] = $reviews_students;

            if (!empty($data)) {
                return $this->response(200, $data);
            } else {
                return $this->response(404, 'Not Found');
            }


        } else {
            return $this->response(404, 'Not Found');
        }
    }

    //to perform useful or not useful action for review
    public function actionLikeDislike()
    {

        $parameters = Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['review_enc_id']) && !empty($parameters['review_enc_id'])) {
            $review_enc_id = $parameters['review_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
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
                return $this->response(422, 'Missing Information');
            }
        } else {
            return $this->response(422, 'Missing Information');
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
                return $this->response(201, 'Saved');
            } else {
                return $this->response(500, 'Not Saved');
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
                return $this->response(201, 'Saved');
            } else {
                return $this->response(500, 'Not Saved');
            }
        } else {
            return $this->response(500, 'Not Saved');
        }

    }

    //to report review
    public function actionReport()
    {

        $parameters = Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($parameters['review_enc_id']) && !empty($parameters['review_enc_id'])) {
            $review_enc_id = $parameters['review_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        if (isset($parameters['value']) && !empty($parameters['value'])) {
            $value = $parameters['value'];
            if ($value == 1 || $value == 2 || $value == 3 || $value == 4) {
                $val = $value;
            } else {
                return $this->response(422, 'Missing Information');
            }
        } else {
            return $this->response(422, 'Missing Information');
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
                return $this->response(201, 'Saved');
            } else {
                return $this->response(500, 'Not Saved');
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
                return $this->response(201, 'Saved');
            } else {
                return $this->response(500, 'Not Saved');
            }

        } else {
            return $this->response(500, 'Not Saved');
        }

    }

    //write claimed Organization review
    public function actionWriteClaimedOrgReview()
    {

        $p = Yii::$app->request->post();
        $candidate = $this->userId();

        //checking the type
        if (isset($p['type']) && !empty($p['type'])) {
            $type = $p['type'];
        } else {
            return $this->response(422, 'Missing Information');
        }

        //if employee review then save data if edit-employee-review then update data
        if ($type == 'employee_review') {
            $model = new Reviews(['scenario' => 'employee-review']);
        } elseif ('edit_employee_review') {
            $model = new Reviews(['scenario' => 'edit-employee-review']);
        }


        if ($model->load(\Yii::$app->request->post(), '')) {

            if ($model->validate()) {
                $avg_rating = null;

                $rating = [$model->skill_development_and_learning + $model->work_life_balance + $model->compensation_and_benefits + $model->company_culture + $model->job_security + $model->growth_and_opportunities + $model->work_satisfaction];
                $avg_rating = array_sum($rating) / 7;
                $avg_rating = number_format($avg_rating, 2);

                $chk = OrganizationReviews::find()
                    ->select(['*'])
                    ->where(['organization_enc_id' => $model->org_enc_id, 'created_by' => $candidate->user_enc_id])
                    ->one();

                //check if review already exists else save new record
                if (!empty($chk)) {
                    $chk->average_rating = $avg_rating;
                    $chk->skill_development = $model->skill_development_and_learning;
                    $chk->work_life = $model->work_life_balance;
                    $chk->compensation = $model->compensation_and_benefits;
                    $chk->organization_culture = $model->company_culture;
                    $chk->job_security = $model->job_security;
                    $chk->growth = $model->growth_and_opportunities;
                    $chk->work = $model->work_satisfaction;
                    $chk->likes = $model->like;
                    $chk->dislikes = $model->dislike;
                    $chk->show_user_details = $model->user_detail;
                    $chk->last_updated_by = $candidate->user_enc_id;
                    $chk->last_updated_on = date('Y-m-d H:i:s');
                    if ($chk->update()) {
                        return $this->response(201, 'Saved');
                    } else {
                        return $this->response(500, 'not saved');
                    }

                } else {

                    $data = new OrganizationReviews();

                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $data->review_enc_id = $utilitiesModel->encrypt();
                    $data->organization_enc_id = $model->org_enc_id;
                    $data->average_rating = $avg_rating;
                    $data->is_current_employee = $model->current_employee;
                    $data->skill_development = $model->skill_development_and_learning;
                    $data->work_life = $model->work_life_balance;
                    $data->compensation = $model->compensation_and_benefits;
                    $data->organization_culture = $model->company_culture;
                    $data->job_security = $model->job_security;
                    $data->growth = $model->growth_and_opportunities;
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
                    $data->show_user_details = $model->user_detail;
                    $data->created_by = $candidate->user_enc_id;
                    $data->created_on = date('Y-m-d H:i:s');
                    $data->status = 1;
                    if ($data->save()) {
                        return $this->response(201, 'Saved');
                    } else {
                        return $this->response(500, 'Not Saved');
                    }
                }
            } else {
                return $this->response(422, 'Missing Information');
            }
        } else {
            return $this->response(422, 'Missing Information');
        }
    }

    //add Category and get category_enc_id for reviews
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
                return $this->response(500, 'Not Saved');
            }
        }
    }

    //add designation and get designation_enc_id for reviews
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
                return $this->response(500, 'Not Saved');
            }
        }

    }

    //write unclaimed organization reviews
    public function actionWriteUnclaimedOrgReview()
    {
        $a = \Yii::$app->request->post();
        $candidate = $this->userId();

        //checking review type model
        if (isset($a['type']) && !empty($a['type'])) {
            if ($a['type'] == 'company') {
                $model = new Reviews(['scenario' => 'unclaimed_employee_review']);
            } elseif ($a['type'] == 'college') {
                $model = new Reviews(['scenario' => 'college']);
            } elseif ($a['type'] == 'school') {
                $model = new Reviews(['scenario' => 'school']);
            } elseif ($a['type'] == 'institute') {
                $model = new Reviews(['scenario' => 'edu_institute']);
            } elseif ($a['type'] == 'edit_company') {
                $model = new Reviews(['scenario' => 'edit_unclaimed_employee_review']);
            } elseif ($a['type'] == 'edit_college') {
                $model = new Reviews(['scenario' => 'edit_college']);
            } elseif ($a['type'] == 'edit_school') {
                $model = new Reviews(['scenario' => 'edit_school']);
            } elseif ($a['type'] == 'edit_institute') {
                $model = new Reviews(['scenario' => 'edit_edu_institute']);
            } else {
                return $this->response(422, 'Missing Information');
            }
        } else {
            return $this->response(422, 'Missing Information');
        }


        if ($model->load(\Yii::$app->request->post(), '')) {

            if ($model->validate()) {

                $options['user_enc_id'] = $candidate->user_enc_id;
                $options['org_enc_id'] = $model->org_enc_id;

                //checking user already reviewed or not
                $chk = NewOrganizationReviews::find()
                    ->select(['*'])
                    ->where(['organization_enc_id' => $model->org_enc_id, 'created_by' => $candidate->user_enc_id])
                    ->one();

                //if user review then update else save new record
                if (!empty($chk)) {
                    $save = $model->__updateData($options);
                    if ($save) {
                        return $this->response(201, 'Saved');
                    } else {
                        return $this->response(500, 'Not Saved');
                    }
                } else {
                    $save = $model->__saveData($options);
                    if ($save) {
                        return $this->response(201, 'Saved');
                    } else {
                        return $this->response(500, 'Not Saved');
                    }
                }

            } else {
                return $this->response(422, 'Missing Information');
            }
        } else {
            return $this->response(422, 'Missing Information');
        }
    }

    //show perticular review data to edit
    public function actionShowReview()
    {
        $a = \Yii::$app->request->post();
        $candidate = $this->userId();

        if (isset($a['org_enc_id']) && !empty($a['org_enc_id'])) {
            $org_enc_id = $a['org_enc_id'];
        } else {
            return $this->response(422, 'Missing information');
        }

        $org = Organizations::find()
            ->select(['organization_enc_id'])
            ->where(['organization_enc_id' => $org_enc_id, 'is_deleted' => 0])
            ->exists();

        $unclaimed_org = UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'b.business_activity'])
            ->joinWith(['organizationTypeEnc b'], false)
            ->where([
                'a.organization_enc_id' => $org_enc_id,
                'a.status' => 1
            ])
            ->asArray()
            ->one();

        if ($org) {
            $claimed_org_review = OrganizationReviews::find()
                ->alias('a')
                ->select([
                    'a.review_enc_id',
                    'a.organization_enc_id',
                    'a.show_user_details',
                    'a.skill_development Skill_Development_And_Learning',
                    'a.work_life Work_Life_Balance',
                    'a.compensation Compensation_And_Benefits',
                    'a.organization_culture Company_Culture',
                    'a.job_security Job_Security',
                    'a.growth Growth_And_Opportunities',
                    'a.work Work_Satisfaction',
                    'a.likes',
                    'a.dislikes',
                    'b.first_name',
                    'b.last_name'
                ])
                ->where(['a.organization_enc_id' => $org_enc_id, 'a.created_by' => $candidate->user_enc_id])
                ->joinWith(['createdBy b'], false)
                ->asArray()
                ->one();

            $sub_array = [];
            $data = [];
            if (!empty($claimed_org_review)) {
                foreach ($claimed_org_review as $key => $value) {
                    if ($key == 'review_enc_id' || $key == 'organization_enc_id' || $key == 'show_user_details' || $key == 'likes' || $key == 'dislikes' || $key == 'first_name' || $key == 'last_name') {
                        $sub_array[$key] = $value;
                    } else {
                        $data[$key] = $value;
                    }
                }
            }

            $sub_array['rating'] = $data;

            if (!empty($sub_array)) {
                return $this->response(200, $sub_array);
            }

        } elseif ($unclaimed_org) {
            $options = [];
            $options['main'] = [
                'alias' => 'a',
                'selections' => [
                    'a.review_enc_id',
                    'a.organization_enc_id',
                    'a.job_security Job_Security',
                    'a.growth Growth_And_Opportunities',
                    'a.organization_culture Company_Culture',
                    'a.compensation Compensation_And_Benefits',
                    'a.work Work_Satisfaction',
                    'a.work_life Work_Life_Balance',
                    'a.skill_development Skill_Development_And_Learning',
                    'a.likes',
                    'a.dislikes',
                    'a.show_user_details',
                    'b.first_name',
                    'b.last_name'
                ]
            ];

            $options['joins']['created_by'] = [
                'alias' => 'b'
            ];

            $options['condition'][] = ['a.organization_enc_id' => $org_enc_id, 'a.status' => 1, 'a.created_by' => $candidate->user_enc_id];
            $options['condition'][] = ['in', 'a.reviewer_type', [0, 1]];

            $options['quant'] = 'one';

            $reviews = $this->__unclaimedReviews($options);

            if ($unclaimed_org['business_activity'] == 'College') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.organization_enc_id',
                        'a.academics Academics',
                        'a.faculty_teaching_quality Faculty_And_Teaching_Quality',
                        'a.infrastructure Infrastructure',
                        'a.accomodation_food Accomodation_And_Food',
                        'a.placements_internships Placements_Internships',
                        'a.social_life_extracurriculars Social_Life_Extracurriculars',
                        'a.culture_diversity Culture_And_Diversity',
                        'a.likes',
                        'a.dislikes',
                        'a.show_user_details',
                        'a.reviewer_type',
                        'b.first_name',
                        'b.last_name'
                    ]
                ];

                $options['joins']['created_by'] = [
                    'alias' => 'b'
                ];

                $options['condition'][] = ['a.organization_enc_id' => $org_enc_id, 'a.status' => 1, 'a.created_by' => $candidate->user_enc_id];
                $options['condition'][] = ['in', 'a.reviewer_type', [2, 3]];
                $options['quant'] = 'one';

                $reviews = $this->__unclaimedReviews($options);


            } elseif ($unclaimed_org['business_activity'] == 'School') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.organization_enc_id',
                        'a.student_engagement Student_Engagement',
                        'a.school_infrastructure Infrastructure',
                        'a.faculty Faculty',
                        'a.accessibility_of_faculty Accessibility_Of_Faculty',
                        'a.co_curricular_activities Co_Curricular_Activities',
                        'a.leadership_development Leadership_Development',
                        'a.sports Sports',
                        'a.likes',
                        'a.dislikes',
                        'a.show_user_details',
                        'a.reviewer_type',
                        'b.first_name',
                        'b.last_name'
                    ]
                ];

                $options['joins']['created_by'] = [
                    'alias' => 'b'
                ];

                $options['condition'][] = ['a.organization_enc_id' => $org_enc_id, 'a.status' => 1, 'a.created_by' => $candidate->user_enc_id];
                $options['condition'][] = ['in', 'a.reviewer_type', [4, 5]];
                $options['quant'] = 'one';

                $reviews = $this->__unclaimedReviews($options);


            } elseif ($unclaimed_org['business_activity'] == 'Educational Institute') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.organization_enc_id',
                        'a.student_engagement Student_Engagement',
                        'a.school_infrastructure Infrastructure',
                        'a.faculty Faculty',
                        'a.value_for_money Value_For_Money',
                        'a.teaching_style Teaching_Style',
                        'a.coverage_of_subject_matter Coverage_Of_Subject_Matter',
                        'a.accessibility_of_faculty Accessibility_Of_Faculty',
                        'a.likes',
                        'a.dislikes',
                        'a.show_user_details',
                        'a.reviewer_type',
                        'b.first_name',
                        'b.last_name'
                    ]
                ];

                $options['joins']['created_by'] = [
                    'alias' => 'b'
                ];

                $options['condition'][] = ['a.organization_enc_id' => $org_enc_id, 'a.status' => 1, 'a.created_by' => $candidate->user_enc_id];
                $options['condition'][] = ['in', 'a.reviewer_type', [6, 7]];
                $options['quant'] = 'one';

                $reviews = $this->__unclaimedReviews($options);

            }

            $sub_array = [];
            $data = [];
            if (!empty($reviews)) {
                foreach ($reviews as $key => $value) {
                    if ($key == 'review_enc_id' || $key == 'organization_enc_id' || $key == 'show_user_details' || $key == 'likes' || $key == 'dislikes' || $key == 'reviewer_type' || $key == 'first_name' || $key == 'last_name') {
                        $sub_array[$key] = $value;
                    } else {
                        $data[$key] = $value;
                    }
                }
            } else {
                return $this->response(404, 'Not Found');
            }

            $sub_array['rating'] = $data;

            if (!empty($sub_array)) {
                return $this->response(200, $sub_array);
            } else {
                return $this->response(404, 'Not Found');
            }


        } else {
            return $this->response(404, 'Not Found');
        }

    }


}