<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\QuizAssets3;

QuizAssets3::register($this);
$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode((!empty($this->title)) ? Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name : Yii::$app->params->site_name); ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <link rel="icon" href="<?= Url::to('/favicon.ico'); ?>">
        <?php
        if ($this->params['seo_tags']) {
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
    <div class="fade-bg"></div>
    <div class="container">
        <?= $content; ?>
    </div>
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