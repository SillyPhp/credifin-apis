<?php

namespace common\models\extended;

use common\models\LoanCoApplicants;

class LoanCoApplicantsExtended extends LoanCoApplicants
{
    public function behaviors()
    {
        $model = explode("\\", LoanCoApplicants::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}