<?php


namespace common\models\crud;

use Yii;

class Referral extends \common\models\Referral
{

    public $is_organization = false;

    public $transaction = false;

    public function create() {
        $utilitiesModel = new \common\models\Utilities();
        $utilitiesModel->variables['string'] = time().rand(10, 100000);
        $this->referral_enc_id =$utilitiesModel->encrypt();
        $this->code = $this->referral_link = $this->_getReferralCode();

        if($this->is_organization) {
            if(empty($this->organization_enc_id)) {
                $this->organization_enc_id = Yii::$app->user->identity->organization->organization_enc_id;
            }
            $this->user_enc_id = NULL;
        } else {
            if(empty($this->user_enc_id)) {
                $this->user_enc_id = Yii::$app->user->identity->user_enc_id;
            }
            $this->organization_enc_id = NULL;
        }

        if(empty($this->created_by)) {
            $this->created_by = Yii::$app->user->identity->user_enc_id;
        }

        if(!$this->validate()) {
            return false;
        }

        if($this->save()) {
            return true;
        }

        return false;
    }

    private function _getReferralCode($n = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }

}