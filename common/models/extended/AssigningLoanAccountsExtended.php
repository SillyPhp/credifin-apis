<?php

namespace common\models\extended;

use common\models\AssigningLoanAccounts;

class AssigningLoanAccountsExtended extends AssigningLoanAccounts
{
    public function behaviors()
    {
        $model = explode("\\", AssigningLoanAccounts::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}
