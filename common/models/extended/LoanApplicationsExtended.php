<?php

namespace common\models\extended;

use common\models\LoanApplications;

class LoanApplicationsExtended extends LoanApplications
{

    public function behaviors()
    {
        $model = explode("\\", LoanApplications::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];

    }
}