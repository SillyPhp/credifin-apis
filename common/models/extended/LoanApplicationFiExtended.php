<?php

namespace common\models\extended;

use common\models\LoanApplicationFi;

class LoanApplicationFiExtended extends LoanApplicationFi
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicationFi::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}