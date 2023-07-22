<?php

namespace common\models\extended;

use common\models\LoanApplicationReleasePayment;

class LoanApplicationReleasePaymentExtended extends LoanApplicationReleasePayment
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicationReleasePayment::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}