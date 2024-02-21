<?php

namespace common\models\extended;

use common\models\LoanPayments;

class LoanPaymentsExtends extends LoanPayments
{
    public function behaviors()
    {
        $model = explode("\\", LoanPayments::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}

?>