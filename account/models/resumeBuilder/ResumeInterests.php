<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace account\models\resumeBuilder;

use common\models\UserInterests;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class ResumeInterests extends Model
{
    public $interests;
    
     public function rules()
    {
        return [
        [['interests'],'required'],
    ];
    }

    public function interest_add(){

         if (!$this->validate()) {
            return $this->getErrors();
        }

        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $interest = new UserInterests();
        $interest->user_interest_enc_id = $utilitiesModel->encrypt();
        $interest->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $interest->interest = $this->interests;
        $interest->created_on = date('Y-m-d h:i:s');
        $interest->created_by = Yii::$app->user->identity->user_enc_id;
        if(!$interest->validate() || !$interest->save()){
            return $interest->getErrors();
        }else{
            return true;
        }
    }
    
}
