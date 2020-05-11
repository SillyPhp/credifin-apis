<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\Utilities;
use common\models\Users;

class ChangePasswordForm extends Model {

    public $oldpassword;
    public $newpassword;
    public $repeatnewpassword;

    public function rules() {
        return [
            [['oldpassword', 'newpassword', 'repeatnewpassword'], 'required'],
            [['repeatnewpassword'], 'compare', 'compareAttribute' => 'newpassword'],
            [['oldpassword', 'newpassword', 'repeatnewpassword'], 'string', 'length' => [8, 20]],
        ];
    }

    public function attributeLabels() {
        return [
            'oldpassword' => Yii::t('frontend', 'Old Password'),
            'newpassword' => Yii::t('frontend', 'New Password'),
            'repeatnewpassword' => Yii::t('frontend', 'Repeat New Password'),
        ];
    }

    public function changePassword() {
        if (!$this->validate()) {
            return false;
        }
        $utilitiesModel = new Utilities();
        $utilitiesModel->variables['password'] = $this->oldpassword;
        $this->oldpassword = $utilitiesModel->encrypt_pass();
        if ($this->oldpassword !== Yii::$app->user->identity->password) {
            return false;
        }
        $utilitiesModel->variables['password'] = $this->newpassword;
        $this->newpassword = $utilitiesModel->encrypt_pass();
        $user = Users::findOne([
            'user_enc_id' => Yii::$app->user->identity->user_enc_id,
        ]);
        
        if(!$user) {
            return false;
        }
        
        $user->password = $this->newpassword;
        if($user->save()) {
            return true;
        } else {
            return false;
        }
    }

}
