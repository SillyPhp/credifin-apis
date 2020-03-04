<?php

namespace frontend\controllers;

use common\models\AppliedTrainingApplications;
use common\models\TrainingProgramApplication;
use common\models\TrainingProgramBatches;
use frontend\models\TrainingAppliedForm;
use frontend\models\applications\ApplicationCards;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class TrainingProgramsController extends Controller
{
    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader(Yii::$app->controller->id);
        Yii::$app->seo->setSeoByRoute(ltrim(Yii::$app->request->url, '/'), $this);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $type = Yii::$app->request->post('type');
            $options = [];
            $options['limit'] = 6;
            $options['page'] = 1;
            $cards = ApplicationCards::TraininingCards($options);
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
    public function actionFetchInstitutes()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $options = Yii::$app->request->post();
            $cards = ApplicationCards::InstitutesCards($options);
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
    }
    public function actionDetail($eaidk){
        $model = new TrainingAppliedForm();
        $application_details = TrainingProgramApplication::find()
            ->where([
                'slug' => $eaidk,
                'is_deleted' => 0
            ])
            ->one();

        if (!$application_details) {
            return 'Not Found';
        }
        $org_details = $application_details->getOrganizationEnc()->select(['name org_name', 'initials_color color', 'slug', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();
        $data = TrainingProgramApplication::find()
                ->alias('a')
                ->distinct()
                ->groupBy('d.id')
                ->where(['a.application_enc_id' => $application_details['application_enc_id']])
                ->select(['a.application_enc_id','a.description','a.training_duration','a.training_duration_type','l.name','c.name as cat_name', 'l.name', 'l.icon_png',])
                ->joinWith(['title0 b'=>function($b)
                {
                    $b->joinWith(['parentEnc l'], false);
                    $b->joinWith(['categoryEnc c'],false);
                }],false)
                ->joinWith(['trainingProgramBatches d'=>function($b)
                {
                    $b->onCondition(['d.is_deleted'=>0]);
                    $b->select(['d.application_enc_id','d.city_enc_id','i.name']);
                    $b->joinWith(['cityEnc i'],false);
                    $b->distinct('d.city_enc_id');
                }])
                ->joinWith(['trainingProgramSkills g' => function ($b) {
                $b->onCondition(['g.is_deleted' => 0]);
                $b->joinWith(['skillEnc h'], false);
                $b->select(['g.application_enc_id', 'h.skill_enc_id', 'h.skill']);
                }])
                ->asArray()
                ->one();
        $command = Yii::$app->db->createCommand("SELECT sum(seats) FROM {{%training_program_batches}} where application_enc_id = '{$application_details['application_enc_id']}'");
        $sum = $command->queryScalar();
        $batches = TrainingProgramBatches::find()
            ->alias('d')
            ->where(['d.application_enc_id'=>$application_details['application_enc_id']])
            ->joinWith(['cityEnc i'],false)
            ->select(['batch_enc_id','d.application_enc_id','d.city_enc_id','i.name','d.fees','(CASE
                WHEN d.fees_methods = "1" THEN "Monthly"
                WHEN d.fees_methods = "2" THEN "Weekly"
                WHEN d.fees_methods = "3" THEN "Anually"
                WHEN d.fees_methods = "4" THEN "One Time"
                ELSE "N/A"
               END) as fees_method','d.seats','d.days','start_time','d.end_time'])
            ->asArray()
            ->all();
        $grouped_cities = [];
        $grouped = [];
        foreach($batches as $batch){
                $grouped_cities[$batch['name']][] = $batch;
        }
        if (!Yii::$app->user->isGuest) {
            $applied_jobs = AppliedTrainingApplications::find()
                ->where(['application_enc_id' => $application_details->application_enc_id])
                ->andWhere(['created_by' => Yii::$app->user->identity->user_enc_id])
                ->andWhere(['is_deleted' => 0])
                ->exists();
        }

        return $this->render('details',[
            'org' => $org_details,
            'data' => $data,
            'application_details' => $application_details,
            'batches' => $batches,
            'grouped_cities' => $grouped_cities,
            'model' => $model,
            'applied' => $applied_jobs,
            'total_seats' => $sum,
        ]);
    }

    public function actionApply()
    {
        $model = new TrainingAppliedForm();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save())
            {
                return true;
            }
            else
            {
                return false;
            }
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

            $cards = ApplicationCards::TraininingCards($options);
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
}