<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\EmployerApplications;
use common\models\AppliedApplications;
use common\models\ApplicationInterviewQuestionnaire;

class ProcessApplicationsController extends Controller
{

    public function actionIndex($aidk)
    {

        $application_id = $aidk;
        if (Yii::$app->user->identity->organization) {
            $applied_users = AppliedApplications::find()
                ->distinct()
                ->alias('a')
                ->where(['a.application_enc_id' => $application_id])
                ->select(['e.resume', 'e.resume_location', 'a.applied_application_enc_id,a.status, b.username, CONCAT(b.first_name, " ", b.last_name) name, CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'COUNT(c.is_completed) total'])
                ->joinWith(['createdBy b'], false)
                ->joinWith(['resumeEnc e'], false)
                ->joinWith(['appliedApplicationProcesses c' => function ($b) {
                    $b->joinWith(['fieldEnc d'], false);
                    $b->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon']);
                }])
                ->groupBy(['a.applied_application_enc_id'])
                ->asArray()
                ->all();
            $application_name = EmployerApplications::find()
                ->alias('a')
                ->select(['c.name job_title'])
                ->where(['a.application_enc_id' => $aidk])
                ->joinWith(['title b' => function ($b) {
                    $b->joinWith(['categoryEnc c'], false, 'INNER JOIN');
                }], false, 'INNER JOIN')
                ->asArray()
                ->one();
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
