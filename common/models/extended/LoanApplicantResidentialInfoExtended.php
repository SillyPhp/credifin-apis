<?php

namespace common\models\extended;

use common\models\LoanApplicantResidentialInfo;

class LoanApplicantResidentialInfoExtended extends LoanApplicantResidentialInfo
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicantResidentialInfo::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}