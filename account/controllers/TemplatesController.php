<?php


namespace account\controllers;
use account\models\questionnaire\QuestionnaireViewForm;
use account\models\templates\QuestionnaireModel;
use common\models\QuestionnaireTemplateFieldOptions;
use common\models\QuestionnaireTemplateFields;
use common\models\QuestionnaireTemplates;
use yii\web\Response;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
class TemplatesController extends Controller
{
   public function actionIndex()
   {
       if (!empty(Yii::$app->user->identity->organization)) {

           return  $this->render('templates',[
               'questionnaire' => $this->__questionnaire(4),
           ]);
       }
       else
       {
           throw new HttpException(404, Yii::t('account', 'Page not found.'));
       }

   }

    public function actionQuestionnaire($id)
    {
        $this->layout = 'main-secondary';
        $model = new QuestionnaireViewForm();
        $result = QuestionnaireTemplates::find()
            ->select(['questionnaire_enc_id', 'questionnaire_name'])
            ->where(['questionnaire_enc_id' => $id])
            ->asArray()
            ->one();

        $fields = QuestionnaireTemplateFields::find()
            ->alias('a')
            ->select(['a.field_enc_id', 'a.field_name', 'a.field_label', 'a.sequence', 'a.field_type', 'a.placeholder', 'a.is_required'])
            ->where(['a.questionnaire_enc_id' => $result['questionnaire_enc_id']])
            ->asArray()
            ->all();
        if (empty($result) || empty($fields)) {
            return 'not found';
        }
        foreach ($fields as $field) {
            $field_option = QuestionnaireTemplateFieldOptions::find()
                ->select(['field_option_enc_id', 'field_option'])
                ->where(['field_enc_id' => $field['field_enc_id']])
                ->asArray()
                ->all();
            $field['options'] = $field_option;
            $arr['fields'][] = $field;
        }


        return $this->render('/questionnaire/display', [
            'fields' => $arr,
            'model' => $model,
            'result' => $result,
        ]);
    }

    public function actionAssignQuestionnaireTemplate()
    {
        if (Yii::$app->request->isPost)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            $q = new QuestionnaireModel();
            if ($q->assignToOrg($id))
            {
               return [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Added To Your List'
                     ];
            }
            else
            {
                return [
                    'status' => 201,
                    'title' => 'error',
                    'message' => 'Something went wrong'
                ];
            }


        }
    }

    private function __questionnaire($limit = NULL)
    {
        $options = [
            'questionnaireType' => 1,
            'orderBy' => [
                'created_on' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $questionnaire = new \account\models\templates\TemplateQuestionnaire();
        return $questionnaire->getQuestionnaire($options);
    }
}