<?php

namespace common\models\extended;

use common\models\LoanAccounts;

class LoanAccountsExtended extends LoanAccounts
{
    public function behaviors()
    {
        $model = explode("\\", LoanAccounts::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}