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

$sharing_image = null;

if ($quiz['sharing_image']) {
    $sharing_image = Url::to(Yii::$app->params->upload_directories->quiz->sharing->image . $quiz['sharing_image_location'] . DIRECTORY_SEPARATOR . $quiz['sharing_image'], 'https');
} else {
    $sharing_image = Url::to('/assets/themes/quiz/eycricket.png', 'https');
}

$image = $sharing_image;

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

    <div class="container" style="margin-top: 12vh;">
        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1 text-center">
                <p id="quiz-question" class="animated"></p>
                <div id="quiz-options">
                </div>
                <div id="quiz-play-again">
                    <button id="quiz-play-again-btn" class="btn animated">Play Again</button>
                    <h1 id="finish-quiz"></h1>
                    <h2 class="subscribe-head">Share With <span>Friends</span></h2>
                    <div class="effect jaques">
                        <div class="buttons">
                            <a href="#" id="btn-share" class="fb" target="_blank" title="Join us on Facebook"><i
                                        class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" id="tw-share" class="tw" target="_blank" title="Share on Twitter"><i
                                        class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" id="link-share" class="linked" target="_blank" title="Share on Linkedin"><i
                                        class="fa fa-linkedin" aria-hidden="true"></i></a>
                            <a href="#" id="wa-share" class="whats" target="_blank" title="Share on Whatsapp"><i
                                        class="fa fa-whatsapp" aria-hidden="true"></i></a>
                            <a href="#" id="wa-share-mob" class="whats" target="_blank" title="Share on Whatsapp"><i
                                        class="fa fa-whatsapp" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <?php
                    if (Yii::$app->user->isGuest) {
                        ?>
                        <h2 class="subscribe-head sign">&</h2>
                        <a href="/signup/individual">
                            <img src="<?= Url::to('@root/assets/themes/quiz/sign-up.png'); ?>" hspace="20px;"
                                 class="share-img" alt="Share on Facebook" align="left"/>
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php

$background_image = null;

if ($quiz['background_image']) {
    $background_image = Url::to(Yii::$app->params->upload_directories->quiz->background->image . $quiz['background_image_location'] . DIRECTORY_SEPARATOR . $quiz['background_image']);
} else {
    $background_image = Url::to('/assets/themes/quiz/cric.png');
}

$this->registerCss('
.background-overlay {
    width: 100%;
    height: 100%;
    background: url(' . $background_image . ');
    background-position: 100% 45%;
    background-size: 100%;
    background-repeat: no-repeat;
    position: fixed;
    z-index: -1;
    background-position: center;
    background-size: cover;
}
.effect {
  width: 100%;
  padding: 10px 0px 30px 0px;
}
.effect .buttons {
  display: flex;
  justify-content: center;
}
.effect a {
  text-decoration: none !important;
  color: #fff;
  width: 60px;
  height: 60px;
  display: flex !important;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  margin-right: 20px;
  font-size: 25px;
  overflow: hidden;
  position: relative;
}
.effect a i {
  position: relative;
  z-index: 3;
}
.effect a.fb {
  background-color: #3b5998;
}
.effect a.tw {
  background-color: #00aced;
}
.effect a.linked {
  background-color: #0077B5;
}
.effect a.whats {
  background-color: #25D366;
}
/* jaques effect */
.effect.jaques a {
  transition: border-top-left-radius 0.1s linear 0s, border-top-right-radius 0.1s linear 0.1s, border-bottom-right-radius 0.1s linear 0.2s, border-bottom-left-radius 0.1s linear 0.3s;
}
.effect.jaques a:hover {
  border-radius: 50%;
}
.subscribe-head {
  font-family: "Lora", serif;
  font-weight: 900;
  font-size: 30px;
  color: #ffffff;
  letter-spacing: 3px;
  margin-top:40px;
}
.subscribe-head span {
  display: inline-block;
}
.subscribe-head span:before, .subscribe-head span:after {
  content: "";
  display: block;
  width: 34px;
  height: 2px;
  background-color: #ffffff;
  margin: 0px 0px 0px 2px;
}
.subscribe-head.sign{margin-top:0px;}
@media(max-width : 400px) {
    .logo-bottom {
        display: block;
    }
    .logo-bottom a img{
        width:30vw !Important;
    }
}
@media screen and (max-width: 991px) {
    #wa-share{display:none !important;}
}
@media screen and (min-width: 991px) {
    #wa-share-mob{display:none !important;}
}
');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Lora');