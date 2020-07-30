<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\EditorAssets;
\frontend\assets\BlankAssets::register($this);
?>
<?php $this->beginPage(); ?>
    <!DOCTYPE html>
    <!--[if IE 8]>
    <html lang="en" class="ie8 no-js"> <![endif]-->
    <!--[if IE 9]>
    <html lang="en" class="ie9 no-js"> <![endif]-->
    <html lang="<?= Yii::$app->language; ?>">
    <head>
        <meta charset="<?= Yii::$app->charset; ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode($this->title); ?></title>
        <link rel="icon" href="/favicon.ico">
        <?php $this->head(); ?>
    </head>
    <?php $this->beginBody(); ?>
    <div class="content">
        <?= $content; ?>
    </div>
    <?php $this->endBody(); ?>
    </html>
<?php $this->endPage(); ?>