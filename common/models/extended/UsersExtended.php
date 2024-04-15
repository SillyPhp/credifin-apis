<?php

namespace common\models\extended;

use common\models\EmployeesCashReport;
use common\models\Users;

class UsersExtended extends Users
{
    public function behaviors()
    {
        $model = explode("\\", Users::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
    public function getEmployeesCashReports2()
    {
        return $this->hasOne(EmployeesCashReport::className(), ['received_from' => 'user_enc_id']);
    }

    public function getEmployeesCashReports3()
    {
        return $this->hasOne(EmployeesCashReport::className(), ['given_to' => 'user_enc_id']);
    }
}
