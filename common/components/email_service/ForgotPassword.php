<?php

namespace common\components\email_service;

use common\models\Users;
use common\models\Organizations;
use common\models\UserVerificationTokens;
use Yii;
use DateTime;
use yii\base\Component;
use common\models\Utilities;
use yii\base\InvalidParamException;

class ForgotPassword extends Component
{

    public function reset($email)
    {
        $is_user = false;
        $data = Organizations::find()
            ->select(['organization_enc_id id', 'name', 'email'])
            ->where([
                'email' => $email,
                'status' => 'Active',
                'is_deleted' => 0,
            ])
            ->asArray()
            ->one();

        if (!$data) {
            $data = Users::find()
                ->select(['user_enc_id id', 'CONCAT(first_name," ",last_name) name', 'email'])
                ->where([
                    'email' => $email,
                    'status' => 'Active',
                    'is_deleted' => 0,
                ])
                ->andWhere([
                    'or',
                    ['!=', 'organization_enc_id', ''],
                    ['organization_enc_id' => NULL],
                ])
                ->asArray()
                ->one();

            if (!$data) {
                return false;
            }

            $is_user = true;
        }

        if (!$data) {
            return false;
        }

        $utilitiesModel = new Utilities();
        $userVerificationModel = new UserVerificationTokens();

        if (!$is_user) {
            $userVerificationModel->organization_enc_id = $data['id'];
        }

        $user['name'] = $data['name'];
        $user['email'] = $data['email'];

        UserVerificationTokens::updateAll([
            'last_updated_on' => date('Y-m-d H:i:s'),
            'last_updated_by' => $data['user_id'],
            'is_deleted' => 1
        ], ['and',
            ['verification_type' => 1],
            ['created_by' => $data['user_id']],
            ['status' => 'Pending'],
            ['is_deleted' => 0]
        ]);


        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userVerificationModel->token_enc_id = $utilitiesModel->encrypt();
        $userVerificationModel->token = Yii::$app->security->generateRandomString();
        $userVerificationModel->verification_type = 1;
        $userVerificationModel->created_by = $data['id'];
        if ($userVerificationModel->validate() && $userVerificationModel->save()) {
            $user['link'] = Yii::$app->urlManager->createAbsoluteUrl(['/reset-password/' . $userVerificationModel->token]);

            Yii::$app->mailer->htmlLayout = 'layouts/email';
            $mail = Yii::$app->mailer->compose(
                ['html' => 'reset-password-email'], ['data' => $user]
            )
                ->setFrom([Yii::$app->params->from_email => Yii::$app->params->site_name])
                ->setTo([$user['email'] => $user['name']])
                ->setSubject(Yii::t('frontend', 'Reset Your Password'));

            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function verify($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password Reset token cannot be blank');
        }

        $user_token = UserVerificationTokens::findOne([
            'token' => $token,
            'verification_type' => 1,
            'status' => 'Pending',
            'is_deleted' => 0
        ]);

        if (!$user_token) {
            throw new InvalidParamException('Wrong Password Reset token');
        }

        $date_expire = $user_token->created_on;
        $date = new DateTime($date_expire);
        $time_now = date('Y-m-d H:i:s');
        $now = new DateTime($time_now);
        $res = $date->diff($now);
        $year = $res->y * (365 * 60 * 60 * 24);
        $month = $res->m * (30 * 60 * 60 * 24);
        $day = $res->d * (60 * 60 * 24);
        $hour = $res->h * (60 * 60);
        $minute = $res->i * 60;
        $second = $res->s;
        $result = $year + $month + $day + $hour + $minute + $second;
        if ($result > Yii::$app->params->expiration_time->reset_password) {
            throw new InvalidParamException('Password reset token has expired.');
        }
        return $user_token->created_by;
    }

    public function change($user_id, $new_password)
    {
        $utilitiesModel = new Utilities();
        $user = Users::findOne([
            'user_enc_id' => $user_id,
            'status' => 'Active',
            'is_deleted' => 0
        ]);

        if (!empty($user)) {
            $utilitiesModel->variables['password'] = $new_password;
            $new_password = $utilitiesModel->encrypt_pass();
        } else {
            return false;
        }

        $user->password = $new_password;
        if (!$user->validate() || !$user->save()) {
            return false;
        }

        $user->is_email_verified = 1;
        $user->update();

        $user_token = UserVerificationTokens::findOne([
            'created_by' => $user_id,
            'verification_type' => 1,
            'status' => 'Pending',
            'is_deleted' => 0,
        ]);

        $user_token->status = 'Verified';
        $user_token->last_updated_by = $user_id;
        $user_token->is_deleted = 1;
        if ($user_token->update()) {
            return true;
        }
        return false;
    }
}