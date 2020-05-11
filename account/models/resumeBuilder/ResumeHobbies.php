<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace account\models\resumeBuilder;

use common\models\UserHobbies;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class ResumeHobbies extends Model
{
    public $hobbies;
    
     public function rules()
    {
        return [
        [['hobbies'],'required'],
    ];
    }

    public function hobby_add(){

         if (!$this->validate()) {
            return $this->getErrors();
        }

        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $hobby = new UserHobbies();
        $hobby->user_hobby_enc_id = $utilitiesModel->encrypt();
        $hobby->user_enc_id = Yii::$app->user->identity->user_enc_id;
        $hobby->hobby = $this->hobbies;
        $hobby->created_on = date('Y-m-d h:i:s');
        $hobby->created_by = Yii::$app->user->identity->user_enc_id;
        if(!$hobby->validate() || !$hobby->save()){
            return $hobby->getErrors();
        }else{
            return true;
        }
    }
    
}
