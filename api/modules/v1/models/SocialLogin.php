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
            [['email', 'source_id', 'platform', 'first_name', 'last_name'], 'required'],
            [['source'], 'safe'],
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

//        if (Yii::$app->user->isGuest) {
        if ($auth) { // login
            return [
                'status' => 203,
                'user_id' => $auth->user_id
            ];
//                $user = UserLogin::findByUsername($auth->user->username, $user_type->user_type_enc_id);
            //$this->updateUserInfo($user);

//                Yii::$app->user->login($user, 3600 * 24 * 30);
        } else { // signup
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
//                        $user = UserLogin::findByUsername($user_db->username, $user_type->user_type_enc_id);
//                        Yii::$app->user->login($user, 3600 * 24 * 30);
                }
//                    Yii::$app->getSession()->setFlash('error', [
//                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->>$this->platform]),
//                    ]);
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
                    'auth_key' => Yii::$app->security->generateRandomString(),
                    'user_type_enc_id' => $user_type->user_type_enc_id,
                    'status' => 'Active',
                    'initials_color' => RandomColors::one(),
                    'is_credential_change' => 1,
                ]);
                //$user->generateAuthKey();
                //$user->generatePasswordResetToken();

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
                        //to do login access to user
//                            $user = UserLogin::findByUsername($user->username, $user_type->user_type_enc_id);
                        //$this->updateUserInfo($user);
//                            Yii::$app->user->login($user, 3600 * 24 * 30);
                    } else {
                        print_r($auth->getErrors());
                        return 500;
//                            Yii::$app->getSession()->setFlash('error', [
//                                Yii::t('app', 'Unable to save {client} account: {errors}', [
//                                    'client' => $this->platform,
//                                    'errors' => json_encode($auth->getErrors()),
//                                ]),
//                            ]);
                    }
                } else {
                    print_r($user->getErrors());
                    return 500;
//                        Yii::$app->getSession()->setFlash('error', [
//                            Yii::t('app', 'Unable to save user: {errors}', [
//                                'client' => $this->platform,
//                                'errors' => json_encode($user->getErrors()),
//                            ]),
//                        ]);
                }
            }
        }
//        } else { // user already logged in
//            if (!$auth) { // add auth provider
//                $auth = new Auth([
//                    'user_id' => Yii::$app->user->identity->user_enc_id,
//                    'source' => $this->platform,
//                    'source_id' => (string)$this->source_id,
//                ]);
//                if ($auth->save()) {
//                    /** @var User $user */
//                    $user = $auth->user;
//                    Yii::$app->getSession()->setFlash('success', [
//                        Yii::t('app', 'Linked {client} account.', [
//                            'client' => $this->platform
//                        ]),
//                    ]);
//                } else {
//                    Yii::$app->getSession()->setFlash('error', [
//                        Yii::t('app', 'Unable to link {client} account: {errors}', [
//                            'client' => $this->platform,
//                            'errors' => json_encode($auth->getErrors()),
//                        ]),
//                    ]);
//                }
//            } else { // there's existing auth
//                Yii::$app->getSession()->setFlash('error', [
//                    Yii::t('app',
//                        'Unable to link {client} account. There is another user using it.',
//                        ['client' => $this->platform]),
//                ]);
//            }
//        }
    }

    /**
     * @param User $user
     */
//    private function updateUserInfo(User $user)
//    {
//        $attributes = $this->client->getUserAttributes();
//        $github = ArrayHelper::getValue($attributes, 'login');
//        if ($user->github === null && $github) {
//            $user->github = $github;
//            $user->save();
//        }
//    }

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