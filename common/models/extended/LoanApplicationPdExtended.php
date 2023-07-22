<?php

namespace common\models\extended;

use common\models\LoanApplicationPd;

class LoanApplicationPdExtended extends LoanApplicationPd
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicationPd::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}