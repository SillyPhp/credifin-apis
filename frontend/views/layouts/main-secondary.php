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
        <title><?= Html::encode((!empty($this->title)) ? Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name : Yii::$app->params->site_name); ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="icon" href="<?= Url::to('/favicon.ico'); ?>">
        <?php
        if (isset($this->params['seo_tags']) && !empty($this->params['seo_tags'])) {
            foreach ($this->params['seo_tags']['rel'] as $key => $value) {
                $this->registerLinkTag([
                    'rel' => $key,
                    'href' => $value,
                ]);
            }
            foreach ($this->params['seo_tags']['name'] as $key => $value) {
                $this->registerMetaTag([
                    'name' => $key,
                    'content' => $value,
                ]);
            }
            foreach ($this->params['seo_tags']['property'] as $key => $value) {
                $this->registerMetaTag([
                    'property' => $key,
                    'content' => $value,
                ]);
            }
        }
        ?>
        <?php $this->head(); ?>
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <div id="wrapper" class="clearfix">
            <div class="main-content">
                <section id="home" class="divider parallax fullscreen layer-overlay overlay-white-9"">
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
        $bg_img = (isset($this->params['background_image']) && !empty($this->params['background_image'])) ? $this->params['background_image'] : '';;
        $this->registerCss('
        body{
            background-image: url( ' . $bg_img . ' );
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
        }
        .layer-overlay::before {
            background: rgba(17, 17, 17, 0.5) none repeat scroll 0 0;
            content: " ";
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 0;
        }
        .layer-overlay.overlay-white-9::before {
            background-color: rgba(255, 255, 255, 0.9);
        }
        .form-control {
            border-radius: 0;
            height: 45px;
        }
        .divider .container {
            padding-top: 70px;
            padding-bottom: 70px;
        }
//        #home{
//            min-height:100% !important;
//        }
        #home {
            min-height:100vh !important;
            height: auto !important;
            margin-bottom:-50px;
        }');

        if (!empty(Yii::$app->params->google->analytics->id)) {
            $this->registerJsFile('https://www.googletagmanager.com/gtag/js?id=' . Yii::$app->params->google->analytics->id, [
                'depends' => [\yii\web\JqueryAsset::className()],
                'sync' => 'async',
            ]);

            $this->registerJs('
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag("js", new Date());
            gtag("config", "' . Yii::$app->params->google->analytics->id . '");        
        ');
        }
        ?>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>