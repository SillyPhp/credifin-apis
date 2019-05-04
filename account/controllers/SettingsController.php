<?php

namespace account\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class SettingsController extends Controller
{
    public function actionIndex(){
        if(Yii::$app->user->identity->organization->organization_enc_id){
            return $this->render('organization-settings');
        }
        return $this->render('individual-settings');
    }
}