<?php

namespace common\models\extended;

use common\models\LoanVerificationLocations;

class LoanVerificationLocationsExtended extends LoanVerificationLocations
{
    public function behaviors()
    {
        $model = explode("\\", LoanVerificationLocations::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}