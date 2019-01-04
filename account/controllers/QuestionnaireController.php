<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;

class QuestionnaireController extends Controller {

    public function actionIndex() {
        $options = [
            'where' => [
                'organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
            ],
            'orderBy' => [
                'id' => SORT_DESC,
            ],
        ];

        $questionnaire = new \account\models\questionnaire\OrganizationQuestionnaire();

        return $this->render('index', [
                    'questionnaire' => $questionnaire->getQuestionnaire($options),
        ]);
    }

    public function actionCreate() {
        $model = new \account\models\questionnaire\QuestionnaireForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->add()) {
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
