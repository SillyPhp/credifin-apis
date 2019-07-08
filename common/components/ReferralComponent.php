<?php

namespace common\components;

use Yii;
use yii\base\Component;

class ReferralComponent extends Component
{
    public function getReferralCode()
    {
        if (!Yii::$app->user->isGuest) {
            return ((!empty(Yii::$app->user->identity->referral->code)) ? '?ref=' . Yii::$app->user->identity->referral->code : false);
        }
        return false;
    }

}