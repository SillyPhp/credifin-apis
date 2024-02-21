<?php

namespace common\models\extended;

use common\models\LoanCertificates;

class LoanCertificatesExtended extends LoanCertificates
{
    public function behaviors()
    {
        $model = explode("\\", LoanCertificates::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}