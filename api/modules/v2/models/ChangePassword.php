<?php

namespace api\modules\v2\models;

use common\models\UserAccessTokens;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Users;
use yii\db\Exception;

class ChangePassword extends Model
{
    public $old_password;
    public $new_password;
    public $user_id;
    public $repeat_new_password;

    public function rules()
    {
        return [
            [['old_password', 'new_password', 'repeat_new_password', 'user_id'], 'required'],
            [['repeat_new_password'], 'compare', 'compareAttribute' => 'new_password', 'message' => 'New password and confirm password should be same.'],
            ['new_password', 'string', 'length' => [8, 20]],
            ['old_password', 'compare', 'compareAttribute' => 'new_password', 'operator' => '!==', 'message' => 'Old password and New password should not be same.'],
        ];
    }

    public function formName()
    {
        return '';
    }

    public function changePassword(): void
    {
        $user = Users::findOne(['user_enc_id' => $this->user_id]);
        if (!$user) {
            throw new Exception("user not found");
        }

        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['password'] = $this->old_password;
        $utilitiesModel->variables['hash'] = $user['password'];

        // checking if old password is correct
        if (!$utilitiesModel->verify_pass()) {
            throw new Exception("Old Password Is Wrong");
        }

        // updating password
        $utilitiesModel->variables['password'] = $this->new_password;
        $user->password = $utilitiesModel->encrypt_pass();

        if (!$user->save()) {
            throw new \Exception (implode(", ", \yii\helpers\ArrayHelper::getColumn($user->getErrors(), 0, false)));
        }
        UserAccessTokens::updateAll(
            [
                'is_deleted' => 1,
                'last_updated_on' => date('Y-m-d H:i:s')
            ],
            [
                'user_enc_id' => $this->user_id,
                'is_deleted' => 0
            ]
        );
    }
}