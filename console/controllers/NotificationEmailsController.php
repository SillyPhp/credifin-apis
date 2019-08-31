<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class NotificationEmailsController extends Controller
{
    public function actionIndex() {
        echo "cron service";
    }

    public function actionMail($to) {
    echo "Sending mail to " . $to;
    }

    public function actionUpdateUserProfile()
    {
        
    }
}


