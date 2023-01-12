<?php
namespace common\models\extended;
use common\models\EducationLoanPayments;
class EducationLoanPaymentsExtends extends EducationLoanPayments {
    public function behaviors(){
        return [
            'common\models\extended\LoggableBehavior'
        ];
    }
}
?>