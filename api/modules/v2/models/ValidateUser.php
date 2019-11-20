<?php

namespace api\modules\v2\models;

use common\models\RandomColors;
use common\models\Users;
use Yii;
use yii\base\Model;
use common\models\Utilities;

class ValidateUser extends Model
{
    public $phone;
    public $email;
    public $username;

    public function rules()
    {
        return [

            [['phone', 'username', 'email'], 'safe'],
            [['phone', 'username', 'email'], 'trim'],
            ['phone', 'checkPhone'],
//            ['phone', 'unique', 'targetClass' => 'api\modules\v1\models\Candidates', 'message' => 'phone number already used'],

            [['username'], 'string', 'length' => [3, 20]],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers'],
            ['username', 'unique', 'targetClass' => 'api\modules\v1\models\Candidates', 'message' => 'username already taken'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'api\modules\v1\models\Candidates', 'message' => 'email already used'],
        ];
    }

    public function checkPhone($attribute, $params)
    {
        $user= Users::find()
            ->where(["REPLACE(phone, ' ', '')" => preg_replace("/\s+/", "", $this->phone)])
            ->one();

        if ($user) {
            return $this->addError($attribute, "$attribute must be unique in brand scope!");
        }
    }
}