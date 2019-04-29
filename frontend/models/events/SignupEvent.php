<?php

namespace frontend\models\events;

use Yii;
use yii\base\Event;

class SignupEvent extends Event{
    public $user;

    public function getUser(){
        return $this->user;
    }
}