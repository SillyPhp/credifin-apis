<?php

namespace common\models\extended;

use common\models\LoanPurpose;

class LoanPurposeExtended extends LoanPurpose
{
    public function behaviors()
    {
        $model = explode("\\", LoanPurpose::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}