<?php

namespace frontend\controllers;

use common\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use common\models\OrganizationLocations;
use common\models\Cities;
use common\models\EmployerApplications;
use common\models\Categories;
use common\models\Industries;
use common\models\EmployeeBenefits;
use common\models\AppliedApplications;
use common\models\UserResume;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\InterviewProcessFields;
use frontend\models\JobApplied;
use frontend\models\applications\ApplicationCards;

class InternshipsController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['internship-preview'],
                'rules' => [
                    [
                        'actions' => ['internship-preview'],
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
            $options = [];
            $options['limit'] = 3;
            $options['page'] = 1;
            $cards = ApplicationCards::internships($options);
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

    public function actionInternshipPreview($eipdk)
    {
        if (!empty($eipdk)) {
            $type = 'Internship';
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

            $cards = ApplicationCards::internships($options);
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
            ->joinWith(['applicationTypeEnc b' => function ($b) {
                $b->andWhere(['b.name' => 'internships']);
            }])
            ->one();
        $type = 'Internship';
        if (empty($application_details)) {
            return 'Application Not found';
        }
        $object = new \account\models\applications\ApplicationForm();
        $org_details = $application_details->getOrganizationEnc()->select(['name org_name', 'email', 'slug', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();

        if (!Yii::$app->user->isGuest) {
            $applied_jobs = AppliedApplications::find()
                ->where(['application_enc_id' => $application_details->application_enc_id])
                ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->exists();

            $resumes = UserResume::find()
                ->select(['user_enc_id', 'resume_enc_id', 'title'])
                ->where(['user_enc_id' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->all();

            $app_que = ApplicationInterviewQuestionnaire::find()
                ->alias('a')
                ->select(['a.field_enc_id', 'a.questionnaire_enc_id', 'b.field_name'])
                ->where(['a.application_enc_id' => $application_details->application_enc_id])
                ->innerJoin(InterviewProcessFields::tableName() . 'as b', 'b.field_enc_id = a.field_enc_id')
                ->andWhere(['b.field_name' => 'Get Applications'])
                ->exists();

            $shortlist = \common\models\ShortlistedApplications::find()
                ->select('shortlisted')
                ->where(['shortlisted' => 1, 'application_enc_id' => $application_details->application_enc_id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                ->asArray()
                ->one();
        }

        if (!empty($application_details)) {
            $model = new JobApplied();
            return $this->render('/employer-applications/detail', [
                'application_details' => $application_details,
                'data' => $object->getCloneData($application_details->application_enc_id,$application_type='Internships'),
                'org' => $org_details,
                'type' => $type,
                'applied' => $applied_jobs,
                'model' => $model,
                'resume' => $resumes,
                'que' => $app_que,
                'shortlist' => $shortlist,
            ]);
        } else {
            return 'Not Found';
        }
    }

    public function actionNearMe(){

        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            $lat = Yii::$app->request->post('lat');
            $long = Yii::$app->request->post('long');
            $radius = Yii::$app->request->post('inprange');
            $num = Yii::$app->request->post('num');
            $keyword = Yii::$app->request->post('keyword');
            $type = 'Internships';
            $walkin = 0;

            $radius = $radius / 1000;

            $cards = \frontend\models\nearme\ApplicationCards::cards($lat,$long,$radius,$num,$keyword,$type,$walkin);

            return $cards;
        }
        return $this->render('near-me-beta');
    }

    public function actionWalkInInterviews(){

        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            $lat = Yii::$app->request->post('lat');
            $long = Yii::$app->request->post('long');
            $radius = Yii::$app->request->post('inprange');
            $num = Yii::$app->request->post('num');
            $keyword = Yii::$app->request->post('keyword');
            $type = 'Internships';
            $walkin = 1;

            $radius = $radius / 1000;

            $cards = \frontend\models\nearme\ApplicationCards::cards($lat,$long,$radius,$num,$keyword,$type,$walkin);

            return $cards;
        }
        return $this->render('walkin-near-me-beta');
    }

    public function actionUserLocation(){

        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){

            $location = Users::find()
                ->alias('a')
                ->select(['b.name','c.name as state_name'])
                ->where(['a.user_enc_id'=>Yii::$app->user->identity->user_enc_id])
                ->joinWith(['cityEnc as b'=>function($x){
                    $x->joinWith(['stateEnc as c']);
                }],false)
                ->asArray()
                ->one();

            return json_encode($location);
        }
    }

}