<?php

namespace frontend\models\events;

use Yii;
use common\models\User;

class UserModel extends User{

    const USER_REGISTERED = 'user_registered';

    public function init(){
        $this->on(self::USER_REGISTERED, [Yii::$app->emailService, 'registrationEmail']);
        parent::init();
    }
}