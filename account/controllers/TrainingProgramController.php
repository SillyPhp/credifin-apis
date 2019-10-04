<?php

namespace account\controllers;
use account\models\applications\ApplicationForm;
use account\models\training_program\TrainingProgram;
use account\models\training_program\UserAppliedTraining;
use common\models\AppliedTrainingApplications;
use common\models\TrainingProgramApplication;
use yii\web\Response;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class TrainingProgramController extends Controller
{
    public function actionCreate()
    {
        if (Yii::$app->user->identity->organization):
        $model = new TrainingProgram();
        $object = new ApplicationForm();
        $primary_cat = $object->getPrimaryFields();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Your Job Has Been Posted Successfully Submitted..');
            } else {
                Yii::$app->session->setFlash('error', 'Error Please Contact Supportive Team ');
            }
            return $this->refresh();
        }
        return $this->render('index',['model'=>$model,'primary_cat'=>$primary_cat]);
        endif;
    }

    public function actionDashboard()
    {
        if (Yii::$app->user->identity->organization) {
            return $this->__organizationDashboard();
        }
    }

    private function __organizationDashboard()
    {
        $userApplied = new UserAppliedTraining();
        return $this->render('dashboard/organization', [
            'applications'=>$this->__trainings(8),
            'total_applied' => $userApplied->total_applied(),
            'applied_applications'=>$userApplied->getUserDetails('Trainings',10)
        ]);
    }

    private function __trainings($limit = NULL)
    {
        $options = [
            'applicationType' => 'Trainings',
            'where' => [
                'a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
                'a.is_deleted' => 0,
            ],
            'orderBy' => [
                'a.created_on' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $applications = new \account\models\applications\TrainingApplications();
        return $applications->getApplications($options);
    }

    public function actionIndex()
    {
        if (Yii::$app->user->identity->organization) {
            return $this->__organizationTrainings();
        }
    }
    private function __organizationTrainings()
    {
        return $this->render('list/organization', [
            'applications' => $this->__trainings(),
        ]);
    }
    public function actionDeleteApplication()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');
            $update = Yii::$app->db->createCommand()
                ->update(TrainingProgramApplication::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['application_enc_id' => $id])
                ->execute();
            if ($update) {
                Yii::$app->sitemap->generate();
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionCandidates($app_id)
    {
        if (Yii::$app->user->identity->organization) {
            $user_data = AppliedTrainingApplications::find()
                ->alias('a')
                ->where(['a.application_enc_id' => $app_id])
                ->select(['applied_application_enc_id','a.application_enc_id','a.created_by'])
                ->joinwith(['createdBy b'=>function($b)
                {
                    $b->select(['b.user_enc_id','b.username','b.experience','b.job_function','b.first_name', 'b.last_name', 'b.image', 'b.image_location','g.name city_name',]);
                    $b->joinWith(['jobFunction f'], false);
                    $b->joinWith(['cityEnc g'], false);
                    $b->joinWith(['userSkills c'=>function($b)
                    {
                        $b->select(['c.created_by','d.skill']);
                        $b->joinWith(['skillEnc d'],false);
                        $b->onCondition(['c.is_deleted' => 0]);
                    }]);
                }])
                ->groupBy(['application_enc_id'])
                ->asArray()
                ->all();
            return $this->render('dashboard/candidate-list', ['user_data' => $user_data]);
        }
    }
}