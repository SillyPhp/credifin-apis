<?php

namespace account\controllers;
use account\models\applications\ApplicationForm;
use account\models\training_program\TrainingProgram;
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
            return json_encode($model->save());
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
        return $this->render('dashboard/organization', [
            'applications'=>$this->__trainings(8)
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
}