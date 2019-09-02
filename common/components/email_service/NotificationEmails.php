<?php

namespace common\components\email_service;

use yii\base\Component;
use yii\base\InvalidParamException;
use common\models\Utilities;
use Yii;

class NotificationEmails extends Component{

    public function userAppliedNotify($user_id=null,$application_id=null,$company_id=null)
    {
        Yii::$app->mailer->htmlLayout = 'layouts/email';

        $mail = Yii::$app->mailer->compose(
            ['html' => 'user-applied'], ['data' => 1]
            )
            ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
            ->setTo(['snehkant93@gmail.com' => 'Sneh'])
            ->setSubject(Yii::t('frontend', 'You Got 1 Candidate'));

        if($mail->send()){
            return true;
        }
        else
        {
            return false;
        }
    }
}