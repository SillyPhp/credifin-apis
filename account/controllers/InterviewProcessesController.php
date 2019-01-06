<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use account\models\processes\InterviewProcess;
use common\models\OrganizationInterviewProcess;

class InterviewProcessesController extends Controller
{

    public function actionIndex()
    {
        $options = [
            'where' => [
                'organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
            ],
            'orderBy' => [
                'id' => SORT_DESC,
            ],
        ];

        $processes = new \account\models\processes\OrganizationInterviewProcesses();

        return $this->render('index', [
            'processes' => $processes->getProcesses($options),
        ]);
    }

    public function actionCreate()
    {
        $model = new InterviewProcess();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return true;
            } else {
                return false;
            }
        }

        return $this->render('form', [
            'model' => $model,
        ]);
    }

    public function actionClone($ipidk)
    {
        $process = OrganizationInterviewProcess::find()
            ->alias('a')
            ->where(['a.interview_process_enc_id' => $ipidk])
            ->joinWith(['interviewProcessFields b'],true)
            ->asArray()
            ->one();

        $model = new InterviewProcess;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return true;
            } else {
                return false;
            }
        } else {
            return $this->render('index', ['model' => $model, 'process' => $process]);
        }
    }

}
