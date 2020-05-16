<?php

namespace api\modules\v3\models\widgets;

use common\models\ReferralSignUpTracking;
use yii\base\Widget;
use common\models\Utilities;
use Yii;

class Referral extends Widget
{
    public $user_id = null;
    public $user_org_id = null;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $cookies_request = Yii::$app->request->cookies;
        $code = $cookies_request->get('ref_csrf-tc');
        if (!empty($code)) {
            $ref = \common\models\Referral::findOne(['code' => $code]);
            $model = new ReferralSignUpTracking();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->tracking_signup_enc_id = $utilitiesModel->encrypt();
            $model->referral_enc_id = $ref->referral_enc_id;
            if (!empty($this->user_id)) {
                $model->sign_up_user_enc_id = $this->user_id;
            }
            if (!empty($this->user_org_id)) {
                $model->sign_up_org_enc_id = $this->user_org_id;
            }
            if ($model->save()) {
                return true;
            }
        }
    }
}