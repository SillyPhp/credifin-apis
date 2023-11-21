<?php

namespace common\models\extended;

use common\models\EmployeesCashReport;

class EmployeesCashReportExtended extends EmployeesCashReport
{
    public function behaviors()
    {
        $model = explode("\\", EmployeesCashReport::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoanLoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}