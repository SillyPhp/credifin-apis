<?php

use yii\helpers\Url;

$this->title = $quiz['title'];

$keywords = $quiz['keywords'];

$description = $quiz['description'];

if (!empty($score) && !empty($total)) {
    if (($score >= 0 && $score <= 10) && ($total >= 0 && $total <= 10)) {
        $description = 'I scored ' . $score . ' out of ' . $total . '. Try Yours!!!. ' . $description;
    }
}

$image = Url::to(Yii::$app->params->upload_directories->quiz->sharing->image . $quiz['sharing_image_location'] . DIRECTORY_SEPARATOR . $quiz['sharing_image'], 'https');

$this->params['seo_tags'] = [
    'rel' => [
        'canonical' => Yii::$app->request->getAbsoluteUrl(),
    ],
    'name' => [
        'keywords' => $keywords,
        'description' => $description,
        'twitter:card' => 'summary_large_image',
        'twitter:title' => Yii::t('frontend', $this->title) . ' ' . Yii::$app->params->seo_settings->title_separator . ' ' . Yii::$app->params->site_name,
        'twitter:site' => '@EmpowerYouthin',
        'twitter:creator' => '@EmpowerYouthin',
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
<div id="app-main-quiz">
    <svg version='1.1' xmlns='http://www.w3.org/2000/svg'>
        <defs>
            <filter id='squiggly-0'>
                <feturbulence basefrequency='0.06' id='turbulence' numoctaves='3' result='noise'
                              seed='0'></feturbulence>
                <fedisplacementmap id='displacement' in2='noise' in='SourceGraphic' scale='6'></fedisplacementmap>
            </filter>
            <filter id='squiggly-1'>
                <feturbulence basefrequency='0.06' id='turbulence' numoctaves='3' result='noise'
                              seed='1'></feturbulence>
                <fedisplacementmap in2='noise' in='SourceGraphic' scale='8'></fedisplacementmap>
            </filter>
            <filter id='squiggly-2'>
                <feturbulence basefrequency='0.06' id='turbulence' numoctaves='3' result='noise'
                              seed='2'></feturbulence>
                <fedisplacementmap in2='noise' in='SourceGraphic' scale='6'></fedisplacementmap>
            </filter>
            <filter id='squiggly-3'>
                <feturbulence basefrequency='0.06' id='turbulence' numoctaves='3' result='noise'
                              seed='3'></feturbulence>
                <fedisplacementmap in2='noise' in='SourceGraphic' scale='8'></fedisplacementmap>
            </filter>
            <filter id='squiggly-4'>
                <feturbulence basefrequency='0.06' id='turbulence' numoctaves='3' result='noise'
                              seed='4'></feturbulence>
                <fedisplacementmap in2='noise' in='SourceGraphic' scale='6'></fedisplacementmap>
            </filter>
        </defs>
    </svg>
    <div class='overlay'></div>
    <div class='options'>
    </div>
    <div class='main'>
        <div class='main_inner'>
            <div class='main_inner__loading'>
                <div class='bg'>
                    <img src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/217233/mars_sunburst.png'>
                </div>
                <div class='loader'>
                    <div class='text'>
                        <span><?= $quiz['name'] ?></span>
                    </div>
                    <p>
                        <button>Click anywhere to play</button>
                    </p>
                </div>
            </div>

            <div class='main_inner__modalOverlay'></div>
            <div class='main_inner__modal'></div>

            <div class='main_inner__modalContent'>
                <h1>Quiz complete!</h1>
                <p class='score'>You got 7 out of 8 correct!</p>

                <div class="effect jaques">
                    <div class="buttons">
                        <a href="#" id="elem-button-share-quiz" class="fb" target="_blank"
                           title="Join us on Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                        <a href="#" id="elem-button-share-quiz-twitter" class="tw" target="_blank"
                           title="Share on Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        <a href="#" id="elem-button-share-quiz-wa" class="whats" target="_blank"
                           title="Share on Whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                        <a href="#" id="elem-button-share-quiz-wa-mob" class="whats" target="_blank"
                           title="Share on Whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                    </div>
                </div>
                <a href="/login" id="" class="login-s" title="Login or Signup to Empoweryouth">Login or Signup</a>
            </div>

            <div class='main_inner__logo'>
                <a href=''>
                    <img src='/assets/common/logos/eylogo.png'>
                </a>
            </div>

            <div class='main_inner__title'>
                <h1 class='hint'></h1>
            </div>

            <div class='main_inner__circle'></div>
            <div class='main_inner__feedback'></div>

            <div class='main_inner__scenes' id="options_cont">
            </div>

            <div class='main_inner__answers'>
                <div class='answer'></div>
                <div class='answer'></div>
                <div class='answer'></div>
                <div class='answer'></div>
            </div>

            <div class='main_inner__breadcrumbs'></div>
        </div>
    </div>
    <canvas class='grain'></canvas>
    <input type="hidden" id="i_path" value="<?= Yii::$app->params->upload_directories->quiz->question->image; ?>">
</div>
<?php
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/mustache.js/2.3.0/mustache.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
if($quiz['is_login'] == 1 && Yii::$app->user->isGuest) {
    echo $this->render('/widgets/login-required-modal');
}
?>

<script id="options-temp" type="text/template">
    <div class='scene {{id}}'>
        <div class='container'>
            <img src="{{img}}"/>
        </div>
    </div>
</script>
