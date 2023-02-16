<?php
namespace common\models\extended;
use common\models\EducationLoanPayments;
class EducationLoanPaymentsExtends extends EducationLoanPayments {
//    public function behaviors(){
//        return [
//            'common\models\extended\LoggableBehavior'
//        ];
//    }

    public function behaviors()
    {
        $model = explode("\\", EducationLoanPayments::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}
?>