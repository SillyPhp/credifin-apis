<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\ApplicationQuestions;
use common\models\Qualifications;
use common\models\States;
use frontend\models\CAApplicationForm;

class CampusAmbassadorController extends Controller
{
    public function actionApply() {
        $this->layout = 'main-secondary';
        $qualificationsModel = Qualifications::find()
            ->select(['qualification_enc_id', 'name'])
            ->orderBy(['name' => SORT_ASC])
            ->asArray()
            ->all();
        $applicationQuestionsModel = ApplicationQuestions::find()
            ->alias('a')
            ->select(['a.application_question_enc_id', 'a.question'])
            ->joinWith(['applicationTypeEnc b'])
            ->where(['b.name' => 'Campus Ambassador'])
            ->orderBy(['a.id' => SORT_ASC])->asArray()
            ->all();
        $statesModel = States::find()
            ->alias('a')
            ->select(['a.state_enc_id', 'a.name'])
            ->joinWith(['countryEnc b'])
            ->where(['b.name' => 'India'])
            ->orderBy(['a.name' => SORT_ASC])
            ->asArray()
            ->all();
        $caApplicationFormModel = new CAApplicationForm();
        if ($caApplicationFormModel->load(Yii::$app->request->post())) {
            if($caApplicationFormModel->save()){
                Yii::$app->session->setFlash('success', 'We will connect with you shortly.');
            } else{
                Yii::$app->session->setFlash('error');
            }
        }

        return $this->render('form', [
            'applicationQuestionsModel' => $applicationQuestionsModel,
            'qualificationsModel' => $qualificationsModel,
            'caApplicationFormModel' => $caApplicationFormModel,
            'statesModel' => $statesModel,
        ]);
    }
}