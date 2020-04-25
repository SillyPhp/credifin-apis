<?php

namespace frontend\controllers;
use account\models\questionnaire\QuestionnaireViewForm;
use common\models\OrganizationQuestionnaire;
use common\models\QuestionnaireFieldOptions;
use common\models\QuestionnaireFields;
use common\models\SuggestionGroup;
use common\models\SuggestionQuestionnaire;
use common\models\SuggestionQuestionnaireFields;
use common\models\Utilities;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;
use yii\web\HttpException;
use yii\db\Expression;

class QuestionSuggestionController extends Controller
{
    public function actionSaveResponse()
    {
        $model = new QuestionnaireViewForm();
        if (Yii::$app->request->isPost)
        {
            $data = Yii::$app->request->post('data');
            $qidk = Yii::$app->request->post('id');
            if ($model->saveResponse($data,$qidk)) {
                return true;
            } else {
                return false;
            }
        }
    }
}