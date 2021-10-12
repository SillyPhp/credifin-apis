<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppSecondaryAssets;

$userType = explode('/', Yii::$app->request->url)[2];
$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language; ?>">
    <head>
        <meta charset="<?= Yii::$app->charset; ?>">
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode((!empty($this->title)) ? Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name : Yii::$app->params->site_name); ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <script src="https://accounts.google.com/gsi/client" async defer></script>
        <link rel="icon" href="<?= Url::to('/favicon.ico'); ?>">
        <?php if(Yii::$app->params->options->crawl) { ?>
            <meta name="robots" content="index"/>
        <?php } else { ?>
            <meta name="robots" content="noindex,nofollow"/>
            <meta name="googlebot" content="noindex,nofollow">
        <?php }
        if (isset($this->params['seo_tags']) && !empty($this->params['seo_tags'])) {
            foreach ($this->params['seo_tags']['rel'] as $key => $value) {
                $this->registerLinkTag([
                    'rel' => $key,
                    'href' => Url::to($value,'https'),
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
            if (!isset($this->params['header_dark'])) {
                $this->params['header_dark'] = false;
            }
        }
        ?>
        <?php $this->head(); ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>

    <?= $content; ?>
    <?php
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