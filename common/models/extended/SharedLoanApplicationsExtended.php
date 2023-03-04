<?php

namespace common\models\extended;

use common\models\SharedLoanApplications;

class SharedLoanApplicationsExtended extends SharedLoanApplications
{
    public function behaviors()
    {
        $model = explode("\\", SharedLoanApplications::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}