<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\rest\ActiveController;
use common\models\OrganizationQuestionnaire;
use common\models\QuestionnaireFields;
use common\models\QuestionnaireFieldOptions;

class QuestionnaireController extends ActiveController {

    public $modelClass = 'common\models\Feedback';

    public function behaviors() {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['POST'],
                ],
            ],
        ];
    }

    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }

    public function actionIndex() {
        if ($attributes = Yii::$app->request->post()) {
//            $results = OrganizationQuestionnaire::find()
//                    ->alias('t1')
//                    ->select(['t1.questionnaire_enc_id', 't2.field_enc_id', 't2.field_label', 't2.field_type', 't3.field_option_enc_id', 't3.field_option'])
//                    ->innerJoin(QuestionnaireFields::tableName() . 'as t2', 't1.questionnaire_enc_id = t2.questionnaire_enc_id')
//                    ->leftJoin(QuestionnaireFieldOptions::tableName() . 'as t3', 't2.field_enc_id = t3.field_enc_id')
//                    ->where(['t1.questionnaire_enc_id' => $attributes['questionnaire_id']])
//                    ->groupBy(['t3.field_option_enc_id'])
//                    ->orderBy(['t2.sequence' => SORT_ASC, 't3.field_option_enc_id' => SORT_ASC])
//                    ->asArray()
//                    ->all();
//            if ($results) {
//                $response = [
//                    'status' => 200,
//                    'form' => $results,
//                ];
//            } else {
//                $response = [
//                    'status' => 201,
//                    'message' => 'No data found.',
//                ];
//            }

            $result = OrganizationQuestionnaire::find()
                    ->select(['questionnaire_enc_id', 'questionnaire_name'])
                    ->where(['questionnaire_enc_id' => $attributes['questionnaire_id']])
                    ->asArray()
                    ->one();

            $fields = QuestionnaireFields::find()
                    ->alias('a')
                    ->select(['a.field_enc_id', 'a.field_name', 'a.field_label', 'a.sequence', 'a.field_type', 'a.placeholder'])
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

            if ($arr) {
                $response = [
                    'status' => 200,
                    'form' => $arr,
                ];
            } else {
                $response = [
                    'status' => 201,
                    'message' => 'No data found.',
                ];
            }
        }
        return $response;
    }

}
