<?php
namespace common\models\extended;
use common\models\Auth;
class AuthExtends extends \common\models\Auth{
    public function behaviors(){
        return [
            'common\models\extended\LoggableBehavior'
        ];
    }
}