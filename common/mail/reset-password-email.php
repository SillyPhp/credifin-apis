<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container-fluid full-title">
    <div class="container">
        <div class="title">
            <p>
                <?= Yii::t('app', 'Reset Password'); ?>
            </p>
        </div>
    </div>
</div>
<div class="container-fluid description-background">
    <div class="container">
        <div class="description">
            <h2><?= Yii::t('app', 'Hello ') . $data['name']; ?>,</h2>
            <p><?= Yii::t('app', 'You have requested your password to be reset. Just click the link below to chance the password.'); ?></p>
            <p>
                <?= Html::a(Yii::t('app', 'Reset Password'), $data['link'], ['class' => 'button']); ?>
            </p>
            <h2><?= Yii::t('app', 'Cheers'); ?>,</h2>
            <p align="left">
                <img src="<?= Url::to('@commonAssets/logos/eyteam.png', true); ?>"/>
            </p>
            <hr width="100%">
            <p align="center" class="footer">
                <?= Yii::t('frontend', 'Copyright') . ' &copy; ' . date('Y') . ' ' . Yii::$app->params->site_name; ?>
            </p>
        </div>
    </div>
</div>