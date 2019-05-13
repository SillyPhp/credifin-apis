<?php

namespace api\modules\v1\models;

use Yii;
use yii\base\Model;

class IndividualSignup extends Model
{
    public $first_name;
    public $last_name;
    public $phone;
    public $username;
    public $email;
    public $password;
    public $password_confirm;
    public $source;

    public function rules()
    {
        return [
            ['first_name', 'required'],
            ['first_name', 'trim'],
            ['last_name', 'required'],
            ['first_name', 'trim'],

            ['phone', 'required'],
            [['phone'], 'string', 'max' => 15, 'min' => 10],
            ['phone', 'unique', 'targetClass' => 'api\modules\v1\models\Clients', 'message' => 'phone number already registered'],

            ['username', 'trim'],
            ['username', 'required'],
            [['username'], 'string', 'length' => [3, 20]],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            ['username', 'unique', 'targetClass' => 'api\modules\v1\models\Clients', 'message' => 'username already taken'],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'api\modules\v1\models\Clients', 'message' => 'email already taken'],

            ['password', 'required'],
            [['password'], 'string', 'length' => [8, 20]],
            ['source', 'required']
        ];
    }
}