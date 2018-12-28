<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use account\models\processes\InterviewProcess;

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

}
