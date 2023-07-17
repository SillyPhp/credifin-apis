<?php


namespace api\modules\v2\models;


use common\models\UserAccessTokens;
use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Users;

class ChangePassword extends Model
{
    public $old_password;
    public $new_password;
    public $repeat_new_password;

    public function rules()
    {
        return [
            [['old_password', 'new_password', 'repeat_new_password'], 'required'],
            [['repeat_new_password'], 'compare', 'compareAttribute' => 'new_password'],
            [['old_password', 'new_password', 'repeat_new_password'], 'string', 'length' => [8, 20]],
        ];
    }

    public function changePassword($user_id)
    {
        $password = Users::find()
            ->where(['user_enc_id' => $user_id])
            ->asArray()
            ->one();
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['password'] = $this->old_password;
        $utilitiesModel->variables['hash'] = $password['password'];
        if ($this->old_password == $this->new_password) {
            return 402;
        }
        if (!$utilitiesModel->verify_pass()) {
            return 403;
        }
        $utilitiesModel->variables['password'] = $this->new_password;
        $this->new_password = $utilitiesModel->encrypt_pass();
        $user = Users::findOne([
            'user_enc_id' => $user_id,
        ]);

        if (!$user) {
            return false;
        }

        $user->password = $this->new_password;
        if ($user->save()) {
            $update = UserAccessTokens::findAll(['user_enc_id' => $user_id]);
            //only active will be deleted
            foreach ($update as $up) {
                $up->is_deleted = 1;
                $up->update();
            }
            return true;
        } else {
            return false;
        }
    }

}