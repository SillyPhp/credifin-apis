<?php

namespace api\modules\v4\models;

use common\models\UserVerificationTokens;
use common\models\Utilities;
use Yii;
use yii\base\Model;

class ForgotPassword extends Model
{
    public function formName()
    {
        return '';
    }

    // forgot passwrod method
    public function forgotPassword($user_data)
    {
        $user_id = $user_data->user_enc_id;

        $user['name'] = $user_data->first_name . ' ' . $user_data->last_name;
        $user['email'] = $user_data->email;

        $utilitiesModel = new Utilities();
        $userVerificationModel = new UserVerificationTokens();

        // this query will delete old user verification tokens
        UserVerificationTokens::updateAll([
            'last_updated_on' => date('Y-m-d H:i:s'),
            'last_updated_by' => $user_id,
            'is_deleted' => 1
        ], ['and',
            ['verification_type' => 1],
            ['created_by' => $user_id],
            ['status' => 'Pending'],
            ['is_deleted' => 0]
        ]);

        // creating new token
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userVerificationModel->token_enc_id = $utilitiesModel->encrypt();
        $userVerificationModel->token = Yii::$app->security->generateRandomString();
        $userVerificationModel->verification_type = 1;
        $userVerificationModel->created_by = $user_id;
        if ($userVerificationModel->validate() && $userVerificationModel->save()) {
//            $user['link'] = 'http://localhost:3000/reset-password/' . $userVerificationModel->token;
            $user['link'] = 'https://www.empowerloans.in/reset-password/' . $userVerificationModel->token;

            // sending email
            Yii::$app->mailer->htmlLayout = 'layouts/email';

            // composing email
            $mail = Yii::$app->mailer->compose(['html' => 'loans-reset-password-email'], ['data' => $user])
                ->setFrom([Yii::$app->params->from_email => 'Empower Loans'])
                ->setTo([$user['email'] => $user['name']])
                ->setSubject(Yii::t('app', 'Reset Your Password'));

            // sending email
            if ($mail->send()) {
                return ['status' => 200, 'message' => 'reset password mail sent to your email please check.'];
            } else {
                return ['status' => 500, 'message' => 'an error occurred while sending mail'];
            }

        } else {
            // if any error occur while saving token
            return ['status' => 500, 'message' => 'an error occurred', 'error' => $userVerificationModel->getErrors()];
        }

    }
}