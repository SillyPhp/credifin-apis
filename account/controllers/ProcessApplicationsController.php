<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\EmployerApplications;
use common\models\AppliedApplications;
use common\models\ApplicationInterviewQuestionnaire;
use yii\web\HttpException;

class ProcessApplicationsController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    public function actionIndex($aidk)
    {
        $application_id = $aidk;
        if (Yii::$app->user->identity->organization) {
            $application_name = EmployerApplications::find()
                ->alias('a')
                ->select(['c.name job_title','a.interview_process_enc_id'])
                ->where(['a.application_enc_id' => $aidk])
                ->andWhere(['a.organization_enc_id'=>Yii::$app->user->identity->organization->organization_enc_id])
                ->joinWith(['title b' => function ($b) {
                    $b->joinWith(['categoryEnc c'], false, 'INNER JOIN');
                }], false, 'INNER JOIN')
                ->joinWith(['interviewProcessEnc d' => function($d){
                    $d->select(['d.interview_process_enc_id']);
                    $d->joinWith(['interviewProcessFields']);
                }])
                ->asArray()
                ->one();
            if (!empty($application_name))
            {
                $applied_users = AppliedApplications::find()
                    ->distinct()
                    ->alias('a')
                    ->where(['a.application_enc_id' => $application_id])
                    ->select(['e.resume', 'e.resume_location', 'a.applied_application_enc_id,a.status, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'COUNT(c.is_completed) total', 'a.created_by'])
                    ->joinWith(['resumeEnc e'], false)
                    ->joinWith(['appliedApplicationProcesses c' => function ($c) {
                        $c->joinWith(['fieldEnc d'], false);
                        $c->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon']);
                    }])
                    ->joinWith(['createdBy b' => function ($b) {
                        $b->joinWith(['userSkills b1' =>function($b1){
                            $b1->groupBy(['b1.user_skill_enc_id']);
                            $b1->select(['b1.skill_enc_id', 'b1.user_skill_enc_id','b2.skill', 'b1.created_by']);
                            $b1->joinWith(['skillEnc b2'], false);
                            $b1->onCondition(['b1.is_deleted' => 0]);
                        }]);
                        $b->joinWith(['userWorkExperiences b11' => function($b11){
                            $b11->groupBy(['b11.experience_enc_id']);
                            $b11->select(['b11.created_by', 'b11.company', 'b11.is_current', 'b11.title']);
                        }]);
                        $b->joinWith(['userEducations b21' => function($b21){
                            $b21->groupBy(['b21.education_enc_id']);
                            $b21->select(['b21.user_enc_id', 'b21.institute', 'b21.degree']);
                        }]);
                        $b->joinWith(['userPreferredIndustries b31' => function($b31){
                            $b31->groupBy(['b31.industry_enc_id']);
                            $b31->select(['b31.industry_enc_id', 'b32.industry', 'b31.created_by']);
                            $b31->joinWith(['industryEnc b32'], false);
                            $b31->onCondition(['b31.is_deleted' => 0]);
                        }]);
                    }])
                    ->groupBy(['a.applied_application_enc_id'])
                    ->asArray()
                    ->all();

                $question = ApplicationInterviewQuestionnaire::find()
                    ->alias('a')
                    ->distinct()
                    ->where(['a.application_enc_id' => $application_id])
                    ->select(['a.interview_questionnaire_enc_id as id', 'a.questionnaire_enc_id as qid', 'b.questionnaire_name as name', 'c.field_label'])
                    ->joinWith(['questionnaireEnc b'], false)
                    ->joinWith(['fieldEnc c'], false)
                    ->orderBy(['a.id' => SORT_DESC])
                    ->asArray()
                    ->all();
                return $this->render('index', [
                    'fields' => $applied_users,
                    'que' => $question,
                    'application_name' => $application_name,
                    'application_id'=>$application_id,
                ]);
            }
            else{
                throw new HttpException(404, Yii::t('account', 'Page not found.'));
            }
        } else {
            $applied_user = AppliedApplications::find()
                ->distinct()
                ->alias('a')
                ->where(['a.application_enc_id' => $application_id, 'a.created_by' => Yii::$app->user->identity->user_enc_id])
                ->select(['a.applied_application_enc_id', 'a.status', 'i.icon', 'h.name org_name', 'h.slug org_slug', 'g.name title', 'b.slug', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'COUNT(c.is_completed) total'])
                ->joinWith(['applicationEnc b' => function ($b) {
                    $b->joinWith(['organizationEnc h'], false);
                    $b->joinWith(['title f' => function ($b) {
                        $b->joinWith(['parentEnc i'], false);
                        $b->joinWith(['categoryEnc g'], false);
                    }], false);

                }], false)
                ->joinWith(['appliedApplicationProcesses c' => function ($b) {
                    $b->joinWith(['fieldEnc d'], false);
                    $b->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon']);
                }])
                ->groupBy(['a.applied_application_enc_id'])
                ->asArray()
                ->one();

            return $this->render('individual_candidate_process', [
                'applied' => $applied_user,
            ]);
        }
    }
}