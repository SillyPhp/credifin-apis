<?php

namespace api\modules\v4\models;

use common\models\Organizations;
use common\models\Users;
use common\models\UserVerificationTokens;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use common\models\Utilities;

class ForgotPassword extends Model
{
    public function formName()
    {
        return '';
    }

    public function forgotPassword($user_data)
    {

        $data['id'] = $user_data->user_enc_id;
        $data['name'] = $user_data->first_name . ' ' . $user_data->last_name;
        $data['email'] = $user_data->email;

        $utilitiesModel = new Utilities();
        $userVerificationModel = new UserVerificationTokens();

        $user['name'] = $data['name'];
        $user['email'] = $data['email'];

        UserVerificationTokens::updateAll([
            'last_updated_on' => date('Y-m-d H:i:s'),
            'last_updated_by' => $data['id'],
            'is_deleted' => 1
        ], ['and',
            ['verification_type' => 1],
            ['created_by' => $data['id']],
            ['status' => 'Pending'],
            ['is_deleted' => 0]
        ]);

        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userVerificationModel->token_enc_id = $utilitiesModel->encrypt();
        $userVerificationModel->token = Yii::$app->security->generateRandomString();
        $userVerificationModel->verification_type = 1;
        $userVerificationModel->created_by = $data['id'];
        if ($userVerificationModel->validate() && $userVerificationModel->save()) {
//            $user['link'] = Url::to('/reset-password/' . $userVerificationModel->token, 'https');
            $user['link'] = 'http://localhost:3000/reset-password/' . $userVerificationModel->token;
//            $user['link'] = 'https://www.empowerloans.in/reset-password/' . $userVerificationModel->token;

            Yii::$app->mailer->htmlLayout = 'layouts/email';
            $mail = Yii::$app->mailer->compose(
                ['html' => 'loans-reset-password-email'], ['data' => $user]
            )
                ->setFrom([Yii::$app->params->from_email => 'Empower Loans'])
                ->setTo([$user['email'] => $user['name']])
                ->setSubject(Yii::t('app', 'Reset Your Password'));

            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}