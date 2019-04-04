<?php

namespace account\models\applications;
use Yii;
use common\models\AppliedApplications;

class UserAppliedApplication
{
    public function getUserDetails($type,$limit=null)
    {
        $u = AppliedApplications::find()
             ->alias('a')
            ->select(['a.status','a.created_on','g.name type','a.applied_application_enc_id', 'a.application_enc_id', 'f.username', 'd.name job_title', 'e.icon', 'CONCAT(f.first_name," ",f.last_name) fullname', 'f.image', 'f.image_location'])
             ->where(['or',
                 ['a.status' => 'Pending'],
                 ['a.status' => 'Incomplete']
             ])
             ->joinWith(['applicationEnc b'=>function($b) use($type)
             {
                 $b->andWhere(['b.organization_enc_id'=>Yii::$app->user->identity->organization->organization_enc_id,'b.is_deleted'=>0]);
                 $b->joinWith(['applicationTypeEnc g'=>function($b) use($type)
                 {
                     $b->andWhere(['g.name'=>$type]);
                 }],false,'INNER JOIN');
                 $b->joinWith(['title c' => function ($c) {
                 $c->joinWith(['categoryEnc d'], false);
                 $c->joinWith(['parentEnc e'], false);
             }], false);
            }], false)
             ->joinWith(['createdBy f'], false)
             ->andWhere(['a.is_deleted'=>0])
             ->orderBy(['created_on'=>SORT_DESC])
             ->limit($limit)
             ->asArray()
             ->all();

        return $u;
    }
}