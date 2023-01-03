<?php

namespace api\modules\v4\models;

use account\models\applications\TrainingApplications;
use common\models\AssignedSupervisor;
use common\models\EmailLogs;
use common\models\Organizations;
use common\models\ReferralSignUpTracking;
use common\models\SelectedServices;
use common\models\Services;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\Users;
use common\models\UserTypes;
use common\models\RandomColors;
use frontend\models\referral\Referral;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class IndividualSignup extends Model
{

    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $username;
    public $password;
    public $source;
    public $dsaRefId;
    public $is_connector;
    public $user_type;
    public $organization_name;
    public $organization_email;
    public $organization_phone;
    public $organization_website;


    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone', 'username'], 'required'],
            [['first_name', 'last_name', 'phone', 'username', 'email'], 'trim'],

            ['phone', 'unique', 'targetClass' => 'api\modules\v4\models\Candidates', 'message' => 'phone number already registered'],

            [['username'], 'string', 'length' => [3, 20]],
            [['username'], 'match', 'pattern' => '/^([A-Za-z]+[0-9]|[0-9]+[A-Za-z]|[a-zA-Z])[A-Za-z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
//            ['username', 'unique', 'targetClass' => 'api\modules\v4\models\Candidates', 'message' => 'username already taken'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'username already taken'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'api\modules\v4\models\Candidates', 'message' => 'email already taken'],

            ['password', 'required'],
            [['password'], 'string', 'length' => [8, 20]],

            ['source', 'required'],
            [['dsaRefId', 'is_connector', 'user_type', 'organization_name', 'organization_email', 'organization_phone', 'organization_website'], 'safe']
        ];
    }

    public function saveUser()
    {
//        $user_type = $this->user_type == 'Employee' ? 'Employee' : 'Individual';

        if ($this->user_type == 'Employee') {
            $user_type = 'Employee';
        } elseif ($this->user_type == 'Dealer') {
            $user_type = 'Dealer';
        } else {
            $user_type = 'Individual';
        }

        if ($this->user_type == 'Connector') {
            $this->is_connector = true;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new Candidates();
            $username = new Usernames();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);

            $username->username = $this->username;
            $username->assigned_to = 1;

            //if username exists the concat random string to user-name
//            $username_exists = Usernames::findOne(['username' => $this->username]);
//            if (!$username_exists) {
//                $username->username = $this->username . strtolower(Yii::$app->getSecurity()->generateRandomString(5));
//            }

            if (!$username->validate() || !$username->save()) {
                $transaction->rollback();
                return false;
            }

            $user->username = $this->username;
            $user->first_name = $this->first_name;
            $user->last_name = $this->last_name;
            $user->phone = preg_replace("/\s+/", "", $this->phone);
            $user->email = $this->email;
            $user->user_enc_id = $utilitiesModel->encrypt();
            $user->user_type_enc_id = UserTypes::findOne(['user_type' => $user_type])->user_type_enc_id;
            $user->initials_color = RandomColors::one();
            $user->created_on = date('Y-m-d H:i:s', strtotime('now'));
            if ($this->user_type == 'Employee') {
                $user->status = 'Pending';
            } else {
                $user->status = 'Active';
            }
            $user->last_visit = date('Y-m-d H:i:s');
            $user->last_visit_through = 'EL';
            $user->signed_up_through = 'EL';
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if (!$user->save()) {
                $transaction->rollback();
                return false;
            }

            $ref_code = $this->addRef($user->user_enc_id);
            if (!$ref_code) {
                $transaction->rollback();
                return false;
            }

            if ($this->dsaRefId && ($this->user_type == 'Employee' || $this->is_connector)) {
                if (!$this->signupTracking($user->user_enc_id)) {
                    $transaction->rollback();
                    return false;
                }
            }

            if ($this->dsaRefId && $user_type != 'Employee') {
                if (!$this->assignedDsaService($user->user_enc_id, $this->dsaRefId)) {
                    $transaction->rollback();
                    return false;
                }
            }

            if ($this->organization_name) {
                $org = new Organizations();
                $org->organization_enc_id = Yii::$app->security->generateRandomString(32);
                $org->name = $this->organization_name;
                $org->email = $this->organization_email;
                $org->phone = $this->organization_phone;
                $org->website = $this->organization_website;
                $utilitiesModel->variables['name'] = $this->username;
                $utilitiesModel->variables['table_name'] = Organizations::tableName();
                $utilitiesModel->variables['field_name'] = 'slug';
                $org->slug = $utilitiesModel->create_slug();
                $org->initials_color = RandomColors::one();;
                $org->created_by = $user->user_enc_id;
                if (!$org->save()) {
                    return false;
                }
            }

            $transaction->commit();

            $data['username'] = $user->username;
            $data['user_enc_id'] = $user->user_enc_id;
            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['initials_color'] = $user->initials_color;
            $data['phone'] = $user->phone;
            $data['email'] = $user->email;
            $data['referral_code'] = $ref_code;
            $data['user_type'] = $user_type;
            $data['access_token'] = '';
            $data['source'] = '';
            $data['refresh_token'] = '';
            $data['access_token_expiry_time'] = '';
            $data['refresh_token_expiry_time'] = '';
            $data['image'] = '';
            $data['organization_enc_id'] = '';
            $data['organization_name'] = '';
            $data['organization_slug'] = '';

            if($this->organization_name){
                $data['organization_enc_id'] = $org->organization_enc_id;
                $data['organization_name'] = $org->name;
                $data['organization_slug'] = $org->slug;
            }

            if ($this->dsaRefId && $this->user_type == 'Employee') {
                $org_id = \common\models\Referral::findOne(['code' => $this->dsaRefId])->organization_enc_id;
                if ($org_id) {
                    $organization = Organizations::find()
                        ->alias('a')
                        ->select(['a.organization_enc_id', 'a.name', 'a.slug', 'b.username'])
                        ->joinWith(['createdBy b'], false)
                        ->where(['a.organization_enc_id' => $org_id])
                        ->asArray()
                        ->one();
                    $data['organization_name'] = $organization['name'];
                    $data['organization_slug'] = $organization['slug'];
                    $data['organization_username'] = $organization['username'];
                    $data['organization_enc_id'] = $organization['organization_enc_id'];
                }
            }

            $is_dsa = SelectedServices::find()
                ->alias('a')
                ->joinWith(['serviceEnc b'])
                ->where(['a.is_selected' => 1, 'a.created_by' => $user->user_enc_id, 'b.name' => 'E-Partners', 'a.organization_enc_id' => Null])
                ->exists();


            if ($is_dsa) {
                $data['user_type'] = "DSA";
            } else if ($this->is_connector) {
                $data['user_type'] = 'Connector';
            }

            if ($token = $this->newToken($user->user_enc_id, $this->source)) {
                $data['access_token'] = $token->access_token;
                $data['source'] = $token->source;
                $data['refresh_token'] = $token->refresh_token;
                $data['access_token_expiry_time'] = $token->access_token_expiration;
                $data['refresh_token_expiry_time'] = $token->refresh_token_expiration;
            }

            return $data;

        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }

    private function addRef($user_id)
    {
        $ref = new \common\models\Referral();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $ref->referral_enc_id = $utilitiesModel->encrypt();
        $ref->code = $ref->referral_link = $this->_getReferralCode();
        $ref->user_enc_id = $user_id;
        $ref->created_by = $user_id;
        $ref->created_on = date('Y-m-d H:i:s');
        if ($ref->save()) {
            return $ref->code;
        }

        return false;
    }

    private function signupTracking($user_id)
    {
        $referralData = \common\models\Referral::findOne(['code' => $this->dsaRefId]);

        $tracking = new ReferralSignUpTracking();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(10, 100000);
        $tracking->tracking_signup_enc_id = $utilitiesModel->encrypt();
        $tracking->referral_enc_id = $referralData->referral_enc_id;
        $tracking->sign_up_user_enc_id = $user_id;
        $tracking->created_on = date('Y-m-d H:i:s');
        if ($tracking->save()) {
            return true;
        }
        return false;
    }

    private function _getReferralCode($n = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

    private function sendMail($userId)
    {
        $mail = Yii::$app->mail;
        $mail->receivers = [];
        $mail->receivers[] = [
            "name" => $this->first_name . " " . $this->last_name,
            "email" => $this->email,
        ];
        $mail->subject = 'Welcome to My eCampus';
        $mail->template = 'mec-thank-you';
        if ($mail->send()) {
            $mail_logs = new EmailLogs();
            $utilitesModel = new Utilities();
            $utilitesModel->variables['string'] = time() . rand(100, 100000);
            $mail_logs->email_log_enc_id = $utilitesModel->encrypt();
            $mail_logs->email_type = 5;
            $mail_logs->user_enc_id = $userId;
            $mail_logs->receiver_name = $this->first_name . " " . $this->last_name;
            $mail_logs->receiver_email = $this->email;
            $mail_logs->receiver_phone = $this->phone;
            $mail_logs->subject = 'Welcome to My eCampus';
            $mail_logs->template = 'mec-thank-you';
            $mail_logs->is_sent = 1;
            $mail_logs->save();
        }
    }

    private function newToken($user_id, $source)
    {
        $token = new UserAccessTokens();
        $time_now = date('Y-m-d H:i:s');
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $token->access_token_enc_id = $utilitiesModel->encrypt();
        $token->user_enc_id = $user_id;
        $token->access_token = \Yii::$app->security->generateRandomString(32);
        $token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
        $token->refresh_token = \Yii::$app->security->generateRandomString(32);
        $token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
        $token->source = $source;
        if ($token->save()) {
            return $token;
        }
        return false;
    }

    public function assignedDsaService($userId, $dsaRefId)
    {
        $assigned_id = null;
        if ($this->is_connector) {
            $id = Services::findOne(['name' => 'Connector'])->service_enc_id;
            $referralData = \common\models\Referral::findOne(['code' => $this->dsaRefId]);
            if ($referralData) {
                if ($referralData->user_enc_id):
                    $assigned_id = $referralData->user_enc_id;
                endif;
                if ($referralData->organization_enc_id):
                    $assigned_id = Users::findOne(['organization_enc_id' => $referralData->organization_enc_id])->user_enc_id;
                endif;
            }
        } else {
            $id = Services::findOne(['name' => 'E-Partners'])->service_enc_id;
        }
        $model = new SelectedServices();
        $model->selected_service_enc_id = Yii::$app->security->generateRandomString(32);
        $model->service_enc_id = $id;
        $model->is_selected = 1;
        $model->assigned_user = $assigned_id;
        $model->created_by = $userId;
        $model->created_on = date('Y-m-d H:i:s');
        if ($model->save()) {
            if (!$this->is_connector) {
                if (!$this->assignedSupervisor($userId, $dsaRefId)) {
                    return false;
                }

                if (!$this->assignedSupervisor($userId, $dsaRefId, 'Lead Source')) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    public function assignedSupervisor($userId, $dsaRefId, $role = 'Manager')
    {
        $assignedSuper = new AssignedSupervisor();
        $assignedSuper->assigned_enc_id = Yii::$app->security->generateRandomString(32);
        $assignedSuper->supervisor_enc_id = Organizations::findOne(['organization_enc_id' => $dsaRefId])->created_by;
        $assignedSuper->assigned_user_enc_id = $userId;
        $assignedSuper->is_supervising = 1;
        $assignedSuper->supervisor_role = $role;
        $assignedSuper->created_on = date('Y-m-d H:i:s');
        $assignedSuper->created_by = $userId;
        if (!$assignedSuper->save()) {
            return false;
        }

        return true;
    }

}