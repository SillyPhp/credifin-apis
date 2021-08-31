<?php

namespace api\modules\v1\models;

use common\models\Auth;
use common\models\User;
use common\models\UserLogin;
use common\models\Usernames;
use common\models\Users;
use common\models\UserTypes;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use common\models\RandomColors;
use common\models\Utilities;

class SocialLogin extends Model
{

    public $email;
    public $first_name;
    public $last_name;
    public $platform;
    public $source_id;
    public $source;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['source_id', 'platform', 'first_name', 'last_name'], 'required'],
            [['source', 'email'], 'safe'],
            [['email', 'first_name', 'last_name', 'source_id', 'platform'], 'trim'],
            ['email', 'email'],
            ['email', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
        ];
    }

    public function handle()
    {
        $user_type = UserTypes::findOne([
            'user_type' => 'Individual',
        ]);

        /* @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->platform,
            'source_id' => $this->source_id,
        ])->one();

        if ($auth) {
            // login
            return [
                'status' => 203,
                'user_id' => $auth->user_id
            ];

        } else {
            // signup
            if ($this->email !== null && Users::find()->where(['email' => $this->email])->exists()) {
                $user_db = Users::find()->where(['email' => $this->email])->one();
                $auth = new Auth([
                    'user_id' => $user_db->user_enc_id,
                    'source' => $this->platform,
                    'source_id' => (string)$this->source_id,
                ]);
                if ($auth->save()) {
                    return [
                        'status' => 203,
                        'user_id' => $auth->user_id
                    ];
                }

            } else {
                $utilitiesModel = new Utilities();
                $password = Yii::$app->security->generateRandomString(8);
                $utilitiesModel->variables['password'] = $password;
                $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                $username = $this->generate_username($this->first_name . ' ' . $this->last_name, 1000);
                $user = new Users([
                    'username' => $username,
                    'user_enc_id' => $utilitiesModel->encrypt(),
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'email' => $this->email,
                    'password' => $utilitiesModel->encrypt_pass(),
                    'last_visit' => date('Y-m-d H:i:s'),
                    'last_visit_through' => 'EYAPP',
                    'signed_up_through' => 'EYAPP',
                    'auth_key' => Yii::$app->security->generateRandomString(),
                    'user_type_enc_id' => $user_type->user_type_enc_id,
                    'status' => 'Active',
                    'initials_color' => RandomColors::one(),
                    'is_credential_change' => 1,
                ]);

                $transaction = Users::getDb()->beginTransaction();
                if ($user->save()) {
                    $auth = new Auth([
                        'user_id' => $user->user_enc_id,
                        'source' => $this->platform,
                        'source_id' => (string)$this->source_id,
                    ]);
                    $usernamesModel = new Usernames();
                    $usernamesModel->username = strtolower($username);
                    $usernamesModel->assigned_to = 1;
                    if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                        $transaction->rollBack();
                        print_r($usernamesModel->getErrors());
                        return 500;
                    }
                    if ($auth->save()) {
                        $transaction->commit();
                        return [
                            'status' => 205,
                            'user_id' => $auth->user_id
                        ];
                    } else {
                        print_r($auth->getErrors());
                        return 500;
                    }
                } else {
                    print_r($user->getErrors());
                    return 500;
                }
            }
        }
    }

    /**
     * @param User $user
     */

    //generate a username from Full name
    private function generate_username($string_name = null, $rand_no = 200)
    {
        $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
        $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

        $part1 = (!empty($username_parts[0])) ? substr($username_parts[0], 0, 8) : ""; //cut first name to 8 letters
        $part2 = (!empty($username_parts[1])) ? substr($username_parts[1], 0, 5) : ""; //cut second name to 5 letters
        $part3 = ($rand_no) ? rand(0, $rand_no) : "";

        $username = $part1 . str_shuffle($part2) . $part3; //str_shuffle to randomly shuffle all characters
        return $username;
    }

}