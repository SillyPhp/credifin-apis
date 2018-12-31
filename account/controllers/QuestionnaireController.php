<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;

class QuestionnaireController extends Controller
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

        $questionnaire = new \account\models\questionnaire\OrganizationQuestionnaire();

        return $this->render('index', [
            'questionnaire' => $questionnaire->getQuestionnaire($options),
        ]);
    }

    public function actionCreate()
    {
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

    public function actionDeleteQuestionnaire()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');
            $update = Yii::$app->db->createCommand()
                ->update(OrganizationQuestionnaire::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d h:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['questionnaire_enc_id' => $id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionClone($qidk)
    {
        $model = new \account\models\questionnaire\QuestionnaireForm();
        $fields = $model->getCloneData($qidk);
        if (empty($fields)) {
            return 'Questionnaire not found!!';
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->add()) {
                return true;
            } else {
                return false;
            }
        } else {
            return $this->render('questionnaire-clone', [
                'model' => $model,
                'fields' => $fields,
            ]);
        }
    }

    public function actionEdit($qidk)
    {
        $model = new \account\models\questionnaire\QuestionnaireForm(); //update soon
        $fields = $model->getCloneData($qidk);
        if (empty($fields)) {
            return 'Questionnaire not found!!';
        }
        if ($model->load(Yii::$app->request->post())) {
            return json_encode($model->update($qidk));
        } else {
            return $this->render('questionnaire-edit', [
                'model' => $model,
                'fields' => $fields,
            ]);
        }
    }

}
