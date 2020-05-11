<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;
use common\models\ApplicationQuestions;
use common\models\Qualifications;
use common\models\States;
use frontend\models\campusAmbassador\ApplicationForm;
use frontend\models\campusAmbassador\CaApplicationForm;

class CampusAmbassadorsController extends Controller
{
    public function actionApply()
    {
        $this->layout = 'main-secondary';
        $type = 'Campus Ambassador';

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


        if(Yii::$app->user->identity->user_enc_id){
            $applicationFormModel = new CaApplicationForm();
            if ($applicationFormModel->load(Yii::$app->request->post())) {
                if ($applicationFormModel->save($type)) {
                    $applicationFormModel = new CaApplicationForm();
                    Yii::$app->session->setFlash('success', 'We will connect with you shortly.');
                } else {
                    Yii::$app->session->setFlash('error');
                }
            }

            return $this->render('ca_form', [
                'applicationQuestionsModel' => $applicationQuestionsModel,
                'qualificationsModel' => $qualificationsModel,
                'applicationFormModel' => $applicationFormModel,
                'statesModel' => $statesModel,
            ]);
        } else {
            $applicationFormModel = new ApplicationForm();
            if (Yii::$app->request->isAjax) {
                if ($applicationFormModel->load(Yii::$app->request->post())) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    if ($applicationFormModel->save($type)) {
                        return $response = [
                            'status' => 200,
                            'title' => 'Thanks for Applying',
                            'message' => 'We will connect with you shortly..',
                        ];
                    } else {
                        return $response = [
                            'status' => 201,
                            'title' => 'Error',
                            'message' => 'An error has occurred. Please try again.',
                        ];
                    }
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

    public function actionApplyCampus()
    {
        if (Yii::$app->request->isAjax) {
            $applicationFormModel = new ApplicationForm();
            Yii::$app->response->format = Response::FORMAT_JSON;
            $applicationFormModel->load(Yii::$app->request->post());
            return ActiveForm::validate($applicationFormModel);
        }
    }
}