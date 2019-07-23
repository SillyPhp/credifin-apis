<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\QuizAssets2;

QuizAssets2::register($this);
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
            <?= $content; ?>
            <?php
            $this->registerJsFile('https://www.googletagmanager.com/gtag/js?id=UA-121432126-1', [
                'depends' => [\yii\web\JqueryAsset::className()],
                'sync' => 'async',
            ]);

            $this->registerJs('
            window.dataLayer = window.dataLayer || [];
                        function gtag(){dataLayer.push(arguments);}
                        gtag("js", new Date());
                        gtag("config", "UA-121432126-1");');
            ?>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>