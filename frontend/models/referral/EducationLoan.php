<?php
namespace frontend\models\referral;
use common\models\LoanApplications;

class EducationLoan {
    public static function JoinWithLoan($id,$created_by){
        $update = LoanApplications::findOne(['loan_app_enc_id'=>$id]);
        $update->created_by = $created_by;
        $update->update();
    }
}