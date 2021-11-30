<?php

namespace account\models\applications;

use common\models\ApplicationTypes;
use common\models\AssignedCategories;
use common\models\EmployerApplications;
use common\models\Users;
use yii\helpers\Url;
use Yii;
use common\models\AppliedApplications;

class UserAppliedApplication
{
    public function getUserDetails($type, $limit = null)
    {
        $u = AppliedApplications::find()
            ->alias('a')
            ->select(['a.status', 'a.created_on', 'g.name type', 'a.applied_application_enc_id', 'a.application_enc_id', 'a.rejection_window', 'f.username', 'd.name job_title', 'e.icon', 'CONCAT_WS(" ",f.first_name,f.last_name) fullname', 'f.image', 'f.image_location', 'f.initials_color'])
            ->where(['or',
                ['a.status' => 'Pending'],
                ['a.status' => 'Incomplete']
            ])
            ->joinWith(['applicationEnc b' => function ($b) use ($type) {
                $b->andWhere(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'b.is_deleted' => 0]);
                $b->joinWith(['applicationTypeEnc g' => function ($b) use ($type) {
                    $b->andWhere(['g.name' => $type]);
                }], false, 'INNER JOIN');
                $b->joinWith(['title c' => function ($c) {
                    $c->joinWith(['categoryEnc d'], false);
                    $c->joinWith(['parentEnc e'], false);
                }], false);
            }], false)
            ->joinWith(['createdBy f'], false)
            ->andWhere(['a.is_deleted' => 0])
            ->orderBy(['created_on' => SORT_DESC])
            ->limit($limit)
            ->asArray()
            ->all();

        return $u;
    }

    public function total_applied($type = null)
    {
        $total_applications = AppliedApplications::find()
            ->alias('a')
            ->innerJoin(EmployerApplications::tableName() . 'as b', 'b.application_enc_id = a.application_enc_id')
            ->innerJoin(ApplicationTypes::tableName() . 'as f', 'f.application_type_enc_id = b.application_type_enc_id')
            ->where(['b.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id])
            ->andWhere(['b.is_deleted' => 0])
            ->andWhere(['f.name' => $type])
            ->innerJoin(Users::tableName() . 'as e', 'e.user_enc_id = a.created_by')
            ->groupBy(['a.applied_application_enc_id'])
            ->count();
        return $total_applications;
    }

    public function getUserOtherDetails($type, $limit = null)
    {
        $db = EmployerApplications::find()
            ->distinct()
            ->select(['y1.name job_title', 'z.organization_enc_id', 'z.application_enc_id', 'z.slug', 'z.application_type_enc_id', 'x2.name type'])
            ->alias('z')
            ->joinWith(['applicationInterviewQuestionnaires aiq' => function ($a1) {
                $a1->groupBy(['aiq.interview_questionnaire_enc_id']);
                $a1->select(['aiq.application_enc_id', 'aiq.field_enc_id', 'aiq.interview_questionnaire_enc_id as id', 'aiq.questionnaire_enc_id as qid', 'aiq1.questionnaire_name as name', 'aiq2.field_label']);
                $a1->joinWith(['questionnaireEnc aiq1'], false);
                $a1->joinWith(['fieldEnc aiq2'], false);
            }])
            ->joinWith(['applicationTypeEnc x2' => function ($x2) use ($type) {
                $x2->andWhere(['x2.name' => $type], false);
            }], false)
            ->joinWith(['title0 y' =>
                function ($y) {
                    $y->joinWith(['categoryEnc y1'], false);
                }], false)
            ->andWhere(['z.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'z.is_deleted' => 0])
            ->andWhere(['not', ['z.status' => 'Closed']])
            ->groupBy(['z.application_enc_id'])
//            ->limit(10)
            ->asArray()
            ->all();
        foreach ($db as $key => $value) {
            $a = AppliedApplications::find()->alias('aa')
                ->select(['aa.applied_application_enc_id', 'aa.application_enc_id', 'aa.created_on', 'aa.status', 'aa.rejection_window', 'COUNT(CASE WHEN c.is_completed = 1 THEN 1 END) as active', 'aa.created_by', 'aa.resume_enc_id', 'e.resume', 'e.resume_location', 'b.user_enc_id', 'b.username', 'CONCAT(b.first_name, " ", b.last_name) name', 'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->digitalOcean->baseUrl . Yii::$app->params->digitalOcean->rootDirectory . Yii::$app->params->upload_directories->users->image) . '", b.image_location, "/", b.image) ELSE NULL END image', 'b.initials_color'])
                ->orderBy(['aa.created_on' => SORT_DESC])
                ->groupBy(['aa.applied_application_enc_id'])
                ->joinWith(['resumeEnc e'], false)
                ->joinWith(['appliedApplicationProcesses c' => function ($c) {
                    $c->joinWith(['fieldEnc d'], false);
                    $c->select(['c.applied_application_enc_id', 'c.process_enc_id', 'c.field_enc_id', 'd.field_name', 'd.icon']);
                }])
                ->joinWith(['createdBy b' => function ($b) {
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
                    $cr->groupBy(['cr.candidate_rejection_enc_id']);
                }])
                ->where(['aa.application_enc_id' => $value['application_enc_id']])
                ->andWhere(['aa.is_deleted' => 0])
                ->asArray()->limit(4)->all();
            $db[$key]['applied'] = $a;
        }
        return $db;
    }
}