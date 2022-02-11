<?php

namespace account\controllers;

use common\models\Industries;
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
                'ind_jobs' => $this->__getApplications("Jobs", "with_ind"),
                'other_jobs' => $this->__getApplications("Jobs", "without_ind"),
                'ind_internships' => $this->__getApplications("Internships", "with_ind"),
                'other_internships' => $this->__getApplications("Internships", "without_ind"),
                'industry' => Industries::find()->andWhere(['industry_enc_id'=>Yii::$app->user->identity->organization->industry_enc_id])->asArray()->one()
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

    private function __getApplications($type = 'Internships', $con)
    {
        $application = \common\models\ApplicationTemplates::find()
            ->alias('a')
            ->select(['f.name temp_type','temp.industry template_industry' ,'a.application_enc_id', 'a.title', 'a.template_industry_enc_id', 'zz.name as cat_name','z1.icon_png', 'g.designation', 'z1.name as parent_name'])
            ->joinWith(['title0 z' => function ($z) {
                $z->joinWith(['categoryEnc zz']);
                $z->joinWith(['parentEnc z1']);
            }],false)
            ->joinWith(['applicationTypeEnc f'], false)
            ->joinWith(['designationEnc g'], false)
            
            ->joinWith(['templateIndustryEnc temp'], false)
            ->where(['f.name' => $type, 'a.is_deleted' => 0, 'a.status' => "Active"])
            ->orderBy(['a.created_on' => SORT_DESC]);
            if($con == "with_ind"){
                $application = $application->andWhere(['a.template_industry_enc_id' => Yii::$app->user->identity->organization->industry_enc_id]);
            }else{
                $application = $application->andWhere(['or', ['a.template_industry_enc_id' => null], ['not', ['a.template_industry_enc_id' => Yii::$app->user->identity->organization->industry_enc_id]]]);
            }
            $application = $application->asArray()->limit(4)
            ->all();

        return $application;
    }
    
    public function actionIndustry()
    {
        if (!empty(Yii::$app->user->identity->organization)) {
            $industry = Industries::find()->andWhere(['industry_enc_id'=>Yii::$app->user->identity->organization->industry_enc_id])->asArray()->one();
            $application = \common\models\ApplicationTemplates::find()
                ->alias('a')
                ->select(['f.name as temp_type', 'a.template_industry_enc_id', 'a.application_enc_id', 'a.title', 'zz.name as cat_name', 'z1.icon_png', 'z1.name as parent_name'])
                ->joinWith(['title0 z' => function ($z) {
                    $z->joinWith(['categoryEnc zz']);
                    $z->joinWith(['parentEnc z1']);
                }], false)
                ->joinWith(['applicationTypeEnc f'], false)
                ->joinWith(['templateIndustryEnc temp'], false)
                ->andWhere(['a.template_industry_enc_id' => $industry['industry_enc_id']])
                ->andWhere(['a.is_deleted' => 0])
                ->orderBy(['f.name' => SORT_DESC])
                ->asArray()
                ->all();


            return $this->render('/jobs/jobs-templates', [
                'jobs' => $application,
            ]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }

    public function actionOther()
    {
        if (!empty(Yii::$app->user->identity->organization)) {
            $industry = Industries::find()->andWhere(['industry_enc_id'=>Yii::$app->user->identity->organization->industry_enc_id])->asArray()->one();
            $application = \common\models\ApplicationTemplates::find()
                ->alias('a')
                ->select(['f.name as temp_type', 'a.template_industry_enc_id', 'temp.industry template_industry','a.application_enc_id', 'a.title', 'zz.name as cat_name', 'z1.icon_png', 'z1.name as parent_name'])
                ->joinWith(['title0 z' => function ($z) {
                    $z->joinWith(['categoryEnc zz']);
                    $z->joinWith(['parentEnc z1']);
                }], false)
                ->joinWith(['applicationTypeEnc f'], false)
                ->joinWith(['templateIndustryEnc temp'], false)
                ->andWhere([
                    'or',
                    ['not', ['a.template_industry_enc_id' => $industry['industry_enc_id']]],
                    ['a.template_industry_enc_id' => null]
                    ])
                ->andWhere(['a.is_deleted' => 0])
                ->orderBy(['f.name' => SORT_DESC])
                ->asArray()
                ->all();


            return $this->render('/jobs/jobs-templates', [
                'jobs' => $application,
            ]);
        } else {
            throw new HttpException(404, Yii::t('account', 'Page not found.'));
        }
    }
}