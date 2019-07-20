<?php

namespace account\controllers;

use common\models\ReferralJobAppliedTracking;
use Yii;
use common\models\Users;
use yii\web\Controller;

class InstitutesController extends Controller
{
    public function actionManageCandidates(){
        $data = ReferralJobAppliedTracking::find()
            ->alias('a')
            ->select(['a.applied_enc_id'])
            ->joinWith(['referralEnc b'], false)
            ->innerJoinWith(['appliedEnc c' => function($c){
                $c->distinct();
                $c->innerJoinWith(['appliedApplicationProcesses d' => function($z){
                    $z->joinWith(['fieldEnc z'], false);
                    $z->select(['d.applied_application_enc_id', 'd.field_enc_id', 'd.is_completed', 'z.field_name', 'z.icon']);
                }]);
                $c->innerJoinWith(['applicationEnc e' => function($d){
                    $d->joinWith(['organizationEnc f'=> function($e){
                        $e->select(['f.organization_enc_id', 'f.name','f.slug']);
                    }]);
//                    $d->joinWith(['title h'],false);
//                    $d->select(['e.application_enc_id','e.organization_enc_id','e.slug']);
                }]);
                $c->joinWith(['createdBy g'], false);
                $c->select(['c.applied_application_enc_id','c.application_enc_id','c.current_round','c.status','c.created_by',' CONCAT(g.first_name, " ", g.last_name) name']);
                $c->onCondition(['c.is_deleted' => 0]);
            }])
            ->distinct()
            ->groupBy(['g.first_name'])
            ->where(['b.code' => Yii::$app->user->identity->referral->code, 'a.is_deleted' => 0])
            ->asArray()
            ->limit(20)
            ->all();

        return $this->render('manage-candidates',[
            'users' => $data,
        ]);
    }

//    public function actionManageCandidates(){
//        $users = Users::find()
//            ->alias('a')
//            ->select(['a.user_enc_id', 'a.username', 'a.first_name', 'a.last_name', 'a.image', 'a.image_location'])
//            ->innerJoinWith(['appliedApplications b' => function($b){
//                $b->distinct();
//                $b->innerJoinWith(['appliedApplicationProcesses c'], false);
//                $b->innerJoinWith(['applicationEnc d' => function($c){
//                    $c->onCondition(['d.organization_enc_id' => Yii::$app->user->identity->organization->organization_enc_id, 'd.is_deleted' => 0]);
//                    $c->joinWith(['organizationEnc e'=> function($d){
//                        $d->select(['e.organization_enc_id', 'e.name','e.slug']);
//                    }]);
//                    $c->select(['d.application_enc_id','d.organization_enc_id','d.slug']);
//                }]);
//                $b->select(['b.applied_application_enc_id','b.application_enc_id','b.current_round','b.status','b.created_by']);
//                $b->onCondition(['b.is_deleted' => 0]);
//            }])
//            ->distinct()
//            ->where(['a.is_deleted' => 0])
//            ->asArray()
//            ->limit(20)
//            ->all();
//
////        print_r($users);
////        exit();
//        return $this->render('manage-candidates',[
//            'users' => $users,
//        ]);
//    }
}