<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use account\models\processes\InterviewProcess;
use common\models\OrganizationInterviewProcess;
use common\models\InterviewProcessFields;

class InterviewProcessesController extends Controller {

    public function actionIndex() {
        $organizationQuestionnaire = \common\models\OrganizationQuestionnaire::find()
                ->select(['questionnaire_enc_id as id', 'questionnaire_name', 'questionnaire_for'])
                ->where(['organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->orderBy(['id' => SORT_ASC])
                ->all();
        return $this->render('index', [
                    'organizationQuestionnaire' => $organizationQuestionnaire,
        ]);
    }

    public function actionCreate() {
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

    public function actionView($id)
    {

        $id = Yii::$app->getRequest()->getQueryParam('id');
        $process_name = OrganizationInterviewProcess::find()
            ->select(['process_name'])
            ->where(['interview_process_enc_id' => $id])
            ->asArray()
            ->one();
        if(empty($process_name))
        {
            return 'not found';
        }
        $process_fields = InterviewProcessFields::find()
            ->select(['field_name', 'icon'])
            ->where(['interview_process_enc_id' => $id])
            ->asArray()
            ->all();

        return $this->render('display', [
            'process_name' => $process_name,
            'process_fields' => $process_fields
        ]);
    }

}
