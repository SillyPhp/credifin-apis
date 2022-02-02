<?php

namespace common\models\extended;

use Yii;
use common\models\LoanApplications;
use common\models\Users;

class EducationLoan  {
   public function SignUp($data){
       $id = Users::find()
           ->where([
               'or',
               ['phone' => $data['phone']],
               ['email' => $data['email']],
           ])->one();
       if ($id) {
           $get = LoanApplications::findOne(['loan_app_enc_id' => $data['loan_app_enc_id']]);
           $get->created_by = $id->user_enc_id;
           if ($get->save()){
               return true;
           }else{
               return false;
           }
       } else {
           $params = [];
           $params['id'] = $data['loan_app_enc_id'];
           $params['name'] = $data['name'];
           $params['email'] = $data['email'];
           $params['phone'] = str_replace('+', '', $data['phone']);
           $id = Yii::$app->notificationEmails->createuserSignUp($params);
           if ($id) {
               $get = LoanApplications::findOne(['loan_app_enc_id' => $data['loan_app_enc_id']]);
               $get->created_by = $id['id'];
               if ($get->save()){
                   return true;
               }else{
                   return false;
               }
           }
       }
   }
}