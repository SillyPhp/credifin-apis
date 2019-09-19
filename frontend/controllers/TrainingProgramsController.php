<?php

namespace frontend\controllers;

use common\models\TrainingProgramApplication;
use common\models\TrainingProgramBatches;
use Yii;
use yii\web\Controller;

class TrainingProgramsController extends Controller
{
    public function actionDetail($eaidk){
        $application_details = TrainingProgramApplication::find()
            ->where([
                'slug' => $eaidk,
                'is_deleted' => 0
            ])
            ->one();

        if (!$application_details) {
            return 'Not Found';
        }
        $org_details = $application_details->getOrganizationEnc()->select(['name org_name', 'initials_color color', 'slug', 'email', 'website', 'logo', 'logo_location', 'cover_image', 'cover_image_location'])->asArray()->one();
        $data = TrainingProgramApplication::find()
                ->alias('a')
                ->distinct()
                ->groupBy('d.id')
                ->where(['a.application_enc_id' => $application_details['application_enc_id']])
                ->select(['a.application_enc_id','SUM(d.seats) total_seats','a.description','a.training_duration','a.training_duration_type','l.name','c.name as cat_name', 'l.name', 'l.icon_png',])
                ->joinWith(['title0 b'=>function($b)
                {
                    $b->joinWith(['parentEnc l'], false);
                    $b->joinWith(['categoryEnc c'],false);
                }],false)
                ->joinWith(['trainingProgramBatches d'=>function($b)
                {
                    $b->onCondition(['d.is_deleted'=>0]);
                    $b->select(['d.application_enc_id','d.city_enc_id','i.name']);
                    $b->joinWith(['cityEnc i'],false);
                    $b->distinct('d.city_enc_id');
                }])
                ->joinWith(['trainingProgramSkills g' => function ($b) {
                $b->onCondition(['g.is_deleted' => 0]);
                $b->joinWith(['skillEnc h'], false);
                $b->select(['g.application_enc_id', 'h.skill_enc_id', 'h.skill']);
                }])
                ->asArray()
                ->one();
        $batches = TrainingProgramBatches::find()
            ->alias('d')
            ->where(['d.application_enc_id'=>$application_details['application_enc_id']])
            ->joinWith(['cityEnc i'],false)
            ->select(['d.application_enc_id','d.city_enc_id','i.name','d.fees','(CASE
                WHEN d.fees_methods = "1" THEN "Monthly"
                WHEN d.fees_methods = "2" THEN "Weekly"
                WHEN d.fees_methods = "3" THEN "Anually"
                WHEN d.fees_methods = "4" THEN "One Time"
                ELSE "N/A"
               END) as fees_method','d.seats','d.days','start_time','d.end_time'])
            ->asArray()
            ->all();
        $grouped_cities = [];
        foreach($batches as $batch){
            $grouped_cities[$batch['name']][] = $batch;
        }

        return $this->render('details',[
            'org' => $org_details,
            'data' => $data,
            'application_details' => $application_details,
            'batches' => $batches,
            'grouped_cities' => $grouped_cities,
        ]);
    }

    public function actionTest()
    {
        return $this->render('detail');
    }
}