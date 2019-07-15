<?php
namespace frontend\models\referral;
use common\models\ReferralJobAppliedTracking;
use yii\base\Widget;
use common\models\Utilities;
use Yii;

class RefferalJobAppliedTracking extends Widget
{
    public $job_applied_id = null;

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
            $model = new ReferralJobAppliedTracking();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->tracking_signup_enc_id = $utilitiesModel->encrypt();
            $model->referral_enc_id = $ref->referral_enc_id;
            if (!empty($this->job_applied_id)) {
                $model->applied_enc_id = $this->job_applied_id;
            }
            $model->save();
        }
    }
}