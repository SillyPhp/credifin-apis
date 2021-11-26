<?php

namespace account\controllers;

use account\models\emails\SendEmailModel;
use common\models\ApplicationInterviewQuestionnaire;
use common\models\AppliedApplications;
use common\models\CandidateConsiderJobs;
use common\models\EmployerApplications;
use common\models\HiringProcessNotes;
use common\models\RejectionReasons;
use common\models\UserOtherDetails;
use common\models\Utilities;
use frontend\models\whatsAppShareForm;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

class ProcessApplicationsController extends Controller
{

    public function beforeAction($action)
    {
        Yii::$app->view->params['sub_header'] = Yii::$app->header->getMenuHeader('account/' . Yii::$app->controller->id, 2);
        return parent::beforeAction($action);
    }

    private function GetJobsOfCompany($appType, $app_id, $appFor)
    {
        $all_application = EmployerApplications::find()
            ->distinct()
            ->alias('a')
            ->select(['c.name job_title', 'a.slug', 'a.application_enc_id', 'a.application_for', 'ate.name application_type', 'pe.icon'])
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
            ->joinWith(['appliedApplications aa' => function ($aa) {
                $aa->select(['aa.application_enc_id']);
            }])
            ->joinWith(['applicationOptions ao'], false)
            ->where(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'a.is_deleted' => 0, 'ate.name' => $appType, 'a.status' => 'Active'])
            ->andWhere(['a.application_for' => $appFor])
            ->orderBy([new \yii\db\Expression('FIELD (a.application_enc_id, "' . $app_id . '") DESC')])
            ->asArray()
            ->all();
        return $all_application;
    }

    public function actionIndex($aidk)
    {
        $application_id = $aidk;
        $model = new SendEmailModel();
        $whatsAppmodel = new whatsAppShareForm();
        if (Yii::$app->request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model->email = Yii::$app->request->post('email');
            $model->application_id = Yii::$app->request->post('application_id');
            return $model->sendEmails();
        }
        if (Yii::$app->user->identity->organization) {
            $application_name = EmployerApplications::find()
                ->alias('a')
                ->select(['c.name job_title', 'a.application_for', 'a.application_for', 'a.slug', 'a.application_enc_id', 'a.interview_process_enc_id', 'ate.name application_type', 'pe.icon',
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
                END) as experience', 'ao.wage_type', 'ao.fixed_wage', 'ao.min_wage', 'ao.max_wage', 'ao.wage_duration', 'a.application_for'])
                ->where(['a.application_enc_id' => $aidk])
                ->andWhere(['a.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
                ->joinWith(['title b' => function ($b) {
                    $b->joinWith(['categoryEnc c'], false, 'INNER JOIN');
                    $b->joinWith(['parentEnc pe'], false, 'INNER JOIN');
                }], false, 'INNER JOIN')
                ->joinWith(['applicationTypeEnc ate'], false)
                ->joinWith(['interviewProcessEnc d' => function ($d) {
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
            if (!empty($application_name)) {
                $applied_users = AppliedApplications::find()
                    ->distinct()
                    ->alias('a')
                    ->where(['a.application_enc_id' => $application_id])
                    ->select(['a.current_round', 'a.id', 'e.resume', 'b.phone', 'b4.name college_name', 'b4.slug college_slug', 'b4.initials_color college_initials',
                        'CASE WHEN b4.logo IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->organizations->logo) . '", b4.logo_location, "/", b4.logo) ELSE NULL END college_logo',
                        'e.resume_location', 'a.applied_application_enc_id,a.status, b.username, b.initials_color, CASE WHEN b.last_name IS NOT NULL THEN CONCAT(b.first_name, " ", b.last_name) ELSE b.first_name END name , CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'COUNT(DISTINCT(c.is_completed)) total', 'a.created_by', 'a.created_on', 'a.rejection_window'])
                    ->joinWith(['resumeEnc e'], false)
                    ->joinWith(['appliedApplicationLocations aal' => function ($aal) {
                        $aal->select(['aal.applied_application_enc_id', 'aal.city_enc_id', 'ce.name']);
                        $aal->joinWith(['cityEnc as ce'], false);
                    }])
                    ->joinWith(['appliedApplicationProcesses c' => function ($c) {
                        $c->joinWith(['fieldEnc d'], false);
                        $c->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon', 'c.is_completed']);
                    }])
                    ->joinWith(['createdBy b' => function ($b) {
                        $b->joinWith(['userSkills b1' => function ($b1) {
                            $b1->groupBy(['b1.user_skill_enc_id']);
                            $b1->select(['b1.skill_enc_id', 'b1.user_skill_enc_id', 'b2.skill', 'b1.created_by']);
                            $b1->joinWith(['skillEnc b2'], false);
                            $b1->onCondition(['b1.is_deleted' => 0]);
                        }]);
                        $b->joinWith(['userWorkExperiences b11' => function ($b11) {
                            $b11->groupBy(['b11.experience_enc_id']);
                            $b11->select(['b11.created_by', 'b11.company', 'b11.is_current', 'b11.title']);
                        }]);
                        $b->joinWith(['userEducations b21' => function ($b21) {
                            $b21->groupBy(['b21.education_enc_id']);
                            $b21->select(['b21.user_enc_id', 'b21.institute', 'b21.degree']);
                        }]);
                        $b->joinWith(['userPreferredIndustries b31' => function ($b31) {
                            $b31->groupBy(['b31.industry_enc_id']);
                            $b31->select(['b31.industry_enc_id', 'b32.industry', 'b31.created_by']);
                            $b31->joinWith(['industryEnc b32'], false);
                            $b31->onCondition(['b31.is_deleted' => 0]);
                        }]);
                        $b->joinWith(['userOtherDetails b3' => function ($b3) {
                            $b3->joinWith(['organizationEnc b4']);
                        }], false);
                    }])
                    ->joinWith(['hiringProcessNotes sh' => function ($sh) {
                        $sh->select(['sh.applied_application_enc_id', 'sh.notes_enc_id', 'sh.notes']);
                    }])
                    ->joinWith(['candidateRejections cr' => function ($cr) {
                        $cr->select(['cr.rejection_type', 'cr.applied_application_enc_id', 'cr.candidate_rejection_enc_id']);
                        $cr->joinWith(['candidateConsiderJobs ccj' => function ($ccj) {
                            $ccj->select(['ccj.consider_job_enc_id', 'ccj.candidate_rejection_enc_id', 'ccj.application_enc_id']);
                            $ccj->joinWith(['applicationEnc ae' => function ($ae) {
                                $ae->select(['ae.application_enc_id', 'ae.slug', 'cc.name job_title', 'pe.icon']);
                                $ae->joinWith(['title bae' => function ($bae) {
                                    $bae->joinWith(['categoryEnc cc'], false);
                                    $bae->joinWith(['parentEnc pe'], false);
                                }], false);
                            }]);
                        }]);
                        $cr->joinWith(['candidateRejectionReasons cr1' => function ($cr1) {
                            $cr1->select(['cr1.candidate_rejection_enc_id', 'cr1.rejection_reasons_enc_id', 'cr2.reason']);
                            $cr1->joinWith(['rejectionReasonsEnc cr2'], false);
                        }]);
                        $cr->groupBy(['cr.candidate_rejection_enc_id']);
                    }])
                    ->groupBy(['a.applied_application_enc_id'])
                    ->orderBy([new \yii\db\Expression("FIELD (a.status, 'Rejected') asc"), 'a.created_on' => SORT_DESC, 'a.id' => SORT_DESC])
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
                $reasons = RejectionReasons::find()
                    ->select(['rejection_reason_enc_id', 'reason'])
                    ->where(['reason_by' => 1, 'is_deleted' => 0, 'status' => 'Approved'])
                    ->asArray()
                    ->all();

                return $this->render('index', [
                    'fields' => $applied_users,
                    'que' => $question,
                    'whatsAppmodel' => $whatsAppmodel,
                    'application_name' => $application_name,
                    'application_id' => $application_id,
                    'similarApps' => $this->GetJobsOfCompany($application_name['application_type'], $aidk, $application_name['application_for']),
                    'reasons' => $reasons,
                ]);
            } else {
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
                'model' => $model,
            ]);
        }
    }

    public function actionProcessNotes()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = Yii::$app->request->post('id');
            $note = Yii::$app->request->post('note');
            $alreadyExist = HiringProcessNotes::find()
                ->where(['applied_application_enc_id' => $id, 'created_by' => Yii::$app->user->identity->user_enc_id])
                ->one();
            if ($alreadyExist) {
                $alreadyExist->notes = $note;
                $alreadyExist->last_updated_by = Yii::$app->user->identity->user_enc_id;
                if ($alreadyExist->update()) {
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
            } else {
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

    public function actionAddReason()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $reason = Yii::$app->request->post('reason');
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model = new RejectionReasons();
            $model->rejection_reason_enc_id = $utilitiesModel->encrypt();
            $model->reason = $reason;
            $model->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
            $model->reason_by = 1;
            $model->created_by = Yii::$app->user->identity->user_enc_id;
            $model->created_on = date('Y-m-d H:i:s');
            if ($model->save()) {
                return json_encode(['status' => 200, 'reason_enc_id' => $model->rejection_reason_enc_id, 'reason' => $model->reason]);
            } else {
                return json_encode(['status' => 500, 'message' => 'an error occurred']);
            }
        }
    }

    public function actionRejectionWindow()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $applied_app_id = Yii::$app->request->post('app_id');
            $rejection_window = AppliedApplications::findOne(['applied_application_enc_id' => $applied_app_id]);
            if ($rejection_window) {
                $rejection_window->rejection_window = 1;
                $rejection_window->update();
            }
        }
    }

    public function actionHideRejectionWindow()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $applied_app_id = Yii::$app->request->post('app_id');
            $rejection_window = AppliedApplications::findOne(['applied_application_enc_id' => $applied_app_id]);
            if ($rejection_window) {
                $rejection_window->rejection_window = 0;
                $rejection_window->update();
            }
        }
    }

    public function actionShowConsiderJobs()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $reject_id = Yii::$app->request->post('reject_id');
            $considerJobs = CandidateConsiderJobs::find()
                ->alias('a')
                ->select(['a.consider_job_enc_id', 'a.application_enc_id'])
                ->joinWith(['applicationEnc ae' => function ($ae) {
                    $ae->select(['ae.application_enc_id', 'ae.slug', 'cc.name job_title', 'pe.icon', 'ao.positions']);
                    $ae->joinWith(['title bae' => function ($bae) {
                        $bae->joinWith(['categoryEnc cc'], false);
                        $bae->joinWith(['parentEnc pe'], false);
                    }], false)
                        ->joinWith(['applicationTypeEnc ate'], false)
                        ->joinWith(['applicationPlacementLocations o' => function ($b) {
                            $b->onCondition(['o.is_deleted' => 0]);
                            $b->joinWith(['locationEnc s' => function ($b) {
                                $b->joinWith(['cityEnc t'], false);
                            }], false);
                            $b->select(['o.location_enc_id', 'o.application_enc_id', 'o.positions', 's.latitude', 's.longitude', 't.city_enc_id', 't.name']);
                            $b->groupBy(['o.application_enc_id']);
                        }])
                        ->joinWith(['applicationOptions ao'], false);
                }])
                ->where(['candidate_rejection_enc_id' => $reject_id])
                ->asArray()
                ->all();
            if ($considerJobs) {
                $positions = 0;
                foreach ($considerJobs as $k => $v) {
                    $considerJobs[$k]['slug'] = $v['applicationEnc']['slug'];
                    $considerJobs[$k]['job_title'] = $v['applicationEnc']['job_title'];
                    $considerJobs[$k]['icon'] = $v['applicationEnc']['icon'];
                    if ($v['applicationEnc']['applicationPlacementLocations']) {
                        foreach ($v['applicationEnc']['applicationPlacementLocations'] as $l) {
                            $considerJobs[$k]['positions'] += $l['positions'];
                        }
                    } else {
                        $considerJobs[$k]['positions'] = $v['applicationEnc']['positions'];
                    }
                }
                return ['status' => 200, 'jobs' => $considerJobs];
            } else {
                return ['status' => 404];
            }
        }
    }

}