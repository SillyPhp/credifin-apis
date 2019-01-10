<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use common\models\OrganizationQuestionnaire;
use common\models\QuestionnaireFields;
use common\models\QuestionnaireFieldOptions;

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

    public function actionView($qidk) {

        $this->layout = 'main-secondary';
        $model = new \frontend\models\questionnaire\QuestionnaireForm;
        $result = OrganizationQuestionnaire::find()
            ->select(['questionnaire_enc_id', 'questionnaire_name'])
            ->where(['questionnaire_enc_id' => $qidk])
            ->asArray()
            ->one();
        if(empty($result))
        {
            return 'not found';
        }
        $fields = QuestionnaireFields::find()
            ->alias('a')
            ->select(['a.field_enc_id', 'a.field_name', 'a.field_label', 'a.sequence', 'a.field_type', 'a.placeholder', 'a.is_required'])
            ->where(['a.questionnaire_enc_id' => $result['questionnaire_enc_id']])
            ->asArray()
            ->all();

        foreach ($fields as $field) {
            $field_option = QuestionnaireFieldOptions::find()
                ->select(['field_option_enc_id', 'field_option'])
                ->where(['field_enc_id' => $field['field_enc_id']])
                ->asArray()
                ->all();
            $field['options'] = $field_option;
            $arr['fields'][] = $field;
        }


        return $this->render('display', [
            'fields' => $arr,
            'model' => $model,
        ]);
    }

}
