<?php

namespace ap\modules\v1\controllers;

use api\modules\v1\controllers\ApiBaseController;
use Yii;

class ProfileController extends ApiBaseController{
    public function behaviors(){
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => \yii\filters\VerbFilter::className(),
            'actions' => [
                'edit' => ['POST']
            ]
        ];
        return $behaviors;
    }

    public function actionEdit(){

    }
}