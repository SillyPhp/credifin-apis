<?php

namespace common\models\extended;

use common\models\LoanApplicationTvr;

class LoanApplicationTvrExtended extends LoanApplicationTvr
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicationTvr::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}