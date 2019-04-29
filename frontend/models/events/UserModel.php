<?php

namespace frontend\models\events;

use Yii;
use common\models\Users;

class UserModel extends Users{

    const USER_REGISTERED = 'user_registered';

    public function init(){
        $this->on(self::USER_REGISTERED, [Yii::$app->emailService, 'registrationEmail']);
        parent::init();
    }
}