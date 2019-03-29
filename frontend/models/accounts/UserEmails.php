<?php

namespace frontend\models\accounts;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Users;
use common\models\Organizations;
use common\models\UserVerificationTokens;

class UserEmails extends Model
{

    public function verificationEmail($id, $is_organization = false)
    {
        if ($is_organization) {
            $condition = ['organization_enc_id' => $id];
            $data = Organizations::find()
                ->select(['organization_enc_id organization_id', 'name', 'email', 'created_by user_id'])
                ->where([
                    'organization_enc_id' => $id,
                    'status' => 'Active',
                    'is_email_verified' => 0,
                    'is_deleted' => 0
                ])
                ->asArray()
                ->one();
        } else {
            $condition = ['created_by' => $id];
            $data = Users::find()
                ->select(['user_enc_id user_id', 'CONCAT(first_name," ", last_name) name', 'email'])
                ->where([
                    'user_enc_id' => $id,
                    'status' => 'Active',
                    'is_email_verified' => 0,
                    'is_deleted' => 0
                ])
                ->asArray()
                ->one();
        }

        if (!$data) {
            return false;
        }

        return UserVerificationTokens::updateAll([
            'last_updated_on' => date('Y-m-d H:i:s'),
            'last_updated_by' => $id,
            'is_deleted' => 1,
        ], ['and',
            ['verification_type' => 'email verification'],
            ['status' => 'Pending'],
            ['is_deleted' => 0],
            $condition
        ]);

        $utilitiesModel = new Utilities();
        $userVerificationTokensModel = new UserVerificationTokens();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userVerificationTokensModel->token_enc_id = $utilitiesModel->encrypt();
        $userVerificationTokensModel->token = Yii::$app->security->generateRandomString();
        $userVerificationTokensModel->verification_type = 'email verification';
        if ($is_organization) {
            $userVerificationTokensModel->organization_enc_id = $data['organization_id'];
        }
        $userVerificationTokensModel->created_on = $userVerificationTokensModel->last_updated_on = date('Y-m-d H:i:s');
        $userVerificationTokensModel->created_by = $userVerificationTokensModel->last_updated_by = $data['user_id'];

        if (!$userVerificationTokensModel->validate() || !$userVerificationTokensModel->save()) {
            return false;
        }

        $user['name'] = $data['name'];
        $user['link'] = Yii::$app->urlManager->createAbsoluteUrl(['/verify/' . $userVerificationTokensModel->token]);

        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'verification-email'], ['data' => $user]
            )
            ->setFrom([Yii::$app->params->contact_email => Yii::$app->params->site_name])
            ->setTo([$data['email'] => $data['name']])
            ->setSubject(Yii::t('frontend', 'Active your ' . Yii::$app->params->site_name . ' account'));

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    public function resetPasswordEmail($email)
    {
        $data = Users::find()
            ->select(['user_enc_id user_id', 'CONCAT(first_name," ", last_name) name', 'email'])
            ->where([
                'email' => $email,
                'status' => 'Active',
                'is_deleted' => 0
            ])
            ->asArray()
            ->one();

        if (!$data) {
            return false;
        }

        UserVerificationTokens::updateAll([
            'last_updated_on' => date('Y-m-d H:i:s'),
            'last_updated_by' => $data['user_id'],
            'is_deleted' => 1,
        ], ['and',
            ['verification_type' => 'reset password'],
            ['created_by' => $data['user_id']],
            ['status' => 'Pending'],
            ['is_deleted' => 0],
        ]);

        $utilitiesModel = new Utilities();
        $userVerificationTokensModel = new UserVerificationTokens();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $userVerificationTokensModel->token_enc_id = $utilitiesModel->encrypt();
        $userVerificationTokensModel->token = Yii::$app->security->generateRandomString();
        $userVerificationTokensModel->verification_type = 1;
        $userVerificationTokensModel->created_by = $data['user_id'];

        if (!$userVerificationTokensModel->validate() || !$userVerificationTokensModel->save()) {
            return false;
        }

        $user['name'] = $data['name'];
        $user['link'] = Yii::$app->urlManager->createAbsoluteUrl(['/reset-password/' . $userVerificationTokensModel->token]);

        Yii::$app->mailer->htmlLayout = 'layouts/email';
        $mail = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'reset-password-email'], ['data' => $user]
            )
            ->setFrom([Yii::$app->params->contact_email => Yii::$app->params->site_name])
            ->setTo([$data['email'] => $data['name']])
            ->setSubject(Yii::t('frontend', 'Reset your password'));

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}