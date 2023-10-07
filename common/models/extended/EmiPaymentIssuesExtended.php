<?php

namespace common\models\extended;

use common\models\EmiPaymentIssues;

class EmiPaymentIssuesExtended extends EmiPaymentIssues
{
    public function behaviors()
    {
        $model = explode("\\", EmiPaymentIssues::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}