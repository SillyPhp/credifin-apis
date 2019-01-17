<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use account\models\processes\InterviewProcess;
use common\models\OrganizationInterviewProcess;
use common\models\InterviewProcessFields;

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

    public function actionView($ipidk)
    {
        $process_name = OrganizationInterviewProcess::find()
            ->select(['process_name'])
            ->where(['interview_process_enc_id' => $ipidk])
            ->asArray()
            ->one();
        if (empty($process_name)) {
            return 'not found';
        }
        $process_fields = InterviewProcessFields::find()
            ->select(['field_name', 'icon'])
            ->where(['interview_process_enc_id' => $ipidk])
            ->asArray()
            ->all();

        return $this->render('display', [
            'process_name' => $process_name,
            'process_fields' => $process_fields
        ]);
    }

    public function actionClone($ipidk)
    {
        $process = OrganizationInterviewProcess::find()
            ->alias('a')
            ->where(['a.interview_process_enc_id' => $ipidk])
            ->joinWith(['interviewProcessFields b'], true)
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
            return $this->render('clone', ['model' => $model, 'process' => $process]);
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');
            $update = Yii::$app->db->createCommand()
                ->update(OrganizationInterviewProcess::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['interview_process_enc_id' => $id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

}