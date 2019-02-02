<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\SharingLinks;
use common\models\SharedLinksCounter;

class LinksController extends Controller
{

    public function actionRedirect($lidk) {
        $sharedLinksCounterModel = new SharedLinksCounter();
        $link_data = SharingLinks::find()
            ->where(['link_enc_id' => $lidk])
            ->asArray()
            ->one();

        $ip = Yii::$app->getRequest()->getUserIP(false);
        $sharedLinksCounterModel->ip_address = $ip;
        $sharedLinksCounterModel->link_enc_id = $lidk;

        if ($sharedLinksCounterModel->validate()) {
            $sharedLinksCounterModel->save();
        }

        return $this->renderPartial('redirect', [
            'link_data' => $link_data,
        ]);
    }

}