<?php

namespace common\models\extended;

use common\models\UserRoles;

class UserRolesExtended extends UserRoles
{
    public function behaviors()
    {
        $model = explode("\\", UserRoles::className());
        return [
            'LoggableBehavior' => [
                'class' => 'common\models\extended\LoggableBehavior',
                'className' => end($model),
            ]
        ];
    }
}
