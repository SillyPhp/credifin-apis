<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppSecondaryAssets;

AppSecondaryAssets::register($this);
$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language; ?>">
    <head>
        <meta charset="<?= Yii::$app->charset; ?>">
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode((!empty($this->title)) ? Yii::t('account', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name : Yii::$app->params->site_name); ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="icon" href="<?= Url::to('/favicon.ico'); ?>">
        <?php $this->head(); ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>
    <div id="wrapper" class="clearfix">
        <div class="main-content">
            <section id="home" class="divider parallax fullscreen layer-overlay overlay-white-9" data-bg-img="<?= (isset($this->params['background_image']) && !empty($this->params['background_image'])) ? $this->params['background_image'] : ''; ?>">
                <div class="display-table">
                    <div class="display-table-cell">
                        <div class="container">
                            <div class="row">
                                <div class="<?= (isset($this->params['grid_size']) ? $this->params['grid_size'] : 'col-md-6 col-md-push-3'); ?>">
                                    <div class="text-center col-md-12 mb-60">
                                        <a href="/">
                                            <img width="275px" alt="<?= Yii::$app->params->site_name; ?>" src="<?= Url::to('@commonAssets/logos/logo.svg'); ?>">
                                        </a>
                                    </div>
                                    <?= $content; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php
    $this->registerCss("
        #home {
            min-height:100vh !important;
            height: auto !important;
            margin-bottom:-50px;
        }");
    ?>
    <?php $this->endBody(); ?>
    </body>
    </html>
<?php $this->endPage(); ?>