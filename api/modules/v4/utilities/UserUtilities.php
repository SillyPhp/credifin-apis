<?php

namespace api\modules\v4\utilities;

// this class is used to get user related data
use common\models\Users;

class UserUtilities
{
    public static function userData($user_id)
    {
        $user = Users::findOne(['user_enc_id' => $user_id]);
    }
}