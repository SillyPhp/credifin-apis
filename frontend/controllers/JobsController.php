<?php

namespace frontend\controllers;

use common\models\ShortlistedApplications;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use frontend\models\JobApplied;
use common\models\EmployerApplications;
use common\models\ApplicationPlacementLocations;
use common\models\Organizations;
use common\models\OrganizationLocations;
use common\models\Cities;
use common\models\Categories;
use common\models\AssignedCategories;
use common\models\EmployeeBenefits;
use common\models\AppliedApplications;
use common\models\UserResume;
use common\models\ReviewedApplications;
use common\models\Industries;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;
use frontend\models\applications\ApplicationCards;

class JobsController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['job-preview'],
                'rules' => [
                    [
                        'actions' => ['job-preview'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $type = Yii::$app->request->post('type');
            $options = [];
            $options['limit'] = 3;
            $options['page'] = 1;
            $cards = ApplicationCards::jobs($options);
            if ($cards) {
                $response = [
                    'status' => 200,
                    'message' => 'Success',
                    'cards' => $cards,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }

        return $this->render('index');
    }


    public function actionList()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $parameters = Yii::$app->request->post();

            $options = [];

            if ($parameters['page'] && (int)$parameters['page'] >= 1) {
                $options['page'] = $parameters['page'];
            } else {
                $options['page'] = 1;
            }

            $options['limit'] = 27;

            if ($parameters['location'] && !empty($parameters['location'])) {
                $options['location'] = $parameters['location'];
            }

            if ($parameters['category'] && !empty($parameters['category'])) {
                $options['category'] = $parameters['category'];
            }

            if ($parameters['keyword'] && !empty($parameters['keyword'])) {
                $options['keyword'] = $parameters['keyword'];
            }

            if ($parameters['company'] && !empty($parameters['company'])) {
                $options['company'] = $parameters['company'];
            }

            $cards = ApplicationCards::jobs($options);
            if (count($cards) > 0) {
                $response = [
                    'status' => 200,
                    'title' => 'Success',
                    'cards' => $cards,
                ];
            } else {
                $response = [
                    'status' => 201,
                ];
            }
            return $response;
        }

        return $this->render('list');
    }

    public function actionDetail($eaidk)
    {
        $application_details = EmployerApplications::find()
            ->where([
                'slug' => $eaidk,
                'is_deleted' => 0
            ])
            ->one();

        if (!$application_details) {
            return 'Not Found';
        }
        $type = 'Job';
        $object = new \account\models\applications\ApplicationForm();
        $org_details = $application_details->getOrganizationEnc()->select(['name org_name', 'initials_color color', 'slug', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();

        if (!Yii::$app->user->isGuest) {
            $applied_jobs = AppliedApplications::find()
                ->where(['application_enc_id' => $application_details->application_enc_id])
                ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['is_deleted'=>0])
                ->exists();

            $shortlist = \common\models\ShortlistedApplications::find()
                ->select('shortlisted')
                ->where(['shortlisted' => 1, 'application_enc_id' => $application_details->application_enc_id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->one();
        }
        $model = new JobApplied();
        return $this->render('/employer-applications/detail', [
            'application_details' => $application_details,
            'data' => $object->getCloneData($application_details->application_enc_id,$application_type='Jobs'),
            'org' => $org_details,
            'applied' => $applied_jobs,
            'type' => $type,
            'model' => $model,
            'shortlist' => $shortlist,
        ]);
    }

    public function actionJobPreview($eipdk)
    {
        if (!empty($eipdk)) {
            $type = 'Job';
            $var = $eipdk;
            $session = Yii::$app->session;
            $object = $session->get($var);
            if (empty($object)) {
                return 'Opps Session expired..!';
            }
            $industry = Industries::find()
                ->where(['industry_enc_id' => $object->industry])
                ->select(['industry'])
                ->asArray()
                ->one();
            $primary_cat = Categories::find()
                ->select(['name','icon_png'])
                ->where(['category_enc_id' => $object->primaryfield])
                ->asArray()
                ->one();
            if ($object->benefit_selection == 1) {
                foreach ($object->emp_benefit as $benefit) {
                    $benefits[] = EmployeeBenefits::find()
                        ->select(['benefit','icon','icon_location'])
                        ->where(['benefit_enc_id' => $benefit])
                        ->asArray()
                        ->one();
                }
            } else {
                $benefits = null;
            }
            if (!empty($object->interviewcity))

            return $this->render('/employer-applications/preview', [
                'object' => $object,
                'industry' => $industry,
                'primary_cat' => $primary_cat,
                'benefits' => $benefits,
                'type' => $type
            ]);
        } else {
            return false;
        }
    }

    public function actionItemId()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('itemid');
            $chkshort = ShortlistedApplications::find()
                ->select(['shortlisted'])
                ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $id])
                ->asArray()
                ->one();
            $short_status = $chkshort['shortlisted'];
            if($short_status == 1){
                $response = [
                    'status' => 201,
                    'message' => 'Can not add, it is already shortlisted.',
                ];
                return $response;
            } else {
                $chkuser = ReviewedApplications::find()
                    ->select(['review'])
                    ->where(['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $id])
                    ->asArray()
                    ->one();
                $status = $chkuser['review'];
                if (empty($chkuser)) {
                    $model = new ReviewedApplications();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $model->review_enc_id = $utilitiesModel->encrypt();
                    $model->application_enc_id = $id;
                    $model->review = 1;
                    $model->created_on = date('Y-m-d H:i:s');
                    $model->created_by = Yii::$app->user->identity->user_enc_id;
                    if ($model->validate() && $model->save()) {
                        $response = [
                            'status' => 200,
                            'message' => 'Job successfully created in review list.',
                        ];
                        return $response;
                    } else {
                        $response = [
                            'status' => 201,
                            'message' => 'Job not created in review list',
                        ];
                        return $response;
                    }
                } else if ($status == 1) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ReviewedApplications::tableName(), ['review' => 0, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $id])
                        ->execute();

                    if ($update) {
                        $response = [
                            'status' => 'unshort',
                            'message' => 'Job removed from review list',
                        ];
                        return $response;
                    }
                } else if ($status == 0) {
                    $update = Yii::$app->db->createCommand()
                        ->update(ReviewedApplications::tableName(), ['review' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['created_by' => Yii::$app->user->identity->user_enc_id, 'application_enc_id' => $id])
                        ->execute();

                    if ($update) {
                        $response = [
                            'status' => 'short',
                            'message' => 'Job added in review list successfully',
                        ];
                        return $response;
                    }
                }
            }

        }
    }

    public function actionJobDetail($eaidk, $type)
    {
        if (Yii::$app->request->isAjax) {
            $application_details = EmployerApplications::find()
                ->alias('a')
                ->select(['a.*', 'b.name org_name', 'b.tag_line', 'b.initials_color color', 'b.slug as org_slug', 'b.email', 'b.website', 'b.logo', 'b.logo_location', 'b.cover_image', 'b.cover_image_location'])
                ->joinWith(['organizationEnc b'], false)
                ->where([
                    'a.slug' => $eaidk,
                    'a.is_deleted' => 0
                ])
                ->asArray()
                ->one();

            if (!$application_details) {
                return 'Not Found';
            }
            $object = new \account\models\applications\ApplicationForm();

            return $this->render('pop_up_detail', [
                'application_details' => $application_details,
                'type' => $type,
                'data' => $object->getCloneData($application_details['application_enc_id'], $type),
            ]);

        }
    }

    public function actionNearMe(){

        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            $lat = Yii::$app->request->post('lat');
            $long = Yii::$app->request->post('long');
            $radius = Yii::$app->request->post('radius');
            $num = Yii::$app->request->post('num');
            $keyword = Yii::$app->request->post('keyword');


            $radius = $radius / 1000;

            $data = EmployerApplications::find()
                ->alias('a')
                ->select([
                    'a.application_enc_id',
                    'a.type',
                    'i.slug as organization_slug',
                    'a.experience',
                    'h.name as job_title',
                    'a.slug',
                    'a.last_date',
                    'e.name as city_name',
                    'c.location_name',
                    'c.location_enc_id',
                    'i.name',
                    'f.wage_type',
                    'c.latitude',
                    'c.longitude',
                    '(CASE
                        WHEN a.experience = "0" THEN "No Experience"
                        WHEN a.experience = "1" THEN "Less Than 1 Year Experience"
                        WHEN a.experience = "2" THEN "1 Year Experience"
                        WHEN a.experience = "3" THEN "2-3 Years Experience"
                        WHEN a.experience = "3-5" THEN "3-5 Years Experience"
                        WHEN a.experience = "5-10" THEN "5-10 Years Experience"
                        WHEN a.experience = "10-20" THEN "10-20 Years Experience"
                        WHEN a.experience = "20+" THEN "More Than 20 Years Experience"
                        ELSE "No Experience"
                        END) as experience',
                    'f.fixed_wage as fixed_salary',
                    'f.wage_type salary_type',
                    'f.max_wage as max_salary',
                    'f.min_wage as min_salary',
                    'f.wage_duration as salary_duration',
                    'i.initials_color as color',
                    'CASE WHEN i.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->organizations->logo) . '", i.logo_location, "/", i.logo) ELSE NULL END logo',
                    "( 6371 * acos( cos( radians('$lat') ) * cos( radians( c.latitude ) ) * cos( radians( c.longitude ) - radians('$long') ) + sin( radians('$lat') ) * sin( radians( c.latitude ) ) ) )  distance",
                    ])
                ->joinWith(['applicationPlacementLocations as b'=>function($x){
                    $x->joinWith(['locationEnc as c'=>function($y){
                        $y->joinWith(['cityEnc as e']);
                    }],false);
                }],false)
                ->joinWith(['applicationOptions as f'],false)
                ->joinWith(['title g'=>function($z){
                    $z->joinWith(['categoryEnc as h'],false);
                    $z->joinWith(['parentEnc p'], false);
                }],false)
                ->joinWith(['organizationEnc as i'])
                ->joinWith(['applicationTypeEnc as j'])
                ->joinWith(['designationEnc l'], false)
                ->joinWith(['preferredIndustry o'], false)
                ->having(['<', 'distance', $radius])
                ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0]);
                if (!empty($keyword)) {
                    $data->andWhere([
                        'or',
                        ['like', 'l.designation',$keyword],
                        ['like', 'a.type', $keyword],
                        ['like', 'h.name', $keyword],
                        ['like', 'o.industry', $keyword],
                        ['like', 'p.name', $keyword],
                    ]);
                }
               $result = $data->limit(20)->offset($num)->asArray()
                ->all();

            $i = 0;
            foreach ($result as $val) {
                $result[$i]['last_date'] = date('d-m-Y', strtotime($val['last_date']));
                if ($val['salary_type'] == "Fixed") {
                    if ($val['salary_duration'] == "Monthly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 12;
                    } elseif ($val['salary_duration'] == "Hourly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 40 * 52;
                    } elseif ($val['salary_duration'] == "Weekly") {
                        $result[$i]['salary'] = $val['fixed_salary'] * 52;
                    } else {
                        $result[$i]['salary'] = $val['fixed_salary'];
                    }
                } elseif ($val['salary_type'] == "Negotiable" || $val['salary_type'] == "Performance Based") {
                    if (!empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['min_salary'] * 12 . " - ₹" . (string)$val['max_salary'] * 12;
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 52) . " - ₹" . (string)($val['max_salary'] * 40 * 52);
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 52) . " - ₹" . (string)($val['max_salary'] * 52);
                        } else {
                            $result[$i]['salary'] = (string)($val['min_salary']) . " - ₹" . (string)($val['max_salary']);
                        }
                    } elseif (!empty($val['min_salary']) && empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['min_salary'] * 12;
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 40 * 52);
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['min_salary'] * 52);
                        } else {
                            $result[$i]['salary'] = (string)($val['min_salary']);
                        }
                    } elseif (empty($val['min_salary']) && !empty($val['max_salary'])) {
                        if ($val['salary_duration'] == "Monthly") {
                            $result[$i]['salary'] = (string)$val['max_salary'] * 12;
                        } elseif ($val['salary_duration'] == "Hourly") {
                            $result[$i]['salary'] = (string)($val['max_salary'] * 40 * 52);
                        } elseif ($val['salary_duration'] == "Weekly") {
                            $result[$i]['salary'] = (string)($val['max_salary'] * 52);
                        } else {
                            $result[$i]['salary'] = (string)($val['max_salary']);
                        }
                    }
                }
                $i++;
            }

            $total = EmployerApplications::find()
                ->alias('a')
                ->select([
                    'a.application_enc_id',
                    "( 6371 * acos( cos( radians('$lat') ) * cos( radians( c.latitude ) ) * cos( radians( c.longitude ) - radians('$long') ) + sin( radians('$lat') ) * sin( radians( c.latitude ) ) ) )  distance",
                ])
                ->joinWith(['applicationTypeEnc as j'])
                ->joinWith(['title g'=>function($z){
                    $z->joinWith(['categoryEnc as h'],false);
                    $z->joinWith(['parentEnc p'], false);
                }],false)
                ->joinWith(['applicationPlacementLocations as b'=>function($x){
                    $x->joinWith(['locationEnc as c'],false);
                }],false)
                ->joinWith(['designationEnc l'], false)
                ->joinWith(['preferredIndustry o'], false)
                ->having(['<', 'distance', $radius])
                ->where(['j.name' => 'Jobs', 'a.status' => 'Active', 'a.is_deleted' => 0]);
                if (!empty($keyword)) {
                    $total->andWhere([
                        'or',
                        ['like', 'l.designation',$keyword],
                        ['like', 'a.type', $keyword],
                        ['like', 'h.name', $keyword],
                        ['like', 'o.industry', $keyword],
                        ['like', 'p.name', $keyword],
                    ]);
                }
                $total = $total->asArray()->all();

            $data = [];
            array_push($data,$result);
            $data['total'] = count($total);
            return json_encode($data);

        }
        return $this->render('near-me-beta');
    }

}