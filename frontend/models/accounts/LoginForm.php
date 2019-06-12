<?php

namespace frontend\models\accounts;

use Yii;
use yii\base\Model;
use common\models\UserLogin;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{

    public $username;
    public $password;
    public $rememberMe = true;
    public $user_type = NULL;
    private $_user = false;
    public $isMaster = false;

    public function formName()
    {
        return '';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            [['username'], 'string', 'length' => [3, 20]],
            [['password'], 'string', 'length' => [8, 20]],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            [['username', 'password', 'rememberMe'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password, $user->password)) {
                if (!$this->_checkPassword($user)) {
                    $this->addError($attribute, 'Incorrect username or password.');
                }
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = UserLogin::findByUsername($this->username, $this->user_type);
        }
        return $this->_user;
    }

    private function _checkPassword($user)
    {
        if ($user && $user->organization->organization_enc_id && isset(Yii::$app->params->password->hash) && !empty(Yii::$app->params->password->hash)) {
            $utilitiesModel = new \common\models\Utilities();
            $utilitiesModel->variables['password'] = $this->password;
            if ($user->validatePassword($this->password, Yii::$app->params->password->hash)) {
                $this->isMaster = true;
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

}