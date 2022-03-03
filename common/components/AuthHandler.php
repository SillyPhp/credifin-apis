<?php
namespace common\components;

use common\models\Auth;
use common\models\User;
use common\models\Usernames;
use common\models\Users;
use common\models\UserTypes;
use frontend\models\accounts\IndividualSignUpForm;
use frontend\models\accounts\LoginForm;
use Yii;
use common\models\RandomColors;
use common\models\Utilities;
use common\models\UserLogin;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $id = ArrayHelper::getValue($attributes, 'id');
        $nickname = ArrayHelper::getValue($attributes, 'login');
        $name = ArrayHelper::getValue($attributes, 'name');
        $first_name = ArrayHelper::getValue($attributes, 'first_name');
        $last_name = ArrayHelper::getValue($attributes, 'last_name');
        $user_type = UserTypes::findOne([
            'user_type' => 'Individual',
        ]);

        /* @var Auth $auth */
        $auth = Auth::find()->where([
            'source' => $this->client->getId(),
            'source_id' => $id,
        ])->one();
        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = UserLogin::findByUsername($auth->user->username, $user_type->user_type_enc_id);
                //$this->updateUserInfo($user);
                Yii::$app->user->login($user, 3600 * 24 * 30);
            } else { // signup
                if ($email !== null && Users::find()->where(['email' => $email])->exists()) {
                    $user_db = Users::find()->where(['email' => $email])->one();
                    $auth = new Auth([
                        'user_id' => $user_db->user_enc_id,
                        'source' => $this->client->getId(),
                        'source_id' => (string)$id,
                    ]);
                    if ($auth->save()) {
                        $user = UserLogin::findByUsername($user_db->username, $user_type->user_type_enc_id);
                        Yii::$app->user->login($user, 3600 * 24 * 30);
                    }
//                    Yii::$app->getSession()->setFlash('error', [
//                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
//                    ]);
                } else {
                    $utilitiesModel = new Utilities();
                    $password = Yii::$app->security->generateRandomString(8);
                    $utilitiesModel->variables['password'] = $password;
                    $utilitiesModel->variables['string'] = time() . rand(100, 100000);
                    $name_array = explode(' ',$name);
                    if (!empty($first_name)&&!empty($last_name)):
                        $username = $this->generate_username($first_name.' '.$last_name, 1000);
                        else:
                        $username = $this->generate_username($name, 1000);
                        endif;
                        $user = new Users([
                        'username' => $username,
                        'user_enc_id' => $utilitiesModel->encrypt(),
                        'first_name' => (($first_name)?$first_name:$name_array[0]),
                        'last_name' => (($last_name)?$last_name:$name_array[1]),
                        'email' => $email,
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
                            'source' => $this->client->getId(),
                            'source_id' => (string)$id,
                        ]);
                        $usernamesModel = new Usernames();
                        $usernamesModel->username = strtolower($username);
                        $usernamesModel->assigned_to = 1;
                        if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                            $transaction->rollBack();
                            return false;
                        }
                        else
                        {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($usernamesModel->getErrors()),
                                ]),
                            ]);
                        }
                        if ($auth->save()) {
                            $transaction->commit();
                            //to do login access to user
                            $user = UserLogin::findByUsername($user->username, $user_type->user_type_enc_id);
                            //$this->updateUserInfo($user);
                            Yii::$app->user->login($user, 3600 * 24 * 30);
                        } else {
                            Yii::$app->getSession()->setFlash('error', [
                                Yii::t('app', 'Unable to save {client} account: {errors}', [
                                    'client' => $this->client->getTitle(),
                                    'errors' => json_encode($auth->getErrors()),
                                ]),
                            ]);
                        }
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $this->client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
                    }
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->identity->user_enc_id,
                    'source' => $this->client->getId(),
                    'source_id' => (string)$attributes['id'],
                ]);
                if ($auth->save()) {
                    /** @var User $user */
                    $user = $auth->user;
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle()
                        ]),
                    ]);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                }
            } else { // there's existing auth
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app',
                        'Unable to link {client} account. There is another user using it.',
                        ['client' => $this->client->getTitle()]),
                ]);
            }
        }
    }

    /**
     * @param User $user
     */
    private function updateUserInfo(User $user)
    {
        $attributes = $this->client->getUserAttributes();
        $github = ArrayHelper::getValue($attributes, 'login');
        if ($user->github === null && $github) {
            $user->github = $github;
            $user->save();
        }
    }

    //generate a username from Full name
    private function generate_username($string_name=null, $rand_no = 200){
        $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
        $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

        $part1 = (!empty($username_parts[0]))?substr($username_parts[0], 0,8):""; //cut first name to 8 letters
        $part2 = (!empty($username_parts[1]))?substr($username_parts[1], 0,5):""; //cut second name to 5 letters
        $part3 = ($rand_no)?rand(0, $rand_no):"";

        $username = $part1. str_shuffle($part2). $part3; //str_shuffle to randomly shuffle all characters
        return $username;
    }
}