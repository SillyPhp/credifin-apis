<?php

namespace account\controllers;

use yii\web\Response;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class TemplatesController extends Controller
{
    public function actionIndex()
    {
        if (!empty(Yii::$app->user->identity->organization)) {
            return $this->render('index', [
                'questionnaire' => $this->__questionnaire(4),
                'interview_processes' => $this->__interviewProcess(4),
            ]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }

    }

    private function __questionnaire($limit = NULL)
    {
        $options = [
            'orderBy' => [
                'a.created_on' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $questionnaire = new \account\models\templates\TemplateQuestionnaire();
        return $questionnaire->getQuestionnaire($options);
    }

    private function __interviewProcess($limit = NULL)
    {
        $options = [
            'orderBy' => [
                'a.created_on' => SORT_DESC,
            ],
            'limit' => $limit,
        ];

        $processess = new \account\models\templates\TemplateHiringProcess();
        return $processess->getProcesses($options);
    }
}