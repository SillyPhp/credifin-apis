<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\QuizAssets;

QuizAssets::register($this);
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
        <div class="background-overlay"></div>
        <div class="logo-bottom"> 
            <a href="/">
                <img alt="<?= Yii::$app->params->site_name; ?>" src="<?= Url::to('@commonAssets/logos/logo.svg'); ?>" style="width: 20vw;"/>
            </a>
        </div>
        <div id="quiz">
            <div class="container-fluid">
                <div id="quiz-stats" class="row text-center">
                    <div class="col-xs-12 col-md-3">

                    </div>
                    <div class="col-xs-4 col-md-3 col-lg-2">
                        <p>Correct Rate</p>
                        <span id="rate-span" class="animated">0/0</span>
                    </div>
                    <div class="col-xs-4 col-md-3 col-lg-2">
                        <p>Correct Streak</p>
                        <span id="streak-span" class="animated">0</span>
                    </div> 
                    <div class="col-xs-4 col-md-3 col-lg-2">
                        <p><span>Avg. </span>Response Time (s)</p>
                        <span id="response-time-span" class="animated">0</span>
                    </div>      
                </div>    
            </div>
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