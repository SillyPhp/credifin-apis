<?php

namespace frontend\controllers;

use common\models\EmployerApplications;
use Yii;
use yii\web\Controller;

class LocationsController extends Controller
{
    public function actionStates(){
        $states = EmployerApplications::find()
            ->alias('a')
            ->distinct()
            ->select(['e.name', 'COUNT(a.application_enc_id) as applications', 'f.name Type'] )
            ->innerJoinWith(['applicationTypeEnc f'], false)
            ->innerJoinWith(['applicationPlacementLocations b' => function($b){
                $b->innerJoinWith(['locationEnc c' => function($c){
                    $c->innerJoinWith(['cityEnc d' => function($d){
                        $d->innerJoinWith(['stateEnc e'], false);
                    }]);
                }],false);
            }],false)
            ->where(['a.status' => 'Active', 'a.is_deleted' => 0])
            ->groupBy(['e.state_enc_id','f.application_type_enc_id'])
            ->orderBy(['e.name' => SORT_ASC])
            ->asArray()
            ->all();
        print_r($states);
        die();

        return $this->render('states',[
            'states' => $states,
        ]);
    }
}