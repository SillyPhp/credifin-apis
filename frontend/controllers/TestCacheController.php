<?php

namespace frontend\controllers;
use common\models\EducationLoanPayments;
use common\models\EmployerApplications;
use common\models\ReviewedApplications;
use yii\web\Controller;
use yii\helpers\Url;
use common\models\Utilities;
use Yii;

class TestCacheController extends Controller
{
  public function actionTest()
  {
      print_r($this->getUserOtherDetails('jobs'));
  }

    public function getUserOtherDetails($type,$limit=null)
    {
      return  $applied_users = EmployerApplications::find()
            ->distinct('z.application_enc_id')
            ->alias('z')
            ->select(['y1.name job_title', 'z.organization_enc_id', 'z.application_enc_id'])
            ->joinWith(['appliedApplications a' => function ($a) use ($type) {
                //$a->select(['a.applied_application_enc_id', 'a.application_enc_id', 'a.status', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'a.created_by', 'a.resume_enc_id', 'e.resume', 'e.resume_location', 'b.user_enc_id', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image',]);
                $a->limit();
                $a->select(['a.application_enc_id','a.applied_application_enc_id']);
                $a->andWhere(['a.is_deleted' => 0]);
                $a->orderBy(['a.created_on' => SORT_DESC]);
                $a->groupBy(['a.applied_application_enc_id']);
                $a->joinWith(['resumeEnc e'], false);
                $a->joinWith(['appliedApplicationProcesses c' => function ($c) {
                    $c->joinWith(['fieldEnc d'], false);
                    $c->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon']);
                }],false);
                $a->joinWith(['createdBy b' => function ($b) {
                    $b->joinWith(['userSkills b1' => function ($b1) {
                        $b1->select(['b1.skill_enc_id', 'b1.user_skill_enc_id', 'b2.skill', 'b1.created_by']);
                        $b1->joinWith(['skillEnc b2'], false);
                        $b1->onCondition(['b1.is_deleted' => 0]);
                    }]);
                    $b->joinWith(['userWorkExperiences b11' => function ($b11) {
                        $b11->select(['b11.created_by', 'b11.company', 'b11.is_current', 'b11.title']);
                    }]);
                    $b->joinWith(['userEducations b21' => function ($b21) {
                        $b21->select(['b21.user_enc_id', 'b21.institute', 'b21.degree']);
                    }]);
                    $b->joinWith(['userPreferredIndustries b31' => function ($b31) {
                        $b31->select(['b31.industry_enc_id', 'b32.industry', 'b31.created_by']);
                        $b31->joinWith(['industryEnc b32'], false);
                        $b31->onCondition(['b31.is_deleted' => 0]);
                    }]);
                }],false);
//                $a->limit(7);
            }])
            ->joinWith(['applicationInterviewQuestionnaires aiq' => function ($a1) {
                $a1->groupBy(['aiq.interview_questionnaire_enc_id']);
                $a1->select(['aiq.application_enc_id', 'aiq.field_enc_id', 'aiq.interview_questionnaire_enc_id as id', 'aiq.questionnaire_enc_id as qid', 'aiq1.questionnaire_name as name', 'aiq2.field_label']);
                $a1->joinWith(['questionnaireEnc aiq1'], false);
                $a1->joinWith(['fieldEnc aiq2'], false);
            }],false)
            ->joinWith(['applicationTypeEnc x2' => function ($x2) use ($type) {
                $x2->andWhere(['x2.name' => $type], false);
            }], false)
            ->joinWith(['title0 y' =>
                function ($y) {
                    $y->joinWith(['categoryEnc y1'], false);
                }], false)
            ->andWhere(['z.organization_enc_id' => 'G80XgQwNbyWQn8JOjJvvlra2EBJq1k', 'z.is_deleted' => 0])
            ->groupBy(['z.application_enc_id'])
            ->limit(2)
            ->asArray()
            ->all();
    }
}