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
                return $this->response(200, ['status' => 200, 'data' => $data]);
            } else {
                return $this->response(404, ['status' => 404, 'message' => 'not found']);
            }
        }
    }
}