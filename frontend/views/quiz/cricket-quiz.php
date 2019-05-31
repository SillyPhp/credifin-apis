<?php

use yii\helpers\Url;


$this->title = 'Cricket World Cup| Quiz 2019| ';

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
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouth__',
        'twitter:creator' => '@EmpowerYouth__',
        'twitter:image' => $image,
    ],
    'property' => [
        'og:locale' => 'en',
        'og:type' => 'website',
        'og:site_name' => 'Empower Youth',
        'og:url' => Yii::$app->request->getAbsoluteUrl(),
        'og:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'og:description' => $description,
        'og:image' => $image,
        'fb:app_id' => '973766889447403'
    ],
];
?>

    <div class="container" style="margin-top: 8vh;">
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
                    <a href="/signup/individual">
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