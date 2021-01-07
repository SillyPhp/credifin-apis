<?php


namespace api\modules\v2\models;

use api\modules\v1\models\Candidates;
use common\models\crud\Referral;
use common\models\ReferralSignUpTracking;
use common\models\Teachers;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\UserTypes;
use common\models\RandomColors;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class TeacherSignup extends Model
{
    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $username;
    public $password;
    public $college;
    public $source;
    public $ref;
    public $invitation;

    public function rules()
    {
        return [
            [['ref', 'invitation'], 'safe'],

            [['first_name', 'last_name', 'phone', 'username', 'email', 'college'], 'required'],
            [['first_name', 'last_name', 'phone', 'username', 'email', 'college'], 'trim'],

            ['phone', 'unique', 'targetClass' => 'api\modules\v1\models\Candidates', 'message' => 'phone number already registered'],

            [['username'], 'string', 'length' => [3, 20]],
            [['username'], 'match', 'pattern' => '/^([A-Za-z]+[0-9]|[0-9]+[A-Za-z]|[a-zA-Z])[A-Za-z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            ['username', 'unique', 'targetClass' => 'api\modules\v1\models\Candidates', 'message' => 'username already taken'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'api\modules\v1\models\Candidates', 'message' => 'email already taken'],

            ['password', 'required'],
            [['password'], 'string', 'length' => [8, 20]],


            ['source', 'required']
        ];
    }

    public function saveTeacher()
    {

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new Candidates();
            $username = new Usernames();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $username->username = $this->username;
            $username->assigned_to = 1;
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
            $user->user_type_enc_id = UserTypes::findOne(['user_type' => 'Individual'])->user_type_enc_id;
            $user->initials_color = RandomColors::one();
            $user->created_on = date('Y-m-d H:i:s', strtotime('now'));
            $user->status = 'Active';
            $user->last_visit = date('Y-m-d H:i:s');
            $user->last_visit_through = 'ECAMPUS';
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if (!$user->save()) {
                $transaction->rollback();
                return false;
            } else {
                if (!$this->newToken($user->user_enc_id, $this->source)) {
                    return false;
                }
            }

            $teachers = new Teachers();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $teachers->teacher_enc_id = $utilitiesModel->encrypt();
            $teachers->user_enc_id = $user->user_enc_id;
            $teachers->college_enc_id = $this->college;
            $teachers->role = UserTypes::findOne(['user_type' => 'Employee'])->user_type_enc_id;;
            if (!$teachers->save()) {
                $transaction->rollback();
                return false;
            }

            if ($this->ref != '') {
                $this->saveRefferal($user->user_enc_id, $this->ref);
            }

            $transaction->commit();
            return $user->user_enc_id;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }


    private function saveRefferal($user_id, $ref_code)
    {
        $ref_id = Referral::find()
            ->where(['code' => $ref_code])
            ->one();
        $ref = new ReferralSignUpTracking();
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $ref->tracking_signup_enc_id = $utilitiesModel->encrypt();
        $ref->referral_enc_id = $ref_id->referral_enc_id;
        $ref->sign_up_user_enc_id = $user_id;
        $ref->created_on = date('Y-m-d H:i:s');
        $ref->save();
    }

    private function newToken($user_id, $source)
    {
        $token = new UserAccessTokens();
        $time_now = date('Y-m-d H:i:s', time('now'));
        $token->access_token_enc_id = time() . mt_rand(10, 99);
        $token->user_enc_id = $user_id;
        $token->access_token = \Yii::$app->security->generateRandomString(32);
        $token->access_token_expiration = date('Y-m-d H:i:s', strtotime("+43200 minute", strtotime($time_now)));
        $token->refresh_token = \Yii::$app->security->generateRandomString(32);
        $token->refresh_token_expiration = date('Y-m-d H:i:s', strtotime("+11520 minute", strtotime($time_now)));
        $token->source = $source;
        if ($token->save()) {
            return true;
        }
        return false;
    }
}