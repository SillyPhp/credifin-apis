<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace account\models\resumeBuilder;

use common\models\UserAchievements;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class ResumeAchievments extends Model
{
   public $achievments;
    
     public function rules()
    {
        return [
        [['achievments'],'required'],
    ];
    }

    public function add(){

        if (!$this->validate()) {
            return $this->getErrors();
        }

        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userAchievements = new UserAchievements();
        $userAchievements->user_achievement_enc_id = $utilitiesModel->encrypt();
        $userAchievements->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $userAchievements->achievement = $this->achievments;
        $userAchievements->created_on = date('Y-m-d h:i:s');
        $userAchievements->created_by = Yii::$app->user->identity->user_enc_id;
        if(!$userAchievements->validate() || !$userAchievements->save()){
            return $userAchievements->getErrors();
        }else{
            return true;
        }

    }
    
}