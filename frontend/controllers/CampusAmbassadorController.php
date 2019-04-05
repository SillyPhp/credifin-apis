<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\ApplicationQuestions;
use common\models\Qualifications;
use common\models\States;
use frontend\models\campusAmbassador\ApplicationForm;

class CampusAmbassadorController extends Controller
{
    public function actionApply()
    {
        $this->layout = 'main-secondary';

        $qualificationsModel = Qualifications::find()
            ->select(['qualification_enc_id qualification_id', 'name'])
            ->orderBy(['name' => SORT_ASC])
            ->asArray()
            ->all();

        $applicationQuestionsModel = ApplicationQuestions::find()
            ->alias('a')
            ->select(['a.application_question_enc_id application_question_id', 'a.question'])
            ->joinWith(['applicationTypeEnc b'])
            ->where(['b.name' => 'Campus Ambassador'])
            ->orderBy(['a.id' => SORT_ASC])->asArray()
            ->all();

        $statesModel = States::find()
            ->alias('a')
            ->select(['a.state_enc_id state_id', 'a.name'])
            ->joinWith(['countryEnc b'])
            ->where(['b.name' => 'India'])
            ->orderBy(['a.name' => SORT_ASC])
            ->asArray()
            ->all();

        $applicationFormModel = new ApplicationForm();
        if ($applicationFormModel->load(Yii::$app->request->post())) {
            if ($applicationFormModel->save()) {
                $applicationFormModel = new ApplicationForm();
                Yii::$app->session->setFlash('success', 'We will connect with you shortly.');
            } else {
                Yii::$app->session->setFlash('error');
            }
        }

        return $this->render('form', [
            'applicationQuestionsModel' => $applicationQuestionsModel,
            'qualificationsModel' => $qualificationsModel,
            'applicationFormModel' => $applicationFormModel,
            'statesModel' => $statesModel,
        ]);
    }
}