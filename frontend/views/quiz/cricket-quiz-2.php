<?php

use yii\helpers\Url;

$this->title = 'Cricket World Cup | Quiz 2019';
$keywords = 'cricket, cricket world cup, cricket world cup 2019, cricket quiz, cricket news, world cup news';
$description = 'If You Are Cricket Lover Then You Definately Like Our Cricket World Cup Quiz And You Also Know The More Facts About Cricket.';
if (!empty($score) && !empty($total)) {
    if (($score >= 0 && $score <= 10) && ($total >= 0 && $total <= 10)) {
        $description = 'I scored ' . $score . ' out of ' . $total . '. Try Yours!!!. ' . $description;
    }
}
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/themes/quiz/eycricket.png');

$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Url::canonical(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth2',
        'twitter:creator' => '@EmpowerYouth2',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Url::canonical(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
    ],
];
?>
    <div class="fade-bg"></div>
    <div class="container">
        <span class="sub-container" id="sub-container">

            <img src="<?= Url::to('@commonAssets/logos/logo.svg'); ?>"
                 style="clear:both; border-radius:0px;max-width:320px;" align="center">

            <!-- Question container -->
            <div class="elem-div-question-container">
              <h1 id="elem-h1-question">
                Loading...
              </h1>
            </div>

            <!-- Progress bar container -->
            <div class="elem-div-progress-container">
              <progress id="elem-progress-bar" class="hidden"></progress>
              <small class="elem-small-progress-val" id="elem-small-progress-val"></small>
            </div>

            <!-- Answers container -->
            <div class="elem-div-answers-container" id="elem-div-answers-container">
                <div class="elem-div-loading-spinner"></div>
            </div>
    </div>

<?php
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');
$this->registerJs("function fbs_click() {
    u = location.href;
    t = document.title;
    window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), 'sharer', 'toolbar=0,status=0,width=626,height=436');
    return false;
}");
