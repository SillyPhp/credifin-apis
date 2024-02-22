<?php

namespace common\models\extended;

use common\models\LoanApplicationOptions;

class LoanApplicationOptionsExtended extends LoanApplicationOptions
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicationOptions::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}