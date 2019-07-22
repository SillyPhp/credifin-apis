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
            ->select(['a.applied_enc_id','a.referral_enc_id'])
            ->joinWith(['referralEnc b'], false)
            ->innerJoinWith(['appliedEnc c' => function($c){
                $c->distinct();
                $c->innerJoinWith(['appliedApplicationProcesses d' => function($z){
                    $z->joinWith(['fieldEnc z'], false);
                    $z->select(['d.applied_application_enc_id', 'd.field_enc_id', 'd.is_completed', 'z.field_name', 'z.icon']);
                }]);
                $c->innerJoinWith(['applicationEnc e' => function($d){
                    $d->joinWith(['organizationEnc f'=> function($e){
                        $e->select(['f.organization_enc_id', 'f.name', 'f.logo', 'f.logo_location', 'f.initials_color as org_initials', 'f.slug']);
                    }]);
                    $d->joinWith(['title h' => function($f){
                        $f->joinWith(['categoryEnc i'],false);
                    }],false);
                    $d->select(['e.application_enc_id','e.organization_enc_id','e.slug as application_slug','i.name as application_title','h.assigned_to']);
                }]);
                $c->joinWith(['createdBy g'], false);
//                $c->groupBy(['g.user_enc_id', 'c.applied_application_enc_id']);
                $c->select(['c.applied_application_enc_id','c.application_enc_id','c.current_round','c.status','c.created_by',' CONCAT(g.first_name, " ", g.last_name) name','g.image','g.image_location','g.initials_color','g.username']);
                $c->onCondition(['c.is_deleted' => 0]);
            }])
            ->distinct()
            ->where(['b.code' => Yii::$app->user->identity->referral->code, 'a.is_deleted' => 0])
//            ->groupBy(['g.user_enc_id', 'c.applied_application_enc_id'])
            ->asArray()
            ->limit(20)
            ->all();

//        print_r($data);
//        exit();

        return $this->render('manage-candidates',[
            'users' => $data,
        ]);
    }
}