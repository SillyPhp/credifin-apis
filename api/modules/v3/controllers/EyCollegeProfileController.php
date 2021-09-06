<?php


namespace api\modules\v3\controllers;


use common\models\AssignedCollegeCourses;
use common\models\ClaimServiceableLocations;
use common\models\CollegeCutoff;
use common\models\CollegeFaculty;
use common\models\CollegeInfrastructureDetail;
use common\models\CollegePlacementHighlights;
use common\models\CollegeRecruitmentByCourse;
use common\models\CollegeScholarships;
use common\models\FollowedOrganizations;
use common\models\NewOrganizationReviews;
use common\models\OrganizationReviewFeedback;
use common\models\OrganizationReviewLikeDislike;
use common\models\OrganizationReviews;
use common\models\Organizations;
use common\models\UnclaimedFollowedOrganizations;
use common\models\UnclaimedOrganizations;
use Yii;
use yii\web\Response;
use yii\helpers\Url;
use yii\rest\Controller;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\models\Utilities;

class EyCollegeProfileController extends ApiBaseController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'college-detail' => ['POST', 'OPTIONS'],
            ]
        ];
        return $behaviors;
    }

    public function actionCollegeDetail()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $college_detail = Organizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', 'a.email', 'a.name', 'a.website website_link', 'b.affiliated_to', 'b1.name city_name', 'a.phone',
                'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo',
                'b.accredited_to', 'b.entrance_exam', 'b.total_programs', 'b.popular_course', 'b.top_recruiter', 'b.brochure', 'b.established_in', 'b.university_type', 'b.application_mode', 'b.fees', 'a.description'
            ])
            ->joinWith(['organizationOtherDetails b' => function ($b) {
                $b->joinWith(['locationEnc b1']);
            }], false)
            ->where(['a.slug' => $params['slug'], 'a.status' => 'Active', 'a.is_deleted' => 0])
            ->asArray()
            ->one();

        if (!$college_detail) {
            $unclaimed = UnclaimedOrganizations::find()
                ->alias('a')
                ->select(['a.organization_enc_id', 'a.email', 'a.name', 'a.website website_link', 'b.name city_name', 'a.phone',
                    'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo'
                ])
                ->joinWith(['cityEnc b'], false)
                ->where(['a.slug' => $params['slug'], 'a.status' => 1, 'a.is_deleted' => 0,])
                ->asArray()
                ->one();

            if ($unclaimed) {
                $unclaimed['website'] = $this->get_domain($unclaimed['website_link']);
                return $this->response(200, ['status' => 200, 'data' => $unclaimed]);
            }
        }

        if ($college_detail) {
            $college_detail['website'] = $this->get_domain($college_detail['website_link']);
            return $this->response(200, ['status' => 200, 'data' => $college_detail]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);
    }

    function get_domain($url)
    {
        $charge = explode('/', $url);
        $charge = $charge[2]; //assuming that the url starts with http:// or https://
        return $charge;
    }

    public function actionCourses()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $college = Organizations::find()
            ->where(['slug' => $params['slug']])
            ->one();

        $courses = AssignedCollegeCourses::find()
            ->distinct()
            ->alias('a')
            ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.organization_enc_id college_id', 'a.course_duration', 'a.type',
                'd.fees', 'd.registration_fee', 'd.selection_process', 'd.eligibility_criteria', 'd.other_details', 'd.scholarship_enc_id',
                'd1.title scholarship_title'
            ])
            ->joinWith(['courseEnc c'], false)
            ->joinWith(['collegeAdmissionDetails d' => function ($d) {
                $d->joinWith(['scholarshipEnc d1'], false);
            }], false)
            ->where(['a.organization_enc_id' => $college->organization_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();
        if ($courses) {
            return $this->response(200, ['status' => 200, 'courses' => $courses]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionScholarships()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $college = Organizations::find()
            ->where(['slug' => $params['slug']])
            ->one();

        $scholarships = CollegeScholarships::find()
            ->select(['college_scholarship_enc_id', 'title', 'amount', 'detail', 'apply_link'])
            ->where(['college_enc_id' => $college->organization_enc_id, 'is_deleted' => 0])
            ->asArray()
            ->all();

        if ($scholarships) {
            return $this->response(200, ['status' => 200, 'scholarships' => $scholarships]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionCutOff()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $college = Organizations::find()
            ->where(['slug' => $params['slug']])
            ->one();

        $cutoffs = CollegeCutoff::find()
            ->alias('a')
            ->select(['a.college_cut_off_enc_id', 'a.assgined_course_enc_id', 'c.course_name', 'a.college_enc_id', 'a.general', 'a.obc',
                'a.sc', 'a.st', 'a.pwd', 'a.ews', 'a.mode'])
            ->joinWith(['assginedCourseEnc b' => function ($b) {
                $b->joinWith(['courseEnc c']);
            }], false)
            ->where(['a.is_deleted' => 0, 'a.college_enc_id' => $college->organization_enc_id,])
            ->asArray()
            ->all();

        if ($cutoffs) {
            return $this->response(200, ['status' => 200, 'cutoff' => $cutoffs]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionFaculty()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $college = Organizations::find()
            ->where(['slug' => $params['slug']])
            ->one();

        $faculty = CollegeFaculty::find()
            ->alias('a')
            ->select(['a.college_faculty_enc_id', 'a.faculty_name', 'a.experience', 'b.designation', 'c.name department',
                'CASE WHEN a.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->collegeProfile->faculty_image, 'https') . '", a.image_location, "/", a.image) ELSE NULL END image'])
            ->joinWith(['designationEnc b'], false)
            ->joinWith(['departmentEnc c'], false)
            ->where(['a.is_deleted' => 0, 'a.college_enc_id' => $college->organization_enc_id])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->asArray()
            ->all();

        if ($faculty) {
            return $this->response(200, ['status' => 200, 'faculty_list' => $faculty]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionInfrastructure()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $college = Organizations::find()
            ->where(['slug' => $params['slug']])
            ->one();

        $list = CollegeInfrastructureDetail::find()
            ->alias('a')
            ->select(['a.college_infrastructure_detail_enc_id', 'a.college_infrastructure_enc_id',
                'a.description', 'b.infra_name',
                'CASE WHEN b.icon IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->collegeProfile->infrastructure_icon, 'https') . '", b.icon_location, "/", b.icon) ELSE NULL END icon',])
            ->joinWith(['collegeInfrastructureEnc b'], false)
            ->where(['a.college_enc_id' => $college->organization_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();

        if ($list) {
            return $this->response(200, ['status' => 200, 'list' => $list]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionPlacementHighlights()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $college = Organizations::find()
            ->where(['slug' => $params['slug']])
            ->one();

        $highlights = CollegePlacementHighlights::find()
            ->select(['college_placement_highlight_enc_id', 'companies_visited', 'top_recruiter', 'companies_offering_dream_packages',
                'highest_stipend_offered', 'highest_placement_package'])
            ->where(['college_enc_id' => $college->organization_enc_id])
            ->asArray()
            ->one();

        if ($highlights) {
            return $this->response(200, ['status' => 200, 'highlights' => $highlights]);
        }

        return $this->response(404, ['status' => 404, 'not found']);

    }

    public function actionCourseRecruitments()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $college = Organizations::find()
            ->where(['slug' => $params['slug']])
            ->one();

        $recruitments = CollegeRecruitmentByCourse::find()
            ->alias('a')
            ->select(['a.college_recruitment_by_course_enc_id', 'a.assigned_course_enc_id', 'a.average_package', 'a.highest_package', 'a.total_offers',
                'a.students_placed', 'a.companies_visiting', 'b1.course_name'])
            ->joinWith(['assignedCourseEnc b' => function ($b) {
                $b->joinWith(['courseEnc b1'], false);
            }], false)
            ->where(['a.is_deleted' => 0, 'a.college_enc_id' => $college->organization_enc_id])
            ->asArray()
            ->all();

        if ($recruitments) {
            return $this->response(200, ['status' => 200, 'recruitments' => $recruitments]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

    }

    public function actionLoanProviders()
    {
        $params = Yii::$app->request->post();

        if (!isset($params['slug']) && empty($params['slug'])) {
            return $this->response(422, ['status' => 422, 'message' => 'missing information']);
        }

        $loans = ClaimServiceableLocations::find()
            ->alias('a')
            ->select(['a.service_location_enc_id', 'a.organization_enc_id', 'c.name', 'c.email', 'c.phone', 'c.website'])
            ->joinWith(['claimCollegeEnc b'])
            ->joinWith(['organizationEnc c'])
            ->where(['b.slug' => $params['slug'], 'b.status' => 'Active', 'b.is_deleted' => 0, 'b.is_erexx_registered' => 1])
            ->asArray()
            ->all();

        if ($loans) {
            return $this->response(200, ['status' => 200, 'data' => $loans]);
        }

        return $this->response(404, ['status' => 404, 'message' => 'not found']);

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
        } elseif ($options['count'] == true) {
            $result = $primary_result->count();
        } else {
            $result = $primary_result
                ->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . $options['user_id'] . '") DESC, a.created_on DESC')])
                ->limit($options['limit'])
                ->offset(($options['page'] - 1) * $options['limit'])
                ->asArray()->all();
        }

        return $result;
    }

    public function actionReviews()
    {
        $parameters = \Yii::$app->request->post();

        $data = [];

        //check parameter is empty or not
        if (isset($parameters['org_enc_id']) && !empty($parameters['org_enc_id'])) {
            $org_enc_id = $parameters['org_enc_id'];
        } else {
            return $this->response(422, 'Missing Information');
        }


        //if parameter not empty then find data of organization claimed
        $org = Organizations::find()
            ->select(['organization_enc_id', '(CASE WHEN organization_enc_id IS NOT NULL THEN "claimed" END) as org_type', 'slug', 'initials_color', 'name', 'website', 'email',
                'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") END logo'])
            ->where(['organization_enc_id' => $org_enc_id, 'is_deleted' => 0])
            ->asArray()
            ->one();

        //if parameter not empty then find data of organization un_claimed
        $unclaimed_org = UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', '(CASE WHEN organization_enc_id IS NOT NULL THEN "unclaimed" END) as org_type', 'b.business_activity', 'a.slug', 'a.initials_color', 'a.name', 'a.website', 'a.email',
                'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo'])
            ->joinWith(['organizationTypeEnc b'], false)
            ->where([
                'a.organization_enc_id' => $org_enc_id,
                'a.status' => 1
            ])
            ->asArray()
            ->one();

        if (!empty($org)) {
            if (isset($parameters['user_enc_id']) && !empty($parameters['user_enc_id'])) {
                $follow = FollowedOrganizations::find()
                    ->select('followed')
                    ->where(['created_by' => $parameters['user_enc_id'], 'organization_enc_id' => $org['organization_enc_id']])
                    ->one();

                $hasReviewed = OrganizationReviews::find()
                    ->select(['organization_enc_id'])
                    ->where(['organization_enc_id' => $org['organization_enc_id'], 'created_by' => $parameters['user_enc_id']])
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

            if (!empty($stats)) {
                $overall_avg = array_sum($stats) / count($stats);
                $round_avg = round($overall_avg);

                $overall['average_rating'] = (string)$round_avg;
            }

            $user_id = $parameters['user_enc_id'];

            $data['org_detail'] = $org;
            if ($follow->followed == 1) {
                $data['follow'] = true;
            } else {
                $data['follow'] = false;
            }
            $data['hasReviewed'] = $hasReviewed;
            $data['total_reviewers'] = $overall['reviews_cnt'];
            $stats['average_count'] = $overall['average_rating'];
            $data['overall_rating'] = $stats;


            if (!empty($data)) {
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
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

            if (isset($parameters['user_enc_id']) && !empty($parameters['user_enc_id'])) {
                $follow = UnclaimedFollowedOrganizations::find()
                    ->select('followed')
                    ->where(['created_by' => $parameters['user_enc_id'], 'organization_enc_id' => $unclaimed_org['organization_enc_id']])
                    ->one();

                $hasReviewed = NewOrganizationReviews::find()
                    ->select(['organization_enc_id'])
                    ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'created_by' => $parameters['user_enc_id']])
                    ->exists();

                if ($hasReviewed) {

                    $type = NewOrganizationReviews::find()
                        ->select(['reviewer_type'])
                        ->where(['organization_enc_id' => $unclaimed_org['organization_enc_id'], 'created_by' => $parameters['user_enc_id']])
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

            if (!empty($emp_stats)) {
                $overall_avg = array_sum($emp_stats) / count($emp_stats);
                $round_avg = round($overall_avg);
            }
            if (!empty($stats_students)) {
                $student_overall_avg = array_sum($stats_students) / count($stats_students);
                $round_students_avg = round($student_overall_avg);
            }

            $overall['average_rating'] = (string)(($round_avg) ? $round_avg : $round_students_avg);

            $org = $unclaimed_org;

            $data['overall_rating'] = $emp_stats;
            $data['overall_rating']['average_count'] = $round_avg;
            if ($org['business_activity'] != 'Others' && $stats_students != null) {
                $data['student_overall_rating'] = $stats_students;
                $data['student_overall_rating']['average_count'] = $round_students_avg;
            }
            $data['org_detail'] = $org;
            $data['total_reviewers'] = $overall['reviews_cnt'];
            $data['reviews_count'] = $overall['average_rating'];
            $data['follow'] = $follow->followed == 1 ? true : false;
            $data['hasReviewed'] = $hasReviewed;
            $data['review_type'] = $reviewed_in;
            if (!empty($data)) {
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionUserReviews()
    {

        $parameters = \Yii::$app->request->post();

        $limit = 5;
        $page = 1;
        if (isset($parameters['limit']) && !empty($parameters['limit'])) {
            $limit = $parameters['limit'];
        }

        if (isset($parameters['page']) && !empty($parameters['page'])) {
            $page = (int)$parameters['page'];
        }

        //check parameter is empty or not
        if (isset($parameters['org_enc_id']) && !empty($parameters['org_enc_id'])) {
            $org_enc_id = $parameters['org_enc_id'];
        } else {
            return $this->response(422, 'Missing Information 1');
        }

        $user_id = $parameters['user_enc_id'];

        //if parameter not empty then find data of organization claimed
        $org = Organizations::find()
            ->select(['organization_enc_id', '(CASE WHEN organization_enc_id IS NOT NULL THEN "claimed" END) as org_type', 'slug', 'initials_color', 'name', 'website', 'email',
                'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", name, "&size=200&rounded=false&background=", REPLACE(initials_color, "#", ""), "&color=ffffff") END logo'])
            ->where(['organization_enc_id' => $org_enc_id, 'is_deleted' => 0])
            ->asArray()
            ->one();

        //if parameter not empty then find data of organization un_claimed
        $unclaimed_org = UnclaimedOrganizations::find()
            ->alias('a')
            ->select(['a.organization_enc_id', '(CASE WHEN organization_enc_id IS NOT NULL THEN "unclaimed" END) as org_type', 'b.business_activity', 'a.slug', 'a.initials_color', 'a.name', 'a.website', 'a.email',
                'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE CONCAT("https://ui-avatars.com/api/?name=", a.name, "&size=200&rounded=false&background=", REPLACE(a.initials_color, "#", ""), "&color=ffffff") END logo'])
            ->joinWith(['organizationTypeEnc b'], false)
            ->where([
                'a.organization_enc_id' => $org_enc_id,
                'a.status' => 1
            ])
            ->asArray()
            ->one();

        if ($org) {
            $reviews = OrganizationReviews::find()
                ->alias('a')
                ->where(['a.organization_enc_id' => $org_enc_id, 'a.status' => 1])
                ->joinWith(['createdBy b'], false)
                ->joinWith(['categoryEnc c'], false)
                ->joinWith(['organizationReviewLikeDislikes d' => function ($d) use ($user_id) {
                    $d->onCondition(['d.created_by' => $user_id]);
                }], false)
                ->joinWith(['organizationReviewFeedbacks f' => function ($f) use ($user_id) {
                    $f->onCondition(['f.created_by' => $user_id]);
                }], false)
                ->joinWith(['designationEnc e'], false);
            $reviews->orderBy([new \yii\db\Expression('FIELD (a.created_by,"' . $user_id . '") DESC, a.created_on DESC')]);
            $count = $reviews->count();
            if ($limit) {
                $reviews->limit($limit);
                $reviews->offset(($page - 1) * $limit);
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
                '(CASE WHEN a.organization_enc_id IS NOT NULL THEN "claimed" END) as org_type',
                'a.review_enc_id',
                'ROUND(a.average_rating) average_rating',
                'c.name profile',
                'e.designation',
                'f.feedback report',
                'd.feedback_type',
                'a.created_on',
                "DATE_FORMAT(a.created_on, '%d/%m/%Y') created_on",
                'a.is_current_employee reviewer_type',
                'a.likes',
                'a.dislikes',
                'a.from_date',
                'a.to_date',
                'a.created_by',
                'b.first_name',
                'b.last_name',
                'b.initials_color',
                'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE NULL END image'])->asArray()
                ->all();

            for ($i = 0; $i < count($result); $i++) {
                if ($result[$i]['created_by'] == $user_id) {
                    $result[$i]['user_review'] = true;
                } else {
                    $result[$i]['user_review'] = false;
                }
                $result[$i]['link'] = Url::to($org['slug'] . '/reviews', 'https');
                $result[$i]['rating'] = $rating[$i];
                $result[$i]['useful'] = OrganizationReviewLikeDislike::find()->where(['review_enc_id' => $result[$i]['review_enc_id'], 'feedback_type' => 1])->count();
                $result[$i]['not_useful'] = OrganizationReviewLikeDislike::find()->where(['review_enc_id' => $result[$i]['review_enc_id'], 'feedback_type' => 0])->count();
            }
            $data['reviews'] = $result;
            $data['count'] = $count;

            if ($data) {
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
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
                        '(CASE WHEN a.organization_enc_id IS NOT NULL THEN "unclaimed" END) as org_type',
                        'a.likes',
                        'a.dislikes',
                        'c.name profile',
                        'd.designation',
                        'a.created_on',
                        'a.created_by',
                        'a.reviewer_type',
                        'a.show_user_details',
                        'a.from_date',
                        'a.to_date',
                        'b.first_name',
                        'b.last_name',
                        'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", image) ELSE NULL END image',
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

                $options['user_id'] = $user_id;

                $options['count'] = true;
                $count = $this->__unclaimedReviews($options);
                $options['count'] = false;

                $options['quant'] = 'all';
                $options['limit'] = $limit;
                $options['page'] = $page;

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

                $options['limit'] = $limit;
                $options['page'] = $page;

                $emp_rating = $this->__unclaimedReviews($options);

                for ($i = 0; $i < count($emp_reviews); $i++) {
                    if ($emp_reviews[$i]['created_by'] == $user_id) {
                        $emp_reviews[$i]['user_review'] = true;
                    } else {
                        $emp_reviews[$i]['user_review'] = false;
                    }
                    $emp_reviews[$i]['link'] = Url::to($unclaimed_org['slug'] . '/reviews', 'https');
                    $emp_reviews[$i]['rating'] = $emp_rating[$i];
                }

                $data['reviews'] = $emp_reviews;
                $data['count'] = $count;

                if (!empty($emp_reviews)) {
                    return $this->response(200, ['status' => 200, 'data' => $data]);
                } else {
                    return $this->response(404, ['status' => 404, 'message' => 'not found']);
                }
            }


            if ($unclaimed_org['business_activity'] == 'College' && $type == 'student') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.average_rating',
                        '(CASE WHEN a.organization_enc_id IS NOT NULL THEN "unclaimed" END) as org_type',
                        'a.likes',
                        'a.dislikes',
                        'a.created_on',
                        'a.created_by',
                        'a.show_user_details',
                        'a.reviewer_type',
                        'a.from_date',
                        'a.to_date',
                        'b.first_name',
                        'b.last_name',
                        'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", image) ELSE NULL END image',
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
                $options['user_id'] = $user_id;
                $options['count'] = true;
                $count = $this->__unclaimedReviews($options);
                $options['count'] = false;
                $options['quant'] = 'all';

                $options['limit'] = $limit;
                $options['page'] = $page;

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

                $options['limit'] = $limit;
                $options['page'] = $page;

                $rating_students = $this->__unclaimedReviews($options);

                for ($i = 0; $i < count($reviews_students); $i++) {
                    if ($reviews_students[$i]['created_by'] == $user_id) {
                        $reviews_students[$i]['user_review'] = true;
                    } else {
                        $reviews_students[$i]['user_review'] = false;
                    }
                    $reviews_students[$i]['link'] = Url::to($unclaimed_org['slug'] . '/reviews', 'https');
                    $reviews_students[$i]['rating'] = $rating_students[$i];
                }

            } elseif ($unclaimed_org['business_activity'] == 'School' && $type == 'student') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.average_rating',
                        '(CASE WHEN a.organization_enc_id IS NOT NULL THEN "unclaimed" END) as org_type',
                        'a.likes',
                        'a.dislikes',
                        'a.created_on',
                        'a.created_by',
                        'a.show_user_details',
                        'a.reviewer_type',
                        'a.from_date',
                        'a.to_date',
                        'b.first_name',
                        'b.last_name',
                        'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", image) ELSE NULL END image',
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
                $options['user_id'] = $user_id;
                $options['count'] = true;
                $count = $this->__unclaimedReviews($options);
                $options['count'] = false;
                $options['quant'] = 'all';

                $options['limit'] = $limit;
                $options['page'] = $page;

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

                $options['limit'] = $limit;
                $options['page'] = $page;

                $rating_students = $this->__unclaimedReviews($options);

                for ($i = 0; $i < count($reviews_students); $i++) {
                    if ($reviews_students[$i]['created_by'] == $user_id) {
                        $reviews_students[$i]['user_review'] = true;
                    } else {
                        $reviews_students[$i]['user_review'] = false;
                    }
                    $reviews_students[$i]['link'] = Url::to($unclaimed_org['slug'] . '/reviews', 'https');
                    $reviews_students[$i]['rating'] = $rating_students[$i];
                }

            } elseif ($unclaimed_org['business_activity'] == 'Educational Institute' && $type == 'student') {

                $options = [];
                $options['main'] = [
                    'alias' => 'a',
                    'selections' => [
                        'a.review_enc_id',
                        'a.average_rating',
                        '(CASE WHEN a.organization_enc_id IS NOT NULL THEN "unclaimed" END) as org_type',
                        'a.likes',
                        'a.dislikes',
                        'a.created_on',
                        'a.created_by',
                        'a.show_user_details',
                        'a.reviewer_type',
                        'a.from_date',
                        'a.to_date',
                        'b.first_name',
                        'b.last_name',
                        'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", image) ELSE NULL END image',
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
                $options['user_id'] = $user_id;
                $options['count'] = true;
                $count = $this->__unclaimedReviews($options);
                $options['count'] = false;
                $options['quant'] = 'all';

                $options['limit'] = $limit;
                $options['page'] = $page;

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

                $options['limit'] = $limit;
                $options['page'] = $page;

                $rating_students = $this->__unclaimedReviews($options);

                for ($i = 0; $i < count($reviews_students); $i++) {
                    if ($reviews_students[$i]['created_by'] == $user_id) {
                        $reviews_students[$i]['user_review'] = true;
                    } else {
                        $reviews_students[$i]['user_review'] = false;
                    }
                    $reviews_students[$i]['link'] = Url::to($unclaimed_org['slug'] . '/reviews', 'https');
                    $reviews_students[$i]['rating'] = $rating_students[$i];
                }

            }

            $data['reviews'] = $reviews_students;
            $data['count'] = $count;

            if (!empty($reviews_students)) {
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }

        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }

    public function actionLikeDislike()
    {

        $parameters = Yii::$app->request->post();

        if (isset($parameters['review_enc_id']) && !empty($parameters['review_enc_id'])) {
            $review_enc_id = $parameters['review_enc_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
        }

        if (isset($parameters['user_enc_id']) && !empty($parameters['user_enc_id'])) {
            $user_enc_id = $parameters['user_enc_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
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
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
            }
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
        }

        $chk = OrganizationReviewLikeDislike::find()
            ->select(['feedback_type'])
            ->where(['created_by' => $user_enc_id, 'review_enc_id' => $review_enc_id])
            ->asArray()
            ->one();

        if ($chk == null) {

            $model = new OrganizationReviewLikeDislike();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->feedback_enc_id = $utilitiesModel->encrypt();
            $model->feedback_type = $val;
            $model->review_enc_id = $review_enc_id;
            $model->created_by = $user_enc_id;
            $model->created_on = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->response(200, ['status' => 200, 'message' => 'Saved']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'Not Saved']);
            }
        } elseif ($chk) {
            $chkk = OrganizationReviewLikeDislike::find()
                ->select(['*'])
                ->where(['created_by' => $user_enc_id, 'review_enc_id' => $review_enc_id])
                ->one();

            $chkk->feedback_type = $val;
            $chkk->last_updated_on = date('Y-m-d H:i:s');
            $chkk->last_updated_by = $user_enc_id;

            if ($chkk->update()) {
                return $this->response(200, ['status' => 200, 'message' => 'Saved']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'Not Saved']);
            }
        } else {
            return $this->response(500, ['status' => 500, 'message' => 'Not Saved']);
        }

    }

    //to report review
    public function actionReport()
    {

        $parameters = Yii::$app->request->post();

        if (isset($parameters['review_enc_id']) && !empty($parameters['review_enc_id'])) {
            $review_enc_id = $parameters['review_enc_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
        }

        if (isset($parameters['user_enc_id']) && !empty($parameters['user_enc_id'])) {
            $user_enc_id = $parameters['user_enc_id'];
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
        }

        if (isset($parameters['value']) && !empty($parameters['value'])) {
            $value = $parameters['value'];
            if ($value == 1 || $value == 2 || $value == 3 || $value == 4) {
                $val = $value;
            } else {
                return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
            }
        } else {
            return $this->response(422, ['status' => 422, 'message' => 'Missing Information']);
        }

        $chk = OrganizationReviewFeedback::find()
            ->select(['feedback_type', 'feedback'])
            ->where(['created_by' => $user_enc_id, 'review_enc_id' => $review_enc_id, 'is_deleted' => 0])
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
            $model->user_enc_id = $user_enc_id;
            $model->created_on = date('Y-m-d H:i:s');
            $model->created_by = $user_enc_id;

            if ($model->save()) {
                return $this->response(200, ['status' => 200, 'message' => 'Saved']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'Not Saved']);
            }
        } elseif ($chk) {

            $chkk = OrganizationReviewFeedback::find()
                ->select(['*'])
                ->where(['created_by' => $user_enc_id, 'review_enc_id' => $review_enc_id, 'is_deleted' => 0])
                ->one();

            $chkk->feedback = $val;
            $chkk->last_updated_on = date('Y-m-d H:i:s');
            $chkk->last_updated_by = $user_enc_id;

            if ($chkk->update()) {
                return $this->response(200, ['status' => 200, 'message' => 'Saved']);
            } else {
                return $this->response(500, ['status' => 500, 'message' => 'Not Saved']);
            }

        } else {
            return $this->response(500, ['status' => 500, 'message' => 'Not Saved']);
        }

    }
}