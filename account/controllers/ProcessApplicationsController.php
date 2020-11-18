<?php

namespace account\controllers;

use common\models\HiringProcessNotes;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\EmployerApplications;
use common\models\AppliedApplications;
use common\models\ApplicationInterviewQuestionnaire;
use yii\web\HttpException;
use yii\web\Response;

class ProcessApplicationsController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }
    private function GetJobsOfCompany($appType,$app_id){
        $all_application = EmployerApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['c.name job_title', 'a.slug', 'a.application_enc_id', 'ate.name application_type', 'pe.icon'])
            ->joinWith(['title b' => function ($b) {
                $b->joinWith(['categoryEnc c'], false, 'INNER JOIN');
                $b->joinWith(['parentEnc pe'], false, 'INNER JOIN');
            }], false, 'INNER JOIN')
            ->joinWith(['applicationTypeEnc ate'], false)
            ->joinWith(['applicationPlacementLocations o' => function ($b) {
                $b->onCondition(['o.is_deleted' => 0]);
                $b->joinWith(['locationEnc s' => function ($b) {
                    $b->joinWith(['cityEnc t'], false);
                }], false);
                $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 's.latitude', 's.longitude', 't.city_enc_id', 't.name']);
                $b->distinct();
            }])
            ->joinWith(['applicationOptions ao'], false)
            ->where(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'a.is_deleted' => 0,'ate.name'=>$appType])
            ->andWhere(['not',['a.application_enc_id'=>$app_id]])
            ->asArray()
            ->all();
        return $all_application;
    }
    public function actionIndex($aidk)
    {
        $application_id = $aidk;
        if (Yii::$app->user->identity->organization) {
            $application_name = EmployerApplications::find()
                ->alias('a')
                ->select(['c.name job_title','a.slug','a.application_enc_id','a.interview_process_enc_id','ate.name application_type','pe.icon',
                    '(CASE
                WHEN a.experience = "0" THEN "No Experience"
                WHEN a.experience = "1" THEN "Less Than 1 Year"
                WHEN a.experience = "2" THEN "1 Year"
                WHEN a.experience = "3" THEN "2-3 Years"
                WHEN a.experience = "3-5" THEN "3-5 Years"
                WHEN a.experience = "5-10" THEN "5-10 Years"
                WHEN a.experience = "10-20" THEN "10-20 Years"
                WHEN a.experience = "20+" THEN "More Than 20 Years"
                WHEN a.minimum_exp = "0" AND a.maximum_exp IS NUll THEN "No Experience"
                WHEN a.minimum_exp = "20" AND a.maximum_exp = "20+" THEN "More Than 20 Years Experience"
                WHEN a.minimum_exp IS NOT NUll AND a.maximum_exp IS NOT NUll THEN CONCAT(a.minimum_exp,"-",a.maximum_exp," Years Experience")
                WHEN a.minimum_exp IS NOT NUll AND a.maximum_exp IS NUll THEN CONCAT("Minimum ",a.minimum_exp," Years Experience") 
                WHEN a.minimum_exp IS NUll AND a.maximum_exp IS NOT NUll THEN CONCAT("Maximum ",a.maximum_exp," Years Experience") 
                ELSE "No Experience" 
                END) as experience','ao.wage_type','ao.fixed_wage','ao.min_wage','ao.max_wage','ao.wage_duration'])
                ->where(['a.application_enc_id' => $aidk])
                ->andWhere(['a.organization_enc_id'=>Yii::$app->user->identity->organization->organization_enc_id])
                ->joinWith(['title b' => function ($b) {
                    $b->joinWith(['categoryEnc c'], false, 'INNER JOIN');
                    $b->joinWith(['parentEnc pe'], false, 'INNER JOIN');
                }], false, 'INNER JOIN')
                ->joinWith(['applicationTypeEnc ate'],false)
                ->joinWith(['interviewProcessEnc d' => function($d){
                    $d->select(['d.interview_process_enc_id']);
                    $d->joinWith(['interviewProcessFields']);
                }])
                ->joinWith(['applicationPlacementLocations o' => function ($b) {
                    $b->onCondition(['o.is_deleted' => 0]);
                    $b->joinWith(['locationEnc s' => function ($b) {
                        $b->joinWith(['cityEnc t'], false);
                    }], false);
                    $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 's.latitude', 's.longitude', 't.city_enc_id', 't.name']);
                    $b->distinct();
                }])
                ->joinWith(['applicationInterviewLocations p' => function ($b) {
                    $b->onCondition(['p.is_deleted' => 0]);
                    $b->joinWith(['locationEnc u' => function ($b) {
                        $b->joinWith(['cityEnc v'], false);
                    }], false);
                    $b->select(['p.location_enc_id', 'p.application_enc_id', 'v.city_enc_id', 'v.name', 'u.latitude as interview_lat', 'u.longitude as interview_long']);
                }])
                ->joinWith(['applicationOptions ao'], false)
                ->asArray()
                ->one();

            if (!empty($application_name))
            {
                $applied_users = AppliedApplications::find()
                    ->distinct()
                    ->alias('a')
                    ->where(['a.application_enc_id' => $application_id])
                    ->select(['e.resume', 'e.resume_location', 'a.applied_application_enc_id,a.status, b.username, b.initials_color, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'COUNT(DISTINCT(c.is_completed)) total', 'a.created_by','a.created_on'])
                    ->joinWith(['resumeEnc e'], false)
                    ->joinWith(['appliedApplicationProcesses c' => function ($c) {
                        $c->joinWith(['fieldEnc d'], false);
                        $c->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon', 'c.is_completed']);
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
                    ->joinWith(['hiringProcessNotes sh' => function($sh){
                        $sh->select(['sh.applied_application_enc_id','sh.notes_enc_id', 'sh.notes']);
                    }])
                    ->groupBy(['a.applied_application_enc_id'])
                    ->orderBy(['a.status' => SORT_ASC])
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
                    'similarApps'=>$this->GetJobsOfCompany($application_name['application_type'], $aidk),
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

    public function actionProcessNotes(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            $note = Yii::$app->request->post('note');
            $alreadyExist =HiringProcessNotes::find()
            ->where(['applied_application_enc_id'=> $id,'created_by'=>Yii::$app->user->identity->user_enc_id])
            ->one();
            if ($alreadyExist){
                 $alreadyExist->notes = $note;
                 $alreadyExist->last_updated_by = Yii::$app->user->identity->user_enc_id;
                 if($alreadyExist->update()){
                     return [
                         'status' => 200,
                         'title' => 'Success',
                         'message' => 'Reminder added successfully.'
                     ];
                 } else {
                     return [
                         'status' => 201,
                         'message' => 'Something went wrong. Please try again.',
                         'title' => 'Opps!!',
                     ];
                 }
            }else{
                $porcessNotes = new HiringProcessNotes();
                $utilitiesModel = new \common\models\Utilities();
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $porcessNotes->notes_enc_id = $utilitiesModel->encrypt();
                $porcessNotes->notes = $note;
                $porcessNotes->applied_application_enc_id = $id;
                $porcessNotes->created_by = Yii::$app->user->identity->user_enc_id;
                if ($porcessNotes->save()) {
                    return [
                        'status' => 200,
                        'title' => 'Success',
                        'message' => 'Reminder added successfully.'
                    ];
                } else {
                    return [
                        'status' => 201,
                        'message' => 'Something went wrong. Please try again.',
                        'title' => 'Opps!!',
                    ];
                }
            }
        }
    }
}