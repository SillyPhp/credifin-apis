<?php

namespace frontend\controllers;
use common\models\UserOtherDetails;
use frontend\models\applications\PreferencesCards;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\Response;

class TestCacheController extends Controller
{
    public function actionIndex()
    {
        $data = new PreferencesCards();
        print_r($data->getPreferenceCards());
    }

    public function actionTest()
    {
        $candidates = UserOtherDetails::find()
            ->alias('a')
            ->distinct()
            ->where(['a.organization_enc_id' => 'RXVWV1duTFYwZTRJZmsyVUJuMGFVUT09'])
            //->select([
//                    'a.user_other_details_enc_id',
//                    'a.user_enc_id',
//                    'b.email',
//                    'b.phone',
//                    'a.university_roll_number',
//                    'c.name department',
//                    'b.first_name',
//                    'b.last_name',
//                    'a.starting_year',
//                    'a.ending_year',
//                    'a.semester',
//                    'c.name',
//                    'cc.educational_requirement course_name',
//                    'CASE WHEN b.image IS NOT NULL THEN CONCAT("' . Url::to(Yii::$app->params->upload_directories->users->image, 'https') . '", b.image_location, "/", b.image) ELSE CONCAT("https://ui-avatars.com/api/?name=", b.first_name, "&size=200&rounded=false&background=", REPLACE(b.initials_color, "#", ""), "&color=ffffff") END image'
    //])
            ->joinWith(['userEnc b' => function ($b) {
                $b->select(['b.user_enc_id']);
                $b->joinWith(['appliedApplications ccc' => function ($c) {
                   $c->select(['ccc.created_by','applied_application_enc_id','d.application_enc_id','application_for']);
//                       // $c->select(['ccc.created_by','ccc.application_enc_id','e.organization_enc_id','e.name company_name','f.name','ccc.applied_application_enc_id','COUNT(CASE WHEN g.is_completed = 1 THEN 1 END) as active', 'COUNT(g.is_completed) total']);
////                    $c->joinWith(['appliedApplicationProcesses g' => function ($g) {
////                        $g->select(['g.applied_application_enc_id', 'h.field_enc_id']);
////                        $g->joinWith(['fieldEnc h' => function ($h) {
////                            $h->select(['h.field_enc_id', 'h.field_name', 'h.sequence']);
////                        }]);
////                    }],false);
                    $c->joinWith(['applicationEnc d' => function ($d) {
                        $d->onCondition(['or',
                            ['d.application_for'=>0],
                            ['d.application_for'=>2]
                        ]);
//////                        $d->joinWith(['title ee' => function ($ee) {
//////                            $ee->joinWith(['categoryEnc f']);
//////                        }]);
//////                        $d->joinWith(['organizationEnc e']);
//                        $d->andWhere([
//                            'd.status' => 'Active',
//                            'd.is_deleted' => 0,
//                        ])
                        //$d->andOnCondition(['in','d.application_for',[0,2]]);
                    }], false,'LEFT JOIN');
//                    $c->groupBy(['ccc.applied_application_enc_id','ccc.created_by']);
                }],true);
            }], true,'LEFT JOIN')
            ->joinWith(['educationalRequirementEnc cc'], false)
            ->joinWith(['departmentEnc c'], false);
        print_r($candidates->createCommand()->getRawSql());
       // print_r($candidates->asArray()->all());
        exit;
    }
}