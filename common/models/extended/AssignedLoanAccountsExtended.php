<?php

namespace common\models\extended;

use common\models\AssignedLoanAccounts;

class AssignedLoanAccountsExtended extends AssignedLoanAccounts
{
    public function behaviors()
    {
        $model = explode("\\", AssignedLoanAccounts::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}
