<?php

namespace api\modules\v4\models;

use api\modules\v4\models\Candidates;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;
    public $isMaster = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['rememberMe'], 'safe'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Incorrect username or password');
            } elseif ($user['status'] != 'Active') {
                $this->addError('error', 'Account status is \'' . $user['status'] . '\'.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Candidates::findByUsername($this->username);
        }
        return $this->_user;
    }
}