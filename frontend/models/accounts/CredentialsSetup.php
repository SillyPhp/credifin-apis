<?php

namespace frontend\models\accounts;

use common\models\Usernames;
use common\models\Users;
use yii\base\Model;
use Yii;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class CredentialsSetup extends Model
{

    public $username;

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
            [['username'], 'required'],
            [['username'], 'string', 'length' => [3, 50]],
            [['username'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Username can only contain alphabets and numbers, without spaces'],
            [['username'], 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
            ['username', 'unique', 'targetClass' => Usernames::className(), 'targetAttribute' => ['username' => 'username'], 'message' => 'This username has already been taken.'],
            // rememberMe must be a boolean value
            // password is validated by validatePassword()
        ];
    }

    public function save()
    {
        $user = Users::findOne(['user_enc_id'=>Yii::$app->user->identity->user_enc_id]);
        $user->is_credential_change = 0;
        $user->username = strtolower($this->username);
        if ($this->username!==Yii::$app->user->identity->username)
        {
            $usernamesModel = new Usernames();
            $usernamesModel->username = strtolower($this->username);
            $usernamesModel->assigned_to = 1;
            if (!$usernamesModel->validate() || !$usernamesModel->save()) {
                return false;
            }
        }
        if ($user->save())
        {
            return true;
        }
        else
        {
            return  false;
        }
    }
}