<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\SharingLinks;
use common\models\SharedLinksCounter;

class LinksController extends Controller
{

    public function actionRedirect($lidk)
    {
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

    public function actionGenerateReferrals()
    {
        $connection = Yii::$app->getDb();
        $command1 = $connection->createCommand("
            SELECT DISTINCT `id`, `user_enc_id` FROM " . \common\models\Users::tableName() . " WHERE `user_enc_id` NOT IN
(SELECT DISTINCT `a`.`user_enc_id` FROM " . \common\models\Referral::tableName() . " `a` INNER JOIN " . \common\models\Users::tableName() . " `b` ON `b`.`user_enc_id` = `a`.`user_enc_id`)
ORDER BY
`id`
        ");

        $users = $command1->queryAll();
        if (count($users) > 0) {
            foreach ($users as $user) {
                $referralModel = new \common\models\crud\Referral();
                $referralModel->user_enc_id = $referralModel->created_by = $user["user_enc_id"];
                if (!$referralModel->create()) {
                    print_r($referralModel->getErrors());
                }
            }
        }

        $command2 = $connection->createCommand("
            SELECT DISTINCT `id`, `organization_enc_id`, `created_by` FROM " . \common\models\Organizations::tableName() . " WHERE `organization_enc_id` NOT IN
(SELECT DISTINCT `a`.`organization_enc_id` FROM " . \common\models\Referral::tableName() . " `a` INNER JOIN " . \common\models\Organizations::tableName() . " `b` ON `b`.`organization_enc_id` = `a`.`organization_enc_id`)
ORDER BY
`id`
        ");

        $organizations = $command2->queryAll();
        if (count($organizations) > 0) {
            foreach ($organizations as $organization) {
                $referralModel = new \common\models\crud\Referral();
                $referralModel->created_by = $organization["created_by"];
                $referralModel->is_organization = true;
                $referralModel->organization_enc_id = $organization["organization_enc_id"];
                if (!$referralModel->create()) {
                    print_r($referralModel->getErrors());
                }
            }
        }
    }

}