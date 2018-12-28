<?php

use yii\helpers\Url;

$this->title = 'FIFA Quiz';
$keywords = 'FIFA,World Cup,2018,Fifa Fantasy,Russia,Football,Matches,Schedule,Quiz,Russia2018,Fifateams,Fifaleagues';
$description = 'Hey all football fans around, test your knowledge of fifa and win amazing prizes daily.Share your score and challenge your friends..#fifaSeason2k18';
if (!empty($score) && !empty($total)) {
    if (($score >= 0 && $score <= 10) && ($total >= 0 && $total <= 10)) {
        $description = 'I scored ' . $score . ' out of ' . $total . '. Try Yours!!!. ' . $description;
    }
}
$image = Yii::$app->urlManager->createAbsoluteUrl('/assets/themes/quiz/fb.png');

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
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-10 col-md-offset-1 text-center">
            <p id="quiz-question" class="animated"></p>
            <div id="quiz-options">
            </div>
            <div id="quiz-play-again">
                <button id="quiz-play-again-btn" class="btn animated">Play Again</button> 
                <h1 id="finish-quiz"></h1>
                <a onclick="return fbs_click()" href="#" id="btn-share" target="_blank">
                    <img src="<?= Url::to('@root/assets/themes/quiz/fb-share.png'); ?>" alt="Share on Facebook" class="share-img" align="left"/>
                </a>
                <a href="/signup/student">
                    <img src="<?= Url::to('@root/assets/themes/quiz/sign-up.png'); ?>" hspace="20px;" class="share-img"alt="Share on Facebook" align="left"/>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("function fbs_click() {
    u = location.href;
    t = document.title;
    window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), 'sharer', 'toolbar=0,status=0,width=626,height=436');
    return false;
}");
