<?php

namespace account\controllers;

use yii\web\Response;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class TemplatesController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (!empty(Yii::$app->user->identity->organization)) {
            return $this->render('index', [
                'questionnaire' => $this->__questionnaire(4),
                'interview_processes' => $this->__interviewProcess(4),
                'jobs' => $this->__getApplications("Jobs"),
                'internships' => $this->__getApplications("Internships"),
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

    private function __getApplications($type = 'Jobs')
    {
        $application = \common\models\ApplicationTemplates::find()
            ->alias('a')
            ->select(['a.application_enc_id', 'a.title', 'zz.name as cat_name','z1.icon_png', 'g.designation'])
            ->joinWith(['title0 z' => function ($z) {
                $z->joinWith(['categoryEnc zz']);
                $z->joinWith(['parentEnc z1']);
            }], false)
            ->joinWith(['applicationTypeEnc f'], false)
            ->joinWith(['designationEnc g'], false)
            ->where(['f.name' => $type, 'a.is_deleted' => 0, 'a.status' => "Active"])
            ->orderBy(['a.created_on' => SORT_DESC])
            ->andWhere([
                'or',
                ['a.template_industry_enc_id' => NULL],
                ['a.template_industry_enc_id' => Yii::$app->user->identity->organization->industry_enc_id]
            ])
            ->asArray()
            ->all();

        return $application;
    }
}