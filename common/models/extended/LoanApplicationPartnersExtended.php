<?php

namespace common\models\extended;

use common\models\LoanApplicationPartners;

class LoanApplicationPartnersExtended extends LoanApplicationPartners
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicationPartners::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}