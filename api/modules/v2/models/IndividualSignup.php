<?php

namespace api\modules\v2\models;

use api\modules\v2\models\Candidates;
use common\models\CollegeSettings;
use common\models\crud\Referral;
use common\models\Departments;
use common\models\EducationalRequirements;
use common\models\EmailLogs;
use common\models\ErexxSettings;
use common\models\ReferralSignUpTracking;
use common\models\UserAccessTokens;
use common\models\Usernames;
use common\models\UserOtherDetails;
use common\models\UserTypes;
use common\models\RandomColors;
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
    public $college;
    public $department;
    public $course_id;
    public $section_id;
    public $semester;
    public $starting_year;
    public $ending_year;
    public $roll_number;
    public $internship_start_date;
    public $internship_duration;
    public $job_start_month;
    public $job_year;
    public $source;
    public $ref;
    public $invitation;

    public function rules()
    {
        return [
            [['internship_start_date', 'internship_duration', 'job_start_month', 'job_year', 'ref', 'invitation', 'section_id', 'course_id', 'semester', 'roll_number'], 'safe'],

            [['first_name', 'last_name', 'phone', 'username', 'email', 'college'], 'required'],
            [['first_name', 'last_name', 'phone', 'username', 'email'], 'trim'],

            ['phone', 'unique', 'targetClass' => 'api\modules\v2\models\Candidates', 'message' => 'phone number already registered'],

            [['username'], 'string', 'length' => [3, 20]],
            [['username'], 'match', 'pattern' => '/^([A-Za-z]+[0-9]|[0-9]+[A-Za-z]|[a-zA-Z])[A-Za-z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            ['username', 'unique', 'targetClass' => 'api\modules\v2\models\Candidates', 'message' => 'username already taken'],

            ['starting_year', 'safe'],
            ['ending_year', 'safe'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'api\modules\v2\models\Candidates', 'message' => 'email already taken'],

            ['password', 'required'],
            [['password'], 'string', 'length' => [8, 20]],

            ['source', 'required']
        ];
    }

    public function saveUser()
    {

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new Candidates();
            $username = new Usernames();
            $user_other_details = new UserOtherDetails();
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
            $user->signed_up_through = 'ECAMPUS';
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if (!$user->save()) {
                $transaction->rollback();
                return false;
            }

            $auto_approve = CollegeSettings::find()
                ->alias('a')
                ->innerJoinWith(['settingEnc b'], false)
                ->where(['a.college_enc_id' => $this->college, 'b.setting' => 'students_approve', 'a.value' => 2])
                ->one();


            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $user_other_details->user_other_details_enc_id = $utilitiesModel->encrypt();
            $user_other_details->organization_enc_id = $this->college;
            $user_other_details->user_enc_id = $user->user_enc_id;

            if ($auto_approve) {
                $user_other_details->college_actions = 0;
            }

            if ($this->department != '') {
                $d = Departments::find()
                    ->where([
                        'name' => $this->department
                    ])
                    ->one();

                if ($d) {
                    $user_other_details->department_enc_id = $d->department_enc_id;
                } else {
                    $department = new Departments();
                    $utilitiesModel = new \common\models\Utilities();
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $department->department_enc_id = $utilitiesModel->encrypt();
                    $department->name = $this->department;
                    if (!$department->save()) {
                        $transaction->rollback();
                        return false;
                    }
                    $user_other_details->department_enc_id = $department->department_enc_id;
                }
            }

            if ($this->course_id != '') {
                $user_other_details->assigned_college_enc_id = $this->course_id;
            }
            $user_other_details->section_enc_id = $this->section_id;
            $user_other_details->semester = $this->semester;
            $user_other_details->starting_year = $this->starting_year;
            $user_other_details->ending_year = $this->ending_year;
            if ($this->roll_number != '') {
                $user_other_details->university_roll_number = $this->roll_number;
            }

            if (!$user_other_details->save()) {
                $transaction->rollback();
                return false;
            }

            if ($this->ref != '') {
                $this->saveRefferal($user->user_enc_id, $this->ref);
            }

            $mail = Yii::$app->mail;
            $mail->receivers = [];
            $mail->receivers[] = [
                "name" => $this->first_name ." " . $this->last_name,
                "email" => $this->email,
            ];
            $mail->subject = 'Welcome to My eCampus';
            $mail->template = 'mec-thank-you';
            if($mail->send()){
                $mail_logs = new EmailLogs();
                $utilitesModel = new Utilities();
                $utilitesModel->variables['string'] = time() . rand(100, 100000);
                $mail_logs->email_log_enc_id = $utilitesModel->encrypt();
                $mail_logs->email_type = 5;
                $mail_logs->user_enc_id = $user->user_enc_id;
                $mail_logs->receiver_name = $user->first_name ." " . $user->last_name;
                $mail_logs->receiver_email = $user->email;
                $mail_logs->receiver_phone = $user->phone;
                $mail_logs->subject = 'Welcome to My eCampus';
                $mail_logs->template = 'mec-thank-you';
                $mail_logs->is_sent = 1;
                $mail_logs->save();
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
            return true;
        }
        return false;
    }

}