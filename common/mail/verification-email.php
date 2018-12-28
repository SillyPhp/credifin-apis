<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="container-fluid full-title">
    <div class="container">
        <div class="title">
            <p>
                <?= Yii::t('app', 'Activate account'); ?>
            </p>
        </div>
    </div>
</div>
<div class="container-fluid description-background">
    <div class="container">
        <div class="description">
            <h2><?= Yii::t('app', 'Hello ') . $data['name']; ?>,</h2>
            <p><?= Yii::t('app', 'Your ' . Yii::$app->params->site_name . ' account has been successfully created, all you need to do is follow the link below to activate it now.'); ?></p>
            <p>
                <?= Html::a(Yii::t('app', 'Activate Account'), $data['link'], ['class' => 'button']); ?>
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