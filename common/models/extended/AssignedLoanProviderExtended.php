<?php

namespace common\models\extended;

use common\models\AssignedLoanProvider;

class AssignedLoanProviderExtended extends AssignedLoanProvider
{
    public function behaviors()
    {
        $model = explode("\\", AssignedLoanProvider::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}