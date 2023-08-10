<?php

namespace common\models\extended;

use common\models\LoanApplicationsReferences;

class LoanApplicationsReferencesExtended extends LoanApplicationsReferences
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicationsReferences::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}