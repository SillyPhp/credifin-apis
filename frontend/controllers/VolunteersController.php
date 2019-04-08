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

class VolunteersController extends Controller
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
            ->where(['b.name' => 'Volunteer'])
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
        if (Yii::$app->request->isAjax) {
            if ($applicationFormModel->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
                if ($applicationFormModel->save()) {
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