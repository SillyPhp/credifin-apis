<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use common\models\OrganizationQuestionnaire;
use common\models\QuestionnaireFields;
use common\models\QuestionnaireFieldOptions;
use common\models\AnsweredQuestionnaire;
use account\models\questionnaire\QuestionnaireForm;
use account\models\questionnaire\QuestionnaireViewForm;

class QuestionnaireController extends Controller
{

    public function actionIndex()
    {
        $options = [
            'where' => [
                'organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id,
            ],
            'orderBy' => [
                'created_on' => SORT_DESC,
            ],
        ];

        $questionnaire = new \account\models\questionnaire\OrganizationQuestionnaire();

        return $this->render('index', [
            'questionnaire' => $questionnaire->getQuestionnaire($options),
        ]);
    }

    public function actionCreate()
    {
        $model = new QuestionnaireForm();
        $type = 'create';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->add()) {
                return true;
            } else {
                return false;
            }
        }

        return $this->render('form', [
            'model' => $model,
            'type' => $type,
        ]);
    }

    public function actionClone($qidk)
    {
        $model = new QuestionnaireForm();
        $fields = $model->getCloneData($qidk);
        $type = 'clone';
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
            return $this->render('form', [
                'model' => $model,
                'fields' => $fields,
                'type' => $type,
            ]);
        }
    }

    public function actionView($qidk)
    {
        $this->layout = 'main-secondary';
        $model = new QuestionnaireViewForm();
        $result = OrganizationQuestionnaire::find()
            ->select(['questionnaire_enc_id', 'questionnaire_name'])
            ->where(['questionnaire_enc_id' => $qidk])
            ->asArray()
            ->one();

        $fields = QuestionnaireFields::find()
            ->alias('a')
            ->select(['a.field_enc_id', 'a.field_name', 'a.field_label', 'a.sequence', 'a.field_type', 'a.placeholder', 'a.is_required'])
            ->where(['a.questionnaire_enc_id' => $result['questionnaire_enc_id']])
            ->asArray()
            ->all();
        if (empty($result) || empty($fields)) {
            return 'not found';
        }
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
            'result' => $result,
        ]);
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isPost) {
            $id = Yii::$app->request->post('data');
            $update = Yii::$app->db->createCommand()
                ->update(OrganizationQuestionnaire::tableName(), ['is_deleted' => 1, 'last_updated_on' => date('Y-m-d H:i:s'), 'last_updated_by' => Yii::$app->user->identity->user_enc_id], ['questionnaire_enc_id' => $id])
                ->execute();
            if ($update) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function actionFillQuestionnaire($qidk, $aaidk)
    {
        if (Yii::$app->user->identity->organization) {
            return 'You have no access to this page';
        }
        $this->layout = 'main-secondary';

        $chk = AnsweredQuestionnaire::find()
            ->where([
                'applied_application_enc_id' => $aaidk,
                'questionnaire_enc_id' => $qidk,
                'created_by' => Yii::$app->user->identity->user_enc_id,
            ])
            ->asArray()
            ->one();
        $result = OrganizationQuestionnaire::find()
            ->select(['questionnaire_enc_id', 'questionnaire_name'])
            ->where(['questionnaire_enc_id' => $qidk])
            ->asArray()
            ->one();

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

        if ($arr) {
            $model = new QuestionnaireViewForm();
            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post('data');
                if ($model->saveAnswer($aaidk, $data, $qidk)) {
                    return true;
                } else {
                    return false;
                }

            } else {
                return $this->render('fill-questionnaire', [
                    'fields' => $arr,
                    'model' => $model,
                    'chk' => $chk,
                ]);
            }
        }

    }

    public function actionDisplayAnswers($qidk, $aaidk)
    {
        $this->layout = 'main-secondary';
        $answers = AnsweredQuestionnaire::find()
            ->alias('a')
            ->distinct()
            ->where(['a.applied_application_enc_id' => $aaidk, 'a.questionnaire_enc_id' => $qidk])
            ->select(['a.answered_questionnaire_enc_id', 'a.rating', 'a.created_by'])
            ->joinWith([
                'answeredQuestionnaireFields b' => function ($b) {
                    $b->joinWith(['fieldEnc c'], false);
                    $b->joinWith(['fieldOptionEnc e'], false);
                    $b->select(['b.answered_questionnaire_enc_id', 'b.answer', 'c.field_enc_id', 'c.field_type', 'c.field_label', 'e.field_option']);
                }
            ], true)
            ->joinWith(['createdBy d' => function ($d) {
                $d->select(['d.user_enc_id', 'd.username', 'd.first_name']);
            }], true)
            ->asArray()
            ->one();
        return $this->render('view-answer', ['answers' => $answers]);
    }

    public function actionRating()
    {
        $rating = Yii::$app->request->post('rate');
        $que = Yii::$app->request->post('que');
        $aid = Yii::$app->request->post('aid');
        $ratingModel = AnsweredQuestionnaire::find()
            ->where(['applied_application_enc_id' => $aid])
            ->andWhere(['questionnaire_enc_id' => $que])
            ->one();
        $ratingModel->rating = $rating;
        if ($ratingModel->update()) {
            return true;
        } else {
            return false;
        }

    }


}
