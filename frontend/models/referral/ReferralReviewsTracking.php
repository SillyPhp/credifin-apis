<?php

namespace frontend\models\referral;

use common\models\ReferralReviewTracking;
use yii\base\Widget;
use common\models\Utilities;
use Yii;

class ReferralReviewsTracking extends Widget
{
    public $claim_review_id = null;
    public $unclaim_review_id = null;

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
            $model = new ReferralReviewTracking();
            $utilitiesModel = new Utilities();
            $utilitiesModel->variables['string'] = time() . rand(100, 100000);
            $model->tracking_review_enc_id = $utilitiesModel->encrypt();
            $model->referral_enc_id = $ref->referral_enc_id;
            if (!empty($this->claim_review_id)) {
                $model->claimed_review_enc_id = $this->claim_review_id;
            }
            if (!empty($this->unclaim_review_id)) {
                $model->unclaimed_review_enc_id = $this->unclaim_review_id;
            }
            if ($model->save()) {
                return true;
            }
        }
    }
}