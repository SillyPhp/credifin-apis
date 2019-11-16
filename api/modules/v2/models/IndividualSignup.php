<?php

namespace api\modules\v2\models;

use api\modules\v1\models\Candidates;
use common\models\crud\Referral;
use common\models\Departments;
use common\models\EducationalRequirements;
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
    public $course_name;
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
            [['internship_start_date', 'internship_duration', 'job_start_month', 'job_year','ref','invitation'], 'safe'],

            [['first_name','last_name','phone','username','email'], 'required'],
            [['first_name','last_name','phone','username','email'], 'trim'],

            ['phone', 'unique', 'targetClass' => 'api\modules\v1\models\Candidates', 'message' => 'phone number already registered'],

            [['username'], 'string', 'length' => [3, 20]],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            ['username', 'unique', 'targetClass' => 'api\modules\v1\models\Candidates', 'message' => 'username already taken'],

            ['starting_year', 'safe'],
            ['ending_year', 'safe'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'api\modules\v1\models\Candidates', 'message' => 'email already taken'],

            ['password', 'required'],
            [['password'], 'string', 'length' => [8, 20]],

            [['college', 'department', 'course_name', 'semester', 'roll_number'], 'required'],

            ['source', 'required']
        ];
    }

    public function saveUser()
    {
        $user = new Candidates();
        $username = new Usernames();
        $user_other_details = new UserOtherDetails();

        $username->username = $this->username;
        $username->assigned_to = 1;
        if (!$username->validate() || !$username->save()) {
            return false;
        }

        $user->username = $this->username;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->user_enc_id = time() . mt_rand(10, 99);
        $user->user_type_enc_id = UserTypes::findOne(['user_type' => 'Individual'])->user_type_enc_id;
        $user->initials_color = RandomColors::one();
        $user->created_on = date('Y-m-d H:i:s', strtotime('now'));
        $user->status = 'Active';
        $user->setPassword($this->password);
        $user->generateAuthKey();
        if (!$user->save()) {
            return false;
        } else {
            if (!$this->newToken($user->user_enc_id, $this->source)) {
                return false;
            }
        }

        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time() . rand(100, 100000);
        $user_other_details->user_other_details_enc_id = $utilitiesModel->encrypt();
        $user_other_details->organization_enc_id = $this->college;
        $user_other_details->user_enc_id = $user->user_enc_id;

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
            if(!$department->save()){
                return false;
            }
            $user_other_details->department_enc_id = $department->department_enc_id;
        }

        $e = EducationalRequirements::find()
            ->where([
                'educational_requirement' => $this->course_name
            ])
            ->one();

        if ($e) {
            $user_other_details->educational_requirement_enc_id = $e->educational_requirement_enc_id;
        } else {
            $eduReq = new EducationalRequirements();
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $eduReq->educational_requirement_enc_id = $utilitiesModel->encrypt();
            $eduReq->educational_requirement = $this->course_name;
            $eduReq->created_on = date('Y-m-d H:i:s');
            $eduReq->created_by = $user->user_enc_id;
            if(!$eduReq->save()){
                return false;
            }
            $user_other_details->educational_requirement_enc_id = $eduReq->educational_requirement_enc_id;
        }

        $user_other_details->semester = $this->semester;
        $user_other_details->starting_year = $this->starting_year;
        $user_other_details->ending_year = $this->ending_year;
        $user_other_details->university_roll_number = $this->roll_number;


        if($this->job_start_month){
            $user_other_details->job_start_month = $this->job_start_month;
        }

        if($this->job_year){
            $user_other_details->job_year = $this->job_year;
        }

        if($this->internship_duration){
            $user_other_details->internship_duration = $this->internship_duration;
        }

        if($this->internship_start_date){
            $user_other_details->internship_start_date = $date = date('Y-m-d', strtotime($this->internship_start_date));
        }

        if (!$user_other_details->save()) {
            return false;
        }

//        $this->saveRefferal($user->user_enc_id,$this->ref);

        return true;
    }

    private function saveRefferal($user_id,$ref_code){
        $ref_id = Referral::find()
            ->where(['code'=>$ref_code])
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