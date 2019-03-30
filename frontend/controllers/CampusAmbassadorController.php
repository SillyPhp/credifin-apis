<?php

namespace frontend\controllers;

use common\models\ApplicationAnswers;
use common\models\ApplicationQuestions;
use common\models\Applications;
use common\models\Qualifications;
use common\models\States;
use frontend\models\ApplicationsForm;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class CampusAmbassadorController extends Controller
{
    public function actionApply() {
        $this->layout = 'main-secondary';
        $qualificationsModel = new Qualifications();
        $applicationQuestionsModel = new ApplicationQuestions();
        $applicationAnswersModel = new ApplicationAnswers();
        $applicationsModel = new Applications();
        $statesModel = new States();
        $applicationFormModel = new ApplicationsForm();
//        $utilitiesModel = new Utilities();
//        if ($applicationsModel->load(Yii::$app->request->post())) {
//            $applicationsModel->application_id = time();
//            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
//            $applicationsModel->application_enc_id = $utilitiesModel->encrypt();
//            if ($applicationsModel->validate() && $applicationsModel->save()) {
//                if ($applicationAnswersModel->load(Yii::$app->request->post())) {
//                    $answers = $applicationAnswersModel->answers;
//                    foreach ($answers as $field => $value) {
//                        $applicationAnswersModel->answers = 'NULL';
//                        if (!empty($value)) {
//                            $applicationAnswersModel->application_enc_id = $applicationsModel->application_enc_id;
//                            $applicationAnswersModel->application_question_enc_id = $field;
//                            $applicationAnswersModel->answer = $value;
//                            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
//                            $applicationAnswersModel->application_answer_enc_id = $utilitiesModel->encrypt();
//                            if ($applicationAnswersModel->validate()) {
//                                if ($applicationAnswersModel->save()) {
//                                    Yii::$app->session->setFlash('success', 'We will connect with you shortly.');
//                                    $applicationAnswersModel = new ApplicationAnswers();
//                                } else {
//                                    Yii::$app->session->setFlash('error');
//                                }
//                            }
//                        }
//                    }
//                }
//                $qualificationsModel = new Qualifications();
//                $applicationQuestionsModel = new ApplicationQuestions();
//                $applicationsModel = new Applications();
//                $statesModel = new States();
//                $utilitiesModel = new Utilities();
//            } else {
//                Yii::$app->session->setFlash('error', 'you have not entered the data correctly');
//            }
//        }

        return $this->render('form', [
            'applicationQuestionsModel' => $applicationQuestionsModel,
            'applicationAnswersModel' => $applicationAnswersModel,
            'qualificationsModel' => $qualificationsModel,
            'applicationsModel' => $applicationsModel,
            'applicationFormModel' => $applicationFormModel,
            'statesModel' => $statesModel,
        ]);
    }
}