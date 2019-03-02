<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;

class DropResumeController extends Controller{



    public function actionIndex(){
        $jobProfile= [
            'Information Technology'=>'information_technology',
            'Accounting'=>'accounting',
            'Hr'=>'hr',
            'Designer'=>'designer'
        ];
        $jobTitle = [
            'Front end'=>'front_end',
            'Back End'=>'back_end',
            'Software Tester'=>'software_tester'
        ];
        $location = [
            'Ludhiana'=>'ludhiana',
            'Amritsar'=>'amritsar',
            'Jalandhar'=>'jalandhar'
        ];

        return $this->render('/companies/detail_test',[
            'jobProfile'=>$jobProfile,
            'jobTitle'=>$jobTitle,
            'location'=>$location,
        ]);
    }
}

?>