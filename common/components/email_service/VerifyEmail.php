<?php

namespace common\components\email_service;

use common\models\Organizations;
use common\models\Users;
use common\models\UserVerificationTokens;
use yii\base\InvalidParamException;
use DateTime;
use Yii;
use yii\base\Component;

class VerifyEmail extends Component{

    public function registerVerification($token){
        if(empty($token) || !is_string($token)){
            throw new InvalidParamException('Email Verification Code Cannot be blank');
        }

        $user_token = UserVerificationTokens::findOne([
            'token' => $token,
            'verification_type' => 2,
            'status' => 'Pending',
            'is_deleted' => 0
        ]);

        if(!$user_token){
            throw new InvalidParamException('Invalid Verification Code');
        }

        $date_expire = $user_token->created_on;
        $date = new DateTime($date_expire);
        $now = new DateTime();
        $res = $date->diff($now);
        $year = $res->y * (365 * 60 *  60 * 24);
        $month = $res->m * (30 * 60 * 60 * 24);
        $day = $res->d * (60 * 60 * 24);
        $hour = $res->h * (60 * 60);
        $minute = $res->i * 60;
        $second = $res->s;
        $result = $year + $month + $day + $hour + $minute + $second;

        if($result > Yii::$app->params->expiration_time->email_verification){
            throw new InvalidParamException('Verification Link has Expired');
        }

        $organization_id = $user_token->organization_enc_id;

        if($organization_id) {
            $organization = Organizations::findOne([
                'organization_enc_id' => $organization_id,
                'status' => 'Active',
                'is_email_verified' => 0,
                'is_deleted' => 0
            ]);

            if ($organization) {
                $organization->is_email_verified = 1;
                $organization->last_updated_on = date('Y-m-d H:i:s');
                $organization->last_updated_by = $user_token->created;
                if (!$organization->update()) {
                    return false;
                }
            }
        }

        $user = Users::findOne([
            'user_enc_id' => $user_token->created_by,
            'is_email_verified' => 0,
            'status' => 'Active',
            'is_deleted' => 0
        ]);

        if($user){
            $user->is_email_verified = 1;
            $user->last_updated_on = date('Y-m-d H:i:s');
            if($user->update()){
                $user_token->status = 'Verified';
                $user_token->is_deleted = 1;
                $user_token->last_updated_on = date('Y-m-d H:i:s');
                $user_token->last_updated_by = $user_token->created_by;
                if($user_token->update()){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}