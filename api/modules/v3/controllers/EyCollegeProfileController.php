<?php


namespace api\modules\v3\controllers;


use common\models\AssignedCollegeCourses;
use common\models\ClaimServiceableLocations;
use common\models\FollowedOrganizations;
use common\models\OrganizationReviews;
use common\models\Organizations;
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
                'CASE WHEN a.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", a.logo_location, "/", a.logo) ELSE NULL END logo'
            ])
            ->innerJoinWith(['organizationOtherDetails b' => function ($b) {
                $b->joinWith(['locationEnc b1']);
            }], false)
            ->where(['a.slug' => $params['slug'], 'a.status' => 'Active', 'a.is_deleted' => 0, 'a.is_erexx_registered' => 1])
            ->asArray()
            ->one();

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
            ->select(['a.assigned_college_enc_id', 'c.course_name', 'a.organization_enc_id college_id', 'a.course_duration', 'a.type'])
            ->joinWith(['courseEnc c'], false)
            ->where(['a.organization_enc_id' => $college->organization_enc_id, 'a.is_deleted' => 0])
            ->asArray()
            ->all();
        if ($courses) {
            return $this->response(200, ['status' => 200, 'courses' => $courses]);
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
            ->select(['organization_enc_id', '(CASE WHEN organization_enc_id IS NOT NULL THEN "claimed" END) as org_type', 'slug', 'initials_color', 'name', 'website', 'email', 'CASE WHEN logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo, 'https') . '", logo_location, "/", logo) ELSE NULL END logo'])
            ->where(['organization_enc_id' => $org_enc_id, 'is_deleted' => 0])
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
//            if ($limit) {
//                $reviews->limit($limit);
//                $reviews->offset(($page - 1) * $limit);
//            }
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
            }


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
            $data['reviews'] = $result;
            $data['count'] = $count;

            if (!empty($data)) {
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        } else {
            return $this->response(404, ['status' => 404, 'message' => 'not found']);
        }
    }
}