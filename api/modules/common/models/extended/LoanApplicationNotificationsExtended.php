<?php

namespace common\models\extended;

use common\models\LoanApplicationNotifications;

class LoanApplicationNotificationsExtended extends LoanApplicationNotifications
{
    public function behaviors()
    {
        $model = explode("\\", LoanApplicationNotifications::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}